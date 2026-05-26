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
        $totalPasien    = Pasien::count();
        $laporanHariIni = Kunjungan::whereDate('tanggal_kunjungan', now())->count();
        $totalDokter    = User::where('role', 'dokter')->count();

        // 10 besar penyakit (satu saja, dari diagnosa)
        $topPenyakit = DB::table('diagnosas')
            ->select('diagnosa_utama', 'kode_icd', DB::raw('COUNT(*) as total'))
            ->groupBy('diagnosa_utama', 'kode_icd')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // 10 besar dokter berdasarkan jumlah pasien yang ditangani
        $topDokter = DB::table('kunjungans')
            ->join('dokters', 'kunjungans.dokter_id', '=', 'dokters.id')
            ->select('dokters.nama_dokter', 'dokters.spesialis', DB::raw('COUNT(*) as total_pasien'))
            ->groupBy('dokters.id', 'dokters.nama_dokter', 'dokters.spesialis')
            ->orderByDesc('total_pasien')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalPasien',
            'laporanHariIni',
            'totalDokter',
            'topPenyakit',
            'topDokter'
        ));
    }
}