@extends('layouts.app')

@section('title', 'Profil Saya - Penginapan Risni')

@section('content')
<div class="min-h-screen pt-24 pb-16 bg-slate-50">
    <div class="max-w-4xl mx-auto px-6">
        
        {{-- Header --}}
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-gray-800 mb-2">Profil Saya</h1>
            <p class="text-gray-600">Kelola informasi profil Anda</p>
        </div>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-green-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        {{-- Profile Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            
            {{-- Profile Header --}}
            <div class="bg-gradient-to-r from-blue-600 to-blue-700 p-8 text-center">
                <div class="inline-flex items-center justify-center w-24 h-24 rounded-full bg-white text-blue-600 text-3xl font-bold mb-4">
                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                </div>
                <h2 class="text-2xl font-bold text-white mb-1">{{ auth()->user()->name }}</h2>
                <p class="text-blue-100">{{ auth()->user()->email }}</p>
            </div>

            {{-- Profile Form --}}
            <form action="{{ route('profile.update') }}" method="POST" class="p-8 space-y-6">
                @csrf
                @method('PUT')

                {{-- Nama Lengkap --}}
                <div>
                    <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">Nama Lengkap</label>
                    <input type="text" 
                        id="name" 
                        name="name" 
                        value="{{ old('name', auth()->user()->name) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">Email</label>
                    <input type="email" 
                        id="email" 
                        name="email" 
                        value="{{ old('email', auth()->user()->email) }}"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        required>
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Hapus field phone dan address, hanya name, email, password --}}

                {{-- Divider --}}
                <div class="border-t border-gray-200 pt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4">Ubah Password</h3>
                    <p class="text-sm text-gray-600 mb-4">Kosongkan jika tidak ingin mengubah password</p>
                </div>

                {{-- Password Lama --}}
                <div>
                    <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">Password Lama</label>
                    <input type="password" 
                        id="current_password" 
                        name="current_password" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Masukkan password lama">
                    @error('current_password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password Baru --}}
                <div>
                    <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">Password Baru</label>
                    <input type="password" 
                        id="password" 
                        name="password" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Masukkan password baru">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Konfirmasi Password Baru --}}
                <div>
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">Konfirmasi Password Baru</label>
                    <input type="password" 
                        id="password_confirmation" 
                        name="password_confirmation" 
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Ulangi password baru">
                </div>

                {{-- Actions --}}
                <div class="flex items-center gap-4 pt-4">
                    <button type="submit" 
                        class="px-6 py-3 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700 transition shadow-md">
                        Simpan Perubahan
                    </button>
                    <a href="/" 
                        class="px-6 py-3 bg-gray-100 text-gray-700 font-semibold rounded-lg hover:bg-gray-200 transition">
                        Batal
                    </a>
                </div>

            </form>

        </div>

        {{-- Quick Actions --}}
        <div class="mt-6 grid md:grid-cols-2 gap-4">
            <a href="{{ route('reservasi.saya') }}" 
                class="block p-6 bg-white rounded-lg border border-gray-200 hover:shadow-md transition group">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center group-hover:bg-blue-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Reservasi Saya</h3>
                        <p class="text-sm text-gray-600">Lihat daftar reservasi Anda</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('kamar.list') }}" 
                class="block p-6 bg-white rounded-lg border border-gray-200 hover:shadow-md transition group">
                <div class="flex items-center gap-4">
                    <div class="flex-shrink-0 w-12 h-12 rounded-full bg-green-100 flex items-center justify-center group-hover:bg-green-200 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800 mb-1">Pesan Kamar</h3>
                        <p class="text-sm text-gray-600">Buat reservasi baru</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Account Info --}}
        <div class="mt-6 bg-blue-50 border border-blue-200 rounded-lg p-6">
            <div class="flex items-start gap-3">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-blue-600 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div>
                    <p class="text-sm font-medium text-blue-900">Informasi Akun</p>
                    <p class="text-sm text-blue-700 mt-1">Akun Anda dibuat pada {{ auth()->user()->created_at->format('d F Y') }}</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
