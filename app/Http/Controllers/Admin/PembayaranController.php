<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Pembayaran;
use App\Models\Reservasi;

class PembayaranController extends Controller
{
    public function index()
    {
        $status = request('status', 'pending');
        
        $pembayarans = Pembayaran::with('reservasi.kamar')
            ->when($status !== 'all', function($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);
        
        $pendingCount = Pembayaran::where('status', 'pending')->count();
        $verifiedCount = Pembayaran::where('status', 'verified')->count();
        $totalCount = Pembayaran::count();
        
        return view('admin.pembayaran', compact('pembayarans', 'pendingCount', 'verifiedCount', 'totalCount', 'status'));
    }

    public function show($id)
    {
        $pembayaran = Pembayaran::with(['reservasi.kamar', 'reservasi.user'])->findOrFail($id);
        return view('admin.pembayaran-detail', compact('pembayaran'));
    }

    public function verifikasi(Request $request, $id)
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

        return redirect()->route('admin.pembayaran.detail', $id)
            ->with('success', 'Pembayaran berhasil diverifikasi');
    }

    public function tolak($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $pembayaran->status = 'rejected';
        $pembayaran->rejected_at = now();
        $pembayaran->rejected_by = auth()->id();
        $pembayaran->save();

        return redirect()->route('admin.pembayaran')
            ->with('success', 'Pembayaran berhasil ditolak');
    }

    public function printInvoice($id)
    {
        $pembayaran = Pembayaran::with(['reservasi.kamar', 'reservasi.user'])->findOrFail($id);
        
        // Check if payment is verified
        if ($pembayaran->status !== 'verified') {
            return redirect()->back()->with('error', 'Invoice hanya bisa dicetak untuk pembayaran yang sudah diverifikasi');
        }
        
        return view('admin.invoice', compact('pembayaran'));
    }
}
