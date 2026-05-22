<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kunjungan;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        // ← tambah 'poli' di eager load
        $query = Kunjungan::with(['pasien', 'dokter', 'diagnosa', 'poli']);

        $judulLaporan = 'LAPORAN DATA KUNJUNGAN';

        if ($request->periode == 'harian') {
            $query->whereDate('tanggal_kunjungan', now());
            $judulLaporan = 'LAPORAN HARIAN';
        }

        if ($request->periode == 'mingguan') {
            $query->whereBetween('tanggal_kunjungan', [now()->startOfWeek(), now()->endOfWeek()]);
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

        if ($request->dari && $request->sampai) {
            $query->whereBetween('tanggal_kunjungan', [$request->dari, $request->sampai]);
            $judulLaporan = 'LAPORAN PERIODE';
        }

        $laporans = $query->orderBy('tanggal_kunjungan', 'desc')->get();

        // 10 besar penyakit dari data yang difilter (query DB langsung agar akurat)
        $topPenyakit = DB::table('diagnosas')
            ->join('kunjungans', 'kunjungans.id', '=', 'diagnosas.kunjungan_id')
            ->when($request->periode == 'harian', fn($q) => $q->whereDate('kunjungans.tanggal_kunjungan', now()))
            ->when($request->periode == 'mingguan', fn($q) => $q->whereBetween('kunjungans.tanggal_kunjungan', [now()->startOfWeek(), now()->endOfWeek()]))
            ->when($request->periode == 'bulanan', fn($q) => $q->whereMonth('kunjungans.tanggal_kunjungan', now()->month))
            ->when($request->periode == 'tahunan', fn($q) => $q->whereYear('kunjungans.tanggal_kunjungan', now()->year))
            ->when($request->dari && $request->sampai, fn($q) => $q->whereBetween('kunjungans.tanggal_kunjungan', [$request->dari, $request->sampai]))
            ->select('diagnosas.diagnosa_utama', 'diagnosas.kode_icd', DB::raw('COUNT(*) as total'))
            ->groupBy('diagnosas.diagnosa_utama', 'diagnosas.kode_icd')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // 10 besar penyakit KESELURUHAN (tidak terfilter periode)
        $topPenyakitKeseluruhan = DB::table('diagnosas')
            ->select('diagnosa_utama', 'kode_icd', DB::raw('COUNT(*) as total'))
            ->groupBy('diagnosa_utama', 'kode_icd')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        return view('laporan', compact(
            'laporans',
            'judulLaporan',
            'topPenyakit',
            'topPenyakitKeseluruhan'
        ));
    }
}
