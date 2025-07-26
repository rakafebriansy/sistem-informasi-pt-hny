<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('kategori', KategoriController::class)->only(['index', 'store', 'update', 'destroy']);
Route::resource('barang', BarangController::class)->only(['index', 'show', 'store', 'update', 'destroy']);
Route::resource('/transaksi', TransaksiController::class)->only(['index','store']);
Route::get('/riwayat-transaksi', [RiwayatTransaksiController::class, 'index'])->name('riwayat.index');