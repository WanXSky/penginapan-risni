@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 py-8 pt-24">
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Konfirmasi Pembayaran</h1>
        <p class="text-gray-600">Amankan pesanan Anda dengan mengonfirmasi detail pembayaran.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Left Sidebar: Ringkasan Pemesanan -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-5 h-5 text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h2 class="text-lg font-semibold text-gray-900">Ringkasan Pemesanan</h2>
                </div>
                
                <div class="bg-blue-50 rounded-lg p-4 mb-4">
                    <p class="text-sm text-gray-600 mb-1">Total Pembayaran</p>
                    <p class="text-3xl font-bold text-gray-900">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</p>
                </div>
                
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID Pemesanan</span>
                        <span class="font-semibold text-gray-900">#PR-{{ str_pad($reservasi->id, 4, '0', STR_PAD_LEFT) }}</span>
                    </div>
                    
                    <div class="flex justify-between">
                        <span class="text-gray-600">Nama Tamu</span>
                        <span class="font-semibold text-gray-900">{{ $reservasi->nama_lengkap }}</span>
                    </div>
                    
                    <div class="flex justify-between items-start">
                        <span class="text-gray-600">Kamar yang dipesan</span>
                        <div class="text-right">
                            @foreach($reservasi->details as $detail)
                                <span class="font-semibold text-gray-900 block">{{ $detail->kamar->nama_kamar }}</span>
                            @endforeach
                        </div>
                    </div>
                    
                    <div class="flex justify-between items-start">
                        <span class="text-gray-600">Check-in & Check-out</span>
                        <div class="text-right">
                            <span class="font-semibold text-gray-900 block">
                                {{ \Carbon\Carbon::parse($reservasi->check_in)->format('d M') }} - 
                                {{ \Carbon\Carbon::parse($reservasi->check_out)->format('d M, Y') }}
                            </span>
                            <p class="text-xs text-blue-600 mt-1">
                                {{ \Carbon\Carbon::parse($reservasi->check_in)->diffInDays($reservasi->check_out) }} Malam
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Content: Konfirmasi Pembayaran -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-lg shadow-md p-6">
                
                {{-- Remove onsubmit from form, use button onclick instead for more reliable validation --}}
                <form action="{{ route('reservasi.konfirmasi.store', $reservasi->id) }}" method="POST" enctype="multipart/form-data" id="paymentForm">
                    @csrf
                    
                    <!-- Hidden input for payment method -->
                    <input type="hidden" name="metode_pembayaran" id="metode_pembayaran" value="transfer">
                    
                    <!-- Payment Method Tabs -->
                    <div class="mb-6">
                        <div class="flex gap-2 mb-6" role="tablist">
                            <button 
                                type="button"
                                onclick="selectPaymentTab('transfer')"
                                id="tab-transfer"
                                class="payment-tab px-6 py-3 rounded-lg font-medium transition-all flex items-center gap-2 bg-blue-500 text-white">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path>
                                </svg>
                                Transfer Bank
                            </button>
                            <button 
                                type="button"
                                onclick="selectPaymentTab('qris')"
                                id="tab-qris"
                                class="payment-tab px-6 py-3 rounded-lg font-medium transition-all flex items-center gap-2 bg-gray-100 text-gray-700 hover:bg-gray-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                </svg>
                                QRIS
                            </button>
                            <button 
                                type="button"
                                onclick="selectPaymentTab('cash')"
                                id="tab-cash"
                                class="payment-tab px-6 py-3 rounded-lg font-medium transition-all flex items-center gap-2 bg-gray-100 text-gray-700 hover:bg-gray-200">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path>
                                </svg>
                                Tunai
                            </button>
                        </div>
                        
                        <!-- Payment Content Sections -->
                        <div class="payment-contents">
                            
                            <!-- Transfer Bank Content -->
                            <div id="content-transfer" class="payment-content" style="display: block;">
                                <div class="bg-blue-50 rounded-lg p-4 mb-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 mb-1">Instruksi Transfer Bank</h3>
                                            <p class="text-sm text-gray-600">Silakan transfer jumlah tepat ke:</p>
                                        </div>
                                    </div>
                                </div>
                                
                                @php
                                    $transferMetode = $metodePembayaran->first(function($item) {
                                        return stripos($item->nama, 'transfer') !== false;
                                    });
                                @endphp
                                
                                @if($transferMetode && $transferMetode->nomor_rekening)
                                <div class="bg-gray-50 rounded-lg p-4 mb-4">
                                    <div class="flex justify-between items-start mb-3">
                                        <div>
                                            <p class="font-bold text-blue-600 text-lg">{{ $transferMetode->nama_bank ?? 'Bank' }}</p>
                                            <p class="text-sm text-gray-500">{{ $transferMetode->nama_bank ?? 'Bank' }}</p>
                                        </div>
                                        <button type="button" onclick="copyToClipboard('{{ $transferMetode->nomor_rekening }}')" class="text-blue-500 hover:text-blue-600 flex items-center gap-1 text-sm">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                            </svg>
                                            Salin
                                        </button>
                                    </div>
                                    <p class="text-2xl font-bold tracking-wider text-gray-900 mb-2">{{ $transferMetode->nomor_rekening }}</p>
                                    <p class="text-sm text-gray-600">Atas Nama: <span class="font-semibold text-gray-900">{{ $transferMetode->nama_rekening ?? 'Penginapan Risni' }}</span></p>
                                </div>
                                @else
                                <div class="bg-red-50 rounded-lg p-4 mb-4">
                                    <p class="text-red-600">Nomor rekening belum tersedia. Silakan hubungi admin.</p>
                                </div>
                                @endif
                                
                                <!-- Upload Section Transfer -->
                                <div class="mt-6">
                                    <h4 class="font-semibold text-gray-900 mb-3">Unggah Bukti Pembayaran</h4>
                                    <div id="upload-area-transfer" class="border-2 border-dashed border-blue-200 rounded-lg p-8 text-center hover:border-blue-400 transition-colors cursor-pointer bg-blue-50/30" onclick="document.getElementById('bukti_pembayaran').click()">
                                        <input type="file" name="bukti_pembayaran" id="bukti_pembayaran" accept="image/*,.pdf" class="hidden" onchange="previewFile(this)">
                                        
                                        <div id="upload-placeholder-transfer">
                                            <svg class="w-12 h-12 mx-auto text-blue-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="text-gray-600 mb-1">Klik untuk unggah atau seret file</p>
                                            <p class="text-sm text-gray-400">JPG, PNG, PDF (maks. 5MB)</p>
                                        </div>
                                        
                                        <div id="image-preview-container-transfer" class="hidden">
                                            <img id="image-preview-transfer" src="/placeholder.svg" alt="Preview" class="max-h-48 mx-auto rounded-lg mb-3">
                                            <div class="flex items-center justify-center gap-2 text-green-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span id="file-name-transfer" class="text-sm font-medium"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- QRIS Content -->
                            <div id="content-qris" class="payment-content" style="display: none;">
                                <div class="bg-blue-50 rounded-lg p-4 mb-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 mb-1">Instruksi QRIS</h3>
                                            <p class="text-sm text-gray-600">Scan kode QR menggunakan aplikasi dompet digital Anda</p>
                                        </div>
                                    </div>
                                </div>
                                
                                @php
                                    $qrisMetode = $metodePembayaran->first(function($item) {
                                        return stripos($item->nama, 'qris') !== false;
                                    });
                                @endphp
                                
                                <!-- QR Code Display -->
                                <div class="bg-gray-50 rounded-lg p-6 mb-4">
                                    <div class="text-center">
                                        @if($qrisMetode && $qrisMetode->qr_code)
                                            <div class="cursor-pointer inline-block" onclick="openQRModal('{{ asset($qrisMetode->qr_code) }}')">
                                                <img src="{{ asset($qrisMetode->qr_code) }}" alt="QR Code QRIS" class="w-48 h-48 mx-auto object-contain mb-3 hover:opacity-80 transition-opacity">
                                                <p class="text-sm text-gray-500 flex items-center justify-center gap-1">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path>
                                                    </svg>
                                                    Klik gambar untuk memperbesar
                                                </p>
                                            </div>
                                        @else
                                            <div class="w-48 h-48 mx-auto bg-gray-200 rounded-lg flex items-center justify-center mb-3">
                                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"></path>
                                                </svg>
                                            </div>
                                            <p class="text-red-500 text-sm">QR Code belum tersedia</p>
                                        @endif
                                        <p class="text-gray-900 font-semibold">QR Code QRIS</p>
                                        <p class="text-sm text-gray-500">Scan untuk membayar</p>
                                    </div>
                                </div>
                                
                                <!-- Upload Section QRIS -->
                                <div class="mt-6">
                                    <h4 class="font-semibold text-gray-900 mb-3">Unggah Bukti Pembayaran QRIS</h4>
                                    <div id="upload-area-qris" class="border-2 border-dashed border-blue-200 rounded-lg p-8 text-center hover:border-blue-400 transition-colors cursor-pointer bg-blue-50/30" onclick="document.getElementById('bukti_pembayaran_qris').click()">
                                        <input type="file" name="bukti_pembayaran_qris" id="bukti_pembayaran_qris" accept="image/*,.pdf" class="hidden" onchange="previewFileQris(this)">
                                        
                                        <div id="upload-placeholder-qris">
                                            <svg class="w-12 h-12 mx-auto text-blue-300 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                                            </svg>
                                            <p class="text-gray-600 mb-1">Klik untuk unggah atau seret file</p>
                                            <p class="text-sm text-gray-400">JPG, PNG, PDF (maks. 5MB)</p>
                                        </div>
                                        
                                        <div id="image-preview-container-qris" class="hidden">
                                            <img id="image-preview-qris" src="/placeholder.svg" alt="Preview" class="max-h-48 mx-auto rounded-lg mb-3">
                                            <div class="flex items-center justify-center gap-2 text-green-600">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                                </svg>
                                                <span id="file-name-qris" class="text-sm font-medium"></span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Cash Content -->
                            <div id="content-cash" class="payment-content" style="display: none;">
                                <div class="bg-green-50 rounded-lg p-4 mb-4">
                                    <div class="flex items-start gap-3">
                                        <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <h3 class="font-semibold text-gray-900 mb-1">Pembayaran Tunai</h3>
                                            <p class="text-sm text-gray-600">Pembayaran dilakukan langsung saat check-in di penginapan</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 rounded-lg p-6">
                                    <div class="text-center py-4">
                                        <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                            <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                                            </svg>
                                        </div>
                                        <h4 class="font-semibold text-gray-900 mb-2">Siapkan Uang Tunai</h4>
                                        <p class="text-gray-600 text-sm mb-4">Silakan siapkan uang tunai sebesar:</p>
                                        <p class="text-3xl font-bold text-green-600 mb-4">Rp {{ number_format($reservasi->total_harga, 0, ',', '.') }}</p>
                                        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3 mt-4">
                                            <div class="flex items-center justify-center gap-2 text-yellow-700">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                                                </svg>
                                                <p class="text-sm">Pastikan Anda membawa uang tunai yang cukup saat check-in.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-4 justify-end mt-8">
                        <a href="{{ route('reservasi.create', ['kamar_id' => $reservasi->details->pluck('kamar_id')->toArray(), 'checkin' => $reservasi->check_in]) }}" class="px-6 py-3 border-2 border-gray-300 rounded-lg font-semibold text-gray-700 hover:bg-gray-50 transition-colors">
                            Kembali ke Detail Pemesanan
                        </a>
                        {{-- Change submit button to type="button" with onclick handler --}}
                        <button type="button" id="btn-konfirmasi" onclick="handleSubmit()" class="px-6 py-3 bg-blue-500 text-white rounded-lg font-semibold hover:bg-blue-600 transition-colors flex items-center gap-2">
                            Konfirmasi Pemesanan
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path>
                            </svg>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

{{-- Completely rewritten JavaScript with better error handling --}}
<script>
// Global variables
var currentMethod = 'transfer';

// Main submit handler function
function handleSubmit() {
    var method = document.getElementById('metode_pembayaran').value;
    var form = document.getElementById('paymentForm');
    
    console.log('[v0] handleSubmit called, method:', method);
    
    // Cash - no validation needed, submit directly
    if (method === 'cash') {
        console.log('[v0] Cash method - submitting form');
        form.submit();
        return;
    }
    
    // Transfer - check file upload
    if (method === 'transfer') {
        var fileInput = document.getElementById('bukti_pembayaran');
        console.log('[v0] Transfer - checking file input:', fileInput);
        console.log('[v0] Transfer - files:', fileInput ? fileInput.files : 'no input');
        
        if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
            alert('PERHATIAN!\n\nAnda memilih metode Transfer Bank.\nSilakan upload bukti transfer terlebih dahulu sebelum melanjutkan.');
            var uploadArea = document.getElementById('upload-area-transfer');
            if (uploadArea) {
                uploadArea.scrollIntoView({ behavior: 'smooth', block: 'center' });
                uploadArea.style.borderColor = '#ef4444';
                uploadArea.style.backgroundColor = '#fef2f2';
                setTimeout(function() {
                    uploadArea.style.borderColor = '';
                    uploadArea.style.backgroundColor = '';
                }, 3000);
            }
            return;
        }
        // Transfer validation passed, submit
        console.log('[v0] Transfer validation passed - submitting form');
        form.submit();
        return;
    }
    
    // QRIS - check file upload
    if (method === 'qris') {
        var fileInputQris = document.getElementById('bukti_pembayaran_qris');
        console.log('[v0] QRIS - checking file input:', fileInputQris);
        console.log('[v0] QRIS - files:', fileInputQris ? fileInputQris.files : 'no input');
        
        if (!fileInputQris || !fileInputQris.files || fileInputQris.files.length === 0) {
            alert('PERHATIAN!\n\nAnda memilih metode QRIS.\nSilakan upload bukti pembayaran QRIS terlebih dahulu sebelum melanjutkan.');
            var uploadAreaQris = document.getElementById('upload-area-qris');
            if (uploadAreaQris) {
                uploadAreaQris.scrollIntoView({ behavior: 'smooth', block: 'center' });
                uploadAreaQris.style.borderColor = '#ef4444';
                uploadAreaQris.style.backgroundColor = '#fef2f2';
                setTimeout(function() {
                    uploadAreaQris.style.borderColor = '';
                    uploadAreaQris.style.backgroundColor = '';
                }, 3000);
            }
            return;
        }
        // QRIS validation passed, submit
        console.log('[v0] QRIS validation passed - submitting form');
        form.submit();
        return;
    }
    
    // Fallback - should not reach here, but submit anyway
    console.log('[v0] Fallback - submitting form');
    form.submit();
}

// Tab selection function
function selectPaymentTab(method) {
    currentMethod = method;
    
    // Update hidden input
    document.getElementById('metode_pembayaran').value = method;
    
    // Update tab styles
    var tabs = document.querySelectorAll('.payment-tab');
    for (var i = 0; i < tabs.length; i++) {
        tabs[i].classList.remove('bg-blue-500', 'text-white');
        tabs[i].classList.add('bg-gray-100', 'text-gray-700');
    }
    
    var selectedTab = document.getElementById('tab-' + method);
    if (selectedTab) {
        selectedTab.classList.remove('bg-gray-100', 'text-gray-700');
        selectedTab.classList.add('bg-blue-500', 'text-white');
    }
    
    // Show/hide content
    var contents = document.querySelectorAll('.payment-content');
    for (var j = 0; j < contents.length; j++) {
        contents[j].style.display = 'none';
    }
    
    var selectedContent = document.getElementById('content-' + method);
    if (selectedContent) {
        selectedContent.style.display = 'block';
    }
}

// File preview for Transfer
function previewFile(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var fileName = file.name;
        
        var placeholder = document.getElementById('upload-placeholder-transfer');
        var previewContainer = document.getElementById('image-preview-container-transfer');
        var previewImage = document.getElementById('image-preview-transfer');
        var fileNameSpan = document.getElementById('file-name-transfer');
        
        if (file.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                if (placeholder) placeholder.classList.add('hidden');
                if (previewContainer) previewContainer.classList.remove('hidden');
                if (previewImage) previewImage.src = e.target.result;
                if (fileNameSpan) fileNameSpan.textContent = fileName;
            };
            reader.readAsDataURL(file);
        } else {
            if (placeholder) placeholder.classList.add('hidden');
            if (previewContainer) previewContainer.classList.remove('hidden');
            if (previewImage) previewImage.style.display = 'none';
            if (fileNameSpan) fileNameSpan.textContent = fileName;
        }
    }
}

// File preview for QRIS
function previewFileQris(input) {
    if (input.files && input.files[0]) {
        var file = input.files[0];
        var fileName = file.name;
        
        var placeholder = document.getElementById('upload-placeholder-qris');
        var previewContainer = document.getElementById('image-preview-container-qris');
        var previewImage = document.getElementById('image-preview-qris');
        var fileNameSpan = document.getElementById('file-name-qris');
        
        if (file.type.startsWith('image/')) {
            var reader = new FileReader();
            reader.onload = function(e) {
                if (placeholder) placeholder.classList.add('hidden');
                if (previewContainer) previewContainer.classList.remove('hidden');
                if (previewImage) previewImage.src = e.target.result;
                if (fileNameSpan) fileNameSpan.textContent = fileName;
            };
            reader.readAsDataURL(file);
        } else {
            if (placeholder) placeholder.classList.add('hidden');
            if (previewContainer) previewContainer.classList.remove('hidden');
            if (previewImage) previewImage.style.display = 'none';
            if (fileNameSpan) fileNameSpan.textContent = fileName;
        }
    }
}

// Copy to clipboard
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(function() {
            alert('Nomor rekening berhasil disalin!');
        });
    } else {
        var textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        alert('Nomor rekening berhasil disalin!');
    }
}

// QR Modal functions
function openQRModal(imageSrc) {
    var modal = document.getElementById('qr-modal');
    var modalImage = document.getElementById('qr-modal-image');
    if (modal && modalImage) {
        modalImage.src = imageSrc;
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
}

function closeQRModal() {
    var modal = document.getElementById('qr-modal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
    }
}

// Close modal with Escape key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeQRModal();
    }
});
</script>

<!-- Modal for QR Code Preview -->
<div id="qr-modal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4" onclick="closeQRModal()">
    <div class="relative max-w-4xl w-full">
        <button type="button" class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors" onclick="closeQRModal()">
            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
        <div class="bg-white rounded-lg p-8 text-center" onclick="event.stopPropagation()">
            <img id="qr-modal-image" src="/placeholder.svg" alt="QR Code" class="max-w-full max-h-[80vh] mx-auto object-contain">
            <p class="text-gray-600 text-sm mt-4">Klik di luar gambar untuk menutup</p>
        </div>
    </div>
</div>
@endsection
