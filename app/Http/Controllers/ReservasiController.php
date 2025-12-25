<?php

namespace App\Http\Controllers;

use App\Models\Reservasi;
use App\Models\ReservasiDetail;
use App\Models\Pembayaran;
use App\Models\Kamar;
use App\Models\MetodePembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ReservasiController extends Controller
{
    public function create(Request $request)
    {
        $selectedKamars = [];
        
        if ($request->has('kamar_id')) {
            $kamarIds = is_array($request->kamar_id) ? $request->kamar_id : [$request->kamar_id];
            
            // Remove duplicates and filter out empty values
            $kamarIds = array_values(array_unique(array_filter($kamarIds)));
            
            if (!empty($kamarIds)) {
                $selectedKamars = Kamar::whereIn('id', $kamarIds)->get();
            }
        }

        $metodePembayaran = MetodePembayaran::aktif()->get();
        $checkin = $request->checkin ?? now()->format('Y-m-d');
        $checkout = $request->checkout ?? now()->addDay()->format('Y-m-d');

        // Pre-fill data user jika sudah login
        $user = auth()->user();

        return view('reservasi.create', compact('selectedKamars', 'metodePembayaran', 'checkin', 'checkout', 'user'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|string|max:100',
            'email' => 'required|email|max:100',
            'no_telp' => 'required|string|max:20',
            'alamat' => 'required|string|max:255',
            'check_in' => 'required|date',
            'check_out' => 'required|date|after:check_in',
            'kamar_ids' => 'required|array|min:1',
            'kamar_ids.*' => 'exists:kamars,id',
        ]);

        DB::beginTransaction();
        try {
            // Hitung jumlah malam
            $checkin = new \DateTime($validated['check_in']);
            $checkout = new \DateTime($validated['check_out']);
            $jumlahMalam = $checkin->diff($checkout)->days;
            
            // Hitung total harga
            $totalHarga = 0;
            $kamars = Kamar::whereIn('id', $validated['kamar_ids'])->get();
            
            foreach ($kamars as $kamar) {
                $totalHarga += $kamar->harga * $jumlahMalam;
            }

            // Buat reservasi
            $reservasi = Reservasi::create([
                'user_id' => auth()->id(),
                'kamar_id' => $validated['kamar_ids'][0], // kamar utama
                'nama_lengkap' => $validated['nama_lengkap'],
                'email' => $validated['email'],
                'no_telp' => $validated['no_telp'],
                'alamat' => $validated['alamat'],
                'check_in' => $validated['check_in'],
                'check_out' => $validated['check_out'],
                'total_harga' => $totalHarga,
                'status' => 'pending',
            ]);

            // Simpan detail reservasi (multiple kamar)
            foreach ($kamars as $kamar) {
                $subtotal = $kamar->harga * $jumlahMalam;
                
                ReservasiDetail::create([
                    'reservasi_id' => $reservasi->id,
                    'kamar_id' => $kamar->id,
                    'jumlah_malam' => $jumlahMalam,
                    'harga_per_malam' => $kamar->harga,
                    'subtotal' => $subtotal,
                ]);
            }

            DB::commit();

            return redirect()->route('reservasi.konfirmasi', $reservasi->id)
                ->with('success', 'Pemesanan berhasil! Silakan lanjutkan pembayaran.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function success($id)
    {
        $reservasi = Reservasi::with(['details.kamar', 'pembayaran'])->findOrFail($id);
        
        // Ambil metode pembayaran yang dipilih
        $metodePembayaran = MetodePembayaran::where('kode', $reservasi->pembayaran->metode)->first();
        
        return view('reservasi.success', compact('reservasi', 'metodePembayaran'));
    }

    public function konfirmasiPembayaran($id)
    {
        $reservasi = Reservasi::with(['details.kamar'])->findOrFail($id);
        
        // Cek apakah reservasi milik user yang login
        if ($reservasi->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        
        $metodePembayaran = MetodePembayaran::aktif()->get();
        
        // Debug: Log metode pembayaran
        Log::info('Metode Pembayaran:', ['data' => $metodePembayaran->toArray()]);
        
        return view('reservasi.konfirmasi-pembayaran', compact('reservasi', 'metodePembayaran'));
    }

    public function konfirmasiStore(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        
        // Cek apakah reservasi milik user yang login
        if ($reservasi->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }

        $rules = [
            'metode_pembayaran' => 'required|in:cash,transfer,qris',
        ];
        
        // Only require bukti_pembayaran if method is transfer or qris
        if (in_array($request->metode_pembayaran, ['transfer', 'qris'])) {
            $rules['bukti_pembayaran'] = 'required|file|mimes:jpg,jpeg,png,pdf|max:5120';
        }

        $validated = $request->validate($rules, [
            'bukti_pembayaran.required' => 'Silakan upload bukti pembayaran terlebih dahulu',
            'bukti_pembayaran.file' => 'File bukti pembayaran tidak valid',
            'bukti_pembayaran.mimes' => 'Format file harus JPG, PNG atau PDF',
            'bukti_pembayaran.max' => 'Ukuran file maksimal 5MB',
        ]);

        DB::beginTransaction();
        try {
            $pembayaranData = [
                'reservasi_id' => $reservasi->id,
                'metode' => $validated['metode_pembayaran'],
                'jumlah' => $reservasi->total_harga,
                'status' => 'pending',
            ];

            if (in_array($validated['metode_pembayaran'], ['transfer', 'qris']) && $request->hasFile('bukti_pembayaran')) {
                $file = $request->file('bukti_pembayaran');
                $filename = 'bukti_' . $validated['metode_pembayaran'] . '_' . $reservasi->id . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('bukti_pembayaran', $filename, 'public');
                $pembayaranData['bukti_bayar'] = $path;
                
                Log::info(ucfirst($validated['metode_pembayaran']) . ' payment proof uploaded', ['path' => $path, 'reservasi_id' => $reservasi->id]);
            }

            if ($validated['metode_pembayaran'] === 'cash') {
                $pembayaranData['status'] = 'confirmed';
                $reservasi->update(['status' => 'confirmed']);
                
                Log::info('Cash payment confirmed automatically', ['reservasi_id' => $reservasi->id]);
            }

            // Create or update pembayaran record
            Pembayaran::updateOrCreate(
                ['reservasi_id' => $reservasi->id],
                $pembayaranData
            );

            DB::commit();

            $successMessage = $validated['metode_pembayaran'] === 'cash' 
                ? 'Pemesanan berhasil dikonfirmasi! Silakan siapkan pembayaran tunai saat check-in.' 
                : 'Pembayaran berhasil dikonfirmasi! Kami akan memverifikasi dalam 15 menit.';

            return redirect()->route('reservasi.detail', $reservasi->id)
                ->with('success', $successMessage);

        } catch (\Exception $e) {
            DB::rollback();
            Log::error('Payment confirmation failed', ['error' => $e->getMessage(), 'reservasi_id' => $reservasi->id]);
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    public function detail($id)
    {
        $reservasi = Reservasi::with(['details.kamar', 'pembayaran'])->findOrFail($id);
        
        // Cek apakah reservasi milik user yang login
        if ($reservasi->user_id !== auth()->id()) {
            abort(403, 'Unauthorized');
        }
        
        // Get payment method details if exists
        $metodePembayaran = null;
        if ($reservasi->pembayaran) {
            $metodePembayaran = MetodePembayaran::where('kode', $reservasi->pembayaran->metode)->first();
        }
        
        return view('reservasi.detail', compact('reservasi', 'metodePembayaran'));
    }
}
