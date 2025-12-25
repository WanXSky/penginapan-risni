@extends('layouts.app')

@section('title', 'Kamar ' . ucfirst($tipeKamar ?? 'Semua') . ' - Penginapan Risni')

@section('content')
<div class="min-h-screen pt-20 pb-12 bg-gray-50">
    <div class="max-w-7xl mx-auto px-6">
        
        <!-- Back Button -->
        <div class="mb-8">
            <a href="/" class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 transition font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>

        <!-- Page Title -->
        <div class="text-center mb-12">
            @if($fromBooking ?? false)
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                    Kamar Semua
                </h1>
                <h2 class="text-xl md:text-2xl text-gray-600 mt-2">
                    Pilih kamar tambahan untuk reservasi Anda
                </h2>
            @else
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                    Kamar {{ ucfirst($tipeKamar) }}
                </h1>
                <h2 class="text-xl md:text-2xl text-gray-600 mt-2">
                    Penginapan Risni
                </h2>
            @endif
        </div>

        <!-- Date Selector for Real-time Check -->
        <div class="bg-white rounded-xl shadow-md p-6 mb-8">
            <div class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Pilih Tanggal Check-in
                    </label>
                    <input 
                        type="date" 
                        id="checkinDate" 
                        value="{{ $tanggalCheckin ?? date('Y-m-d') }}"
                        min="{{ date('Y-m-d') }}"
                        class="w-full border border-gray-300 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                    >
                </div>
                <button 
                    id="checkAvailabilityBtn"
                    class="w-full md:w-auto px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-2"
                >
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                    </svg>
                    Cek Ketersediaan
                </button>
            </div>
        </div>

        <!-- Rooms Grid -->
        <div id="roomsGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @forelse ($kamars as $kamar)
                <div class="room-card bg-white border-2 border-gray-200 rounded-2xl overflow-hidden hover:shadow-xl transition" data-kamar-id="{{ $kamar->id }}">
                    
                    <!-- Room Image -->
                    <div class="aspect-video bg-gray-100 relative">
                        @if($kamar->gambar_utama)
                            <img src="{{ asset('storage/' . $kamar->gambar_utama) }}" alt="{{ $kamar->nama_kamar }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                        @endif
                        
                        <!-- Loading Overlay -->
                        <div class="loading-overlay hidden absolute inset-0 bg-black/40 flex items-center justify-center">
                            <div class="animate-spin rounded-full h-12 w-12 border-4 border-white border-t-transparent"></div>
                        </div>
                    </div>

                    <!-- Room Info -->
                    <div class="p-6">
                        <!-- Simplified to only use nama_kamar from database -->
                        <h3 class="text-xl font-bold text-gray-800 mb-2">
                            {{ $kamar->nama_kamar }}
                        </h3>

                        <!-- Added price display -->
                        <p class="text-2xl font-bold text-blue-600 mb-3">
                            Rp {{ number_format($kamar->harga, 0, ',', '.') }}
                            <span class="text-sm text-gray-500 font-normal">/ malam</span>
                        </p>

                        <!-- Availability Status -->
                        <div class="availability-status mb-4">
                            <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold bg-gray-100 text-gray-600">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                Cek ketersediaan
                            </span>
                        </div>

                        <!-- Added buttons container with View and Book buttons -->
                        <div class="flex gap-2">
                            <a href="{{ route('kamar.show', $kamar->id) }}" 
                               class="flex-1 py-3 text-center rounded-lg font-semibold transition border-2 border-blue-600 text-blue-600 hover:bg-blue-50">
                                Lihat Detail
                            </a>
                            <button 
                               onclick="selectRoom({{ $kamar->id }})"
                               data-kamar-id="{{ $kamar->id }}"
                               class="book-room-btn flex-1 py-3 text-center rounded-lg font-semibold transition bg-gray-300 text-gray-500 cursor-not-allowed pointer-events-none">
                                {{ request('from_booking') ? 'Pilih Kamar' : 'Pesan Kamar' }}
                            </button>
                        </div>
                        
                    </div>
                </div>
            @empty
                <div class="col-span-full text-center py-12">
                    <p class="text-gray-500 text-lg">Tidak ada kamar tersedia untuk kategori ini.</p>
                </div>
            @endforelse
        </div>

    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const checkinInput = document.getElementById('checkinDate');
    const checkBtn = document.getElementById('checkAvailabilityBtn');
    const tipeKamar = '{{ $tipeKamar }}';
    const fromBooking = {{ ($fromBooking ?? false) ? 'true' : 'false' }};

    @if($tanggalCheckin)
        checkAllAvailability();
    @endif

    // Check availability on button click
    checkBtn.addEventListener('click', function() {
        checkAllAvailability();
    });

    // Also check when date changes
    checkinInput.addEventListener('change', function() {
        checkAllAvailability();
    });

    /**
     * Check all rooms availability (Real-time)
     */
    function checkAllAvailability() {
        const checkinDate = checkinInput.value;
        
        if (!checkinDate) {
            alert('Silakan pilih tanggal check-in');
            return;
        }

        console.log('[v0] Checking availability for:', { 
            tipe: fromBooking ? 'semua (all types)' : tipeKamar, 
            checkin: checkinDate,
            from_booking: fromBooking
        });

        // Show loading state
        const roomCards = document.querySelectorAll('.room-card');
        roomCards.forEach(card => {
            const overlay = card.querySelector('.loading-overlay');
            if (overlay) overlay.classList.remove('hidden');
        });

        const requestBody = {
            checkin: checkinDate,
            from_booking: fromBooking
        };
        
        // Only add tipe parameter if NOT from booking and tipe is a valid category
        if (!fromBooking && tipeKamar !== 'semua' && ['biasa', 'reguler', 'vip'].includes(tipeKamar.toLowerCase())) {
            requestBody.tipe = tipeKamar;
        }

        console.log('[v0] Request body:', requestBody);

        fetch('{{ route('kamar.checkAllAvailability') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            },
            body: JSON.stringify(requestBody)
        })
        .then(response => {
            console.log('[v0] Response status:', response.status);
            if (!response.ok) {
                return response.json().then(errData => {
                    console.error('[v0] Error response:', errData);
                    throw new Error(errData.message || 'Network response was not ok: ' + response.status);
                });
            }
            return response.json();
        })
        .then(data => {
            console.log('[v0] Response data:', data);
            if (data.success) {
                // Update each room card
                data.data.forEach(room => {
                    updateRoomCard(room.id, room.available);
                });
            } else {
                alert('Terjadi kesalahan saat mengecek ketersediaan: ' + (data.message || 'Unknown error'));
                console.error('[v0] API error:', data);
            }
        })
        .catch(error => {
            console.error('[v0] Error checking availability:', error);
            alert('Terjadi kesalahan koneksi: ' + error.message);
        })
        .finally(() => {
            // Hide loading state
            const roomCards = document.querySelectorAll('.room-card');
            roomCards.forEach(card => {
                const overlay = card.querySelector('.loading-overlay');
                if (overlay) overlay.classList.add('hidden');
            });
        });
    }

    /**
     * Update room card UI based on availability
     */
    function updateRoomCard(kamarId, isAvailable) {
        const card = document.querySelector(`[data-kamar-id="${kamarId}"]`);
        if (!card) {
            console.warn('[v0] Card not found for kamar ID:', kamarId);
            return;
        }

        const statusBadge = card.querySelector('.availability-status');
        const bookBtn = card.querySelector('.book-room-btn');
        const imageContainer = card.querySelector('.aspect-video');

        const existingOverlay = imageContainer.querySelector('.unavailable-overlay');
        if (existingOverlay) {
            existingOverlay.remove();
        }

        if (isAvailable) {
            statusBadge.innerHTML = `
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold bg-green-100 text-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tersedia
                </span>
            `;
            
            bookBtn.classList.remove('bg-gray-300', 'text-gray-500', 'cursor-not-allowed', 'pointer-events-none');
            bookBtn.classList.add('bg-blue-600', 'text-white', 'hover:bg-blue-700', 'cursor-pointer');
        } else {
            statusBadge.innerHTML = `
                <span class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full text-sm font-semibold bg-red-100 text-red-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    Tidak Tersedia
                </span>
            `;

            const overlay = document.createElement('div');
            overlay.className = 'unavailable-overlay absolute inset-0 bg-black/50 flex items-center justify-center';
            overlay.innerHTML = `
                <svg xmlns="http://www.w3.org/2000/svg" class="w-24 h-24 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="3">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            `;
            imageContainer.appendChild(overlay);
            
            bookBtn.classList.remove('bg-blue-600', 'text-white', 'hover:bg-blue-700', 'cursor-pointer');
            bookBtn.classList.add('bg-gray-300', 'text-gray-500', 'cursor-not-allowed', 'pointer-events-none');
        }

        console.log('[v0] Updated card for kamar', kamarId, '- Available:', isAvailable);
    }
});

function selectRoom(kamarId) {
    const fromBooking = {{ ($fromBooking ?? false) ? 'true' : 'false' }};
    const checkinDate = document.getElementById('checkinDate').value;
    
    if (!fromBooking) {
        // Normal booking flow - just redirect with single room
        window.location.href = '{{ route("reservasi.create") }}?kamar_id=' + kamarId + '&checkin=' + checkinDate;
        return;
    }
    
    // When adding more rooms - get existing kamar_ids from sessionStorage
    const savedData = sessionStorage.getItem('reservasiFormData');
    let existingKamarIds = [];
    
    if (savedData) {
        const data = JSON.parse(savedData);
        existingKamarIds = data.kamar_ids || [];
    }
    
    // Check if room is already selected
    if (existingKamarIds.includes(kamarId.toString())) {
        alert('Kamar ini sudah dipilih sebelumnya');
        return;
    }
    
    // Add new room to the list
    existingKamarIds.push(kamarId.toString());
    
    // Build URL with all kamar_ids
    const kamarIdsParam = existingKamarIds.map(id => 'kamar_id[]=' + id).join('&');
    window.location.href = '{{ route("reservasi.create") }}?' + kamarIdsParam + '&checkin=' + checkinDate + '&add_more=1';
}
</script>
@endpush

@endsection
