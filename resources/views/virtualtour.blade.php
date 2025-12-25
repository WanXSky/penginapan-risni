@extends('layouts.app')

@section('title', 'Virtual Tour 360° - Penginapan Risni')

@push('styles')
    <style>
        .tour-frame {
            width: 100%;
            height: 100%;
            border: none;
        }
    </style>
@endpush

@section('content')
    <!-- ================= 360 TOUR SECTION ================= -->
    <section class="pt-24 pb-12 min-h-screen bg-white">
        <div class="max-w-7xl mx-auto px-6">

            <!-- Back Button -->
            <div class="mb-6">
                <a href="/"
                    class="inline-flex items-center gap-2 text-gray-700 hover:text-blue-600 font-medium transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 group-hover:-translate-x-1 transition-transform"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                    </svg>
                    Kembali
                </a>
            </div>

            <!-- Replaced Pannellum with 3DVista iframe -->
            <!-- 3DVista Viewer Container -->
            <div class="relative rounded-2xl overflow-hidden shadow-2xl bg-gray-900
            max-w-5xl mx-auto"
                style="height: 70vh;">

                <!-- Fullscreen Button -->
                <button id="fullscreenBtn"
                    class="absolute top-4 right-4 z-20 bg-white/90 hover:bg-white rounded-lg p-3 shadow-lg transition group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-800 group-hover:text-blue-600"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                    </svg>
                    <span class="sr-only">Lihat Penuh</span>
                </button>

                <!-- 3DVista Tour iframe -->
                <iframe id="tourFrame" class="tour-frame" src="{{ asset('virtualtour360/index.htm') }}" allowfullscreen
                    allow="xr-spatial-tracking; gyroscope; accelerometer"></iframe>

            </div>

            <!-- Navigation Instructions -->
            <div class="mt-8 text-center">
                <p class="text-gray-600">
                    <span class="font-semibold">Tips:</span> Klik dan drag untuk melihat sekeliling, gunakan kontrol di
                    dalam viewer untuk navigasi
                </p>
            </div>

        </div>
    </section>
@endsection

@push('scripts')
    <script>
        // Fullscreen functionality
        const fullscreenBtn = document.getElementById('fullscreenBtn');
        const tourContainer = document.getElementById('tourFrame').parentElement;

        fullscreenBtn.addEventListener('click', () => {
            if (!document.fullscreenElement) {
                tourContainer.requestFullscreen().catch(err => {
                    console.error('Error attempting to enable fullscreen:', err);
                });
            } else {
                document.exitFullscreen();
            }
        });

        // Update fullscreen button icon on fullscreen change
        document.addEventListener('fullscreenchange', () => {
            const icon = fullscreenBtn.querySelector('svg');
            if (document.fullscreenElement) {
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M9 9V4.5M9 9H4.5M9 9L3.75 3.75M9 15v4.5M9 15H4.5M9 15l-5.25 5.25M15 9h4.5M15 9V4.5M15 9l5.25-5.25M15 15h4.5M15 15v4.5m0-4.5l5.25 5.25" />';
            } else {
                icon.innerHTML =
                    '<path stroke-linecap="round" stroke-linejoin="round" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />';
            }
        });
    </script>
@endpush
