@extends('admin.layout')

@section('title', 'Ikhtisar Admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Ikhtisar Admin</h1>
        <p class="text-gray-600">Selamat datang kembali, berikut ringkasan operasional hari ini.</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Kamar -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 mb-1">Total Kamar</p>
                    <p class="text-4xl font-bold text-gray-900">{{ $totalKamar }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Kamar Tersedia -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-green-600 mb-1">Kamar Tersedia</p>
                    <p class="text-4xl font-bold text-gray-900">{{ $kamarTersedia }}</p>
                </div>
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Reservasi Aktif -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-blue-600 mb-1">Reservasi Aktif</p>
                    <p class="text-4xl font-bold text-gray-900">{{ $reservasiAktif }}</p>
                </div>
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                </div>
            </div>
        </div>

        <!-- Pembayaran Tertunda -->
        <div class="bg-white rounded-xl p-6 border border-gray-200 border-l-4 border-l-orange-500 hover:shadow-lg transition-shadow">
            <div class="flex items-start justify-between">
                <div>
                    <p class="text-sm font-medium text-orange-600 mb-1">Pembayaran Tertunda</p>
                    <p class="text-4xl font-bold text-gray-900">{{ $pembayaranTertunda }}</p>
                </div>
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <div class="relative">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reservasi Terbaru -->
    <div class="bg-white rounded-xl border border-gray-200 mb-8">
        <div class="p-6 border-b border-gray-200 flex items-center justify-between">
            <h2 class="text-xl font-semibold text-gray-900">Reservasi Terbaru</h2>
            <a href="{{ route('admin.reservasi') }}" class="text-sm text-blue-600 hover:text-blue-700 font-medium">
                Lihat Semua
            </a>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">ID Booking</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">Nama Tamu</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">Check-in</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">Check-out</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reservasiTerbaru as $reservasi)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $reservasi->generateBookingId() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mr-3 text-white font-semibold text-sm">
                                    {{ strtoupper(substr($reservasi->nama_lengkap ?? 'U', 0, 2)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $reservasi->nama_lengkap ?? 'Guest' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ \Carbon\Carbon::parse($reservasi->check_in)->locale('id')->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            {{ \Carbon\Carbon::parse($reservasi->check_out)->locale('id')->translatedFormat('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($reservasi->status === 'confirmed')
                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-medium rounded-full bg-green-100 text-green-800">
                                    <span class="w-1.5 h-1.5 bg-green-600 rounded-full mr-1.5"></span>
                                    Confirmed
                                </span>
                            @elseif($reservasi->status === 'check-in')
                                <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-medium rounded-full bg-blue-100 text-blue-800">
                                    <span class="w-1.5 h-1.5 bg-blue-600 rounded-full mr-1.5"></span>
                                    Check-In
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-gray-100 text-gray-800">
                                    {{ ucfirst($reservasi->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm">
                            <a href="{{ route('admin.pembayaran.detail', $reservasi->pembayaran->id ?? $reservasi->id) }}" class="text-blue-600 hover:text-blue-700 font-medium hover:underline">
                                Lihat Detail
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-6 py-12 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-gray-500 text-sm">Tidak ada reservasi terbaru</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Verifikasi Pembayaran Tertunda -->
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="p-6 border-b border-gray-200 flex items-start gap-3">
            <div class="w-6 h-6 bg-orange-100 rounded-lg flex items-center justify-center flex-shrink-0">
                <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                </svg>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-900">Verifikasi Pembayaran Tertunda</h2>
            </div>
        </div>
        
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">ID Booking</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">Nama Tamu</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">Metode</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">Status Pembayaran</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-blue-600 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($pembayaranVerifikasi as $pembayaran)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $pembayaran->reservasi->generateBookingId() }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-10 h-10 bg-gradient-to-br from-purple-500 to-pink-500 rounded-full flex items-center justify-center mr-3 text-white font-semibold text-sm">
                                    {{ strtoupper(substr($pembayaran->reservasi->nama_lengkap ?? 'U', 0, 2)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-900">{{ $pembayaran->reservasi->nama_lengkap ?? 'Guest' }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-700">
                            @if($pembayaran->metode === 'transfer')
                                Transfer Bank BCA
                            @elseif($pembayaran->metode === 'qris')
                                E-Wallet (OVO)
                            @else
                                {{ ucfirst($pembayaran->metode) }}
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-3 py-1 inline-flex items-center text-xs leading-5 font-medium rounded-full bg-orange-100 text-orange-800">
                                <span class="w-1.5 h-1.5 bg-orange-600 rounded-full mr-1.5"></span>
                                Menunggu Verifikasi
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <a 
                                href="{{ route('admin.pembayaran.detail', $pembayaran->id) }}"
                                class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors shadow-sm inline-block"
                            >
                                Verifikasi Pembayaran
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-12 text-center">
                            <svg class="w-12 h-12 text-gray-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <p class="text-gray-500 text-sm">Tidak ada pembayaran yang menunggu verifikasi</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

@endsection
