@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 pt-24 pb-12">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Success Alert -->
        @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-start gap-3">
            <svg class="w-6 h-6 text-green-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div>
                <h4 class="font-semibold text-green-900">Berhasil!</h4>
                <p class="text-green-700 text-sm mt-1">{{ session('success') }}</p>
            </div>
        </div>
        @endif

        <!-- Header -->
        <div class="bg-white rounded-lg shadow-sm p-6 mb-6">
            <div class="flex items-center justify-between mb-4">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900">Ringkasan Pemesanan</h1>
                    <!-- Fixed ID display to use actual reservation code -->
                    <p class="text-gray-600 mt-1">ID Pemesanan: <span class="font-semibold">#PR-{{ str_pad($reservasi->id, 4, '0', STR_PAD_LEFT) }}</span></p>
                </div>
                
                <!-- Status Badge -->
                @php
                    $statusConfig = [
                        'pending' => ['bg' => 'bg-yellow-100', 'text' => 'text-yellow-800', 'label' => 'Menunggu Verifikasi'],
                        'confirmed' => ['bg' => 'bg-green-100', 'text' => 'text-green-800', 'label' => 'Dikonfirmasi'],
                        'rejected' => ['bg' => 'bg-red-100', 'text' => 'text-red-800', 'label' => 'Ditolak'],
                        'cancelled' => ['bg' => 'bg-gray-100', 'text' => 'text-gray-800', 'label' => 'Dibatalkan'],
                    ];
                    $currentStatus = $reservasi->pembayaran->status ?? 'pending';
                    $status = $statusConfig[$currentStatus] ?? $statusConfig['pending'];
                @endphp
                
                <div class="flex flex-col items-end gap-2">
                    <span class="px-4 py-2 {{ $status['bg'] }} {{ $status['text'] }} rounded-full text-sm font-semibold">
                        {{ $status['label'] }}
                    </span>
                    <p class="text-xs text-gray-500">{{ $reservasi->created_at->format('d M Y, H:i') }}</p>
                </div>
            </div>

            <!-- Timeline Status -->
            <div class="border-t pt-4">
                <div class="flex items-center justify-between relative">
                    <!-- Step 1: Pemesanan -->
                    <div class="flex flex-col items-center flex-1 relative z-10">
                        <div class="w-10 h-10 bg-green-500 rounded-full flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-900">Pemesanan</p>
                        <p class="text-xs text-gray-500">Dibuat</p>
                    </div>

                    <!-- Connection Line -->
                    <div class="absolute top-5 left-0 right-0 h-0.5 bg-gray-200 -z-0"></div>
                    <div class="absolute top-5 left-0 h-0.5 bg-green-500 -z-0 transition-all" style="width: {{ ($reservasi->pembayaran && in_array($reservasi->pembayaran->status, ['confirmed', 'verified'])) ? '50%' : '0%' }}"></div>

                    <!-- Step 2: Pembayaran -->
                    <div class="flex flex-col items-center flex-1 relative z-10">
                        <div class="w-10 h-10 {{ ($reservasi->pembayaran && in_array($reservasi->pembayaran->status, ['confirmed', 'verified'])) ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center mb-2">
                            @if($reservasi->pembayaran && in_array($reservasi->pembayaran->status, ['confirmed', 'verified']))
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            @else
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            @endif
                        </div>
                        <p class="text-xs font-semibold text-gray-900">Pembayaran</p>
                        <p class="text-xs text-gray-500">
                            @if($reservasi->pembayaran && in_array($reservasi->pembayaran->status, ['confirmed', 'verified']))
                                Dikonfirmasi
                            @elseif($reservasi->pembayaran && $reservasi->pembayaran->status === 'rejected')
                                Ditolak
                            @else
                                Menunggu
                            @endif
                        </p>
                    </div>

                    <!-- Step 3: Check-in -->
                    <div class="flex flex-col items-center flex-1 relative z-10">
                        <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center mb-2">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                            </svg>
                        </div>
                        <p class="text-xs font-semibold text-gray-900">Check-in</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($reservasi->check_in)->format('d M') }}</p>
                    </div>

                    <!-- Step 4: Check-out -->
                    @php
                        $now = \Carbon\Carbon::now();
                        $checkoutDate = \Carbon\Carbon::parse($reservasi->check_out);
                        $isCheckedOut = $now->greaterThanOrEqualTo($checkoutDate);
                    @endphp
                    
                    <div class="flex flex-col items-center flex-1 relative z-10">
                        <div class="w-10 h-10 {{ $isCheckedOut ? 'bg-green-500' : 'bg-gray-300' }} rounded-full flex items-center justify-center mb-2">
                            @if($isCheckedOut)
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            @else
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                            </svg>
                            @endif
                        </div>
                        <p class="text-xs font-semibold text-gray-900">Check-out</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($reservasi->check_out)->format('d M') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Detail Tamu -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        Detail Tamu
                    </h2>
                    <div class="space-y-3">
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-gray-600">Nama Lengkap</span>
                            <span class="font-semibold text-gray-900">{{ $reservasi->nama_lengkap }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-gray-600">Email</span>
                            <span class="font-semibold text-gray-900">{{ $reservasi->email }}</span>
                        </div>
                        <div class="flex justify-between py-2 border-b">
                            <span class="text-gray-600">No. Telepon</span>
                            <span class="font-semibold text-gray-900">{{ $reservasi->no_telp }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Alamat</span>
                            <span class="font-semibold text-gray-900 text-right">{{ $reservasi->alamat }}</span>
                        </div>
                    </div>
                </div>

                <!-- Detail Kamar -->
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                        </svg>
                        Kamar yang Dipesan
                    </h2>
                    <div class="space-y-4">
                        @foreach($reservasi->details as $detail)
                        <div class="flex gap-4 p-4 border rounded-lg">
                            @if($detail->kamar->gambar_utama)
                            <img src="{{ asset('storage/' . $detail->kamar->gambar_utama) }}" alt="{{ $detail->kamar->nama }}" class="w-24 h-24 object-cover rounded-lg">
                            @endif
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900">{{ $detail->kamar->nama }}</h3>
                                <p class="text-sm text-gray-600 mt-1">{{ $detail->jumlah_malam }} malam × Rp {{ number_format($detail->harga_per_malam, 0, ',', '.') }}</p>
                                <p class="text-sm font-semibold text-blue-600 mt-2">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</p>
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="mt-4 pt-4 border-t">
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Check-in</span>
                            <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($reservasi->check_in)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Check-out</span>
                            <span class="font-semibold text-gray-900">{{ \Carbon\Carbon::parse($reservasi->check_out)->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between py-2">
                            <span class="text-gray-600">Durasi</span>
                            <span class="font-semibold text-gray-900">{{ $reservasi->details->first()->jumlah_malam }} Malam</span>
                        </div>
                    </div>
                </div>

                <!-- Bukti Pembayaran -->
                @if($reservasi->pembayaran && $reservasi->pembayaran->bukti_bayar)
                <div class="bg-white rounded-lg shadow-sm p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4 flex items-center gap-2">
                        <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                        Bukti Pembayaran
                    </h2>
                    <div class="border rounded-lg p-4 bg-gray-50">
                        @php
                            $buktiPath = $reservasi->pembayaran->bukti_bayar;
                            $extension = pathinfo($buktiPath, PATHINFO_EXTENSION);
                            
                            // Support both relative paths and full URLs
                            if (filter_var($buktiPath, FILTER_VALIDATE_URL)) {
                                $imageUrl = $buktiPath;
                            } else {
                                $imageUrl = asset('storage/' . $buktiPath);
                            }
                        @endphp
                        
                        @if(in_array(strtolower($extension), ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                            <div class="relative">
                                <img 
                                    src="{{ $imageUrl }}" 
                                    alt="Bukti Pembayaran" 
                                    class="max-w-full h-auto rounded-lg cursor-pointer hover:opacity-90 transition-opacity shadow-md" 
                                    onclick="showImageModal(this.src)"
                                    onerror="handleImageLoadError(this, '{{ $buktiPath }}', '{{ $imageUrl }}')">
                                <p class="text-xs text-gray-500 mt-3 text-center">Klik gambar untuk memperbesar</p>
                                
                                <!-- Debug info (hidden by default, shown on error) -->
                                <div id="image-debug-info" class="hidden mt-2 p-2 bg-yellow-50 border border-yellow-200 rounded text-xs">
                                    <p class="font-semibold text-yellow-800">Debug Info:</p>
                                    <p class="text-yellow-700">Path: {{ $buktiPath }}</p>
                                    <p class="text-yellow-700">URL: {{ $imageUrl }}</p>
                                </div>
                            </div>
                        @elseif(strtolower($extension) === 'pdf')
                            <div class="flex items-center justify-center gap-3 py-6">
                                <svg class="w-12 h-12 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4z"></path>
                                </svg>
                                <div>
                                    <p class="font-semibold text-gray-900">Bukti Pembayaran PDF</p>
                                    <a href="{{ $imageUrl }}" target="_blank" class="text-sm text-blue-600 hover:underline">Klik untuk melihat PDF</a>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-6">
                                <p class="text-gray-600">File: {{ basename($buktiPath) }}</p>
                                <a href="{{ $imageUrl }}" target="_blank" class="text-blue-600 hover:underline text-sm">Download</a>
                            </div>
                        @endif
                    </div>
                </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Ringkasan Pembayaran -->
                <div class="bg-white rounded-lg shadow-sm p-6 sticky top-24">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Ringkasan Pembayaran</h2>
                    
                    <div class="space-y-3 mb-4">
                        @foreach($reservasi->details as $detail)
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-600">{{ $detail->kamar->nama }}</span>
                            <span class="font-semibold text-gray-900">Rp {{ number_format($detail->subtotal, 0, ',', '.') }}</span>
                        </div>
                        @endforeach
                    </div>

                    <div class="border-t pt-4 mb-4">
                        <div class="flex justify-between">
                            <span class="text-lg font-semibold text-gray-900">Total Pembayaran</span>
                            <span class="text-lg font-bold text-blue-600">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($metodePembayaran)
                    <div class="border-t pt-4">
                        <p class="text-sm text-gray-600 mb-2">Metode Pembayaran</p>
                        <div class="flex items-center gap-2">
                            @if($metodePembayaran->kode === 'cash')
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                            </svg>
                            @else
                            <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                            </svg>
                            @endif
                            <span class="font-semibold text-gray-900">{{ $metodePembayaran->nama }}</span>
                        </div>
                    </div>
                    @endif

                    <div class="mt-6 space-y-3">
                        <a href="{{ route('reservasi.saya') }}" class="block w-full px-4 py-3 bg-blue-500 text-white text-center rounded-lg font-semibold hover:bg-blue-600 transition-colors">
                            Lihat Semua Reservasi
                        </a>
                        <a href="{{ route('home') }}" class="block w-full px-4 py-3 bg-gray-100 text-gray-700 text-center rounded-lg font-semibold hover:bg-gray-200 transition-colors">
                            Kembali ke Beranda
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal for Image Preview -->
<script>
function handleImageLoadError(img, originalPath, attemptedUrl) {
    console.log('[v0] Image failed to load');
    console.log('[v0] Original path:', originalPath);
    console.log('[v0] Attempted URL:', attemptedUrl);
    
    // Show debug info
    const debugInfo = document.getElementById('image-debug-info');
    if (debugInfo) {
        debugInfo.classList.remove('hidden');
    }
    
    // Replace image with error message
    const container = img.parentElement;
    container.innerHTML = `
        <div class='p-6 text-center bg-red-50 border border-red-200 rounded-lg'>
            <svg class='w-12 h-12 text-red-400 mx-auto mb-3' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'/>
            </svg>
            <p class='font-semibold text-red-800 mb-2'>Gambar tidak dapat dimuat</p>
            <p class='text-xs text-red-600 mb-3'>Path: <span class='font-mono'>${originalPath}</span></p>
            <div class='space-y-2'>
                <a href='${attemptedUrl}' target='_blank' class='inline-block px-4 py-2 bg-blue-600 text-white text-sm rounded hover:bg-blue-700'>
                    Coba buka di tab baru
                </a>
            </div>
            <p class='text-xs text-red-500 mt-3'>Jika gambar tidak muncul, hubungi admin untuk memeriksa konfigurasi storage</p>
        </div>
    `;
}

function showImageModal(src) {
    const modal = document.createElement('div');
    modal.className = 'fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 p-4';
    modal.innerHTML = `
        <div class="relative max-w-4xl max-h-full">
            <img src="${src}" alt="Bukti Pembayaran" class="max-w-full max-h-[90vh] object-contain rounded-lg">
            <button onclick="this.closest('.fixed').remove()" class="absolute top-4 right-4 w-10 h-10 bg-white rounded-full flex items-center justify-center hover:bg-gray-100 transition-colors">
                <svg class="w-6 h-6 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>
        </div>
    `;
    document.body.appendChild(modal);
    
    modal.addEventListener('click', function(e) {
        if (e.target === modal) {
            modal.remove();
        }
    });
}
</script>
@endsection
