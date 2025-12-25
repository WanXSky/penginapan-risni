<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kamar;

class KamarController extends Controller
{
    public function index()
    {
        $kamars = Kamar::orderBy('created_at', 'desc')->paginate(10);
        
        return view('admin.kamar', compact('kamars'));
    }

    public function create()
    {
        return view('admin.kamar-form');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kamar' => 'required|string|max:255',
            'tipe' => 'required|in:biasa,reguler,vip',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'fasilitas' => 'nullable|string',
            'preview_360' => 'nullable|string',
            'status' => 'required|in:tersedia,penuh'
        ]);

        Kamar::create($validated);

        return redirect()->route('admin.kamar')->with('success', 'Kamar berhasil ditambahkan');
    }

    public function edit($id)
    {
        $kamar = Kamar::findOrFail($id);
        return view('admin.kamar-form', compact('kamar'));
    }

    public function update(Request $request, $id)
    {
        $kamar = Kamar::findOrFail($id);
        
        $validated = $request->validate([
            'nama_kamar' => 'required|string|max:255',
            'tipe' => 'required|in:biasa,reguler,vip',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'fasilitas' => 'nullable|string',
            'preview_360' => 'nullable|string',
            'status' => 'required|in:tersedia,penuh'
        ]);

        $kamar->update($validated);

        return redirect()->route('admin.kamar')->with('success', 'Kamar berhasil diperbarui');
    }

    public function destroy($id)
    {
        $kamar = Kamar::findOrFail($id);
        $kamar->delete();

        return response()->json(['success' => true]);
    }
}
