<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KamarController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Room availability check API
Route::post('/kamar/check-all-availability', [KamarController::class, 'checkAllAvailability']);
