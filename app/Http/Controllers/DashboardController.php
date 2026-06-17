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

        // ── RL 5.1 — Morbiditas: breakdown per kelompok umur & jenis kelamin ──
        $kelompokUmur = ['<1 thn', '1-4 thn', '5-14 thn', '15-44 thn', '45-64 thn', '≥65 thn'];

        $rawRl51 = DB::table('diagnosas')
            ->join('kunjungans', 'diagnosas.kunjungan_id', '=', 'kunjungans.id')
            ->join('pasiens',    'kunjungans.pasien_id',   '=', 'pasiens.id')
            ->select(
                'diagnosas.diagnosa_utama',
                'diagnosas.kode_icd',
                'pasiens.jenis_kelamin',
                'pasiens.ttl',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('diagnosas.diagnosa_utama', 'diagnosas.kode_icd', 'pasiens.jenis_kelamin', 'pasiens.ttl')
            ->get();

        $rl51Rows = [];
        foreach ($rawRl51 as $row) {
            $key = $row->diagnosa_utama;
            if (!isset($rl51Rows[$key])) {
                $rl51Rows[$key] = [
                    'diagnosa_utama' => $row->diagnosa_utama,
                    'kode_icd'       => $row->kode_icd,
                    'umur'           => array_fill_keys($kelompokUmur, ['L' => 0, 'P' => 0]),
                    'total_kasus_L'  => 0,
                    'total_kasus_P'  => 0,
                    'total_kasus'    => 0,
                ];
            }

            $umur = $row->ttl
                ? (int) floor((time() - strtotime($row->ttl)) / (365.25 * 86400))
                : null;

            if ($umur !== null) {
                if ($umur < 1)       $gol = '<1 thn';
                elseif ($umur <= 4)  $gol = '1-4 thn';
                elseif ($umur <= 14) $gol = '5-14 thn';
                elseif ($umur <= 44) $gol = '15-44 thn';
                elseif ($umur <= 64) $gol = '45-64 thn';
                else                 $gol = '≥65 thn';

                $jk = strtoupper($row->jenis_kelamin);
                if (in_array($jk, ['L', 'P'])) {
                    $rl51Rows[$key]['umur'][$gol][$jk]      += $row->total;
                    $rl51Rows[$key]['total_kasus_' . $jk]   += $row->total;
                    $rl51Rows[$key]['total_kasus']           += $row->total;
                }
            }
        }

        usort($rl51Rows, fn($a, $b) => $b['total_kasus'] <=> $a['total_kasus']);
        $rl51 = ['kelompok_umur' => $kelompokUmur, 'rows' => array_values($rl51Rows)];

        // ── RL 5.2 — 10 Besar Kasus Baru (pasien unik per diagnosa) ──
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

        // ── RL 5.3 — 10 Besar Kunjungan (total kunjungan per diagnosa) ──
        $rl53 = DB::table('diagnosas')
            ->select(
                'diagnosa_utama',
                'kode_icd',
                DB::raw('COUNT(*) as total')
            )
            ->groupBy('diagnosa_utama', 'kode_icd')
            ->orderByDesc('total')
            ->limit(10)
            ->get();

        // ── 10 Besar Dokter ──
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
            'rl51',
            'rl52',
            'rl53',
            'topDokter'
        ));
    }
}