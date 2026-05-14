<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KunjunganController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\RegisterController;

Route::get('/', function () {
    return view('default');
});
Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

});

Route::middleware('auth')->group(function () {

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');

    Route::get('/datakunjungan', [KunjunganController::class, 'index'])->name('datakunjungan');

    Route::get('/datapasien', [PasienController::class, 'index'])->name('datapasien');

    Route::get('/laporan', function () {
        return view('laporan');
    })->name('laporan');

});

/* DASHBOARD ROLE */
Route::middleware(['auth', 'role:petugas'])
    ->get('/dashboard', fn() => view('dashboard'))
    ->name('dashboard');

Route::middleware(['auth', 'role:kepalarm'])
    ->get('/dashboard-kepalarm', fn() => view('dashboardkepalarm'))
    ->name('dashboard.kepala');

Route::middleware(['auth', 'role:dokter'])
    ->get('/dashboard-dokter', fn() => view('dashboarddokter'))
    ->name('dashboard.dokter');

Route::middleware('auth')->get('/menunggu', function () {

    $role = auth()->user()->role;

    // kalau sudah bukan umum → lempar ke dashboard sesuai
    if ($role !== 'umum') {
        return match ($role) {
            'petugas' => redirect('/dashboard'),
            'kepala' => redirect('/dashboard-kepala'),
            'dokter' => redirect('/dashboard-dokter'),
            default => redirect('/'),
        };
    }

    return view('menunggu');
})->name('menunggu');

Route::get('/', function () {
    if (auth()->check()) {
        return redirect('/menunggu'); // atau redirect-role
    }
    return view('default');
});

require __DIR__.'/auth.php';

Route::get('/force-logout', function () {
    auth()->logout();
    session()->invalidate();
    session()->regenerateToken();
    return redirect('/');
});