@extends('admin.layout')

@section('title', 'Manajemen Reservasi')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Manajemen Reservasi</h1>
            <p class="text-sm text-gray-600">Kelola reservasi masuk, check-in, dan check-out tamu secara real-time.</p>
        </div>
        <div class="flex items-center gap-3">
            <button class="px-4 py-2 border border-gray-300 rounded-lg bg-white hover:bg-gray-50 flex items-center gap-2 text-sm font-medium text-gray-700">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                Semua Tanggal
            </button>
            <button onclick="openReservasiBaru()" class="px-4 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-2 text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Reservasi Baru
            </button>
        </div>
    </div>

    <!-- Added search bar matching wireframe -->
    <div class="mb-6">
        <div class="relative max-w-md">
            <svg class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input 
                type="text" 
                placeholder="Cari ID reservasi atau nama tamu..." 
                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
            >
        </div>
    </div>

    <!-- Updated filter tabs with better styling -->
    <div class="mb-6 flex gap-2">
        <button onclick="filterReservasi('all')" class="px-4 py-2 text-sm font-medium rounded-lg {{ !request('status') ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
            Semua <span class="ml-1 px-2 py-0.5 bg-white/20 rounded-full text-xs">54</span>
        </button>
        <button onclick="filterReservasi('menunggu-konfirmasi')" class="px-4 py-2 text-sm font-medium rounded-lg {{ request('status') === 'menunggu-konfirmasi' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
            Menunggu Konfirmasi <span class="ml-1 px-2 py-0.5 bg-gray-100 rounded-full text-xs">4</span>
        </button>
        <button onclick="filterReservasi('check-in')" class="px-4 py-2 text-sm font-medium rounded-lg {{ request('status') === 'check-in' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
            Check-In <span class="ml-1 px-2 py-0.5 bg-gray-100 rounded-full text-xs">8</span>
        </button>
        <button onclick="filterReservasi('check-out')" class="px-4 py-2 text-sm font-medium rounded-lg {{ request('status') === 'check-out' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
            Check-Out
        </button>
        <button onclick="filterReservasi('selesai')" class="px-4 py-2 text-sm font-medium rounded-lg {{ request('status') === 'selesai' ? 'bg-blue-600 text-white' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-50' }}">
            Selesai
        </button>
    </div>

    <!-- Updated table headers and content matching wireframe exactly -->
    <div class="bg-white rounded-xl border border-gray-200">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50 border-b border-gray-200">
                    <tr>
                        <th class="px-6 py-3 text-left">
                            <input type="checkbox" class="rounded border-gray-300">
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">ID RESERVASI</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">TAMU & KONTAK</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">KAMAR</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">TANGGAL</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">STATUS</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider">AKSI</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse($reservasis as $reservasi)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <input type="checkbox" class="rounded border-gray-300">
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $reservasi->booking_id }}</div>
                            <div class="text-xs text-gray-500">Just now</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="w-8 h-8 bg-gradient-to-br from-blue-400 to-purple-500 rounded-full flex items-center justify-center mr-3 text-white font-medium text-sm">
                                    {{ substr($reservasi->nama_tamu, 0, 1) }}
                                </div>
                                <div>
                                    <div class="text-sm font-medium text-gray-900">{{ $reservasi->nama_tamu }}</div>
                                    <div class="text-xs text-gray-500">{{ $reservasi->no_telepon }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ $reservasi->kamar->nama_kamar ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-500">{{ ucfirst($reservasi->kamar->tipe_kamar ?? '') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">In: {{ \Carbon\Carbon::parse($reservasi->check_in)->format('d M Y') }}</div>
                            <div class="text-sm text-gray-900">Out: {{ \Carbon\Carbon::parse($reservasi->check_out)->format('d M Y') }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($reservasi->status === 'confirmed')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-green-100 text-green-800">
                                    Confirmed
                                </span>
                            @elseif($reservasi->status === 'check-in')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-blue-100 text-blue-800">
                                    Check-in
                                </span>
                            @elseif($reservasi->status === 'menunggu')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-yellow-100 text-yellow-800">
                                    Menunggu
                                </span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-medium rounded-full bg-gray-100 text-gray-800">
                                    {{ ucfirst($reservasi->status) }}
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <button class="px-3 py-1.5 bg-blue-600 text-white text-xs font-medium rounded-lg hover:bg-blue-700">
                                    Konfirmasi
                                </button>
                                <button onclick="lihatDetail({{ $reservasi->id }})" class="p-1.5 text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                    </svg>
                                </button>
                                <button onclick="editReservasi({{ $reservasi->id }})" class="p-1.5 text-gray-400 hover:text-gray-600">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                            </svg>
                            <p class="text-gray-500 text-sm">Tidak ada reservasi ditemukan</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Added pagination footer matching wireframe -->
        @if($reservasis->hasPages())
        <div class="px-6 py-4 border-t border-gray-200 flex items-center justify-between">
            <p class="text-sm text-gray-600">
                Menampilkan 1-4 dari 54 data
            </p>
            <div class="flex gap-1">
                <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </button>
                <button class="px-3 py-1 bg-blue-600 text-white rounded-lg">1</button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50">2</button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50">3</button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50">4</button>
                <button class="px-3 py-1 border border-gray-300 rounded-lg hover:bg-gray-50">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </button>
            </div>
        </div>
        @endif
    </div>
</div>

<script>
function filterReservasi(status) {
    if (status === 'all') {
        window.location.href = "{{ route('admin.reservasi') }}";
    } else {
        window.location.href = `{{ route('admin.reservasi') }}?status=${status}`;
    }
}

function openReservasiBaru() {
    window.location.href = "{{ route('admin.reservasi.create') }}";
}

function lihatDetail(id) {
    window.location.href = `/admin/reservasi/${id}`;
}

function editReservasi(id) {
    window.location.href = `/admin/reservasi/${id}/edit`;
}
</script>
@endsection
