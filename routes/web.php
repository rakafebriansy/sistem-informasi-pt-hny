<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\LayananController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PengirimanController;
use App\Http\Controllers\ProvinsiController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('loginAttempt');
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('pelanggan', PelangganController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('provinsi', ProvinsiController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('kota', KotaController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('layanan', LayananController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
    Route::resource('pengiriman', PengirimanController::class)->only(['index', 'store', 'show']);
    Route::get('/riwayat-pengiriman', [PengirimanController::class, 'showRiwayat'])->name('riwayat-pengiriman.index');
});