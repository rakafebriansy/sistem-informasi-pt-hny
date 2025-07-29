<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KotaController;
use App\Http\Controllers\ProvinsiController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::resource('provinsi', ProvinsiController::class)->only(['index', 'store', 'show', 'update', 'destroy']);
Route::resource('kota', KotaController::class)->only(['index', 'store', 'show', 'update', 'destroy']);