@php
\Carbon\Carbon::setLocale('id');

$dari   = request('dari');
$sampai = request('sampai');

if ($dari && $sampai) {
    $dariTanggal   = \Carbon\Carbon::parse($dari);
    $sampaiTanggal = \Carbon\Carbon::parse($sampai);

    if ($dariTanggal->format('m-d') == '01-01' && $sampaiTanggal->format('m-d') == '12-31' && $dariTanggal->year == $sampaiTanggal->year) {
        $periode = 'Periode Tahunan ' . $dariTanggal->translatedFormat('Y') . ' (' . $dariTanggal->translatedFormat('d F Y') . ' s/d ' . $sampaiTanggal->translatedFormat('d F Y') . ')';
    } elseif ($dariTanggal->format('Y-m') == $sampaiTanggal->format('Y-m')) {
        $periode = 'Periode Bulanan ' . $dariTanggal->translatedFormat('F Y') . ' (' . $dariTanggal->translatedFormat('d F Y') . ' s/d ' . $sampaiTanggal->translatedFormat('d F Y') . ')';
    } elseif ($dariTanggal->year == $sampaiTanggal->year) {
        $periode = 'Periode ' . $dariTanggal->translatedFormat('F') . ' - ' . $sampaiTanggal->translatedFormat('F Y') . ' (' . $dariTanggal->translatedFormat('d F Y') . ' s/d ' . $sampaiTanggal->translatedFormat('d F Y') . ')';
    } else {
        $periode = 'Periode ' . $dariTanggal->translatedFormat('d F Y') . ' s/d ' . $sampaiTanggal->translatedFormat('d F Y');
    }
} else {
    $periode = 'Semua Data';
}
@endphp

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }
        body { background: #f3f4f6; margin: 0; padding: 0; font-family: Arial, sans-serif; }

        /* ===== KOP ===== */
        .kop { border-bottom: 3px solid #1d4ed8; padding-bottom: 16px; margin-bottom: 16px; }
        .kop-wrapper { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .kop-logo img { width: 100px; height: 100px; object-fit: contain; display: block; }
        .kop-text { flex: 1; text-align: center; }
        .kop-text h1 { margin: 0 0 4px; font-size: 26px; font-weight: bold; color: #1d4ed8; text-transform: uppercase; letter-spacing: 2px; line-height: 1.2; }
        .kop-tagline { font-style: italic; color: #4b5563; font-size: 12.5px; margin: 0 0 8px; }
        .kop-divider { width: 55%; height: 1px; background: #d1d5db; margin: 6px auto 8px; }
        .kop-text p { margin: 2px 0; font-size: 12px; color: #374151; line-height: 1.6; }

        /* ===== TABEL ===== */
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #9ca3af; padding: 7px 8px; font-size: 12px; vertical-align: middle; }
        th { text-align: center; font-weight: bold; }

        /* ===== JUDUL LAPORAN ===== */
        .judul { text-align: center; font-size: 18px; font-weight: bold; text-transform: uppercase; margin: 10px 0 4px; letter-spacing: 0.5px; }
        .subjudul { text-align: center; font-size: 13px; font-weight: bold; margin-bottom: 14px; color: #374151; }

        /* ===== HALAMAN PRINT ===== */
        .page-print { background: white; padding: 40px; border-radius: 20px; margin: 30px auto; box-shadow: 0 2px 10px rgba(0,0,0,0.08); width: 100%; max-width: 1300px; }

        /* ===== REPORT VIEW ===== */
        .report-page { display: none; }
        .report-page.active { display: block; }

        /* ===== RL 5.1 TABLE ===== */
        .rl51-table { width: max-content; min-width: 100%; border-collapse: collapse; font-size: 9px; }
        .rl51-table th, .rl51-table td { border: 1px solid #9ca3af; padding: 2px 3px; text-align: center; vertical-align: middle; }
        .rl51-table td:nth-child(3) { text-align: left; white-space: nowrap; }
        .rl51-table th.rl51-vertical { writing-mode: vertical-rl; transform: rotate(180deg); font-size: 8px; font-weight: normal; height: 70px; min-width: 16px; max-width: 16px; padding: 2px 0; line-height: 1.1; }
        .rl51-table th.rl51-vertical .lp { font-weight: bold; }
        .rl51-keterangan { font-size: 11px; font-style: italic; margin-top: 8px; text-align: center; }
        #semuaPenyakitPage.page-print { overflow-x: auto; }

        /* ===== TTD ===== */
        .ttd { margin-top: 60px; display: flex; justify-content: flex-end; padding-right: 40px; }
        .ttd-box { width: 250px; text-align: center; font-size: 13px; }

        /* ===== PRINT ===== */
        @page { size: A4 landscape; margin: 15mm; }

        @media print {
    html, body { background: white !important; margin: 0 !important; padding: 0 !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
    .no-print { display: none !important; }
    aside, nav, .sidebar { display: none !important; }
    .flex-1 { margin-left: 0 !important; width: 100% !important; }
    main { padding: 0 !important; margin: 0 !important; }

    .report-page { display: none !important; }
    .report-page.active { display: block !important; }

    .page-print { width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 20px !important; border-radius: 0 !important; box-shadow: none !important; page-break-after: always; }
    .page-print:last-child { page-break-after: auto; }

    /* ===== THEAD REPEAT ===== */
    thead { display: table-header-group; }
    tbody { display: table-row-group; }
    tbody tr { page-break-inside: avoid; }

    /* Baris kop (tr pertama thead) — tanpa border, background putih */
    thead tr:first-child th {
        border: none !important;
        padding: 0 0 8px 0 !important;
        background: white !important;
        color: black !important;
    }

    /* Header kolom biasa */
    th, td { border: 1px solid black !important; font-size: 11px !important; padding: 5px !important; }

    /* Warna header tabel */
    .bg-blue-600 { background-color: #2563eb !important; color: white !important; }
    .bg-blue-500 { background-color: #3b82f6 !important; color: white !important; }
    .bg-blue-400 { background-color: #60a5fa !important; color: white !important; }
    .bg-red-600  { background-color: #dc2626 !important; color: white !important; }
    .bg-green-600 { background-color: #16a34a !important; color: white !important; }
    thead th { color: white !important; }

    /* RL 5.1 keseluruhan */
    .rl51-table { font-size: 7px; }
    .rl51-table th, .rl51-table td { padding: 1px 2px; }
    .rl51-table th.rl51-vertical { font-size: 6px; height: 55px; }
    #semuaPenyakitPage.page-print { overflow: visible; transform: scale(0.85); transform-origin: top left; width: 117.6%; }
}
    </style>
</head>

<body>
<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <div class="no-print">@include('layouts.sidebar')</div>

    <div class="flex-1 ml-64 flex flex-col">

        {{-- NAVIGATION --}}
        <div class="no-print">@include('layouts.rsnavigation')</div>

        <main class="p-6">

            {{-- ===== FILTER ===== --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 max-w-4xl mx-auto no-print">
                <form method="GET" action="{{ route('laporan') }}">
                    <div class="flex flex-wrap items-center justify-center gap-4">
                        <div class="flex items-center gap-2">
                            <label class="font-semibold text-sm">Dari:</label>
                            <input type="date" name="dari" value="{{ request('dari') }}"
                                   class="border rounded-lg px-3 py-2 text-sm">
                        </div>
                        <div class="flex items-center gap-2">
                            <label class="font-semibold text-sm">Sampai:</label>
                            <input type="date" name="sampai" value="{{ request('sampai') }}"
                                   class="border rounded-lg px-3 py-2 text-sm">
                        </div>
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg text-sm font-semibold">
                            Terapkan
                        </button>
                        <a href="{{ route('laporan') }}"
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm">
                            Reset
                        </a>
                    </div>
                </form>
            </div>

            {{-- ===== TOMBOL PILIH LAPORAN + CETAK ===== --}}
            <div class="flex justify-center gap-3 mb-6 no-print">

                <div class="relative inline-block" id="printWrapper">
                    <button type="button" onclick="togglePrintMenu()"
                            class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow text-sm font-semibold">
                        Pilih Laporan
                        <span class="border-l border-white/40 pl-2 ml-1">▾</span>
                    </button>

                    <div id="printDropdown"
                         class="hidden absolute left-0 mt-1 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden">
                        <button type="button" onclick="showPage('laporanPage')"
                                class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b">
                            Laporan Kunjungan
                        </button>
                        <button type="button" onclick="showPage('semuaPenyakitPage')"
                                class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b">
                            10 Besar (Keseluruhan)
                        </button>
                        <button type="button" onclick="showPage('rl51Page')"
                                class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b">
                            RL 5.1 – Morbiditas
                        </button>
                        <button type="button" onclick="showPage('rl52Page')"
                                class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b">
                            RL 5.2 – Kasus Baru
                        </button>
                        <button type="button" onclick="showPage('rl53Page')"
                                class="w-full text-left px-4 py-3 hover:bg-gray-50">
                            RL 5.3 – Kunjungan
                        </button>
                    </div>
                </div>

                <button type="button" onclick="window.print()"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-xl shadow text-sm font-semibold">
                    🖨 Cetak
                </button>

            </div>

            {{-- ===== HALAMAN 1: LAPORAN KUNJUNGAN ===== --}}
            <div id="laporanPage" class="page-print report-page active">
                <table>
                    <thead>
                        <tr>
                            <th colspan="10" style="border:none; padding:0 0 4px 0; background:white;">
                                @include('layouts.kopsurat')
                                <div class="judul">LAPORAN REKAP DATA REKAM MEDIS PASIEN</div>
                                <div class="subjudul">{{ $periode }}</div>
                            </th>
                        </tr>
                        <tr class="bg-blue-600 text-white">
                            <th>NO</th>
                            <th>NAMA PASIEN</th>
                            <th>TANGGAL KUNJUNGAN</th>
                            <th>NAMA DOKTER</th>
                            <th>NAMA POLI</th>
                            <th>NO. RM</th>
                            <th>JK</th>
                            <th>KELUHAN UTAMA</th>
                            <th>DIAGNOSA UTAMA</th>
                            <th>DIAGNOSA SEKUNDER</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($laporans as $l)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td>{{ $l->pasien->nama_pasien ?? '-' }}</td>
                            <td class="text-center">{{ \Carbon\Carbon::parse($l->tanggal_kunjungan)->translatedFormat('d F Y') }}</td>
                            <td>{{ $l->dokter->nama_dokter ?? '-' }}</td>
                            <td>{{ $l->poli->nama_poli ?? '-' }}</td>
                            <td class="text-center">{{ $l->pasien->no_rm ?? '-' }}</td>
                            <td class="text-center">{{ $l->pasien->jenis_kelamin ?? '-' }}</td>
                            <td>{{ $l->keluhan_utama ?? '-' }}</td>
                            <td>{{ $l->diagnosa->diagnosa_utama ?? '-' }}</td>
                            <td>{{ $l->diagnosa->diagnosa_sekunder ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-gray-400">
                                Tidak ada data laporan untuk periode ini
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="ttd">
                    <div class="ttd-box">
                        <p>Jember, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                        <p style="margin: 12px 0 80px; font-weight:bold;">Kepala Rekam Medis</p>
                        <p style="margin-bottom:5px;">( ......................................... )</p>
                        <p>Nama Terang</p>
                    </div>
                </div>
            </div>

            {{-- ===== HALAMAN 3: 10 BESAR PENYAKIT (KESELURUHAN / RL 5.1 LENGKAP) ===== --}}
            <div id="semuaPenyakitPage" class="page-print report-page">
                <table class="rl51-table">
                    <thead>
                        <tr>
                            <th colspan="{{ 4 + (count($rl51['kelompok_umur']) * 2) + 6 }}"
                                style="border:none; padding:0 0 4px 0; background:white;">
                                @include('layouts.kopsurat')
                                <div class="judul">RL 5.1 KOMPILASI MORBIDITAS PASIEN RAWAT JALAN</div>
                                <div class="subjudul">Data Keseluruhan (Semua Periode)</div>
                            </th>
                        </tr>
                        <tr class="bg-green-600 text-white">
                            <th rowspan="2" style="width:35px;">NO</th>
                            <th rowspan="2" style="width:70px;">KODE<br>ICD</th>
                            <th rowspan="2" style="min-width:140px;">DIAGNOSIS<br>PENYAKIT</th>
                            <th colspan="{{ count($rl51['kelompok_umur']) * 2 }}">
                                JUMLAH KASUS BARU MENURUT KELOMPOK UMUR &amp; JENIS KELAMIN
                            </th>
                            <th colspan="3">JUMLAH KASUS BARU<br>MENURUT JENIS KELAMIN</th>
                            <th colspan="3">JUMLAH<br>KUNJUNGAN</th>
                        </tr>
                        <tr class="bg-green-600 text-white">
                            @foreach($rl51['kelompok_umur'] as $kel)
                                <th class="rl51-vertical">{{ $kel }}<br><span class="lp">L</span></th>
                                <th class="rl51-vertical">{{ $kel }}<br><span class="lp">P</span></th>
                            @endforeach
                            <th style="width:32px;">L</th>
                            <th style="width:32px;">P</th>
                            <th style="width:40px;">Total</th>
                            <th style="width:32px;">L</th>
                            <th style="width:32px;">P</th>
                            <th style="width:40px;">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($rl51['rows'] as $r)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center"><strong>{{ $r['kode_icd'] }}</strong></td>
                            <td>{{ $r['diagnosa_utama'] }}</td>
                            @foreach($rl51['kelompok_umur'] as $kel)
                                <td class="text-center">{{ $r['umur'][$kel]['L'] ?: '' }}</td>
                                <td class="text-center">{{ $r['umur'][$kel]['P'] ?: '' }}</td>
                            @endforeach
                            <td class="text-center"><strong>{{ $r['total_kasus_L'] ?: '' }}</strong></td>
                            <td class="text-center"><strong>{{ $r['total_kasus_P'] ?: '' }}</strong></td>
                            <td class="text-center"><strong>{{ $r['total_kasus'] }}</strong></td>
                            <td class="text-center">{{ $r['kunjungan_L'] ?: '' }}</td>
                            <td class="text-center">{{ $r['kunjungan_P'] ?: '' }}</td>
                            <td class="text-center"><strong>{{ $r['kunjungan_total'] }}</strong></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ 4 + (count($rl51['kelompok_umur']) * 2) + 6 }}" class="text-center py-4 text-gray-400">
                                Tidak ada data morbiditas
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <p class="rl51-keterangan">
                    *) L = Laki-laki, P = Perempuan &nbsp;&nbsp;&nbsp;&nbsp;
                    **) jam = jam, hr = hari, bln = bulan, th = tahun
                </p>

                <div class="ttd">
                    <div class="ttd-box">
                        <p>Jember, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                        <p style="margin: 12px 0 80px; font-weight:bold;">Kepala Rekam Medis</p>
                        <p style="margin-bottom:5px;">( ......................................... )</p>
                        <p>Nama Terang</p>
                    </div>
                </div>
            </div>

            {{-- ===== HALAMAN 4: RL 5.1 – MORBIDITAS (PERIODE) ===== --}}
            <div id="rl51Page" class="page-print report-page">
                <table>
                    <thead>
                        <tr>
                            <th colspan="10" style="border:none; padding:0 0 4px 0; background:white;">
                                @include('layouts.kopsurat')
                                <div class="judul">FORMULIR RL 5.1</div>
                                <div class="subjudul">KOMPILASI MORBIDITAS PASIEN RAWAT JALAN</div>
                                <div class="subjudul">{{ $periode }}</div>
                            </th>
                        </tr>
                        <tr class="bg-blue-600 text-white">
                            <th rowspan="2">NO</th>
                            <th rowspan="2">NAMA PENYAKIT / DIAGNOSA</th>
                            <th rowspan="2">KODE ICD-10</th>
                            <th colspan="7">GOLONGAN UMUR &amp; JENIS KELAMIN</th>
                        </tr>
                        <tr class="bg-blue-500 text-white">
                            <th>&lt;1 thn</th>
                            <th>1–4 thn</th>
                            <th>5–14 thn</th>
                            <th>15–44 thn</th>
                            <th>45–64 thn</th>
                            <th>≥65 thn</th>
                            <th>TOTAL</th>
                        </tr>
                        <tr class="bg-blue-400 text-white text-xs">
                            <th></th><th></th><th></th>
                            <th>L / P</th>
                            <th>L / P</th>
                            <th>L / P</th>
                            <th>L / P</th>
                            <th>L / P</th>
                            <th>L / P</th>
                            <th>L / P</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $hitungUmur = fn($tgl) => $tgl ? \Carbon\Carbon::parse($tgl)->age : null;

                        $golUmur = function($umur) {
                            if ($umur === null) return null;
                            if ($umur < 1)   return 0;
                            if ($umur <= 4)  return 1;
                            if ($umur <= 14) return 2;
                            if ($umur <= 44) return 3;
                            if ($umur <= 64) return 4;
                            return 5;
                        };

                        $morbiditas = $laporans
                            ->whereNotNull('diagnosa')
                            ->whereNotNull('diagnosa.diagnosa_utama')
                            ->groupBy(fn($l) => $l->diagnosa->diagnosa_utama)
                            ->map(function($group) use ($hitungUmur, $golUmur) {
                                $grid = array_fill(0, 6, ['L' => 0, 'P' => 0]);
                                foreach ($group as $l) {
                                    $gol = $golUmur($hitungUmur($l->pasien->tanggal_lahir ?? null));
                                    $jk  = strtoupper($l->pasien->jenis_kelamin ?? '');
                                    if ($gol !== null && in_array($jk, ['L', 'P'])) {
                                        $grid[$gol][$jk]++;
                                    }
                                }
                                return [
                                    'diagnosa' => $group->first()->diagnosa->diagnosa_utama,
                                    'kode_icd' => $group->first()->diagnosa->kode_icd ?? '-',
                                    'grid'     => $grid,
                                    'total_l'  => array_sum(array_column($grid, 'L')),
                                    'total_p'  => array_sum(array_column($grid, 'P')),
                                ];
                            })
                            ->sortByDesc(fn($d) => $d['total_l'] + $d['total_p'])
                            ->values();
                    @endphp

                    @forelse($morbiditas as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item['diagnosa'] }}</td>
                            <td class="text-center">{{ $item['kode_icd'] }}</td>
                            @foreach($item['grid'] as $gol)
                                <td class="text-center text-xs">{{ $gol['L'] }} / {{ $gol['P'] }}</td>
                            @endforeach
                            <td class="text-center font-semibold">{{ $item['total_l'] }} / {{ $item['total_p'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-4 text-gray-400">
                                Tidak ada data untuk periode ini
                            </td>
                        </tr>
                    @endforelse

                    @php
                        $totalGrid = array_fill(0, 6, ['L' => 0, 'P' => 0]);
                        foreach ($morbiditas as $item) {
                            foreach ($item['grid'] as $i => $gol) {
                                $totalGrid[$i]['L'] += $gol['L'];
                                $totalGrid[$i]['P'] += $gol['P'];
                            }
                        }
                        $grandL = array_sum(array_column($totalGrid, 'L'));
                        $grandP = array_sum(array_column($totalGrid, 'P'));
                    @endphp
                    <tr class="bg-blue-50 font-bold">
                        <td colspan="3" class="text-center">TOTAL</td>
                        @foreach($totalGrid as $gol)
                            <td class="text-center text-xs">{{ $gol['L'] }} / {{ $gol['P'] }}</td>
                        @endforeach
                        <td class="text-center">{{ $grandL }} / {{ $grandP }}</td>
                    </tr>
                    </tbody>
                </table>

                <div class="ttd">
                    <div class="ttd-box">
                        <p>Jember, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                        <p style="margin: 12px 0 80px; font-weight:bold;">Kepala Rekam Medis</p>
                        <p style="margin-bottom:5px;">( ......................................... )</p>
                        <p>Nama Terang</p>
                    </div>
                </div>
            </div>

            {{-- ===== HALAMAN 5: RL 5.2 – KASUS BARU PENYAKIT RAWAT JALAN ===== --}}
            <div id="rl52Page" class="page-print report-page">
                <table>
                    <thead>
                        <tr>
                            <th colspan="4" style="border:none; padding:0 0 4px 0; background:white;">
                                @include('layouts.kopsurat')
                                <div class="judul">FORMULIR RL 5.2</div>
                                <div class="subjudul">10 BESAR KASUS BARU PENYAKIT RAWAT JALAN</div>
                                <div class="subjudul">{{ $periode }}</div>
                            </th>
                        </tr>
                        <tr class="bg-blue-600 text-white">
                            <th>NO</th>
                            <th>NAMA PENYAKIT / DIAGNOSA</th>
                            <th>KODE ICD-10</th>
                            <th>JUMLAH KASUS BARU</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $kasusBaru = $laporans
                            ->whereNotNull('diagnosa')
                            ->whereNotNull('diagnosa.diagnosa_utama')
                            ->groupBy(fn($l) => $l->diagnosa->diagnosa_utama)
                            ->map(fn($group) => [
                                'diagnosa' => $group->first()->diagnosa->diagnosa_utama,
                                'kode_icd' => $group->first()->diagnosa->kode_icd ?? '-',
                                'jumlah'   => $group->pluck('pasien.no_rm')->unique()->count(),
                            ])
                            ->sortByDesc('jumlah')
                            ->take(10)
                            ->values();
                    @endphp

                    @forelse($kasusBaru as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item['diagnosa'] }}</td>
                            <td class="text-center">{{ $item['kode_icd'] }}</td>
                            <td class="text-center">{{ $item['jumlah'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-400">
                                Tidak ada data untuk periode ini
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="ttd">
                    <div class="ttd-box">
                        <p>Jember, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                        <p style="margin: 12px 0 80px; font-weight:bold;">Kepala Rekam Medis</p>
                        <p style="margin-bottom:5px;">( ......................................... )</p>
                        <p>Nama Terang</p>
                    </div>
                </div>
            </div>
            {{-- ===== HALAMAN 6: RL 5.3 – KUNJUNGAN PENYAKIT RAWAT JALAN ===== --}}
            <div id="rl53Page" class="page-print report-page">
                <table>
                    <thead>
                        <tr>
                            <th colspan="4" style="border:none; padding:0 0 4px 0; background:white;">
                                @include('layouts.kopsurat')
                                <div class="judul">FORMULIR RL 5.3</div>
                                <div class="subjudul">10 BESAR KUNJUNGAN PENYAKIT RAWAT JALAN</div>
                                <div class="subjudul">{{ $periode }}</div>
                            </th>
                        </tr>
                        <tr class="bg-blue-600 text-white">
                            <th>NO</th>
                            <th>NAMA PENYAKIT / DIAGNOSA</th>
                            <th>KODE ICD-10</th>
                            <th>JUMLAH KUNJUNGAN</th>
                        </tr>
                    </thead>
                    <tbody>
                    @php
                        $kunjungan = $laporans
                            ->whereNotNull('diagnosa')
                            ->whereNotNull('diagnosa.diagnosa_utama')
                            ->groupBy(fn($l) => $l->diagnosa->diagnosa_utama)
                            ->map(fn($group) => [
                                'diagnosa' => $group->first()->diagnosa->diagnosa_utama,
                                'kode_icd' => $group->first()->diagnosa->kode_icd ?? '-',
                                'jumlah'   => $group->count(),
                            ])
                            ->sortByDesc('jumlah')
                            ->take(10)
                            ->values();
                    @endphp

                    @forelse($kunjungan as $index => $item)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item['diagnosa'] }}</td>
                            <td class="text-center">{{ $item['kode_icd'] }}</td>
                            <td class="text-center">{{ $item['jumlah'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-400">
                                Tidak ada data untuk periode ini
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>

                <div class="ttd">
                    <div class="ttd-box">
                        <p>Jember, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                        <p style="margin: 12px 0 80px; font-weight:bold;">Kepala Rekam Medis</p>
                        <p style="margin-bottom:5px;">( ......................................... )</p>
                        <p>Nama Terang</p>
                    </div>
                </div>
            </div>

        </main>
    </div>
</div>

<script>
    function showPage(id) {
        document.querySelectorAll('.report-page').forEach(page => page.classList.remove('active'));
        document.getElementById(id).classList.add('active');
        closePrintMenu();
    }

    function togglePrintMenu() {
        document.getElementById('printDropdown').classList.toggle('hidden');
    }

    function closePrintMenu() {
        document.getElementById('printDropdown').classList.add('hidden');
    }

    document.addEventListener('click', function (e) {
        const wrapper = document.getElementById('printWrapper');
        if (wrapper && !wrapper.contains(e.target)) closePrintMenu();
    });
</script>

</body>
</html>