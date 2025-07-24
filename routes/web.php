<?php

use App\Http\Controllers\BarangController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\RiwayatTransaksiController;
use App\Http\Controllers\TransaksiController;
use Illuminate\Support\Facades\Route;

Route::get('/',[DashboardController::class, 'index'])->name('dashboard');
Route::resource('kategori', KategoriController::class)->only(['index', 'store', 'destroy']);
Route::prefix('barang')->group(function() {
    Route::get('/',[BarangController::class, 'index'])->name('barang.index');
    Route::post('/', [BarangController::class, 'store'])->name('barang.store');
});
Route::get('/transaksi',[TransaksiController::class, 'index'])->name('transaksi.index');
Route::get('/riwayat-transaksi',[RiwayatTransaksiController::class, 'index'])->name('riwayat.index');