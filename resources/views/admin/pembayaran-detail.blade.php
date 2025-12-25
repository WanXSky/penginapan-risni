@extends('admin.layout')

@section('title', 'Konfirmasi Pembayaran')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Breadcrumb -->
    <nav class="mb-4 text-sm text-gray-600">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-blue-600">Dashboard</a>
        <span class="mx-2">/</span>
        <a href="{{ route('admin.pembayaran') }}" class="hover:text-blue-600">Pembayaran</a>
        <span class="mx-2">/</span>
        <span class="text-gray-900">Konfirmasi #{{ $pembayaran->reservasi->generateBookingId() }}</span>
    </nav>

    <!-- Header with Back Button -->
    <div class="mb-6 flex items-center gap-4">
        <a href="{{ route('admin.pembayaran') }}" class="text-gray-600 hover:text-gray-900 bg-white border border-gray-300 rounded-lg p-2 hover:bg-gray-50 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Konfirmasi Pembayaran</h1>
            <p class="text-sm text-gray-600 mt-1">Verifikasi detail pembayaran untuk pesanan #{{ $pembayaran->reservasi->generateBookingId() }}</p>
        </div>
    </div>

    @if(session('success'))
    <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-800 rounded-lg">
        {{ session('success') }}
    </div>
    @endif

    <!-- Restructured to 2-column layout with details on left and payment proof on right -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Left Column: Booking Details (2/3 width) -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm">
                <!-- Status Badge -->
                <div class="p-6 pb-4 border-b border-gray-200">
                    @if($pembayaran->status === 'pending')
                    <span class="px-4 py-2 inline-flex items-center text-sm font-medium rounded-lg bg-yellow-50 text-yellow-700 border border-yellow-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Menunggu Konfirmasi
                    </span>
                    @elseif($pembayaran->status === 'verified')
                    <span class="px-4 py-2 inline-flex items-center text-sm font-medium rounded-lg bg-green-50 text-green-700 border border-green-200">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/>
                        </svg>
                        Confirmed
                    </span>
                    @endif
                </div>

                <!-- Detail Pemesanan -->
                <div class="p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-6">Detail Pemesanan</h2>
                    
                    <div class="grid grid-cols-2 gap-x-8 gap-y-6">
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">ID Pemesanan</p>
                            <p class="text-base font-bold text-gray-900">#{{ $pembayaran->reservasi->generateBookingId() }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Nama Tamu</p>
                            <div class="flex items-center gap-2">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center text-white text-xs font-semibold">
                                    {{ strtoupper(substr($pembayaran->reservasi->nama_lengkap ?? 'G', 0, 2)) }}
                                </div>
                                <span class="text-base font-medium text-gray-900">{{ $pembayaran->reservasi->nama_lengkap }}</span>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Check-in</p>
                            <div class="flex items-center gap-2 text-gray-900">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-medium text-sm">{{ \Carbon\Carbon::parse($pembayaran->reservasi->check_in)->locale('id')->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Check-out</p>
                            <div class="flex items-center gap-2 text-gray-900">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <span class="font-medium text-sm">{{ \Carbon\Carbon::parse($pembayaran->reservasi->check_out)->locale('id')->translatedFormat('d M Y') }}</span>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Tipe Kamar</p>
                            <p class="text-base font-medium text-gray-900">{{ $pembayaran->reservasi->kamar->tipe }}</p>
                        </div>
                        
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Nomor Kamar</p>
                            <p class="text-base font-bold text-gray-900">
                                {{ $pembayaran->reservasi->kamar->nama_kamar }}
                            </p>
                        </div>
                        
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Durasi</p>
                            <p class="text-base font-medium text-gray-900">{{ \Carbon\Carbon::parse($pembayaran->reservasi->check_in)->diffInDays(\Carbon\Carbon::parse($pembayaran->reservasi->check_out)) }} Malam</p>
                        </div>
                        
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Metode Pembayaran</p>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V7a3 3 0 00-3-3H5a3 3 0 00-3 3v12a3 3 0 003 3z"/>
                                </svg>
                                <span class="text-base font-medium text-gray-900">
                                    @if($pembayaran->metode === 'transfer')
                                        Transfer Bank BCA
                                    @elseif($pembayaran->metode === 'qris')
                                        QRIS
                                    @else
                                        Cash/Tunai
                                    @endif
                                </span>
                            </div>
                        </div>
                        
                        <div>
                            <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Status Pemesanan</p>
                            @if($pembayaran->reservasi->status === 'confirmed')
                            <span class="px-3 py-1 inline-flex items-center text-xs font-medium rounded-full bg-green-100 text-green-700">
                                Confirmed
                            </span>
                            @else
                            <span class="px-3 py-1 inline-flex items-center text-xs font-medium rounded-full bg-gray-100 text-gray-700">
                                {{ ucfirst($pembayaran->reservasi->status) }}
                            </span>
                            @endif
                        </div>
                    </div>

                    @if($pembayaran->reservasi->catatan)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-semibold text-gray-900 mb-2">Catatan Tamu</h3>
                        <p class="text-sm text-gray-600 italic">"{{ $pembayaran->reservasi->catatan }}"</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Right Column: Payment Proof & Actions (1/3 width) -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl border border-gray-200 shadow-sm sticky top-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">
                        Bukti Transfer
                    </h3>
                    
                    <!-- Improved image display with better error handling and URL support -->
                    @if($pembayaran->metode !== 'cash' && $pembayaran->bukti_bayar)
                    @php
                        // Support both relative paths and full URLs
                        if (filter_var($pembayaran->bukti_bayar, FILTER_VALIDATE_URL)) {
                            $imageUrl = $pembayaran->bukti_bayar;
                        } else {
                            $imageUrl = asset('storage/' . $pembayaran->bukti_bayar);
                        }
                    @endphp
                    <div class="border-2 border-gray-200 rounded-lg overflow-hidden mb-3 cursor-pointer hover:border-blue-400 transition-colors" onclick="openImageModal()">
                        <img src="{{ $imageUrl }}" 
                             alt="Bukti Pembayaran" 
                             id="paymentProof"
                             class="w-full h-auto object-cover"
                             onerror="handleImageError(this, '{{ $pembayaran->bukti_bayar }}', '{{ $imageUrl }}')">
                    </div>
                    <p class="text-xs text-center text-gray-500 mb-4">Klik gambar untuk memperbesar</p>
                    @elseif($pembayaran->metode === 'cash')
                    <div class="border border-gray-200 rounded-lg p-6 text-center bg-gray-50 mb-4">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        <p class="text-xs text-gray-600">Pembayaran Tunai</p>
                    </div>
                    @else
                    <div class="border border-gray-200 rounded-lg p-6 text-center bg-gray-50 mb-4">
                        <svg class="w-12 h-12 text-gray-400 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        <p class="text-xs text-gray-500">Tidak ada bukti pembayaran</p>
                    </div>
                    @endif

                    <!-- Moved total and action buttons to right sidebar -->
                    <div class="space-y-3 mb-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-gray-600">Subtotal</span>
                            <span class="font-medium text-gray-900">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</span>
                        </div>
                        <div class="pt-3 border-t border-gray-200">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-gray-600 uppercase">Total Tagihan</span>
                            </div>
                            <div class="mt-1">
                                <span class="text-3xl font-bold text-blue-600">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons in Sidebar -->
                    @if($pembayaran->status === 'pending')
                    <div class="space-y-3">
                        <form action="{{ route('admin.pembayaran.verifikasi', $pembayaran->id) }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                Terima Pembayaran
                            </button>
                        </form>
                        <button onclick="if(confirm('Apakah Anda yakin ingin menolak pembayaran ini?')) { window.location.href='{{ route('admin.pembayaran') }}'; }" 
                                class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white border-2 border-red-600 text-red-600 font-medium rounded-lg hover:bg-red-50 transition-colors">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                            Tolak Pembayaran
                        </button>
                    </div>
                    
                    <!-- Info Note -->
                    <div class="mt-4 p-3 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex gap-2">
                            <svg class="w-5 h-5 text-blue-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-xs text-blue-800">Pastikan nominal transfer sesuai dengan total tagihan sebelum menerima pembayaran.</p>
                        </div>
                    </div>
                    @elseif($pembayaran->status === 'verified')
                    <a href="{{ route('admin.pembayaran.invoice', $pembayaran->id) }}" 
                       target="_blank"
                       class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Unduh Invoice
                    </a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Fullscreen Modal for Image Preview -->
<div id="imageModal" class="hidden fixed inset-0 bg-black bg-opacity-95 z-50 flex items-center justify-center p-4" onclick="closeImageModal()">
    <div class="relative max-w-full max-h-full">
        <button onclick="closeImageModal()" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors">
            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
        <img id="modalImage" src="/placeholder.svg" alt="Bukti Pembayaran" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl">
    </div>
</div>

<script>
function handleImageError(img, originalPath, attemptedUrl) {
    console.log('[v0] Image failed to load in admin panel');
    console.log('[v0] Original path:', originalPath);
    console.log('[v0] Attempted URL:', attemptedUrl);
    
    img.setAttribute('data-error', 'true');
    const container = img.parentElement;
    container.classList.remove('cursor-pointer', 'hover:border-blue-400');
    container.innerHTML = `
        <div class='p-6 text-center bg-red-50'>
            <svg class='w-12 h-12 text-red-400 mx-auto mb-2' fill='none' stroke='currentColor' viewBox='0 0 24 24'>
                <path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z'/>
            </svg>
            <p class='text-sm font-semibold text-red-800 mb-1'>Gambar tidak dapat dimuat</p>
            <p class='text-xs text-red-600 mb-2 font-mono break-all'>${originalPath}</p>
            <a href='${attemptedUrl}' target='_blank' class='inline-block mt-2 px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700'>
                Buka di tab baru
            </a>
            <p class='text-xs text-red-500 mt-3'>Periksa: php artisan storage:link</p>
        </div>
    `;
}

function openImageModal() {
    const modal = document.getElementById('imageModal');
    const modalImage = document.getElementById('modalImage');
    const paymentProof = document.getElementById('paymentProof');
    
    if (paymentProof && !paymentProof.getAttribute('data-error')) {
        modalImage.src = paymentProof.src;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeImageModal() {
    const modal = document.getElementById('imageModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeImageModal();
    }
});
</script>
@endsection
