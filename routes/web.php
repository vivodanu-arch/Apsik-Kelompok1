<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;

/*
| HALAMAN AWAL
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
| AUTH
*/
Route::middleware('auth')->group(function () {

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // DATA
    Route::get('/datakunjungan', [KunjunganController::class, 'index'])->name('datakunjungan');
    Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');

    // PASIEN CRUD
    Route::resource('/pasien', PasienController::class);
});

/*
| DASHBOARD
*/
Route::middleware(['auth', 'role:petugas'])
    ->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::middleware(['auth', 'role:kepalarm'])
    ->get('/dashboard-kepalarm', fn() => view('dashboardkepalarm'));

Route::middleware(['auth', 'role:dokter'])
    ->get('/dashboard-dokter', fn() => view('dashboarddokter'));

/*
| LOGOUT PAKSA
*/
Route::get('/force-logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
});

require __DIR__.'/auth.php';