<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\LaporanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'petugas' => redirect('/dashboard'),
            'kepalarm' => redirect('/dashboard-kepalarm'),
            'dokter' => redirect('/dashboard-dokter'),
            default => redirect('/'),
        };
    }

    return view('default');
});

/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // DATA
    Route::get('/datakunjungan', [KunjunganController::class, 'index'])->name('datakunjungan');
    Route::get('/datapasien', [PasienController::class, 'index'])->name('datapasien');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

});

/*
|--------------------------------------------------------------------------
| DASHBOARD ROLE
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:petugas'])
    ->get('/dashboard', fn() => view('dashboard'))
    ->name('dashboard');

Route::middleware(['auth', 'role:kepalarm'])
    ->get('/dashboard-kepalarm', fn() => view('dashboardkepalarm'))
    ->name('dashboard.kepala');

Route::middleware(['auth', 'role:dokter'])
    ->get('/dashboard-dokter', fn() => view('dashboarddokter'))
    ->name('dashboard.dokter');

/*
|--------------------------------------------------------------------------
| FORCE LOGOUT
|--------------------------------------------------------------------------
*/
Route::get('/force-logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
});
Route::middleware(['auth'])->group(function () {
    Route::resource('/pasien', App\Http\Controllers\PasienController::class);
});
require __DIR__.'/auth.php';