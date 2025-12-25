@extends('layouts.app')

@section('title', 'Penginapan Risni - Kenyamanan Seperti di Rumah Sendiri')

@section('content')
    <!-- ================= HERO ================= -->
    <section class="relative min-h-screen flex items-center bg-cover bg-center"
        style="background-image: url('{{ asset('penginapanrisni/penginapan.jpg') }}');">

        <div class="absolute inset-0 bg-gradient-to-b from-black/60 via-black/40 to-black/60"></div>

        <div class="relative z-10 max-w-7xl mx-auto px-6 pt-32 pb-16 text-center text-white">
            <div class="max-w-4xl mx-auto">
                <h1 class="text-5xl md:text-6xl font-bold leading-tight">
                    Selamat Datang di Penginapan Risni
                </h1>

                <p class="mt-6 text-lg md:text-xl text-white/90">
                    Menawarkan kenyamanan & Kehangatan layaknya rumah sendiri.
                </p>

                <div class="mt-8 flex flex-wrap justify-center gap-4">
                    <a href="#"
                        class="px-8 py-3 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-lg">
                        Pesan Sekarang
                    </a>
                    <a href="/virtualtour"
                        class="px-8 py-3 rounded-lg border-2 border-white/40 bg-white/10 backdrop-blur text-white font-semibold hover:bg-white/20 transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                        Virtual Tour 360°
                    </a>
                </div>
            </div>

            <!-- Menambahkan form cek ketersediaan dengan dropdown hasil -->
            <div class="mt-16 max-w-3xl mx-auto">
                <div class="bg-white rounded-2xl p-6 shadow-2xl">
                    <div class="flex flex-col md:flex-row gap-4 items-end">
                        <div class="flex-1 w-full text-left">
                            <label class="text-sm font-medium text-gray-600 block mb-2">Tanggal check-in</label>
                            <input id="checkin" type="date"
                                class="w-full border border-gray-200 rounded-lg px-4 py-3 text-gray-800 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>

                        <button id="cekBtn"
                            class="w-full md:w-auto px-8 py-3 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition flex items-center justify-center gap-2 disabled:opacity-50 disabled:cursor-not-allowed">
                            <svg id="searchIcon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <svg id="loadingIcon" class="w-5 h-5 animate-spin hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                            <span id="btnText">Cek Ketersediaan</span>
                        </button>
                    </div>
                </div>

                <!-- Dropdown hasil ketersediaan kamar -->
                <div id="availabilityDropdown" class="hidden mt-2 bg-white rounded-2xl shadow-2xl overflow-hidden border border-gray-100">
                    <div class="bg-gray-50 px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                        <div>
                            <h3 class="font-semibold text-gray-800">Ketersediaan Kamar</h3>
                            <p id="checkinDateLabel" class="text-sm text-gray-500">Tanggal: -</p>
                        </div>
                        <button id="closeDropdown" type="button" class="text-gray-400 hover:text-gray-600 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                    </div>
                    <div id="dropdownContent" class="divide-y divide-gray-100 max-h-[500px] overflow-y-auto">
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- ================= KATEGORI KAMAR ================= -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold text-gray-800">
                    Kategori Kamar
                </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

                <!-- Biasa -->
                <div class="rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl transition">
                    <div class="aspect-square bg-gray-100 relative group" data-carousel="biasa">
                        <div class="carousel-container relative w-full h-full overflow-hidden">
                            <img src="{{ asset('images/room-biasa-1.jpg') }}" alt="Kamar Biasa 1"
                                class="carousel-image w-full h-full object-cover absolute inset-0 opacity-100 transition-opacity duration-500">
                            <img src="{{ asset('images/room-biasa-2.jpg') }}" alt="Kamar Biasa 2"
                                class="carousel-image w-full h-full object-cover absolute inset-0 opacity-0 transition-opacity duration-500">
                            <img src="{{ asset('images/room-biasa-3.jpg') }}" alt="Kamar Biasa 3"
                                class="carousel-image w-full h-full object-cover absolute inset-0 opacity-0 transition-opacity duration-500">
                        </div>
                        
                        <button class="carousel-prev absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg z-10">
                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        
                        <button class="carousel-next absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg z-10">
                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                            <span class="carousel-indicator w-2 h-2 rounded-full bg-white opacity-100"></span>
                            <span class="carousel-indicator w-2 h-2 rounded-full bg-white opacity-50"></span>
                            <span class="carousel-indicator w-2 h-2 rounded-full bg-white opacity-50"></span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Biasa</h3>
                        <ul class="space-y-2 text-gray-600 mb-4">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                Item One
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                Item Two
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                Item Three
                            </li>
                        </ul>
                        <div class="flex justify-center">
                            <a href="{{ route('kamar.list', ['tipe' => 'biasa']) }}"
                               class="px-6 py-2.5 rounded-full bg-green-100 text-green-700 text-sm font-semibold hover:bg-green-200 transition">
                                Lihat Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Reguler -->
                <div class="rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl transition">
                    <div class="aspect-square bg-gray-100 relative group" data-carousel="reguler">
                        <div class="carousel-container relative w-full h-full overflow-hidden">
                            <img src="{{ asset('images/room-reguler-1.jpg') }}" alt="Kamar Reguler 1"
                                class="carousel-image w-full h-full object-cover absolute inset-0 opacity-100 transition-opacity duration-500">
                            <img src="{{ asset('images/room-reguler-2.jpg') }}" alt="Kamar Reguler 2"
                                class="carousel-image w-full h-full object-cover absolute inset-0 opacity-0 transition-opacity duration-500">
                            <img src="{{ asset('images/room-reguler-3.jpg') }}" alt="Kamar Reguler 3"
                                class="carousel-image w-full h-full object-cover absolute inset-0 opacity-0 transition-opacity duration-500">
                        </div>
                        
                        <button class="carousel-prev absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg z-10">
                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        
                        <button class="carousel-next absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg z-10">
                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                            <span class="carousel-indicator w-2 h-2 rounded-full bg-white opacity-100"></span>
                            <span class="carousel-indicator w-2 h-2 rounded-full bg-white opacity-50"></span>
                            <span class="carousel-indicator w-2 h-2 rounded-full bg-white opacity-50"></span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">Reguler</h3>
                        <ul class="space-y-2 text-gray-600 mb-4">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                Item One
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                Item Two
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                Item Three
                            </li>
                        </ul>
                        <div class="flex justify-center">
                            <a href="{{ route('kamar.list', ['tipe' => 'reguler']) }}"
                               class="px-6 py-2.5 rounded-full bg-green-100 text-green-700 text-sm font-semibold hover:bg-green-200 transition">
                                Lihat Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>

                <!-- VIP -->
                <div class="rounded-2xl border border-gray-200 overflow-hidden hover:shadow-xl transition">
                    <div class="aspect-square bg-gray-100 relative group" data-carousel="vip">
                        <div class="carousel-container relative w-full h-full overflow-hidden">
                            <img src="{{ asset('images/room-vip-1.jpg') }}" alt="Kamar VIP 1"
                                class="carousel-image w-full h-full object-cover absolute inset-0 opacity-100 transition-opacity duration-500">
                            <img src="{{ asset('images/room-vip-2.jpg') }}" alt="Kamar VIP 2"
                                class="carousel-image w-full h-full object-cover absolute inset-0 opacity-0 transition-opacity duration-500">
                            <img src="{{ asset('images/room-vip-3.jpg') }}" alt="Kamar VIP 3"
                                class="carousel-image w-full h-full object-cover absolute inset-0 opacity-0 transition-opacity duration-500">
                        </div>
                        
                        <button class="carousel-prev absolute left-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg z-10">
                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        
                        <button class="carousel-next absolute right-2 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white rounded-full p-2 opacity-0 group-hover:opacity-100 transition-opacity shadow-lg z-10">
                            <svg class="w-6 h-6 text-gray-800" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-10">
                            <span class="carousel-indicator w-2 h-2 rounded-full bg-white opacity-100"></span>
                            <span class="carousel-indicator w-2 h-2 rounded-full bg-white opacity-50"></span>
                            <span class="carousel-indicator w-2 h-2 rounded-full bg-white opacity-50"></span>
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <h3 class="text-xl font-bold text-gray-800 mb-3">VIP</h3>
                        <ul class="space-y-2 text-gray-600 mb-4">
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                Item One
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                Item Two
                            </li>
                            <li class="flex items-center gap-2">
                                <span class="w-1.5 h-1.5 rounded-full bg-blue-600"></span>
                                Item Three
                            </li>
                        </ul>
                        <div class="flex justify-center">
                            <a href="{{ route('kamar.list', ['tipe' => 'vip']) }}"
                               class="px-6 py-2.5 rounded-full bg-green-100 text-green-700 text-sm font-semibold hover:bg-green-200 transition">
                                Lihat Selengkapnya
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= FASILITAS GRATIS ================= -->
    <section class="py-24 bg-white" id="fasilitas">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <h2 class="text-3xl font-bold text-gray-800">
                Fasilitas yang tersedia
            </h2>

            <div class="mt-12 grid grid-cols-1 md:grid-cols-4 gap-8">

                <!-- Dapur Umum -->
                <div class="p-8 rounded-2xl border hover:shadow-lg transition text-left">
                    <div class="w-12 h-12 mb-4 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 3h16v18H4zM9 3v18M15 3v18" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-800">Dapur Umum</h3>
                    <p class="mt-3 text-gray-600">
                        Dapur bersama yang bersih dan lengkap untuk kebutuhan memasak tamu.
                    </p>
                </div>

                <!-- Laundry -->
                <div class="p-8 rounded-2xl border hover:shadow-lg transition text-left">
                    <div class="w-12 h-12 mb-4 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 4h18v16H3zM7 4v4h10V4" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-800">Laundry</h3>
                    <p class="mt-3 text-gray-600">
                        Fasilitas laundry gratis untuk kenyamanan selama menginap.
                    </p>
                </div>

                <!-- Wi-Fi -->
                <div class="p-8 rounded-2xl border hover:shadow-lg transition text-left">
                    <div class="w-12 h-12 mb-4 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8.5 16.5a4 4 0 017 0M5 13a9 9 0 0114 0M2 9a14 14 0 0120 0" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-800">Wi-Fi Gratis</h3>
                    <p class="mt-3 text-gray-600">
                        Akses internet gratis dan stabil di seluruh area penginapan.
                    </p>
                </div>

                <!-- Parkir -->
                <div class="p-8 rounded-2xl border hover:shadow-lg transition text-left">
                    <div class="w-12 h-12 mb-4 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 3h6a5 5 0 010 10H6V3z" />
                        </svg>
                    </div>
                    <h3 class="font-semibold text-lg text-gray-800">Parkir Gratis</h3>
                    <p class="mt-3 text-gray-600">
                        Area parkir luas dan aman untuk kendaraan tamu.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= CTA ================= -->
    <section class="py-24 bg-blue-600 text-white text-center">
        <h2 class="text-3xl md:text-4xl font-bold">
            Siap Menginap di Penginapan Risni?
        </h2>
        <p class="mt-4 text-lg text-white/90">
            Pesan sekarang dan nikmati kenyamanan terbaik di Bone – Bone.
        </p>
        <div class="mt-8">
            <a href="#"
                class="inline-flex items-center gap-2 px-12 py-4 rounded-full bg-white text-blue-600 font-semibold hover:bg-slate-100 transition shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                Pesan Sekarang
            </a>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        const checkinInput = document.getElementById('checkin');
        const checkAvailabilityBtn = document.getElementById('cekBtn');
        const searchIcon = document.getElementById('searchIcon');
        const loadingIcon = document.getElementById('loadingIcon');
        const btnText = document.getElementById('btnText');
        const availabilityDropdown = document.getElementById('availabilityDropdown');
        const dropdownContent = document.getElementById('dropdownContent');
        const checkinDateLabel = document.getElementById('checkinDateLabel');
        const closeDropdown = document.getElementById('closeDropdown');

        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        checkinInput.value = today;
        checkinInput.min = today;

        closeDropdown.addEventListener('click', function() {
            availabilityDropdown.classList.add('hidden');
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!availabilityDropdown.contains(e.target) && !checkAvailabilityBtn.contains(e.target) && e.target !== checkinInput) {
                availabilityDropdown.classList.add('hidden');
            }
        });

        checkAvailabilityBtn.addEventListener('click', async function(e) {
            e.preventDefault();
            
            const tgl = checkinInput.value;

            if (!tgl) {
                alert('Silakan pilih tanggal check-in!');
                return;
            }

            // Show loading state
            checkAvailabilityBtn.disabled = true;
            searchIcon.classList.add('hidden');
            loadingIcon.classList.remove('hidden');
            btnText.textContent = 'Mengecek...';

            try {
                const tipeKamar = ['biasa', 'reguler', 'vip'];
                const results = {};

                for (const tipe of tipeKamar) {
                    try {
                        const response = await fetch('{{ route('kamar.checkAllAvailability') }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                tipe: tipe,
                                checkin: tgl
                            })
                        });

                        if (response.ok) {
                            const data = await response.json();
                            if (data.success && data.data) {
                                results[tipe] = data.data;
                            }
                        }
                    } catch (err) {
                        console.error('Error fetching ' + tipe + ':', err);
                    }
                }

                // Format tanggal untuk label
                const dateObj = new Date(tgl);
                const formattedDate = dateObj.toLocaleDateString('id-ID', { 
                    weekday: 'long', 
                    year: 'numeric', 
                    month: 'long', 
                    day: 'numeric' 
                });
                checkinDateLabel.textContent = 'Tanggal: ' + formattedDate;

                // Display results in dropdown
                displayDropdown(results, tgl);

            } catch (error) {
                console.error('Error:', error);
                alert('Terjadi kesalahan saat mengecek ketersediaan. Silakan coba lagi.');
            } finally {
                // Reset button state
                checkAvailabilityBtn.disabled = false;
                searchIcon.classList.remove('hidden');
                loadingIcon.classList.add('hidden');
                btnText.textContent = 'Cek Ketersediaan';
            }
        });

        function displayDropdown(results, tanggal) {
            const tipeConfig = {
                'biasa': { 
                    name: 'Kamar Biasa', 
                    bgColor: 'bg-blue-50', 
                    textColor: 'text-blue-600', 
                    borderColor: 'border-blue-200', 
                    dotColor: 'bg-blue-500',
                    hoverBg: 'hover:bg-blue-100'
                },
                'reguler': { 
                    name: 'Kamar Reguler', 
                    bgColor: 'bg-green-50', 
                    textColor: 'text-green-600', 
                    borderColor: 'border-green-200', 
                    dotColor: 'bg-green-500',
                    hoverBg: 'hover:bg-green-100'
                },
                'vip': { 
                    name: 'Kamar VIP', 
                    bgColor: 'bg-purple-50', 
                    textColor: 'text-purple-600', 
                    borderColor: 'border-purple-200', 
                    dotColor: 'bg-purple-500',
                    hoverBg: 'hover:bg-purple-100'
                }
            };

            let html = '';
            let hasResults = false;

            for (const tipe in tipeConfig) {
                const config = tipeConfig[tipe];
                const kamars = results[tipe] || [];
                
                if (kamars.length === 0) continue;
                
                hasResults = true;
                const availableRooms = kamars.filter(function(k) { return k.available; });
                const unavailableRooms = kamars.filter(function(k) { return !k.available; });

                html += '<div class="p-6">';
                
                // Header tipe kamar dengan badge jumlah tersedia
                html += '<div class="flex items-center justify-between mb-4">';
                html += '<div class="flex items-center gap-3">';
                html += '<span class="w-3 h-3 rounded-full ' + config.dotColor + '"></span>';
                html += '<h4 class="font-semibold text-lg text-gray-800">' + config.name + '</h4>';
                html += '</div>';
                html += '<span class="text-sm ' + config.textColor + ' font-semibold ' + config.bgColor + ' px-4 py-1.5 rounded-full">';
                html += availableRooms.length + ' dari ' + kamars.length + ' tersedia';
                html += '</span>';
                html += '</div>';

                // Grid kamar (maksimal 3 kamar per tipe, hanya yang tersedia)
                html += '<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 mb-4">';

                // Tampilkan hanya kamar yang tersedia (maksimal 3)
                const displayedAvailable = availableRooms.slice(0, 3);
                displayedAvailable.forEach(function(kamar) {
                    html += '<a href="{{ url('/kamar') }}/' + kamar.id + '?checkin=' + tanggal + '" ';
                    html += 'class="flex items-center gap-3 p-4 rounded-xl border-2 ' + config.borderColor + ' ' + config.bgColor + ' ' + config.hoverBg + ' transition group">';
                    html += '<span class="w-2.5 h-2.5 rounded-full bg-green-500 flex-shrink-0"></span>';
                    html += '<div class="flex-1 min-w-0">';
                    html += '<span class="text-sm font-semibold text-gray-800 truncate block">' + kamar.nama_kamar + '</span>';
                    html += '<span class="text-xs ' + config.textColor + '">Tersedia</span>';
                    html += '</div>';
                    html += '<svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-gray-400 group-hover:text-gray-600 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">';
                    html += '<path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />';
                    html += '</svg>';
                    html += '</a>';
                });

                html += '</div>';

                html += '<a href="{{ route('kamar.list') }}?tipe=' + tipe + '&checkin=' + tanggal + '" ';
                html += 'class="inline-flex items-center gap-2 px-4 py-2.5 text-sm font-semibold ' + config.textColor + ' border-2 ' + config.borderColor + ' rounded-lg ' + config.hoverBg + ' transition">';
                html += '<svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">';
                html += '<path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />';
                html += '</svg>';
                html += 'Lihat Semua ' + config.name;
                html += '</a>';
                
                html += '</div>';
            }

            // Jika tidak ada hasil
            if (!hasResults) {
                html = '<div class="p-12 text-center text-gray-500">';
                html += '<svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">';
                html += '<path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />';
                html += '</svg>';
                html += '<p class="text-lg font-semibold text-gray-600 mb-1">Tidak Ada Data</p>';
                html += '<p class="text-sm">Tidak dapat memuat data ketersediaan kamar.</p>';
                html += '</div>';
            }

            dropdownContent.innerHTML = html;
            availabilityDropdown.classList.remove('hidden');
        }

        document.addEventListener('DOMContentLoaded', function() {
            const carousels = document.querySelectorAll('[data-carousel]');
            
            carousels.forEach(carousel => {
                const images = carousel.querySelectorAll('.carousel-image');
                const indicators = carousel.querySelectorAll('.carousel-indicator');
                const prevBtn = carousel.querySelector('.carousel-prev');
                const nextBtn = carousel.querySelector('.carousel-next');
                
                let currentIndex = 0;
                let autoSlideInterval;
                
                function showSlide(index) {
                    images.forEach(img => img.style.opacity = '0');
                    indicators.forEach(ind => ind.style.opacity = '0.5');
                    
                    images[index].style.opacity = '1';
                    indicators[index].style.opacity = '1';
                    
                    currentIndex = index;
                }
                
                function nextSlide() {
                    const nextIndex = (currentIndex + 1) % images.length;
                    showSlide(nextIndex);
                }
                
                function prevSlide() {
                    const prevIndex = (currentIndex - 1 + images.length) % images.length;
                    showSlide(prevIndex);
                }
                
                function startAutoSlide() {
                    autoSlideInterval = setInterval(nextSlide, 3000);
                }
                
                function stopAutoSlide() {
                    clearInterval(autoSlideInterval);
                }
                
                prevBtn.addEventListener('click', () => {
                    prevSlide();
                    stopAutoSlide();
                    startAutoSlide();
                });
                
                nextBtn.addEventListener('click', () => {
                    nextSlide();
                    stopAutoSlide();
                    startAutoSlide();
                });
                
                carousel.addEventListener('mouseenter', stopAutoSlide);
                carousel.addEventListener('mouseleave', startAutoSlide);
                
                startAutoSlide();
            });
        });
    </script>
@endpush
