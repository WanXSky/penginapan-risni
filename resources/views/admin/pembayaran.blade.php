@extends('admin.layout')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Konfirmasi Pembayaran</h1>
        <p class="text-sm text-gray-600">Verifikasi detail pembayaran untuk pesanan #RSN-2024-882</p>
    </div>

    <!-- Payment Confirmation Card -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left side - Payment Details -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Reservation Details Card -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <div class="mb-4 pb-4 border-b border-gray-200">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-yellow-100 text-yellow-800 text-xs font-medium rounded-lg">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Menunggu Konfirmasi
                    </div>
                </div>

                <h2 class="text-lg font-semibold text-gray-900 mb-6">Detail Pemesanan</h2>
                
                <div class="grid grid-cols-2 gap-6">
                    <div>
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">ID Pemesanan</p>
                        <p class="text-sm font-semibold text-gray-900">#RSN-2024-882</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Nama Tamu</p>
                        <div class="flex items-center gap-2">
                            <div class="w-6 h-6 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center text-white text-xs font-medium">
                                B
                            </div>
                            <p class="text-sm font-medium text-gray-900">Budi Santoso</p>
                        </div>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Check-In</p>
                        <p class="text-sm text-gray-900 flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            15 Des 2023
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Check-Out</p>
                        <p class="text-sm text-gray-900 flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            16 Des 2023
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Tipe Kamar</p>
                        <p class="text-sm text-gray-900">Biasa, Kamar 1</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Durasi</p>
                        <p class="text-sm text-gray-900">1 Malam</p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Metode Pembayaran</p>
                        <p class="text-sm text-gray-900 flex items-center gap-1">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            Transfer Bank BCA
                        </p>
                    </div>
                    <div>
                        <p class="text-xs text-gray-500 mb-1 uppercase tracking-wide">Status Pemesanan</p>
                        <span class="inline-flex px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">
                            Confirmed
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right side - Payment Proof & Actions -->
        <div class="space-y-6">
            <!-- Payment Proof -->
            <div class="bg-white rounded-xl border border-gray-200 p-6">
                <h3 class="text-sm font-semibold text-gray-900 mb-4">Bukti Transfer</h3>
                <div class="aspect-square bg-gray-100 rounded-lg flex items-center justify-center border-2 border-dashed border-gray-300">
                    <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                
                <div class="mt-4 p-4 bg-gray-50 rounded-lg">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-gray-600">TOTAL TAGIHAN</span>
                    </div>
                    <p class="text-2xl font-bold text-gray-900">Rp 90.000</p>
                </div>
            </div>

            <!-- Actions -->
            <div class="bg-white rounded-xl border border-gray-200 p-6 space-y-3">
                <button class="w-full px-4 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Terima Pembayaran
                </button>
                <button class="w-full px-4 py-3 bg-red-50 text-red-600 font-medium rounded-lg hover:bg-red-100 transition-colors flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Tolak Pembayaran
                </button>

                <div class="pt-3 border-t border-gray-200">
                    <div class="flex items-start gap-2 p-3 bg-blue-50 rounded-lg">
                        <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <p class="text-xs text-blue-900 leading-relaxed">
                            Pastikan nominal transfer sesuai dengan total tagihan sebelum menerima pembayaran.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
