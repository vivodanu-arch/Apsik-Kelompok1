<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Kunjungan::with(['pasien', 'dokter']);

        // FILTER PERIODE
        if ($request->periode == 'harian') {
            $query->whereDate('tanggal_kunjungan', now());
        }

        if ($request->periode == 'mingguan') {
            $query->whereBetween('tanggal_kunjungan', [
                now()->startOfWeek(),
                now()->endOfWeek()
            ]);
        }

        if ($request->periode == 'bulanan') {
            $query->whereMonth('tanggal_kunjungan', now()->month);
        }

        if ($request->periode == 'tahunan') {
            $query->whereYear('tanggal_kunjungan', now()->year);
        }

        // FILTER CUSTOM DATE
        if ($request->dari && $request->sampai) {
            $query->whereBetween('tanggal_kunjungan', [
                $request->dari,
                $request->sampai
            ]);
        }

        $laporans = $query->get();

        return view('laporan', compact('laporans'));
    }
}