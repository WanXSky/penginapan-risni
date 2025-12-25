@extends('layouts.app')

@section('title', $kamar->nama_kamar . ' - Penginapan Risni')

@section('content')
    <!-- Back Button Section -->
    <section class="pt-24 pb-8 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <a href="{{ url()->previous() }}" 
               class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 transition font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Kembali
            </a>
        </div>
    </section>

    <!-- Room Detail Section -->
    <section class="pb-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="border border-gray-200 rounded-2xl p-8 md:p-12">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                    <!-- Left Side - 3D Vista Virtual Tour 360 -->
                    <div class="flex items-center justify-center">
                        <div class="w-full max-w-md aspect-square bg-gray-100 rounded-xl relative overflow-hidden border border-gray-200">
                            @if($kamar->preview_360)
                                <!-- Embed 3D Vista Tour 360 -->
                                <iframe 
                                    src="{{ $kamar->preview_360 }}" 
                                    class="w-full h-full border-0"
                                    allow="accelerometer; gyroscope; magnetometer; vr; xr"
                                    allowfullscreen
                                    title="Virtual Tour 360 - {{ $kamar->nama_kamar }}">
                                </iframe>
                            @else
                                <!-- Placeholder jika belum ada preview 360 -->
                                <div class="w-full h-full flex flex-col items-center justify-center bg-gray-100">
                                    <div class="relative w-64 h-64 mb-4">
                                        <svg class="w-full h-full text-gray-300" viewBox="0 0 100 100">
                                            <line x1="0" y1="0" x2="100" y2="100" stroke="currentColor" stroke-width="1"/>
                                            <line x1="100" y1="0" x2="0" y2="100" stroke="currentColor" stroke-width="1"/>
                                            <rect x="0" y="0" width="100" height="100" fill="none" stroke="currentColor" stroke-width="1"/>
                                        </svg>
                                    </div>
                                    <p class="text-gray-400 text-center">
                                        <span class="block text-lg">preview</span>
                                        <span class="block text-lg">360</span>
                                    </p>
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Right Side - Room Info -->
                    <div class="flex flex-col">
                        <!-- Room Type and Name - gunakan nama_kamar dari database -->
                        <div class="mb-4">
                            <p class="text-sm text-gray-500 mb-1">Jenis: Kamar {{ ucfirst($kamar->tipe) }}</p>
                            <h1 class="text-4xl md:text-5xl font-bold text-gray-800">{{ $kamar->nama_kamar }}</h1>
                        </div>

                        <!-- Description -->
                        <div class="mb-6">
                            @if($kamar->deskripsi)
                                <p class="text-gray-600 leading-relaxed">{{ $kamar->deskripsi }}</p>
                            @else
                                <p class="text-gray-400 leading-relaxed text-sm">
                                    Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. 
                                    Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat.
                                </p>
                            @endif
                        </div>

                        <!-- Fasilitas Kamar dengan checkbox style -->
                        <div class="mb-8">
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">Fasilitas Kamar</h2>
                            <div class="space-y-3">
                                @if($kamar->fasilitas)
                                    @php
                                        // Try to decode as JSON first
                                        $fasilitasArray = json_decode($kamar->fasilitas, true);
                                        
                                        // If not valid JSON, split by comma
                                        if (!is_array($fasilitasArray)) {
                                            $fasilitasArray = array_map('trim', explode(',', $kamar->fasilitas));
                                        }
                                    @endphp
                                    
                                    @foreach($fasilitasArray as $fasilitas)
                                        @if($fasilitas)
                                            <div class="flex items-start gap-3">
                                                <div class="mt-0.5 w-5 h-5 border-2 border-gray-400 rounded flex items-center justify-center flex-shrink-0">
                                                    <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                </div>
                                                <span class="text-gray-700">{{ $fasilitas }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                @else
                                    <p class="text-gray-400 text-sm">Tidak ada informasi fasilitas</p>
                                @endif
                            </div>
                        </div>

                        <!-- Harga -->
                        <div class="mb-8">
                            <h2 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2">Harga</h2>
                            <p class="text-3xl font-bold text-blue-600">
                                Rp {{ number_format($kamar->harga ?? 0, 0, ',', '.') }}<span class="text-lg text-gray-600 font-normal">/malam</span>
                            </p>
                        </div>

                        <!-- Pesan Kamar Button - biru sesuai wireframe -->
                        @if($kamar->status === 'tersedia')
                            <a href="{{ route('pesan', ['kamar_id' => $kamar->id]) }}" 
                               class="inline-block px-12 py-4 text-center rounded-lg bg-blue-600 text-white text-lg font-bold hover:bg-blue-700 transition shadow-lg">
                                Pesan Kamar
                            </a>
                        @else
                            <button disabled 
                                    class="inline-block px-12 py-4 text-center rounded-lg bg-gray-300 text-gray-600 text-lg font-bold cursor-not-allowed">
                                Kamar Tidak Tersedia
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
