<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Reservasi;

class ReservasiController extends Controller
{
    public function index(Request $request)
    {
        $query = Reservasi::with('kamar')->orderBy('created_at', 'desc');

        if ($request->has('status') && $request->status) {
            $query->where('status', $request->status);
        }

        $reservasis = $query->paginate(15);
        
        return view('admin.reservasi', compact('reservasis'));
    }

    public function show($id)
    {
        $reservasi = Reservasi::with('kamar', 'pembayaran')->findOrFail($id);
        return view('admin.reservasi-detail', compact('reservasi'));
    }

    public function updateStatus(Request $request, $id)
    {
        $reservasi = Reservasi::findOrFail($id);
        
        $validated = $request->validate([
            'status' => 'required|in:pending,confirmed,check-in,check-out,completed,cancelled'
        ]);

        $reservasi->update($validated);

        return response()->json(['success' => true]);
    }
}
