<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\DokterDashboardController;
use App\Http\Controllers\KepalaDashboardController;

/*
| HALAMAN AWAL
*/
Route::get('/', function () {
    if (auth()->check()) {
        return match (auth()->user()->role) {
            'petugas' => redirect('/dashboard'),
            'kepalarm' => redirect('/dashboardkepalarm'),
            'dokter' => redirect('/dashboarddokter'),
            default => redirect('/'),
        };
    }

    return view('default');
});

/*
| AUTH (LOGIN)
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
| DASHBOARD BERDASARKAN ROLE
*/
Route::middleware(['auth', 'role:petugas'])
    ->get('/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');

Route::middleware(['auth', 'role:dokter'])->group(function () {
    Route::get('/dashboard-dokter', [DokterDashboardController::class, 'index'])->name('dashboarddokter');
});

Route::middleware(['auth', 'role:kepalarm'])->group(function () {
    Route::get('/dashboard-kepalarm', [KepalaDashboardController::class, 'index'])->name('dashboardkepalarm');
});

/*
| SUPER ADMIN (is_super_admin = 1)
*/
Route::middleware(['auth', 'superadmin'])->group(function () {

    // MANAJEMEN USER
    Route::get('/users', [UserController::class, 'index'])
        ->name('users.index');

    // TAMBAH USER
    Route::get('/register', [RegisteredUserController::class, 'create'])
        ->name('register');

    Route::post('/register', [RegisteredUserController::class, 'store']);

});

/*
| LOGOUT PAKSA
*/
Route::get('/force-logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
});

/*
| AUTH BAWAAN LARAVEL
*/
require __DIR__.'/auth.php';