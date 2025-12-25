<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kamar;
use App\Models\Reservasi;
use App\Models\Pembayaran;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics
        $totalKamar = Kamar::count();
        $kamarTersedia = Kamar::where('status', 'tersedia')->count();
        $reservasiAktif = Reservasi::whereIn('status', ['confirmed', 'check-in'])->count();
        $pembayaranTertunda = Pembayaran::where('status', 'pending')->count();

        // Get latest reservations (5 most recent)
        $reservasiTerbaru = Reservasi::with(['kamar', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Get payments pending verification
        $pembayaranVerifikasi = Pembayaran::with(['reservasi.kamar', 'reservasi.user'])
            ->where('status', 'pending')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'totalKamar',
            'kamarTersedia',
            'reservasiAktif',
            'pembayaranTertunda',
            'reservasiTerbaru',
            'pembayaranVerifikasi'
        ));
    }

    public function verifikasiPembayaran(Request $request, $id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->status = 'verified';
        $pembayaran->verified_at = now();
        $pembayaran->verified_by = auth()->id();
        $pembayaran->save();

        // Update reservasi status
        $reservasi = $pembayaran->reservasi;
        $reservasi->status = 'confirmed';
        $reservasi->save();

        return response()->json(['success' => true, 'message' => 'Pembayaran berhasil diverifikasi']);
    }
}
