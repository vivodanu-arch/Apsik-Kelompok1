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
    $filterAktif = true;
} else {
    $periode     = 'Semua Data (Keseluruhan Periode)';
    $filterAktif = false;
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

        /* ===== LAYOUT WRAPPER ===== */
        .app-shell { display: flex; min-height: 100vh; }

        .sidebar-wrapper {
            position: fixed;
            top: 0; left: 0;
            width: 256px;
            height: 100vh;
            z-index: 40;
            flex-shrink: 0;
        }
        .main-wrapper {
            margin-left: 256px;
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
        }
        .topbar-wrapper {
            position: sticky;
            top: 0;
            z-index: 30;
            background: white;
            flex-shrink: 0;
        }
        .content-area {
            flex: 1;
            padding: 24px;
            overflow-x: auto;
        }

        /* ===== KOP ===== */
        .kop { border-bottom: 3px solid #1d4ed8; padding-bottom: 16px; margin-bottom: 16px; }
        .kop-wrapper { display: flex; align-items: center; justify-content: space-between; gap: 16px; }
        .kop-logo img { width: 100px; height: 100px; object-fit: contain; display: block; }
        .kop-text { flex: 1; text-align: center; }
        .kop-text h1 { margin: 0 0 4px; font-size: 26px; font-weight: bold; color: #1d4ed8; text-transform: uppercase; letter-spacing: 2px; line-height: 1.2; }
        .kop-tagline { font-style: italic; color: #4b5563; font-size: 12.5px; margin: 0 0 8px; }
        .kop-divider { width: 55%; height: 1px; background: #d1d5db; margin: 6px auto 8px; }
        .kop-text p { margin: 2px 0; font-size: 12px; color: #374151; line-height: 1.6; }

        /* ===== TABEL UMUM ===== */
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #9ca3af; padding: 7px 8px; font-size: 12px; vertical-align: middle; }
        th { text-align: center; font-weight: bold; }

        /* ===== JUDUL ===== */
        .judul  { text-align: center; font-size: 18px; font-weight: bold; text-transform: uppercase; margin: 10px 0 4px; letter-spacing: 0.5px; }
        .subjudul { text-align: center; font-size: 13px; font-weight: bold; margin-bottom: 14px; color: #374151; }

        /* ===== HALAMAN CETAK ===== */
        .page-print {
            background: white;
            padding: 40px;
            border-radius: 20px;
            margin: 0 auto 30px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
        }
        .report-page { display: none; }
        .report-page.active { display: block; }

        /* ===== RL 5.1 — tabel lebar dengan scroll ===== */
        .rl51-scroll-wrapper {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        .rl51-table {
            border-collapse: collapse;
            font-size: 9px;
            width: max-content;
            min-width: 100%;
        }
        .rl51-table th, .rl51-table td {
            border: 1px solid #9ca3af;
            padding: 2px 3px;
            text-align: center;
            vertical-align: middle;
        }
        .rl51-table td.diagnosa-cell { text-align: left; white-space: nowrap; padding-left: 6px; }
        /* Header kelompok umur: teks horizontal, lebar minimal */
        .rl51-table th.rl51-umur {
            font-size: 7.5px;
            font-weight: 600;
            min-width: 30px;
            max-width: 40px;
            white-space: nowrap;
            padding: 3px 2px;
        }
        /* Subkolom L/P di bawah kelompok umur */
        .rl51-table th.rl51-lp {
            font-size: 8px;
            font-weight: 700;
            min-width: 14px;
            max-width: 18px;
            padding: 2px 1px;
        }
        .rl51-keterangan { font-size: 11px; font-style: italic; margin-top: 8px; text-align: center; }

        /* ===== TTD ===== */
        .ttd {
            margin-top: 40px;
            display: flex;
            justify-content: flex-end;
            padding-right: 40px;
            page-break-inside: avoid;
            break-inside: avoid;
        }
        .ttd-box { width: 250px; text-align: center; font-size: 13px; }

        /* ===== BADGE FILTER ===== */
        .filter-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            color: #1d4ed8;
            border-radius: 20px;
            padding: 4px 12px;
            font-size: 12px;
            font-weight: 600;
        }
        .filter-badge .remove { cursor: pointer; color: #6b7280; font-size: 14px; line-height: 1; }
        .filter-badge .remove:hover { color: #dc2626; }

        /* ===== MODAL FILTER ===== */
        #filterModal {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 9999;
            align-items: center;
            justify-content: center;
        }
        #filterModal.show { display: flex; }
        .modal-backdrop {
            position: absolute; inset: 0;
            background: rgba(0,0,0,0.45);
            backdrop-filter: blur(2px);
        }
        .modal-card {
            position: relative;
            background: white;
            border-radius: 20px;
            padding: 32px 28px 28px;
            width: 420px;
            max-width: 95vw;
            box-shadow: 0 20px 60px rgba(0,0,0,0.25);
            z-index: 1;
            animation: modalIn 0.2s ease;
        }
        @keyframes modalIn {
            from { opacity: 0; transform: scale(0.92) translateY(10px); }
            to   { opacity: 1; transform: scale(1) translateY(0); }
        }
        .modal-card h2 { font-size: 18px; font-weight: 700; color: #1e3a5f; margin: 0 0 6px; }
        .modal-card p  { font-size: 13px; color: #6b7280; margin: 0 0 24px; }

        .filter-option-btn {
            display: flex; align-items: center; gap: 14px;
            width: 100%; padding: 14px 16px;
            border-radius: 12px; border: 2px solid #e5e7eb;
            background: white; cursor: pointer;
            transition: border-color 0.15s, background 0.15s;
            margin-bottom: 12px; text-align: left;
        }
        .filter-option-btn:hover { border-color: #3b82f6; background: #eff6ff; }
        .filter-option-btn .icon {
            width: 40px; height: 40px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            font-size: 20px; flex-shrink: 0;
        }
        .filter-option-btn .icon.blue  { background: #dbeafe; }
        .filter-option-btn .icon.green { background: #dcfce7; }
        .filter-option-btn .label { font-size: 14px; font-weight: 700; color: #111827; margin-bottom: 2px; }
        .filter-option-btn .desc  { font-size: 12px; color: #6b7280; }

        #tanggalForm { display: none; border-top: 1px solid #e5e7eb; padding-top: 16px; margin-top: 4px; }
        #tanggalForm.show { display: block; }
        .form-row { display: flex; gap: 12px; margin-bottom: 14px; flex-wrap: wrap; }
        .form-row label { font-size: 12px; font-weight: 600; color: #374151; margin-bottom: 4px; display: block; }
        .form-row input[type=date] {
            border: 1.5px solid #d1d5db; border-radius: 8px;
            padding: 8px 10px; font-size: 13px; flex: 1; min-width: 130px;
        }
        .form-row input[type=date]:focus { outline: none; border-color: #3b82f6; }
        .btn-primary {
            background: #2563eb; color: white; padding: 9px 22px; border-radius: 9px;
            border: none; cursor: pointer; font-size: 13px; font-weight: 600; transition: background 0.15s;
        }
        .btn-primary:hover { background: #1d4ed8; }
        .btn-secondary {
            background: #f3f4f6; color: #374151; padding: 9px 16px; border-radius: 9px;
            border: none; cursor: pointer; font-size: 13px; transition: background 0.15s;
        }
        .btn-secondary:hover { background: #e5e7eb; }

        /* ===== INFO BANNER (laporan kunjungan tidak bisa cetak) ===== */
        .no-print-banner {
            display: flex; align-items: center; gap: 10px;
            background: #fefce8; border: 1px solid #fde68a;
            color: #92400e; border-radius: 10px;
            padding: 10px 16px; font-size: 12.5px;
            margin-bottom: 14px;
        }

        @page { size: A4 landscape; margin: 10mm 8mm; }

        @media print {
            html, body { background: white !important; margin: 0 !important; padding: 0 !important;
                -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .no-print { display: none !important; }
            .sidebar-wrapper, .topbar-wrapper { display: none !important; }
            .main-wrapper { margin-left: 0 !important; }
            .content-area { padding: 0 !important; overflow: visible !important; }

            /* Sembunyikan halaman kunjungan saat cetak */
            #laporanPage { display: none !important; }

            .report-page { display: none !important; }
            .report-page.active { display: block !important; }
            #laporanPage.active { display: none !important; }

            .page-print { width: 100% !important; max-width: 100% !important; margin: 0 !important;
                padding: 16px !important; border-radius: 0 !important; box-shadow: none !important;
                page-break-after: always; }
            .page-print:last-child { page-break-after: auto; }

            thead { display: table-header-group; }
            tfoot { display: table-footer-group; }
            tbody { display: table-row-group; }
            tbody tr { page-break-inside: avoid; }

            /* Warna umum tabel non-RL51 */
            th, td { border: 1px solid black !important; font-size: 10px !important; padding: 4px !important; }
            .bg-blue-600  { background-color: #2563eb !important; color: white !important; }
            .bg-blue-500  { background-color: #3b82f6 !important; color: white !important; }
            .bg-blue-400  { background-color: #60a5fa !important; color: white !important; }
            .bg-green-600 { background-color: #16a34a !important; color: white !important; }
            thead th { color: white !important; }
            thead tr:first-child th { border: none !important; padding: 0 0 6px 0 !important; background: white !important; color: black !important; }

            /* RL 5.1: cetak landscape, paksa muat dalam 1 lebar halaman */
            .rl51-scroll-wrapper { overflow: visible !important; width: 100% !important; }
            .rl51-table {
                font-size: 5.5px !important;
                width: 100% !important;
                table-layout: auto !important;
            }
            .rl51-table th, .rl51-table td {
                padding: 1px 0px !important;
                font-size: 5.5px !important;
                border: 0.5px solid black !important;
            }
            .rl51-table thead th { color: white !important; }
            .rl51-table thead tr:first-child th { border: none !important; }
            .rl51-table th.rl51-umur {
                font-size: 5px !important;
                min-width: unset !important; max-width: unset !important;
                padding: 1px 0 !important;
                white-space: nowrap !important;
            }
            .rl51-table th.rl51-lp {
                font-size: 5.5px !important;
                min-width: unset !important; max-width: unset !important;
                padding: 1px 0 !important;
            }
            .rl51-table td.diagnosa-cell {
                font-size: 5.5px !important;
                white-space: normal !important;
                word-break: break-word !important;
                max-width: 80px !important;
                text-align: left !important;
            }
            /* TTD: tidak pernah terpisah ke halaman baru */
            .ttd {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                page-break-before: avoid !important;
                break-before: avoid !important;
                margin-top: 16px !important;
            }
            .ttd-box { font-size: 10px !important; }
            .rl51-keterangan {
                page-break-inside: avoid !important;
                break-inside: avoid !important;
                page-break-before: avoid !important;
            }
            tfoot tr { page-break-inside: avoid !important; break-inside: avoid !important; }
            #rl52Page table, #rl53Page table { page-break-inside: avoid !important; }
            #rl52Page .ttd, #rl53Page .ttd { page-break-before: avoid !important; break-before: avoid !important; }
        }
    </style>
</head>

<body>
<div class="app-shell">

    {{-- SIDEBAR (fixed) --}}
    <div class="sidebar-wrapper no-print">@include('layouts.sidebar')</div>

    {{-- AREA KANAN --}}
    <div class="main-wrapper">

        {{-- TOPBAR (sticky) --}}
        <div class="topbar-wrapper no-print">@include('layouts.rsnavigation')</div>

        {{-- KONTEN --}}
        <div class="content-area">

            {{-- ===== TOOLBAR ===== --}}
            <div class="flex flex-wrap items-center justify-between gap-3 mb-6 no-print">

                {{-- Kiri: dropdown pilih laporan + badge filter --}}
                <div class="flex items-center gap-3 flex-wrap">
                    <div class="relative inline-block" id="printWrapper">
                        <button type="button" onclick="togglePrintMenu()"
                                class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-5 py-2.5 rounded-xl shadow text-sm font-semibold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Pilih Laporan
                            <span class="border-l border-white/40 pl-2 ml-1">▾</span>
                        </button>

                        <div id="printDropdown"
                             class="hidden absolute left-0 mt-1 w-60 bg-white border border-gray-200 rounded-xl shadow-xl z-50 overflow-hidden">
                            <div class="px-3 py-2 bg-gray-50 border-b text-xs text-gray-500 font-semibold uppercase tracking-wide">
                                Jenis Laporan
                            </div>
                            {{-- Laporan Kunjungan: langsung tampil, tanpa modal filter, tanpa cetak --}}
                            <button type="button" onclick="showPageDirect('laporanPage'); closePrintMenu();"
                                    class="w-full text-left px-4 py-3 hover:bg-blue-50 border-b text-sm flex items-center gap-2">
                                <span class="text-blue-500">📋</span>
                                <div>
                                    <div class="font-medium">Laporan Kunjungan</div>
                                    <div class="text-xs text-gray-400">Hanya tampil, tidak dapat dicetak</div>
                                </div>
                            </button>
                            {{-- Laporan yang dapat dicetak: muncul modal filter dulu --}}
                            <button type="button" onclick="onSelectLaporan('rl51Page', 'RL 5.1 – Morbiditas')"
                                    class="w-full text-left px-4 py-3 hover:bg-blue-50 border-b text-sm flex items-center gap-2">
                                <span class="text-green-500">📊</span> RL 5.1 – Morbiditas
                            </button>
                            <button type="button" onclick="onSelectLaporan('rl52Page', 'RL 5.2 – Kasus Baru')"
                                    class="w-full text-left px-4 py-3 hover:bg-blue-50 border-b text-sm flex items-center gap-2">
                                <span class="text-yellow-500">📑</span> RL 5.2 – Kasus Baru
                            </button>
                            <button type="button" onclick="onSelectLaporan('rl53Page', 'RL 5.3 – Kunjungan')"
                                    class="w-full text-left px-4 py-3 hover:bg-blue-50 text-sm flex items-center gap-2">
                                <span class="text-purple-500">🏥</span> RL 5.3 – Kunjungan
                            </button>
                        </div>
                    </div>

                    {{-- Badge filter aktif --}}
                    @if($filterAktif)
                    <div class="filter-badge">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                        {{ \Carbon\Carbon::parse($dari)->format('d/m/Y') }} – {{ \Carbon\Carbon::parse($sampai)->format('d/m/Y') }}
                        <a href="{{ route('laporan') }}" class="remove" title="Hapus filter">×</a>
                    </div>
                    @else
                    <span class="text-xs text-gray-400 italic">Menampilkan keseluruhan periode</span>
                    @endif
                </div>

                {{-- Kanan: tombol cetak (hanya muncul bila bukan halaman kunjungan) --}}
                <button type="button" id="btnCetak" onclick="window.print()"
                        class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-xl shadow text-sm font-semibold flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                    </svg>
                    Cetak
                </button>
            </div>

            {{-- ===== HALAMAN 1: LAPORAN KUNJUNGAN (default, tidak bisa cetak) ===== --}}
            <div id="laporanPage" class="page-print report-page active">

                {{-- Banner info tidak bisa cetak --}}
                <div class="no-print-banner no-print">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Halaman ini hanya untuk tampilan. Untuk mencetak laporan, pilih RL 5.1, RL 5.2, atau RL 5.3 dari menu <strong>Pilih Laporan</strong>.
                </div>

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
            </div>

            {{-- ===== HALAMAN 2: RL 5.1 – MORBIDITAS (tabel lengkap kelompok umur) ===== --}}
            <div id="rl51Page" class="page-print report-page">

                {{-- Kop & judul di luar scroll wrapper agar tidak terpotong --}}
                @include('layouts.kopsurat')
                <div class="judul">FORMULIR RL 5.1</div>
                <div class="subjudul">KOMPILASI MORBIDITAS PASIEN RAWAT JALAN</div>
                <div class="subjudul">{{ $periode }}</div>

                {{-- Tabel lebar scroll sendiri --}}
                <div class="rl51-scroll-wrapper">
                    <table class="rl51-table">
                        <thead>
                            {{-- Baris 1: header utama --}}
                            <tr class="bg-blue-600 text-white">
                                <th rowspan="3" style="width:28px; min-width:28px;">NO</th>
                                <th rowspan="3" style="width:55px; min-width:55px;">KODE ICD</th>
                                <th rowspan="3" style="min-width:150px; text-align:left; padding-left:6px;">NAMA PENYAKIT / DIAGNOSA</th>
                                <th colspan="{{ count($rl51['kelompok_umur']) * 2 }}">
                                    JUMLAH KASUS BARU MENURUT KELOMPOK UMUR &amp; JENIS KELAMIN
                                </th>
                                <th colspan="3">JUMLAH KASUS BARU<br>MENURUT JENIS KELAMIN</th>
                                <th colspan="3">JUMLAH KUNJUNGAN</th>
                            </tr>
                            {{-- Baris 2: label kelompok umur, masing-masing colspan=2 --}}
                            <tr class="bg-blue-500 text-white">
                                @foreach($rl51['kelompok_umur'] as $kel)
                                    <th colspan="2" class="rl51-umur">{{ $kel }}</th>
                                @endforeach
                                <th rowspan="2" style="min-width:24px;">L</th>
                                <th rowspan="2" style="min-width:24px;">P</th>
                                <th rowspan="2" style="min-width:32px;">Total</th>
                                <th rowspan="2" style="min-width:24px;">L</th>
                                <th rowspan="2" style="min-width:24px;">P</th>
                                <th rowspan="2" style="min-width:32px;">Total</th>
                            </tr>
                            {{-- Baris 3: subkolom L/P di bawah setiap kelompok umur --}}
                            <tr class="bg-blue-400 text-white">
                                @foreach($rl51['kelompok_umur'] as $kel)
                                    <th class="rl51-lp">L</th>
                                    <th class="rl51-lp">P</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                        @forelse($rl51['rows'] as $r)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center"><strong>{{ $r['kode_icd'] }}</strong></td>
                                <td class="diagnosa-cell">{{ $r['diagnosa_utama'] }}</td>
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
                                <td colspan="{{ 3 + (count($rl51['kelompok_umur']) * 2) + 6 }}" class="text-center py-4 text-gray-400">
                                    Tidak ada data morbiditas
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                        {{-- tfoot: keterangan + TTD melekat di akhir tabel, tidak terpisah --}}
                        <tfoot>
                            <tr>
                                <td colspan="{{ 3 + (count($rl51['kelompok_umur']) * 2) + 6 }}"
                                    style="border:none; padding:6px 0 0 0; page-break-inside:avoid; break-inside:avoid;">
                                    <p class="rl51-keterangan" style="margin:4px 0 0;">
                                        *) L = Laki-laki, P = Perempuan &nbsp;&nbsp;
                                        **) jam = jam, hr = hari, bln = bulan, th = tahun
                                    </p>
                                </td>
                            </tr>
                            <tr style="page-break-inside:avoid; break-inside:avoid;">
                                <td colspan="{{ 3 + (count($rl51['kelompok_umur']) * 2) + 6 }}"
                                    style="border:none; padding:30px 40px 0 0; text-align:right; page-break-inside:avoid; break-inside:avoid;">
                                    <div style="display:inline-block; width:240px; text-align:center; font-size:12px;">
                                        <p style="margin:0 0 4px;">Jember, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                                        <p style="margin:8px 0 70px; font-weight:bold;">Kepala Rekam Medis</p>
                                        <p style="margin-bottom:4px;">( ......................................... )</p>
                                        <p style="margin:0;">Nama Terang</p>
                                    </div>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            {{-- ===== HALAMAN 3: RL 5.2 – KASUS BARU ===== --}}
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
                            <td colspan="4" class="text-center py-4 text-gray-400">Tidak ada data untuk periode ini</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="4" style="border:none; padding:40px 40px 0 0; text-align:right; page-break-inside:avoid;">
                            <div style="display:inline-block; width:240px; text-align:center; font-size:12px;">
                                <p style="margin:0 0 4px;">Jember, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                                <p style="margin:8px 0 70px; font-weight:bold;">Kepala Rekam Medis</p>
                                <p style="margin-bottom:4px;">( ......................................... )</p>
                                <p style="margin:0;">Nama Terang</p>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

            {{-- ===== HALAMAN 4: RL 5.3 – KUNJUNGAN ===== --}}
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
                            <td colspan="4" class="text-center py-4 text-gray-400">Tidak ada data untuk periode ini</td>
                        </tr>
                    @endforelse
                    <tr>
                        <td colspan="4" style="border:none; padding:40px 40px 0 0; text-align:right; page-break-inside:avoid;">
                            <div style="display:inline-block; width:240px; text-align:center; font-size:12px;">
                                <p style="margin:0 0 4px;">Jember, {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                                <p style="margin:8px 0 70px; font-weight:bold;">Kepala Rekam Medis</p>
                                <p style="margin-bottom:4px;">( ......................................... )</p>
                                <p style="margin:0;">Nama Terang</p>
                            </div>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>

        </div>{{-- end content-area --}}
    </div>{{-- end main-wrapper --}}
</div>{{-- end app-shell --}}


{{-- ===== MODAL FILTER PERIODE ===== --}}
<div id="filterModal">
    <div class="modal-backdrop" onclick="closeFilterModal()"></div>
    <div class="modal-card">
        <button onclick="closeFilterModal()" style="position:absolute;top:14px;right:16px;background:none;border:none;font-size:20px;color:#9ca3af;cursor:pointer;line-height:1;">×</button>
        <h2>Filter Periode Laporan</h2>
        <p>Pilih rentang waktu data yang ingin ditampilkan</p>

        <div id="filterOptions">
            <button class="filter-option-btn" onclick="pilihKeseluruhan()">
                <div class="icon green">📅</div>
                <div>
                    <div class="label">Keseluruhan Periode</div>
                    <div class="desc">Tampilkan semua data tanpa batasan tanggal</div>
                </div>
            </button>
            <button class="filter-option-btn" onclick="pilihPerTanggal()">
                <div class="icon blue">🗓️</div>
                <div>
                    <div class="label">Per Rentang Tanggal</div>
                    <div class="desc">Tentukan tanggal mulai dan tanggal akhir</div>
                </div>
            </button>
        </div>

        <div id="tanggalForm">
            <form method="GET" id="tanggalFormEl">
                <div class="form-row">
                    <div style="flex:1; min-width:130px;">
                        <label>Dari Tanggal</label>
                        <input type="date" name="dari" value="{{ request('dari') }}" required>
                    </div>
                    <div style="flex:1; min-width:130px;">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="sampai" value="{{ request('sampai') }}" required>
                    </div>
                </div>
                <div style="display:flex; gap:10px; justify-content:flex-end;">
                    <button type="button" class="btn-secondary" onclick="backToOptions()">← Kembali</button>
                    <button type="submit" class="btn-primary">Terapkan Filter</button>
                </div>
            </form>
        </div>
    </div>
</div>


<script>
    // Halaman yang sedang aktif (default: laporan kunjungan)
    let currentPage = 'laporanPage';
    let targetPage  = 'laporanPage';

    // ── Tampilkan halaman langsung (tanpa modal) ──
    function showPageDirect(id) {
        currentPage = id;
        document.querySelectorAll('.report-page').forEach(p => p.classList.remove('active'));
        const el = document.getElementById(id);
        if (el) el.classList.add('active');
        updateCetakBtn();
    }

    // ── Pilih laporan yang memerlukan modal filter ──
    function onSelectLaporan(pageId) {
        targetPage = pageId;
        closePrintMenu();
        openFilterModal();
    }

    // ── Sembunyikan tombol cetak saat laporan kunjungan aktif ──
    function updateCetakBtn() {
        const btn = document.getElementById('btnCetak');
        if (!btn) return;
        btn.style.display = (currentPage === 'laporanPage') ? 'none' : '';
    }

    // ── Dropdown ──
    function togglePrintMenu() {
        document.getElementById('printDropdown').classList.toggle('hidden');
    }
    function closePrintMenu() {
        document.getElementById('printDropdown').classList.add('hidden');
    }
    document.addEventListener('click', function(e) {
        const w = document.getElementById('printWrapper');
        if (w && !w.contains(e.target)) closePrintMenu();
    });

    // ── Modal ──
    function openFilterModal() {
        document.getElementById('filterOptions').style.display = 'block';
        document.getElementById('tanggalForm').classList.remove('show');
        document.getElementById('filterModal').classList.add('show');
    }
    function closeFilterModal() {
        document.getElementById('filterModal').classList.remove('show');
    }

    function pilihKeseluruhan() {
        closeFilterModal();
        showPageDirect(targetPage);
        const params = new URLSearchParams(window.location.search);
        if (params.has('dari') || params.has('sampai')) {
            window.location.href = '{{ route('laporan') }}';
        }
    }

    function pilihPerTanggal() {
        document.getElementById('filterOptions').style.display = 'none';
        document.getElementById('tanggalForm').classList.add('show');
    }
    function backToOptions() {
        document.getElementById('filterOptions').style.display = 'block';
        document.getElementById('tanggalForm').classList.remove('show');
    }

    document.getElementById('tanggalFormEl').addEventListener('submit', function(e) {
        e.preventDefault();
        const data = new FormData(this);
        const params = new URLSearchParams();
        params.set('dari', data.get('dari'));
        params.set('sampai', data.get('sampai'));
        window.location.href = '{{ route('laporan') }}?' + params.toString();
    });

    // Inisialisasi: sembunyikan tombol cetak saat pertama load (default halaman kunjungan)
    document.addEventListener('DOMContentLoaded', function() {
        updateCetakBtn();
    });
</script>

</body>
</html>