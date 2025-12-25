<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Penginapan Risni - Kenyamanan Seperti di Rumah Sendiri')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @stack('styles')
</head>

<body class="font-sans antialiased bg-slate-50">

    <!-- ================= NAVBAR ================= -->
    <nav class="fixed top-0 inset-x-0 z-30 bg-white/80 backdrop-blur border-b">
        <div class="max-w-7xl mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-lg bg-white flex items-center justify-center overflow-hidden">
                        <img src="{{ asset('penginapanrisni/test.png') }}" alt="Logo Penginapan Risni"
                            class="w-full h-full object-contain">
                    </div>
                    <span class="font-semibold text-lg text-gray-800">Penginapan Risni</span>
                </div>

                <!-- Desktop Menu - Hidden on mobile, visible on tablet and up -->
                <div class="hidden md:flex items-center gap-8">
                    <a href="/" class="text-gray-600 font-medium hover:text-blue-600 transition">Beranda</a>
                    <a href="{{ route('kontak') }}" class="text-gray-600 font-medium hover:text-blue-600 transition">Kontak</a>
                    <a href="{{ route('peraturan') }}" class="text-gray-600 font-medium hover:text-blue-600 transition">Peraturan</a>
                    
                    <!-- Show user profile dropdown when authenticated, otherwise show Login + Pesan Sekarang -->
                    @auth
                        <!-- User Profile Dropdown -->
                        <div class="relative">
                            <!-- Simplified to circular avatar with initials only -->
                            <button id="profile-dropdown-btn" 
                                class="flex items-center gap-2 hover:opacity-80 transition">
                                <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold text-base shadow-md">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <svg id="profile-dropdown-icon" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-500 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <!-- Dropdown Menu -->
                            <!-- Simplified dropdown with only "Lihat Profil" and "Keluar" -->
                            <div id="profile-dropdown-menu" 
                                class="hidden absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 py-1 z-50">
                                
                                <a href="{{ route('profile') }}" class="flex items-center gap-3 px-4 py-3 text-gray-700 hover:bg-blue-50 transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    <span class="text-sm font-medium">Lihat Profil</span>
                                </a>

                                <div class="border-t border-gray-100"></div>
                                
                                <!-- Added onclick confirmation for logout -->
                                <form action="{{ route('logout') }}" method="POST" id="logout-form">
                                    @csrf
                                    <button type="button" onclick="confirmLogout()" class="flex items-center gap-3 w-full px-4 py-3 text-red-600 hover:bg-red-50 transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                        </svg>
                                        <span class="text-sm font-medium">Keluar</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 font-medium hover:text-blue-600 transition">Login</a>
                        <a href="{{ route('pesan') }}"
                            class="px-6 py-2.5 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-md">
                            Pesan Sekarang
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button - Only visible on mobile, hidden on tablet and up -->
                <button id="mobile-menu-button" class="block md:hidden p-2 rounded-lg text-gray-600 hover:bg-gray-100 transition focus:outline-none">
                    <svg id="hamburger-icon" xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>

            <!-- Mobile Menu Dropdown - Only visible on mobile when opened -->
            <div id="mobile-menu" class="hidden md:hidden bg-white shadow-lg border-t mt-4 rounded-lg overflow-hidden">
                <div class="py-2">
                    <a href="/" class="block px-4 py-3 text-gray-600 font-medium hover:text-blue-600 hover:bg-blue-50 transition">
                        Beranda
                    </a>
                    <a href="{{ route('kontak') }}" class="block px-4 py-3 text-gray-600 font-medium hover:text-blue-600 hover:bg-blue-50 transition">
                        Kontak
                    </a>
                    <a href="{{ route('peraturan') }}" class="block px-4 py-3 text-gray-600 font-medium hover:text-blue-600 hover:bg-blue-50 transition">
                        Peraturan
                    </a>
                    
                    <!-- Updated mobile menu to show user options when authenticated -->
                    @auth
                        <div class="px-4 py-3 border-t border-gray-100">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="w-10 h-10 rounded-full bg-blue-600 text-white flex items-center justify-center font-semibold">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </div>
                                <div>
                                    <p class="text-sm font-semibold text-gray-800">{{ auth()->user()->name }}</p>
                                    <p class="text-xs text-gray-500">{{ auth()->user()->email }}</p>
                                </div>
                            </div>
                        </div>
                        
                        <a href="{{ route('profile') }}" class="block px-4 py-3 text-gray-600 font-medium hover:text-blue-600 hover:bg-blue-50 transition">
                            Profil Saya
                        </a>
                        <a href="{{ route('reservasi.saya') }}" class="block px-4 py-3 text-gray-600 font-medium hover:text-blue-600 hover:bg-blue-50 transition">
                            Reservasi Saya
                        </a>
                        
                        <div class="px-4 py-3">
                            <a href="{{ route('pesan') }}"
                                class="block text-center py-3 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-md">
                                Pesan Kamar
                            </a>
                        </div>
                        
                        <div class="border-t border-gray-100">
                            <!-- Added onclick confirmation for mobile logout -->
                            <form action="{{ route('logout') }}" method="POST" id="logout-form-mobile">
                                @csrf
                                <button type="button" onclick="confirmLogout()" class="block w-full text-left px-4 py-3 text-red-600 font-medium hover:bg-red-50 transition">
                                    Keluar
                                </button>
                            </form>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="block px-4 py-3 text-gray-600 font-medium hover:text-blue-600 hover:bg-blue-50 transition">
                            Login
                        </a>
                        <div class="px-4 py-3">
                            <a href="{{ route('pesan') }}"
                                class="block text-center py-3 rounded-lg bg-blue-600 text-white font-semibold hover:bg-blue-700 transition shadow-md">
                                Pesan Sekarang
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <!-- ================= CONTENT ================= -->
    @yield('content')

    <!-- ================= FOOTER ================= -->
    <footer class="bg-gradient-to-b from-blue-600 to-blue-700 text-white py-12">
        <div class="max-w-7xl mx-auto px-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
                
                <!-- Penginapan Risni -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Penginapan Risni</h3>
                    <p class="text-white/80 leading-relaxed">
                        Kami adalah penginapan yang menawarkan kenyamanan dan kehangatan layaknya di rumah sendiri. 
                        Dengan fasilitas lengkap dan lokasi strategis di Bone – Bone.
                    </p>
                </div>

                <!-- Link Cepat -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Link Cepat</h3>
                    <ul class="space-y-3">
                        <li>
                            <a href="/" class="text-white/80 hover:text-white transition">Beranda</a>
                        </li>
                        <li>
                            <a href="{{ route('kontak') }}" class="text-white/80 hover:text-white transition">Kontak</a>
                        </li>
                        <li>
                            <a href="{{ route('peraturan') }}" class="text-white/80 hover:text-white transition">Peraturan</a>
                        </li>
                                                <li>
                            <a href="/virtualtour" class="text-white/80 hover:text-white transition">Virtual Tour 360°</a>
                        </li>
                        @auth
                            <li>
                                <a href="{{ route('profile') }}" class="text-white/80 hover:text-white transition">Profil Saya</a>
                            </li>
                            <li>
                                <a href="{{ route('reservasi.saya') }}" class="text-white/80 hover:text-white transition">Reservasi Saya</a>
                            </li>
                        @else
                            <li>
                                <a href="{{ route('login') }}" class="text-white/80 hover:text-white transition">Login</a>
                            </li>
                        @endauth
                    </ul>
                </div>

                <!-- Kontak Kami -->
                <div>
                    <h3 class="text-xl font-bold mb-4">Kontak Kami</h3>
                    <ul class="space-y-3">
                        <li class="flex items-start gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mt-0.5 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span class="text-white/80">Jl. Trans Sulawesi</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                            </svg>
                            <span class="text-white/80">(+62)-852-994-65990-</span>
                        </li>
                        <li class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 flex-shrink-0" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            <span class="text-white/80">penginapanrisni@gmail.com</span>
                        </li>
                    </ul>
                </div>

            </div>

            <div class="border-t border-white/20 mt-12 pt-8 text-center">
                <p class="text-white/70">
                    &copy; 2025 Penginapan Risni. Hak Cipta Terlindungi.
                </p>
            </div>
        </div>
    </footer>

    <!-- Improved JavaScript for Mobile Menu Toggle -->
    <script>
        function confirmLogout() {
            if (confirm('Apakah Anda yakin ingin keluar?')) {
                // Submit the desktop or mobile logout form
                const desktopForm = document.getElementById('logout-form');
                const mobileForm = document.getElementById('logout-form-mobile');
                
                if (desktopForm) {
                    desktopForm.submit();
                } else if (mobileForm) {
                    mobileForm.submit();
                }
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Mobile Menu
            const mobileMenuButton = document.getElementById('mobile-menu-button');
            const mobileMenu = document.getElementById('mobile-menu');
            const hamburgerIcon = document.getElementById('hamburger-icon');
            
            if (mobileMenuButton && mobileMenu && hamburgerIcon) {
                let isMenuOpen = false;

                mobileMenuButton.addEventListener('click', function(e) {
                    e.stopPropagation();
                    isMenuOpen = !isMenuOpen;
                    
                    if (isMenuOpen) {
                        mobileMenu.classList.remove('hidden');
                        hamburgerIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />';
                    } else {
                        mobileMenu.classList.add('hidden');
                        hamburgerIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                    }
                });

                document.addEventListener('click', function(event) {
                    if (isMenuOpen && !mobileMenu.contains(event.target) && !mobileMenuButton.contains(event.target)) {
                        mobileMenu.classList.add('hidden');
                        hamburgerIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                        isMenuOpen = false;
                    }
                });

                const mobileMenuLinks = mobileMenu.querySelectorAll('a');
                mobileMenuLinks.forEach(link => {
                    link.addEventListener('click', function() {
                        mobileMenu.classList.add('hidden');
                        hamburgerIcon.innerHTML = '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />';
                        isMenuOpen = false;
                    });
                });
            }

            // Profile Dropdown
            const profileDropdownBtn = document.getElementById('profile-dropdown-btn');
            const profileDropdownMenu = document.getElementById('profile-dropdown-menu');
            const profileDropdownIcon = document.getElementById('profile-dropdown-icon');
            
            if (profileDropdownBtn && profileDropdownMenu && profileDropdownIcon) {
                let isDropdownOpen = false;

                profileDropdownBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    isDropdownOpen = !isDropdownOpen;
                    
                    if (isDropdownOpen) {
                        profileDropdownMenu.classList.remove('hidden');
                        profileDropdownIcon.style.transform = 'rotate(180deg)';
                    } else {
                        profileDropdownMenu.classList.add('hidden');
                        profileDropdownIcon.style.transform = 'rotate(0deg)';
                    }
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    if (isDropdownOpen && !profileDropdownMenu.contains(event.target) && !profileDropdownBtn.contains(event.target)) {
                        profileDropdownMenu.classList.add('hidden');
                        profileDropdownIcon.style.transform = 'rotate(0deg)';
                        isDropdownOpen = false;
                    }
                });
            }
        });
    </script>

    @stack('scripts')

</body>

</html>
