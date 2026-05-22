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
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #9ca3af; padding: 8px; font-size: 12px; vertical-align: middle; }
        th { text-align: center; font-weight: bold; }
        .kop { border-bottom: 4px solid #1d4ed8; padding-bottom: 15px; margin-bottom: 25px; }
        .kop-wrapper { display: flex; align-items: center; gap: 20px; }
        .kop-logo img { width: 90px; height: 90px; object-fit: contain; }
        .kop-text { flex: 1; text-align: center; }
        .kop-text h1 { margin: 0; font-size: 28px; font-weight: bold; color: #1d4ed8; text-transform: uppercase; }
        .kop-text p { margin: 3px 0; font-size: 13px; }
        .page-print { background: white; padding: 40px; border-radius: 20px; margin: 30px auto; box-shadow: 0 2px 10px rgba(0,0,0,0.08); width: 100%; max-width: 1300px; }
        .judul { text-align: center; font-size: 26px; font-weight: bold; text-transform: uppercase; margin-bottom: 8px; }
        .subjudul { text-align: center; font-size: 15px; font-weight: bold; margin-bottom: 20px; color: #374151; }
        .ttd { margin-top: 80px; display: flex; justify-content: flex-end; padding-right: 40px; }
        .ttd-box { width: 250px; text-align: center; }

        @page { size: A4 landscape; margin: 15mm; }

        @media print {
            html, body { background: white !important; margin: 0 !important; padding: 0 !important; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            .no-print { display: none !important; }
            aside, nav, .sidebar { display: none !important; }
            .flex-1 { margin-left: 0 !important; width: 100% !important; }
            main { padding: 0 !important; margin: 0 !important; }
            .page-print { width: 100% !important; max-width: 100% !important; margin: 0 !important; padding: 20px !important; border-radius: 0 !important; box-shadow: none !important; page-break-after: always; }
            .page-print:last-child { page-break-after: auto; }
            th, td { border: 1px solid black !important; font-size: 11px !important; padding: 5px !important; }
            .bg-blue-600  { background-color: #2563eb !important; color: white !important; }
            .bg-red-600   { background-color: #dc2626 !important; color: white !important; }
            .bg-green-600 { background-color: #16a34a !important; color: white !important; }
            thead th { color: white !important; }
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

            {{-- TOMBOL PRINT --}}
            <div class="flex flex-wrap justify-center gap-4 mb-6 no-print">
                <button onclick="printOnly('laporanPage')"
                        class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow text-sm font-semibold">
                    🖨 Print Laporan Kunjungan
                </button>
                <button onclick="printOnly('penyakitPage')"
                        class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl shadow text-sm font-semibold">
                    🖨 Print 10 Besar (Periode)
                </button>
                <button onclick="printOnly('semuaPenyakitPage')"
                        class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-xl shadow text-sm font-semibold">
                    🖨 Print 10 Besar (Keseluruhan)
                </button>
                <button onclick="window.print()"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-xl shadow text-sm font-semibold">
                    🖨 Print Semua
                </button>
            </div>

            {{-- ===== HALAMAN 1: LAPORAN KUNJUNGAN ===== --}}
            <div id="laporanPage" class="page-print">

                <div class="kop">
                    <div class="kop-wrapper">
                        <div class="kop-logo">
                            <img src="{{ asset('images/logoRS.jpeg') }}" alt="Logo">
                        </div>
                        <div class="kop-text">
                            <h1>Rumah Sakit Kasih</h1>
                            <p>Melayani Dengan Kasih, Mengutamakan Kesembuhan</p>
                            <p>Jl. KH. Ahmad Dahlan No. 25, Jember, Jawa Timur</p>
                            <p>Telp: (0331) 123456 | Email: rskasihjember@gmail.com</p>
                        </div>
                    </div>
                </div>

                <div class="judul">LAPORAN REKAP DATA REKAM MEDIS PASIEN</div>
                <div class="subjudul">{{ $periode }}</div>

                <table>
                    <thead class="bg-blue-600 text-white">
                        <tr>
                            <th>NO</th>
                            <th>NAMA PASIEN</th>
                            <th>TANGGAL KUNJUNGAN</th>
                            <th>NAMA DOKTER</th>
                            <th>NAMA POLI</th>     {{-- ← fix --}}
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

                            {{-- ← PERBAIKAN UTAMA: dari $l->pasien->nama_poli ke $l->poli->nama_poli --}}
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
            <div id="penyakitPage" class="page-print">

                <div class="kop">
                    <div class="kop-wrapper">
                        <div class="kop-logo">
                            <img src="{{ asset('images/logoRS.jpeg') }}" alt="Logo">
                        </div>
                        <div class="kop-text">
                            <h1>Rumah Sakit Kasih</h1>
                            <p>Melayani Dengan Kasih, Mengutamakan Kesembuhan</p>
                            <p>Jl. KH. Ahmad Dahlan No. 25, Jember, Jawa Timur</p>
                            <p>Telp: (0331) 123456 | Email: rskasihjember@gmail.com</p>
                        </div>
                    </div>
                </div>

                <div class="judul">10 BESAR PENYAKIT RAWAT JALAN</div>
                <div class="subjudul">{{ $periode }}</div>

                <table style="max-width:700px; margin: 20px auto;">
                    <thead class="bg-red-600 text-white">
                        <tr>
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
                            <td class="text-center">
                                <strong>{{ $tp->kode_icd ?? '-' }}</strong>
                            </td>
                            <td>{{ $tp->diagnosa_utama }}</td>
                            <td class="text-center">
                                <strong>{{ $tp->total }}</strong>
                            </td>
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
            <div id="semuaPenyakitPage" class="page-print">

                <div class="kop">
                    <div class="kop-wrapper">
                        <div class="kop-logo">
                            <img src="{{ asset('images/logoRS.jpeg') }}" alt="Logo">
                        </div>
                        <div class="kop-text">
                            <h1>Rumah Sakit Kasih</h1>
                            <p>Melayani Dengan Kasih, Mengutamakan Kesembuhan</p>
                            <p>Jl. KH. Ahmad Dahlan No. 25, Jember, Jawa Timur</p>
                            <p>Telp: (0331) 123456 | Email: rskasihjember@gmail.com</p>
                        </div>
                    </div>
                </div>

                <div class="judul">10 BESAR PENYAKIT PELAPORAN</div>
                <div class="subjudul">Data Keseluruhan (Semua Periode)</div>

                <table style="max-width:700px; margin: 20px auto;">
                    <thead class="bg-green-600 text-white">
                        <tr>
                            <th style="width:50px;">NO</th>
                            <th style="width:120px;">KODE ICD</th>
                            <th>NAMA PENYAKIT</th>
                            <th style="width:100px;">JUMLAH KASUS</th>
                        </tr>
                    </thead>
                    <tbody>
                    {{-- ← sekarang pakai $topPenyakitKeseluruhan dari controller, bukan query di view --}}
                    @forelse($topPenyakitKeseluruhan as $sp)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center">
                                <strong>{{ $sp->kode_icd ?? '-' }}</strong>
                            </td>
                            <td>{{ $sp->diagnosa_utama }}</td>
                            <td class="text-center">
                                <strong>{{ $sp->total }}</strong>
                            </td>
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
function printOnly(id) {
    const pages = document.querySelectorAll('.page-print');
    pages.forEach(p => p.style.display = 'none');
    document.getElementById(id).style.display = 'block';
    setTimeout(() => {
        window.print();
        pages.forEach(p => p.style.display = 'block');
    }, 300);
}
</script>

</body>
</html>
