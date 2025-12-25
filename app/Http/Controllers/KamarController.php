<?php

namespace App\Http\Controllers;

use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;

class KamarController extends Controller
{
    /**
     * Display room list with availability check
     */
    public function index(Request $request)
    {
        $tipe = $request->query('tipe');
        $tanggalCheckin = $request->query('checkin', date('Y-m-d'));
        $fromBooking = $request->query('from_booking') == '1';

        Log::info('==== KamarController@index DIPANGGIL ====', [
            'tipe' => $tipe,
            'from_booking' => $fromBooking,
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'query_params' => $request->query(),
        ]);

        $kamars = Kamar::when($tipe && !$fromBooking, function ($query) use ($tipe) {
            $query->where('tipe', $tipe);
        })->get();

        Log::info('==== Data kamars ====', [
            'count' => $kamars->count(),
            'tipe_filter' => $tipe,
            'from_booking' => $fromBooking,
            'kamars' => $kamars->pluck('nama_kamar', 'id')->toArray()
        ]);

        Log::info('==== Akan return view kamar.list ====');

        return view('kamar.list', [
            'kamars' => $kamars,
            'tipeKamar' => $tipe ?? 'semua',
            'tanggalCheckin' => $tanggalCheckin,
            'fromBooking' => $fromBooking,
        ]);
    }

    /**
     * Display room list by category
     */
    public function listByCategory($kategori)
    {
        // Normalize category name
        $kategori = strtolower($kategori);
        
        $kamars = Kamar::where('tipe', $kategori)->get();

        return view('kamar.list', [
            'kamars' => $kamars,
            'tipeKamar' => $kategori,
            'tanggalCheckin' => date('Y-m-d'),
        ]);
    }

    /**
     * Display room detail
     */
    public function show($id)
    {
        $kamar = Kamar::findOrFail($id);

        return view('kamar.detail', compact('kamar'));
    }

    /**
     * API endpoint to check all rooms availability for specific date and type
     */
    public function checkAllAvailability(Request $request)
    {
        Log::info('checkAllAvailability called', [
            'request_data' => $request->all()
        ]);

        $validator = Validator::make($request->all(), [
            'tipe' => 'nullable|string',
            'checkin' => 'required|date|after_or_equal:today',
            'from_booking' => 'nullable|boolean',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', [
                'errors' => $validator->errors()->toArray()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Invalid input',
                'errors' => $validator->errors()
            ], 422);
        }

        try {
            $fromBooking = $request->from_booking ?? false;
            
            $kamars = Kamar::when($request->tipe && !$fromBooking, function($query) use ($request) {
                $query->whereRaw('LOWER(tipe) = ?', [strtolower($request->tipe)]);
            })->get();

            Log::info('Kamars found', [
                'tipe' => $request->tipe,
                'from_booking' => $fromBooking,
                'count' => $kamars->count(),
                'kamars' => $kamars->map(function($k) {
                    return [
                        'id' => $k->id,
                        'nama' => $k->nama_kamar,
                        'tipe' => $k->tipe,
                        'status' => $k->status
                    ];
                })->toArray()
            ]);

            $availability = [];
            
            foreach ($kamars as $kamar) {
                $isAvailable = strtolower($kamar->status) === 'tersedia';
                
                $availability[] = [
                    'id' => $kamar->id,
                    'nama_kamar' => $kamar->nama_kamar,
                    'available' => $isAvailable,
                    'harga' => $kamar->harga,
                    'tipe' => $kamar->tipe,
                ];
            }

            Log::info('Availability check completed', [
                'tipe' => $request->tipe,
                'from_booking' => $fromBooking,
                'checkin' => $request->checkin,
                'total_rooms' => count($availability),
                'available_rooms' => collect($availability)->where('available', true)->count(),
                'data' => $availability
            ]);

            return response()->json([
                'success' => true,
                'data' => $availability,
                'checkin' => $request->checkin,
                'tipe' => $request->tipe,
                'from_booking' => $fromBooking,
            ]);

        } catch (\Exception $e) {
            Log::error('Error checking availability: ' . $e->getMessage(), [
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat mengecek ketersediaan',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
}
