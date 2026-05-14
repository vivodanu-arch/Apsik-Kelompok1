<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Laporan;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Laporan::query();

        if ($request->dari && $request->sampai) {

            $query->whereBetween(
                'tanggal_kunjungan',
                [$request->dari, $request->sampai]
            );
        }

        if ($request->periode == 'harian') {

            $query->whereDate(
                'tanggal_kunjungan',
                now()->toDateString()
            );
        }

        elseif ($request->periode == 'mingguan') {

            $query->whereBetween(
                'tanggal_kunjungan',
                [now()->startOfWeek(), now()->endOfWeek()]
            );
        }

        elseif ($request->periode == 'bulanan') {

            $query->whereMonth(
                'tanggal_kunjungan',
                now()->month
            );
        }

        elseif ($request->periode == 'tahunan') {

            $query->whereYear(
                'tanggal_kunjungan',
                now()->year
            );
        }

        $laporans = $query->get();

        return view('laporan', compact('laporans'));
    }
}