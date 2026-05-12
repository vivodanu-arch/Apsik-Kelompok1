<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PasienController;

Route::get('/datakunjungan', [KunjunganController::class, 'index'])
    ->name('datakunjungan');

Route::get('/', function () {
    return view('default');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/* ✅ DATA PASIEN */
Route::get('/datapasien', [PasienController::class, 'index'])
    ->name('datapasien');

/* LAPORAN */
Route::get('/laporan', function () {
    return view('laporan');
})->name('laporan');

require __DIR__.'/auth.php';