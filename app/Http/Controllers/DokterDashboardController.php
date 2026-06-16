<?php

namespace App\Http\Controllers;

use App\Models\Kunjungan;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DokterDashboardController extends Controller
{
    public function index()
    {
        // Ambil profil dokter milik user yang sedang login
        $dokter = Auth::user()->dokter;

        // Jika user ini tidak punya profil dokter, tampil data kosong
        if (!$dokter) {
            return view('dashboarddokter', [
                'dokterNama'      => Auth::user()->name,
                'pasienHariIni'   => 0,
                'diagnosaHariIni' => 0,
                'labelHari'       => ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'],
                'grafikData'      => [0, 0, 0, 0, 0, 0, 0],
                'pasienTerbaru'   => collect(),
            ]);
        }

        $dokterId = $dokter->id;

        // --- Card: Pasien hari ini milik dokter ini ---
        $pasienHariIni = Kunjungan::where('dokter_id', $dokterId)
            ->whereDate('tanggal_kunjungan', now())
            ->count();

        // --- Card: Diagnosa hari ini milik dokter ini ---
        $diagnosaHariIni = Kunjungan::where('dokter_id', $dokterId)
            ->whereDate('tanggal_kunjungan', now())
            ->whereHas('diagnosa')
            ->count();

        // --- Grafik: kunjungan per hari dalam minggu ini (filter dokter) ---
        $mulaiMinggu = Carbon::now()->startOfWeek(Carbon::MONDAY);
        $akhirMinggu = Carbon::now()->endOfWeek(Carbon::SUNDAY);

        $kunjunganMingguIni = Kunjungan::where('dokter_id', $dokterId)
            ->selectRaw('DAYOFWEEK(tanggal_kunjungan) as hari, COUNT(*) as total')
            ->whereBetween('tanggal_kunjungan', [$mulaiMinggu, $akhirMinggu])
            ->groupBy('hari')
            ->pluck('total', 'hari');

        // DAYOFWEEK: 1=Minggu, 2=Sen, 3=Sel, 4=Rab, 5=Kam, 6=Jum, 7=Sab
        $labelHari = ['Min', 'Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab'];
        $grafikData = [];
        foreach (range(1, 7) as $h) {
            $grafikData[] = $kunjunganMingguIni[$h] ?? 0;
        }

        // --- Tabel: 10 pasien terbaru milik dokter ini saja ---
        $pasienTerbaru = Kunjungan::with(['pasien', 'poli', 'diagnosa'])
            ->where('dokter_id', $dokterId)
            ->orderBy('tanggal_kunjungan', 'desc')
            ->orderBy('id', 'desc')
            ->limit(10)
            ->get();

        return view('dashboarddokter', compact(
            'dokter',
            'pasienHariIni',
            'diagnosaHariIni',
            'labelHari',
            'grafikData',
            'pasienTerbaru'
        ));
    }
}