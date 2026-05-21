@php
\Carbon\Carbon::setLocale('id');
@endphp

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Laporan</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>

        *{
            box-sizing: border-box;
        }

        body{
            background: #f3f4f6;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        table{
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td{
            border: 1px solid #9ca3af;
            padding: 8px;
            font-size: 12px;
            vertical-align: top;
        }

        th{
            text-align: center;
            font-weight: bold;
        }

        .kop{
            border-bottom: 4px solid #1d4ed8;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }

        .kop-wrapper{
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .kop-logo img{
            width: 90px;
            height: 90px;
            object-fit: contain;
        }

        .kop-text{
            flex: 1;
            text-align: center;
        }

        .kop-text h1{
            margin: 0;
            font-size: 30px;
            font-weight: bold;
            color: #1d4ed8;
            text-transform: uppercase;
        }

        .kop-text p{
            margin: 3px 0;
            font-size: 14px;
        }

        .page-print{
            background: white;
            padding: 40px;
            border-radius: 20px;
            margin: 30px auto;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 1300px;
        }

        .ttd{
            margin-top: 80px;
            display: flex;
            justify-content: flex-end;
        }

        .ttd-box{
            width: 280px;
            text-align: center;
        }

        .judul{
            text-align: center;
            font-size: 28px;
            font-weight: bold;
            text-transform: uppercase;
            margin-bottom: 25px;
        }

        @page{
            size: A4 landscape;
            margin: 15mm;
        }

        @media print {

            html,
            body{
                background: white !important;
                margin: 0 !important;
                padding: 0 !important;
            }

            .no-print{
                display: none !important;
            }

            aside,
            nav,
            .sidebar{
                display: none !important;
            }

            .flex-1{
                margin-left: 0 !important;
                width: 100% !important;
            }

            main{
                padding: 0 !important;
                margin: 0 !important;
            }

            .page-print{
                width: 100% !important;
                max-width: 100% !important;
                margin: 0 !important;
                padding: 20px !important;
                border-radius: 0 !important;
                box-shadow: none !important;
                page-break-after: always;
            }

            .page-print:last-child{
                page-break-after: auto;
            }

            table{
                width: 100% !important;
            }

            th,
            td{
                border: 1px solid black !important;
                font-size: 11px !important;
                padding: 6px !important;
            }

            .judul{
                font-size: 24px;
            }

        }

    </style>

</head>

<body>

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <div class="no-print">
        @include('layouts.sidebar')
    </div>

    <div class="flex-1 ml-64 flex flex-col">

        {{-- NAVBAR --}}
        <div class="no-print">
            @include('layouts.rsnavigation')
        </div>

        <main class="p-6">

            {{-- FILTER --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 max-w-4xl mx-auto no-print">

                <form method="GET" action="{{ route('laporan') }}">

                    <div class="flex flex-wrap items-center justify-center gap-4">

                        <div class="flex items-center gap-2">

                            <label class="font-semibold">
                                Dari:
                            </label>

                            <input
                                type="date"
                                name="dari"
                                value="{{ request('dari') }}"
                                class="border rounded-lg px-3 py-2">

                        </div>

                        <div class="flex items-center gap-2">

                            <label class="font-semibold">
                                Sampai:
                            </label>

                            <input
                                type="date"
                                name="sampai"
                                value="{{ request('sampai') }}"
                                class="border rounded-lg px-3 py-2">

                        </div>

                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-lg">

                            Terapkan

                        </button>

                    </div>

                </form>

            </div>

            {{-- BUTTON PRINT --}}
            <div class="flex flex-wrap justify-center gap-4 mb-6 no-print">

                <button
                    onclick="printOnly('laporanPage')"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2 rounded-xl shadow">

                    🖨 Print Laporan

                </button>

                <button
                    onclick="printOnly('penyakitPage')"
                    class="bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-xl shadow">

                    🖨 Print 10 Besar Penyakit

                </button>

                <button
                    onclick="printOnly('semuaPenyakitPage')"
                    class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-xl shadow">

                    🖨 Print Penyakit Keseluruhan

                </button>

                <button
                    onclick="window.print()"
                    class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-xl shadow">

                    🖨 Print Semua

                </button>

            </div>

            {{-- HALAMAN 1 --}}
            <div id="laporanPage" class="page-print">

                <div class="kop">

                    <div class="kop-wrapper">

                        <div class="kop-logo">

                            <img
                                src="{{ asset('images/logoRS.jpeg') }}"
                                alt="Logo">

                        </div>

                        <div class="kop-text">

                            <h1>
                                Rumah Sakit Kasih
                            </h1>

                            <p>
                                Melayani Dengan Kasih, Mengutamakan Kesembuhan
                            </p>

                            <p>
                                Jl. KH. Ahmad Dahlan No. 25, Jember, Jawa Timur
                            </p>

                            <p>
                                Telp: (0331) 123456 | Email: rskasihjember@gmail.com
                            </p>

                        </div>

                    </div>

                </div>

                <div class="judul">
                    {{ $judulLaporan }}
                </div>

                <table>

                    <thead class="bg-blue-600 text-white">

                        <tr>

                            <th>NO</th>
                            <th>NAMA PASIEN</th>
                            <th>TANGGAL KUNJUNGAN</th>
                            <th>NAMA DOKTER</th>
                            <th>NAMA POLI</th>
                            <th>NO.RM</th>
                            <th>JENIS KELAMIN</th>
                            <th>KELUHAN UTAMA</th>
                            <th>DIAGNOSA UTAMA</th>
                            <th>DIAGNOSA SEKUNDER</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($laporans as $l)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $l->pasien->nama_pasien ?? '-' }}
                            </td>

                            <td>
                                {{ \Carbon\Carbon::parse($l->tanggal_kunjungan)->translatedFormat('d F Y') }}
                            </td>

                            <td>
                                {{ $l->dokter->nama_dokter ?? '-' }}
                            </td>

                            <td>
                                {{ $l->pasien->nama_poli ?? '-' }}
                            </td>

                            <td>
                                {{ $l->pasien->no_rm ?? '-' }}
                            </td>

                            <td>
                                {{ $l->pasien->jenis_kelamin ?? '-' }}
                            </td>

                            <td>
                                {{ $l->keluhan_utama }}
                            </td>

                            <td>
                                {{ $l->diagnosa->diagnosa_utama ?? '-' }}
                            </td>

                            <td>
                                {{ $l->diagnosa->diagnosa_sekunder ?? '-' }}
                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="10" class="text-center py-4">
                                Tidak ada data laporan
                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

                <div class="ttd">

                    <div class="ttd-box">

                        <p class="mb-4">
                            Jember,
                            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                        </p>

                        <p class="font-semibold mb-20">
                            Admin Rekam Medis
                        </p>

                        <div class="border-b border-black mb-2"></div>

                        <p>
                            Nama Terang
                        </p>

                    </div>

                </div>

            </div>

            {{-- HALAMAN 2 --}}
            <div id="penyakitPage" class="page-print">

                <div class="kop">

                    <div class="kop-wrapper">

                        <div class="kop-logo">

                            <img
                                src="{{ asset('images/logoRS.jpeg') }}"
                                alt="Logo">

                        </div>

                        <div class="kop-text">

                            <h1>
                                Rumah Sakit Kasih
                            </h1>

                            <p>
                                Melayani Dengan Kasih, Mengutamakan Kesembuhan
                            </p>

                            <p>
                                Jl. KH. Ahmad Dahlan No. 25, Jember, Jawa Timur
                            </p>

                            <p>
                                Telp: (0331) 123456 | Email: rskasihjember@gmail.com
                            </p>

                        </div>

                    </div>

                </div>

                <div class="judul">
                    10 Besar Penyakit
                </div>

                <table>

                    <thead class="bg-red-600 text-white">

                        <tr>

                            <th>NO</th>
                            <th>NAMA PENYAKIT</th>
                            <th>JUMLAH</th>

                        </tr>

                    </thead>

                    <tbody>

                        @php
                            $penyakit = $laporans
                                ->groupBy(function ($item) {
                                    return $item->diagnosa->diagnosa_utama ?? 'Tidak Ada Diagnosa';
                                })
                                ->map(function ($items) {
                                    return $items->count();
                                })
                                ->sortDesc()
                                ->take(10);
                        @endphp

                        @forelse($penyakit as $nama => $jumlah)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $nama }}
                            </td>

                            <td class="text-center">
                                {{ $jumlah }}
                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="3" class="text-center py-4">
                                Tidak ada data penyakit
                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- HALAMAN 3 --}}
            <div id="semuaPenyakitPage" class="page-print">

                <div class="kop">

                    <div class="kop-wrapper">

                        <div class="kop-logo">

                            <img
                                src="{{ asset('images/logoRS.jpeg') }}"
                                alt="Logo">

                        </div>

                        <div class="kop-text">

                            <h1>
                                Rumah Sakit Kasih
                            </h1>

                            <p>
                                Melayani Dengan Kasih, Mengutamakan Kesembuhan
                            </p>

                            <p>
                                Jl. KH. Ahmad Dahlan No. 25, Jember, Jawa Timur
                            </p>

                            <p>
                                Telp: (0331) 123456 | Email: rskasihjember@gmail.com
                            </p>

                        </div>

                    </div>

                </div>

                <div class="judul">
                    10 Besar Penyakit Keseluruhan
                </div>

                <table>

                    <thead class="bg-green-600 text-white">

                        <tr>

                            <th>NO</th>
                            <th>NAMA PENYAKIT</th>
                            <th>JUMLAH</th>

                        </tr>

                    </thead>

                    <tbody>

                        @php
                            $semuaPenyakit = \App\Models\Kunjungan::with('diagnosa')
                                ->get()
                                ->groupBy(function ($item) {
                                    return $item->diagnosa->diagnosa_utama ?? 'Tidak Ada Diagnosa';
                                })
                                ->map(function ($items) {
                                    return $items->count();
                                })
                                ->sortDesc()
                                ->take(10);
                        @endphp

                        @forelse($semuaPenyakit as $nama => $jumlah)

                        <tr>

                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $nama }}
                            </td>

                            <td class="text-center">
                                {{ $jumlah }}
                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="3" class="text-center py-4">
                                Tidak ada data penyakit
                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </main>

    </div>

</div>

<script>

function printOnly(id){

    let pages = document.querySelectorAll('.page-print');

    pages.forEach(page => {
        page.style.display = 'none';
    });

    let selectedPage = document.getElementById(id);

    selectedPage.style.display = 'block';

    setTimeout(() => {

        window.print();

        pages.forEach(page => {
            page.style.display = 'block';
        });

    }, 300);

}

</script>

</body>
</html>