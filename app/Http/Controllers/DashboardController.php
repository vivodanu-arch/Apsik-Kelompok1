<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPasien      = Pasien::count();
        $KunjunganHariIni = Kunjungan::whereDate('tanggal_kunjungan', now())->count();
        $totalDokter      = User::where('role', 'dokter')->count();

        // RL 5.2 — 10 Besar Kasus Baru (unique pasien per diagnosa)
        $rl52 = DB::table('diagnosas')
            ->join('kunjungans', 'diagnosas.kunjungan_id', '=', 'kunjungans.id')
            ->select(
                'diagnosas.diagnosa_utama',
                'diagnosas.kode_icd',
                DB::raw('COUNT(DISTINCT kunjungans.pasien_id) as total')
            )
            ->groupBy('diagnosas.diagnosa_utama', 'diagnosas.kode_icd')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // 10 Besar Dokter
        $topDokter = DB::table('kunjungans')
            ->join('dokters', 'kunjungans.dokter_id', '=', 'dokters.id')
            ->select(
                'dokters.nama_dokter',
                'dokters.spesialis',
                DB::raw('COUNT(*) as total_pasien')
            )
            ->groupBy('dokters.id', 'dokters.nama_dokter', 'dokters.spesialis')
            ->orderByDesc('total_pasien')
            ->limit(10)
            ->get();

        return view('dashboard', compact(
            'totalPasien',
            'KunjunganHariIni',
            'totalDokter',
            'rl52',
            'topDokter'
        ));
    }
}