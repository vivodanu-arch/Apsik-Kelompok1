<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Total pasien
        $totalPasien = Pasien::count();

        // Laporan hari ini
        $laporanHariIni = Kunjungan::whereDate('tanggal_kunjungan', now())->count();

        // Total dokter
        $totalDokter = User::where('role', 'dokter')->count();

        // Statistik 10 besar penyakit
        $topPenyakit = DB::table('kunjungans')
            ->join('diagnosas', 'kunjungans.id', '=', 'diagnosas.kunjungan_id')
            ->select(
                'diagnosas.diagnosa_utama',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('diagnosa_utama')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalPasien',
            'laporanHariIni',
            'totalDokter',
            'topPenyakit'
        ));
    }
}