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
        .kop {
            border-bottom: 3px solid #1d4ed8;
            padding-bottom: 16px;
            margin-bottom: 16px;
        }
        .kop-wrapper {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .kop-logo img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            display: block;
        }
        .kop-text {
            flex: 1;
            text-align: center;
        }
        .kop-text h1 {
            margin: 0 0 4px;
            font-size: 26px;
            font-weight: bold;
            color: #1d4ed8;
            text-transform: uppercase;
            letter-spacing: 2px;
            line-height: 1.2;
        }
        .kop-tagline {
            font-style: italic;
            color: #4b5563;
            font-size: 12.5px;
            margin: 0 0 8px;
        }
        .kop-divider {
            width: 55%;
            height: 1px;
            background: #d1d5db;
            margin: 6px auto 8px;
        }
        .kop-text p {
            margin: 2px 0;
            font-size: 12px;
            color: #374151;
            line-height: 1.6;
        }

        /* ===== TABEL ===== */
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #9ca3af; padding: 7px 8px; font-size: 12px; vertical-align: middle; }
        th { text-align: center; font-weight: bold; }

        /* ===== JUDUL LAPORAN ===== */
        .judul {
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            text-transform: uppercase;
            margin: 10px 0 4px;
            letter-spacing: 0.5px;
        }
        .subjudul {
            text-align: center;
            font-size: 13px;
            font-weight: bold;
            margin-bottom: 14px;
            color: #374151;
        }

        /* ===== HALAMAN PRINT ===== */
        .page-print {
            background: white;
            padding: 40px;
            border-radius: 20px;
            margin: 30px auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 1300px;
        }
        /* ===== REPORT VIEW ===== */
        .report-page {
            display: none;
        }

        .report-page.active {
            display: block;
        }

        /* ===== TTD ===== */
        .ttd { margin-top: 60px; display: flex; justify-content: flex-end; padding-right: 40px; }
        .ttd-box { width: 250px; text-align: center; font-size: 13px; }

        /* ===== PRINT ===== */
        @page { size: A4 landscape; margin: 15mm; }

        @media print {
            .no-print {
                display: none !important;
            }

            .report-page {
                display: none !important;
            }

            .report-page.active {
                display: block !important;
            }
            .report-page {
                display: none !important;
            }

            .report-page.active {
                display: block !important;
            }
            html, body {
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
                -webkit-print-color-adjust: exact !important;
                print-color-adjust: exact !important;
            }
            .no-print { display: none !important; }
            aside, nav, .sidebar { display: none !important; }
            .flex-1 { margin-left: 0 !important; width: 100% !important; }
            main { padding: 0 !important; margin: 0 !important; }
            .page-print {
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 20px !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                page-break-after: always;
            }
            .page-print:last-child { page-break-after: auto; }

            /* Kop otomatis repeat tiap halaman baru */
            thead { display: table-header-group; }
            tbody { display: table-row-group; }

            /* Baris data tidak terpotong tanggung */
            tbody tr { page-break-inside: avoid; }

            th, td { border: 1px solid black !important; font-size: 11px !important; padding: 5px !important; }
            .bg-blue-600  { background-color: #2563eb !important; color: white !important; }
            .bg-red-600   { background-color: #dc2626 !important; color: white !important; }
            .bg-green-600 { background-color: #16a34a !important; color: white !important; }
            thead th { color: white !important; }

            /* Kop header cell tidak perlu border */
            thead tr:first-child th {
                border: none !important;
                padding: 0 0 8px 0 !important;
                background: white !important;
            }
        }
    </style>
</head>

<body>
<div class="flex min-h-screen">

    <div class="no-print">@include('layouts.sidebar')</div>

    <div class="flex-1 ml-64 flex flex-col">

        <div class="no-print">@include('layouts.rsnavigation')</div>

        <main class="p-6">

            {{-- FILTER --}}
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

            {{-- TOMBOL PRINT (DROPDOWN) --}}
            <div class="flex justify-center gap-3 mb-6 no-print">

                <div class="relative inline-block" id="printWrapper">

                    <button
                        type="button"
                        onclick="togglePrintMenu()"
                        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow text-sm font-semibold">
                        Pilih Laporan
                        <span class="border-l border-white/40 pl-2 ml-1">▾</span>
                    </button>

                    <div id="printDropdown"
                        class="hidden absolute left-0 mt-1 w-56 bg-white border border-gray-200 rounded-xl shadow-lg z-50 overflow-hidden">

                        <button
                            type="button"
                            onclick="showPage('laporanPage')"
                            class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b">
                            Laporan Kunjungan
                        </button>

                        <button
                            type="button"
                            onclick="showPage('penyakitPage')"
                            class="w-full text-left px-4 py-3 hover:bg-gray-50 border-b">
                            10 Besar (Periode)
                        </button>

                        <button
                            type="button"
                            onclick="showPage('semuaPenyakitPage')"
                            class="w-full text-left px-4 py-3 hover:bg-gray-50">
                            10 Besar (Keseluruhan)
                        </button>

                    </div>
                </div>

                <button
                    type="button"
                    onclick="window.print()"
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
                            <td class="text-center">
                                {{ \Carbon\Carbon::parse($l->tanggal_kunjungan)->translatedFormat('d F Y') }}
                            </td>
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

            {{-- ===== HALAMAN 2: 10 BESAR PENYAKIT (PERIODE) ===== --}}
            <div id="penyakitPage" class="page-print report-page">
                <table style="max-width:700px; margin:0 auto;">
                    <thead>
                        <tr>
                            <th colspan="4" style="border:none; padding:0 0 4px 0; background:white;">
                                @include('layouts.kopsurat')
                                <div class="judul">10 BESAR PENYAKIT RAWAT JALAN</div>
                                <div class="subjudul">{{ $periode }}</div>
                            </th>
                        </tr>
                        <tr class="bg-red-600 text-white">
                            <th style="width:50px;">NO</th>
                            <th style="width:120px;">KODE ICD</th>
                            <th>NAMA PENYAKIT</th>
                            <th style="width:100px;">JUMLAH KASUS</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($topPenyakit as $tp)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center"><strong>{{ $tp->kode_icd ?? '-' }}</strong></td>
                            <td>{{ $tp->diagnosa_utama }}</td>
                            <td class="text-center"><strong>{{ $tp->total }}</strong></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-400">
                                Tidak ada data penyakit untuk periode ini
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

            {{-- ===== HALAMAN 3: 10 BESAR PENYAKIT (KESELURUHAN) ===== --}}
            <div id="semuaPenyakitPage" class="page-print report-page">
                <table style="max-width:700px; margin:0 auto;">
                    <thead>
                        <tr>
                            <th colspan="4" style="border:none; padding:0 0 4px 0; background:white;">
                                @include('layouts.kopsurat')
                                <div class="judul">10 BESAR PENYAKIT PELAPORAN</div>
                                <div class="subjudul">Data Keseluruhan (Semua Periode)</div>
                            </th>
                        </tr>
                        <tr class="bg-green-600 text-white">
                            <th style="width:50px;">NO</th>
                            <th style="width:120px;">KODE ICD</th>
                            <th>NAMA PENYAKIT</th>
                            <th style="width:100px;">JUMLAH KASUS</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($topPenyakitKeseluruhan as $sp)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center"><strong>{{ $sp->kode_icd ?? '-' }}</strong></td>
                            <td>{{ $sp->diagnosa_utama }}</td>
                            <td class="text-center"><strong>{{ $sp->total }}</strong></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-gray-400">
                                Tidak ada data penyakit
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
function showPage(id)
{
    document
        .querySelectorAll('.report-page')
        .forEach(page => {
            page.classList.remove('active');
        });

    document
        .getElementById(id)
        .classList.add('active');

    closePrintMenu();
}

function togglePrintMenu()
{
    document
        .getElementById('printDropdown')
        .classList.toggle('hidden');
}

function closePrintMenu()
{
    document
        .getElementById('printDropdown')
        .classList.add('hidden');
}

document.addEventListener('click', function(e)
{
    const wrapper = document.getElementById('printWrapper');

    if (wrapper && !wrapper.contains(e.target))
    {
        closePrintMenu();
    }
});
</script>

</body>
</html>