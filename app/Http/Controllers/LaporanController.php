<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kunjungan::with(['pasien', 'dokter']);

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

        $laporans = $query->get();

        return view('laporan', compact(
            'laporans',
            'judulLaporan'
        ));
    }
}