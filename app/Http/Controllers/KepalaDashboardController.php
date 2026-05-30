<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use App\Models\Kunjungan;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class KepalaDashboardController extends Controller
{
    public function index()
    {
        $totalPasien    = Pasien::count();
        $totalKunjungan = Kunjungan::count();
        $totalDokter    = User::where('role', 'dokter')->count();
        $totalPetugas   = User::where('role', 'petugas')->count();

        $grafikBulanan = Kunjungan::selectRaw('MONTH(tanggal_kunjungan) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_kunjungan', now()->year)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->pluck('total', 'bulan');

        $labelBulan = ['Jan','Feb','Mar','Apr','Mei','Jun','Jul','Agu','Sep','Okt','Nov','Des'];
        $grafikData = [];
        foreach (range(1, 12) as $b) {
            $grafikData[] = $grafikBulanan[$b] ?? 0;
        }

        $petugasAktif = User::where('role', 'petugas')
            ->orderBy('name')
            ->get();

        return view('dashboardkepalarm', compact(
            'totalPasien',
            'totalKunjungan',
            'totalDokter',
            'totalPetugas',
            'labelBulan',
            'grafikData',
            'petugasAktif'
        ));
    }
}