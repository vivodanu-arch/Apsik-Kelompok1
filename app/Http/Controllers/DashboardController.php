<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
        // Total pasien
        $totalPasien = Pasien::count();

        // Laporan hari ini (kunjungan hari ini)
        $laporanHariIni = Kunjungan::whereDate('tanggal_kunjungan', now())->count();

        // Total dokter (dari tabel users role dokter)
        $totalDokter = User::where('role', 'dokter')->count();

        return view('dashboard', compact(
            'totalPasien',
            'laporanHariIni',
            'totalDokter'
        ));
    }
}
