@extends('layouts.app')

@section('title', 'Reservasi Saya - Penginapan Risni')

@section('content')
<div class="min-h-screen pt-24 pb-16 bg-slate-50">
    <div class="max-w-6xl mx-auto px-6">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Reservasi Saya</h1>
            <p class="text-gray-600">Kelola dan lihat riwayat reservasi Anda</p>
        </div>

        {{-- Tabs --}}
        <div class="mb-6 border-b border-gray-200">
            <nav class="flex gap-8" id="reservasi-tabs">
                <button data-tab="aktif" class="tab-button active pb-4 px-1 font-semibold text-blue-600 border-b-2 border-blue-600 transition">
                    Reservasi Aktif
                </button>
                <button data-tab="riwayat" class="tab-button pb-4 px-1 font-semibold text-gray-500 hover:text-gray-700 border-b-2 border-transparent transition">
                    Riwayat
                </button>
            </nav>
        </div>

        {{-- Reservasi Aktif --}}
        <div id="tab-aktif" class="tab-content">
            @php
                // Dummy data untuk contoh
                $reservasiAktif = [
                    [
                        'id' => 1,
                        'kamar' => 'Kamar 1',
                        'tipe' => 'Biasa',
                        'checkin' => '2025-12-25',
                        'checkout' => '2025-12-27',
                        'status' => 'Menunggu Konfirmasi',
                        'total' => 186000,
                    ],
                    [
                        'id' => 2,
                        'kamar' => 'Kamar 10',
                        'tipe' => 'Reguler',
                        'checkin' => '2025-12-28',
                        'checkout' => '2025-12-30',
                        'status' => 'Dikonfirmasi',
                        'total' => 340000,
                    ],
                ];
            @endphp

            @if(count($reservasiAktif) > 0)
                <div class="space-y-4">
                    @foreach($reservasiAktif as $reservasi)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    
                                    {{-- Info Kamar --}}
                                    <div class="flex-1">
                                        <div class="flex items-start gap-4">
                                            <div class="w-20 h-20 rounded-lg bg-gradient-to-br from-blue-500 to-blue-600 flex items-center justify-center text-white font-bold text-xl">
                                                {{ substr($reservasi['kamar'], -1) }}
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="text-lg font-bold text-gray-800">{{ $reservasi['kamar'] }}</h3>
                                                <p class="text-sm text-gray-500 mb-2">Tipe: {{ $reservasi['tipe'] }}</p>
                                                
                                                <div class="flex items-center gap-4 text-sm">
                                                    <div class="flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="text-gray-600">{{ date('d M Y', strtotime($reservasi['checkin'])) }}</span>
                                                    </div>
                                                    <span class="text-gray-400">→</span>
                                                    <div class="flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="text-gray-600">{{ date('d M Y', strtotime($reservasi['checkout'])) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Status & Actions --}}
                                    <div class="flex flex-col items-end gap-3">
                                        @if($reservasi['status'] == 'Menunggu Konfirmasi')
                                            <span class="px-4 py-2 bg-yellow-100 text-yellow-700 text-sm font-semibold rounded-lg">
                                                {{ $reservasi['status'] }}
                                            </span>
                                        @elseif($reservasi['status'] == 'Dikonfirmasi')
                                            <span class="px-4 py-2 bg-green-100 text-green-700 text-sm font-semibold rounded-lg">
                                                {{ $reservasi['status'] }}
                                            </span>
                                        @endif
                                        
                                        <p class="text-lg font-bold text-gray-800">Rp {{ number_format($reservasi['total'], 0, ',', '.') }}</p>
                                        
                                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                            Lihat Detail →
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Reservasi Aktif</h3>
                    <p class="text-gray-600 mb-6">Anda belum memiliki reservasi yang aktif saat ini</p>
                    <a href="{{ route('pesan') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Pesan Kamar Sekarang
                    </a>
                </div>
            @endif
        </div>

        {{-- Riwayat Reservasi --}}
        <div id="tab-riwayat" class="tab-content hidden">
            @php
                // Dummy data riwayat
                $riwayat = [
                    [
                        'id' => 3,
                        'kamar' => 'Kamar 18',
                        'tipe' => 'VIP',
                        'checkin' => '2025-11-15',
                        'checkout' => '2025-11-17',
                        'status' => 'Selesai',
                        'total' => 380000,
                    ],
                ];
            @endphp

            @if(count($riwayat) > 0)
                <div class="space-y-4">
                    @foreach($riwayat as $reservasi)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition opacity-75">
                            <div class="p-6">
                                <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                                    
                                    {{-- Info Kamar --}}
                                    <div class="flex-1">
                                        <div class="flex items-start gap-4">
                                            <div class="w-20 h-20 rounded-lg bg-gradient-to-br from-gray-400 to-gray-500 flex items-center justify-center text-white font-bold text-xl">
                                                {{ substr($reservasi['kamar'], -2) }}
                                            </div>
                                            <div class="flex-1">
                                                <h3 class="text-lg font-bold text-gray-800">{{ $reservasi['kamar'] }}</h3>
                                                <p class="text-sm text-gray-500 mb-2">Tipe: {{ $reservasi['tipe'] }}</p>
                                                
                                                <div class="flex items-center gap-4 text-sm">
                                                    <div class="flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="text-gray-600">{{ date('d M Y', strtotime($reservasi['checkin'])) }}</span>
                                                    </div>
                                                    <span class="text-gray-400">→</span>
                                                    <div class="flex items-center gap-2">
                                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                        </svg>
                                                        <span class="text-gray-600">{{ date('d M Y', strtotime($reservasi['checkout'])) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Status & Actions --}}
                                    <div class="flex flex-col items-end gap-3">
                                        <span class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-semibold rounded-lg">
                                            {{ $reservasi['status'] }}
                                        </span>
                                        
                                        <p class="text-lg font-bold text-gray-800">Rp {{ number_format($reservasi['total'], 0, ',', '.') }}</p>
                                        
                                        <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                                            Lihat Detail →
                                        </a>
                                    </div>

                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                    <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Belum Ada Riwayat</h3>
                    <p class="text-gray-600">Anda belum memiliki riwayat reservasi</p>
                </div>
            @endif
        </div>

    </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabButtons = document.querySelectorAll('.tab-button');
        const tabContents = document.querySelectorAll('.tab-content');

        tabButtons.forEach(button => {
            button.addEventListener('click', function() {
                const tabName = this.getAttribute('data-tab');

                // Remove active class from all buttons
                tabButtons.forEach(btn => {
                    btn.classList.remove('active', 'text-blue-600', 'border-blue-600');
                    btn.classList.add('text-gray-500', 'border-transparent');
                });

                // Add active class to clicked button
                this.classList.add('active', 'text-blue-600', 'border-blue-600');
                this.classList.remove('text-gray-500', 'border-transparent');

                // Hide all tab contents
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                });

                // Show selected tab content
                document.getElementById('tab-' + tabName).classList.remove('hidden');
            });
        });
    });
</script>
@endpush
@endsection
