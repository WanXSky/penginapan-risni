@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50 py-8">
    <div class="max-w-4xl mx-auto px-4">
        <!-- Back Button -->
        <a href="{{ url()->previous() }}" class="inline-flex items-center text-gray-600 hover:text-gray-900 mb-6">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>

        <div class="bg-white rounded-lg shadow-sm p-6 md:p-8">
            <h1 class="text-2xl font-bold text-gray-900 mb-2">Selesaikan Pemesanan Anda</h1>
            <p class="text-gray-600 mb-6">Tinjau pilihan Anda dan isi detail di bawah ini.</p>

            @if(session('error'))
                <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded mb-6">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('reservasi.store') }}" method="POST" id="reservasiForm">
                @csrf

                <!-- Selected Rooms -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Kamar yang Dipilih</h2>
                    <div id="selectedRoomsContainer" class="space-y-4">
                        @forelse($selectedKamars as $index => $kamar)
                            <div class="flex items-start gap-4 p-4 border border-gray-200 rounded-lg room-item" data-kamar-id="{{ $kamar->id }}">
                                <img src="{{ $kamar->preview_360 ? asset('storage/' . $kamar->preview_360) : 'https://via.placeholder.com/150x100' }}" 
                                     alt="{{ $kamar->nama_kamar }}" 
                                     class="w-24 h-16 object-cover rounded">
                                <div class="flex-1">
                                    <h3 class="font-semibold text-gray-900">{{ $kamar->nama_kamar }}</h3>
                                    <p class="text-sm text-gray-600">{{ $kamar->fasilitas }}</p>
                                    <p class="text-blue-600 font-semibold mt-1">Rp {{ number_format($kamar->harga, 0, ',', '.') }} / malam</p>
                                </div>
                                <button type="button" onclick="removeRoom({{ $kamar->id }})" class="text-gray-400 hover:text-red-500">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                </button>
                                <input type="hidden" name="kamar_ids[]" value="{{ $kamar->id }}">
                            </div>
                        @empty
                            <div class="text-center py-8 text-gray-500">
                                Belum ada kamar yang dipilih. <a href="{{ route('kamar.list') }}" class="text-blue-600 hover:underline">Pilih Kamar</a>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- Guest Contact Info -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Informasi Kontak Tamu</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap (Sesuai KTP)</label>
                            <input type="text" name="nama_lengkap" value="{{ old('nama_lengkap', $user->name ?? '') }}" 
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Contoh: Budi Santoso">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Email</label>
                            <input type="email" name="email" value="{{ old('email', $user->email ?? '') }}" 
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Contoh: budi.santoso@email.com">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Nomor Telepon (WhatsApp)</label>
                            <input type="tel" name="no_telp" value="{{ old('no_telp') }}" 
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Contoh: 081234567890">
                            <p class="text-xs text-gray-500 mt-1">Nomor WhatsApp yang bisa dihubungi</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Alamat Lengkap</label>
                            <input type="text" name="alamat" value="{{ old('alamat') }}" 
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                   placeholder="Contoh: Jl. Sudirman No. 10, Desa/Kel. Mawar, Kec. Bojong">
                            <p class="text-xs text-gray-500 mt-1">Alamat sesuai KTP (Jalan, Desa/Kel, Kec)</p>
                        </div>
                    </div>
                </div>

                <!-- Booking Details -->
                <div class="mb-8">
                    <h2 class="text-lg font-semibold mb-4">Detail Pemesanan</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Check-in</label>
                            <input type="date" name="check_in" value="{{ old('check_in', $checkin) }}" 
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Tanggal Check-out</label>
                            <input type="date" name="check_out" value="{{ old('check_out', $checkout) }}" 
                                   required
                                   class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    <button type="button" id="addMoreRoomsBtn" class="inline-flex items-center justify-center w-full px-4 py-3 border-2 border-dashed border-gray-300 rounded-lg text-gray-600 hover:border-blue-500 hover:text-blue-600 transition">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                        </svg>
                        Tambah Kamar Lain
                    </button>
                </div>

                <!-- Price Summary -->
                <div class="border-t border-gray-200 pt-6 mb-6">
                    <h2 class="text-lg font-semibold mb-4">Ringkasan Harga</h2>
                    <div id="priceSummary" class="space-y-2 text-gray-700">
                        @foreach($selectedKamars as $kamar)
                            <div class="flex justify-between">
                                <span>{{ $kamar->nama_kamar }} (1 malam)</span>
                                <span>Rp {{ number_format($kamar->harga, 0, ',', '.') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <div class="border-t border-gray-200 mt-4 pt-4 flex justify-between items-center">
                        <span class="text-lg font-semibold">Total Harga</span>
                        <span id="totalPrice" class="text-2xl font-bold text-blue-600">
                            Rp {{ number_format(collect($selectedKamars)->sum('harga'), 0, ',', '.') }}
                        </span>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">Termasuk pajak</p>
                </div>

                <!-- Submit Button -->
                <button type="submit" 
                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-4 rounded-lg transition">
                    Konfirmasi Pemesanan
                </button>

                <p class="text-center text-sm text-gray-600 mt-4">
                    Dengan mengklik konfirmasi, Anda menyetujui 
                    <a href="{{ route('peraturan') }}" class="text-blue-600 hover:underline">Peraturan</a> kami.
                </p>
            </form>
        </div>
    </div>
</div>

<script>
function removeRoom(kamarId) {
    const roomItems = document.querySelectorAll('.room-item');
    if (roomItems.length > 1) {
        const roomToRemove = document.querySelector(`.room-item[data-kamar-id="${kamarId}"]`);
        if (roomToRemove) {
            roomToRemove.remove();
            updatePriceSummary();
        }
        
        const kamarIds = Array.from(document.querySelectorAll('[name="kamar_ids[]"]')).map(input => input.value);
        const savedData = JSON.parse(sessionStorage.getItem('reservasiFormData') || '{}');
        savedData.kamar_ids = kamarIds;
        sessionStorage.setItem('reservasiFormData', JSON.stringify(savedData));
        
    } else {
        alert('Minimal harus ada 1 kamar yang dipilih');
    }
}

function updatePriceSummary() {
    const checkinDate = new Date(document.querySelector('[name="check_in"]').value);
    const checkoutDate = new Date(document.querySelector('[name="check_out"]').value);
    const nights = Math.ceil((checkoutDate - checkinDate) / (1000 * 60 * 60 * 24)) || 1;
    
    const roomItems = document.querySelectorAll('.room-item');
    let summaryHTML = '';
    let total = 0;
    
    roomItems.forEach(item => {
        const roomName = item.querySelector('h3').textContent;
        const priceText = item.querySelector('.text-blue-600').textContent;
        const price = parseInt(priceText.replace(/[^0-9]/g, ''));
        const subtotal = price * nights;
        total += subtotal;
        
        summaryHTML += `
            <div class="flex justify-between">
                <span>${roomName} (${nights} malam)</span>
                <span>Rp ${subtotal.toLocaleString('id-ID')}</span>
            </div>
        `;
    });
    
    document.getElementById('priceSummary').innerHTML = summaryHTML;
    document.getElementById('totalPrice').textContent = `Rp ${total.toLocaleString('id-ID')}`;
}

function saveFormData() {
    const formData = {
        nama_lengkap: document.querySelector('[name="nama_lengkap"]')?.value || '',
        email: document.querySelector('[name="email"]')?.value || '',
        no_telp: document.querySelector('[name="no_telp"]')?.value || '',
        alamat: document.querySelector('[name="alamat"]')?.value || '',
        check_in: document.querySelector('[name="check_in"]')?.value || '',
        check_out: document.querySelector('[name="check_out"]')?.value || '',
        kamar_ids: Array.from(document.querySelectorAll('[name="kamar_ids[]"]')).map(input => input.value)
    };
    
    sessionStorage.setItem('reservasiFormData', JSON.stringify(formData));
}

document.addEventListener('input', function(e) {
    if (e.target.matches('[name="nama_lengkap"], [name="email"], [name="no_telp"], [name="alamat"]')) {
        saveFormData();
    }
});

document.querySelector('[name="check_in"]')?.addEventListener('change', function() {
    updatePriceSummary();
    saveFormData();
});

document.querySelector('[name="check_out"]')?.addEventListener('change', function() {
    updatePriceSummary();
    saveFormData();
});

document.getElementById('addMoreRoomsBtn')?.addEventListener('click', function() {
    saveFormData();
    
    const formData = JSON.parse(sessionStorage.getItem('reservasiFormData') || '{}');
    window.location.href = '{{ route("kamar.list") }}?from_booking=1&checkin=' + (formData.check_in || '{{ $checkin }}');
});

window.addEventListener('DOMContentLoaded', function() {
    const savedData = sessionStorage.getItem('reservasiFormData');
    if (savedData) {
        const data = JSON.parse(savedData);
        
        // Restore form inputs
        if (data.nama_lengkap) document.querySelector('[name="nama_lengkap"]').value = data.nama_lengkap;
        if (data.email) document.querySelector('[name="email"]').value = data.email;
        if (data.no_telp) document.querySelector('[name="no_telp"]').value = data.no_telp;
        if (data.alamat) document.querySelector('[name="alamat"]').value = data.alamat;
        if (data.check_in) document.querySelector('[name="check_in"]').value = data.check_in;
        if (data.check_out) document.querySelector('[name="check_out"]').value = data.check_out;
    }
    
    updatePriceSummary();
});

document.getElementById('reservasiForm')?.addEventListener('submit', function() {
    sessionStorage.removeItem('reservasiFormData');
});
</script>
@endsection
