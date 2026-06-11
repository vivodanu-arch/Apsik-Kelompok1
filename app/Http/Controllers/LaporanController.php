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

        // ===== RL 5.1: KOMPILASI MORBIDITAS PASIEN RAWAT JALAN (KESELURUHAN) =====
        $rl51 = $this->buildRl51();

        return view('laporan', compact(
            'laporans',
            'judulLaporan',
            'topPenyakit',
            'topPenyakitKeseluruhan',
            'rl51'
        ));
    }

    /**
     * Definisi kelompok umur sesuai formulir RL 5.1
     * key => [label, batas_bawah_hari, batas_atas_hari] (null = tak terbatas)
     */
    private function kelompokUmurRl51(): array
    {
        return [
            '<1 jam'      => ['<1 jam', 0, 0],          // 0 hari (penanda khusus, lihat hitung umur)
            '1-23 jam'    => ['1-23 jam', 0, 0],
            '1-7 hr'      => ['1-7 hr', 1, 7],
            '8-28 hr'     => ['8-28 hr', 8, 28],
            '29 hr - <3 bln' => ['29 hr - <3 bln', 29, 89],
            '3 - <6 bln'  => ['3 - <6 bln', 90, 179],
            '6-11 bln'    => ['6-11 bln', 180, 364],
            '1-4 th'      => ['1-4 th', 365, 1824],
            '5-9 th'      => ['5-9 th', 1825, 3649],
            '10-14 th'    => ['10-14 th', 3650, 5474],
            '15-19 th'    => ['15-19 th', 5475, 7299],
            '20-24 th'    => ['20-24 th', 7300, 9124],
            '25-29 th'    => ['25-29 th', 9125, 10949],
            '30-34 th'    => ['30-34 th', 10950, 12774],
            '35-39 th'    => ['35-39 th', 12775, 14599],
            '40-44 th'    => ['40-44 th', 14600, 16424],
            '45-49 th'    => ['45-49 th', 16425, 18249],
            '50-54 th'    => ['50-54 th', 18250, 20074],
            '55-59 th'    => ['55-59 th', 20075, 21899],
            '60-64 th'    => ['60-64 th', 21900, 23724],
            '65-69 th'    => ['65-69 th', 23725, 25549],
            '70-74 th'    => ['70-74 th', 25550, 27374],
            '75-79 th'    => ['75-79 th', 27375, 29199],
            '80-84 th'    => ['80-84 th', 29200, 31024],
            '≥85 th'      => ['≥85 th', 31025, null],
        ];
    }

    /**
     * Tentukan kunci kelompok umur berdasarkan umur dalam hari saat kunjungan.
     * Catatan: '<1 jam' dan '1-23 jam' tidak bisa dibedakan dari tanggal lahir saja
     * (butuh data jam lahir & jam kunjungan), sehingga pasien usia 0 hari
     * dimasukkan ke kelompok '1-7 hr' sebagai pendekatan terbaik yang tersedia.
     */
    private function tentukanKelompokUmur(int $umurHari): string
    {
        $kelompok = $this->kelompokUmurRl51();

        foreach ($kelompok as $key => [$label, $min, $max]) {
            if ($key === '<1 jam' || $key === '1-23 jam') {
                continue; // tidak bisa dihitung dari tanggal lahir saja
            }
            if ($umurHari >= $min && ($max === null || $umurHari <= $max)) {
                return $key;
            }
        }

        return '1-7 hr';
    }

    /**
     * Bangun data RL 5.1 (Kompilasi Morbiditas Pasien Rawat Jalan) - KESELURUHAN DATA.
     * Setiap baris = satu kode ICD, dengan rincian jumlah kasus baru per
     * kelompok umur & jenis kelamin, total kasus baru per JK, dan jumlah kunjungan.
     */
    private function buildRl51(): array
    {
        $kelompokKeys = array_keys($this->kelompokUmurRl51());

        // Ambil semua diagnosa beserta data kunjungan & pasien terkait
        $rows = DB::table('diagnosas')
            ->join('kunjungans', 'kunjungans.id', '=', 'diagnosas.kunjungan_id')
            ->join('pasiens', 'pasiens.id', '=', 'kunjungans.pasien_id')
            ->select(
                'diagnosas.kode_icd',
                'diagnosas.diagnosa_utama',
                'diagnosas.kunjungan_id',
                'kunjungans.tanggal_kunjungan',
                'pasiens.id as pasien_id',
                'pasiens.ttl',
                'pasiens.jenis_kelamin'
            )
            ->whereNotNull('diagnosas.kode_icd')
            ->get();

        $hasil = [];

        foreach ($rows as $row) {
            $kodeIcd = $row->kode_icd ?: '-';
            $namaPenyakit = $row->diagnosa_utama;
            $jk = $row->jenis_kelamin === 'P' ? 'P' : 'L';

            if (!isset($hasil[$kodeIcd])) {
                $hasil[$kodeIcd] = [
                    'kode_icd' => $kodeIcd,
                    'diagnosa_utama' => $namaPenyakit,
                    'umur' => [], // [kelompok][L/P] = jumlah kasus baru (pasien unik)
                    'pasien_terhitung' => [], // set pasien_id yang sudah dihitung sbg kasus baru
                    'kunjungan_L' => 0,
                    'kunjungan_P' => 0,
                ];
                foreach ($kelompokKeys as $k) {
                    $hasil[$kodeIcd]['umur'][$k] = ['L' => 0, 'P' => 0];
                }
            }

            // Jumlah kunjungan: setiap baris diagnosa = 1 kunjungan dengan kode ICD ini
            $hasil[$kodeIcd]['kunjungan_' . $jk]++;

            // Kasus baru: dihitung sekali per pasien per kode ICD (kunjungan pertama)
            $pasienKey = $row->pasien_id;
            if (!isset($hasil[$kodeIcd]['pasien_terhitung'][$pasienKey])) {
                $hasil[$kodeIcd]['pasien_terhitung'][$pasienKey] = true;

                $umurHari = 0;
                if ($row->ttl) {
                    $umurHari = \Carbon\Carbon::parse($row->ttl)
                        ->diffInDays(\Carbon\Carbon::parse($row->tanggal_kunjungan));
                }

                $kelompok = $this->tentukanKelompokUmur($umurHari);
                $hasil[$kodeIcd]['umur'][$kelompok][$jk]++;
            }
        }

        // Hitung total kasus baru per JK & per baris, lalu urutkan & susun ulang
        $rl51 = [];
        foreach ($hasil as $kodeIcd => $data) {
            $totalL = 0;
            $totalP = 0;
            foreach ($data['umur'] as $k => $jkArr) {
                $totalL += $jkArr['L'];
                $totalP += $jkArr['P'];
            }

            $rl51[] = [
                'kode_icd' => $data['kode_icd'],
                'diagnosa_utama' => $data['diagnosa_utama'],
                'umur' => $data['umur'],
                'total_kasus_L' => $totalL,
                'total_kasus_P' => $totalP,
                'total_kasus' => $totalL + $totalP,
                'kunjungan_L' => $data['kunjungan_L'],
                'kunjungan_P' => $data['kunjungan_P'],
                'kunjungan_total' => $data['kunjungan_L'] + $data['kunjungan_P'],
            ];
        }

        // Urutkan berdasarkan kode ICD
        usort($rl51, fn($a, $b) => strcmp($a['kode_icd'], $b['kode_icd']));

        return [
            'kelompok_umur' => $kelompokKeys,
            'rows' => $rl51,
        ];
    }
}
