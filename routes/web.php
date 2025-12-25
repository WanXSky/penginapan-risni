<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

/* USER */
use App\Http\Controllers\KamarController;
use App\Http\Controllers\ReservasiController; // Menambahkan route untuk booking

/* ADMIN */
use App\Http\Controllers\Admin\KamarController as AdminKamarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ReservasiController as AdminReservasiController;
use App\Http\Controllers\Admin\PembayaranController;

/*
|--------------------------------------------------------------------------
| PUBLIC PAGES
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'))->name('home');
Route::get('/virtualtour', fn () => view('virtualtour'))->name('virtualtour');
Route::get('/kontak', fn () => view('kontak'))->name('kontak');
Route::get('/peraturan', fn () => view('peraturan'))->name('peraturan');

/*
|--------------------------------------------------------------------------
| AUTHENTICATION
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.post');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

/*
|--------------------------------------------------------------------------
| USER – KAMAR
|--------------------------------------------------------------------------
*/

Route::get('/kamar', [KamarController::class, 'index'])
    ->name('kamar.list');

Route::get('/kamar/tipe/{tipe}', [KamarController::class, 'listByCategory'])
    ->name('kamar.byTipe');

Route::get('/kamar/{id}', [KamarController::class, 'show'])
    ->name('kamar.show');

/*
|--------------------------------------------------------------------------
| USER – BOOKING (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::put('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::get('/reservasi/saya', function () {
        return view('reservasi-saya');
    })->name('reservasi.saya');

    Route::get('/reservasi/create', [ReservasiController::class, 'create'])->name('reservasi.create');
    Route::post('/reservasi', [ReservasiController::class, 'store'])->name('reservasi.store');
    Route::get('/reservasi/{id}/konfirmasi', [ReservasiController::class, 'konfirmasiPembayaran'])->name('reservasi.konfirmasi');
    Route::post('/reservasi/{id}/konfirmasi', [ReservasiController::class, 'konfirmasiStore'])->name('reservasi.konfirmasi.store');
    Route::get('/reservasi/{id}/detail', [ReservasiController::class, 'detail'])->name('reservasi.detail');
    Route::get('/reservasi/{id}/success', [ReservasiController::class, 'success'])->name('reservasi.success');
});

Route::get('/pesan', function () {
    return redirect()->route('reservasi.create', request()->query());
})->name('pesan')->middleware('auth');

/*
|--------------------------------------------------------------------------
| ADMIN PANEL (LOGIN REQUIRED)
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->prefix('admin')->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('admin.dashboard');

    // KAMAR (ADMIN)
    Route::get('/kamar', [AdminKamarController::class, 'index'])
        ->name('admin.kamar');
    
    Route::get('/kamar/create', [AdminKamarController::class, 'create'])
        ->name('admin.kamar.create');
    
    Route::post('/kamar', [AdminKamarController::class, 'store'])
        ->name('admin.kamar.store');
    
    Route::get('/kamar/{id}/edit', [AdminKamarController::class, 'edit'])
        ->name('admin.kamar.edit');
    
    Route::put('/kamar/{id}', [AdminKamarController::class, 'update'])
        ->name('admin.kamar.update');
    
    Route::delete('/kamar/{id}', [AdminKamarController::class, 'destroy'])
        ->name('admin.kamar.destroy');

    // RESERVASI
    Route::get('/reservasi', [AdminReservasiController::class, 'index'])
        ->name('admin.reservasi');

    Route::get('/reservasi/create', [AdminReservasiController::class, 'create'])
        ->name('admin.reservasi.create');

    Route::get('/reservasi/{id}', [AdminReservasiController::class, 'show'])
        ->name('admin.reservasi.detail');

    // PEMBAYARAN
    Route::get('/pembayaran', [PembayaranController::class, 'index'])
        ->name('admin.pembayaran');
    
    Route::get('/pembayaran/{id}', [PembayaranController::class, 'show'])
        ->name('admin.pembayaran.detail');

    Route::post('/pembayaran/{id}/verifikasi', [PembayaranController::class, 'verifikasi'])
        ->name('admin.pembayaran.verifikasi');
    
    Route::get('/pembayaran/{id}/invoice', [PembayaranController::class, 'printInvoice'])
        ->name('admin.pembayaran.invoice');
});

/*
|--------------------------------------------------------------------------
| API / AJAX
|--------------------------------------------------------------------------
*/

Route::post('/kamar/check-all',
    [KamarController::class, 'checkAllAvailability']
)->name('kamar.checkAllAvailability');
