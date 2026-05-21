<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kunjungan::with(['pasien', 'dokter', 'diagnosa']);

        // Default judul
        $judulLaporan = 'LAPORAN DATA KUNJUNGAN';

        // FILTER PERIODE
        if ($request->periode == 'harian') {

            $query->whereDate('tanggal_kunjungan', now());

            $judulLaporan = 'LAPORAN HARIAN';
        }

        if ($request->periode == 'mingguan') {

            $query->whereBetween('tanggal_kunjungan', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]);

            $judulLaporan = 'LAPORAN MINGGUAN';
        }

        if ($request->periode == 'bulanan') {

            $query->whereMonth('tanggal_kunjungan', now()->month);

            $judulLaporan = 'LAPORAN BULANAN';
        }

        if ($request->periode == 'tahunan') {

            $query->whereYear('tanggal_kunjungan', now()->year);

            $judulLaporan = 'LAPORAN TAHUNAN';
        }

        // FILTER CUSTOM DATE
        if ($request->dari && $request->sampai) {

            $query->whereBetween('tanggal_kunjungan', [
                $request->dari,
                $request->sampai
            ]);

            $judulLaporan = 'LAPORAN PERIODE';
        }

        // DATA LAPORAN
        $laporans = $query->get();

        // 10 BESAR PENYAKIT
        $topPenyakit = Kunjungan::join('diagnosas', 'kunjungans.id', '=', 'diagnosas.kunjungan_id')
            ->select(
                'diagnosas.diagnosa_utama',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('diagnosas.diagnosa_utama')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('laporan', compact(
            'laporans',
            'judulLaporan',
            'topPenyakit'
        ));
    }
}