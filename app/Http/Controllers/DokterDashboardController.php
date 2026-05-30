<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use App\Models\Pasien;
use Illuminate\Support\Facades\DB;

class DokterDashboardController extends Controller
{
    public function index()
    {
        $pasienHariIni = Kunjungan::whereDate('tanggal_kunjungan', now())->count();

        $diagnosaHariIni = Kunjungan::whereDate('tanggal_kunjungan', now())
            ->whereHas('diagnosa')
            ->count();

        $kunjunganMingguIni = Kunjungan::selectRaw('DAYOFWEEK(tanggal_kunjungan) as hari, COUNT(*) as total')
            ->whereBetween('tanggal_kunjungan', [now()->startOfWeek(), now()->endOfWeek()])
            ->groupBy('hari')
            ->orderBy('hari')
            ->pluck('total', 'hari');

        $labelHari = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $grafikData = [];
        foreach (range(1, 7) as $h) {
            $grafikData[] = $kunjunganMingguIni[$h] ?? 0;
        }

        $pasienTerbaru = Kunjungan::with(['pasien', 'poli'])
            ->orderBy('tanggal_kunjungan', 'desc')
            ->limit(10)
            ->get();

        return view('dashboarddokter', compact(
            'pasienHariIni',
            'diagnosaHariIni',
            'labelHari',
            'grafikData',
            'pasienTerbaru'
        ));
    }
}