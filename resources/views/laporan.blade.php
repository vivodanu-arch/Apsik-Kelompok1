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

        @media print {

            body * {
                visibility: hidden;
            }

            #printTable,
            #printTable * {
                visibility: visible;
            }

            #printTable {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
            }

        }

    </style>

</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    <div class="flex-1 ml-64 flex flex-col">

        {{-- Navbar --}}
        @include('layouts.rsnavigation')

        {{-- Main --}}
        <main class="p-6 bg-gray-100 min-h-screen">

            {{-- Header --}}
            <div class="bg-blue-700 rounded-2xl p-6 mb-6 shadow-sm">

                <h1 class="text-3xl font-bold text-white uppercase">
                    Laporan
                </h1>

            </div>

            {{-- Filter --}}
            <div class="bg-white rounded-2xl shadow-sm p-4 mb-6">

                <form method="GET" action="{{ route('laporan') }}">

                    <div class="flex flex-wrap items-center gap-4">

                        {{-- Filter Periode --}}
                        <div class="flex items-center gap-2">

                            <span class="text-sm font-semibold text-gray-700">
                                Filter Periode:
                            </span>

                            <div class="flex bg-gray-100 rounded-lg p-1">

                                <button type="submit"
                                    name="periode"
                                    value="harian"
                                    class="{{ request('periode') == 'harian' ? 'bg-white shadow text-blue-700' : 'text-gray-500' }} px-4 py-1 rounded-lg text-sm font-semibold">

                                    Harian
                                </button>

                                <button type="submit"
                                    name="periode"
                                    value="mingguan"
                                    class="{{ request('periode') == 'mingguan' ? 'bg-white shadow text-blue-700' : 'text-gray-500' }} px-4 py-1 rounded-lg text-sm font-semibold">

                                    Mingguan
                                </button>

                                <button type="submit"
                                    name="periode"
                                    value="bulanan"
                                    class="{{ request('periode') == 'bulanan' ? 'bg-white shadow text-blue-700' : 'text-gray-500' }} px-4 py-1 rounded-lg text-sm font-semibold">

                                    Bulanan
                                </button>

                                <button type="submit"
                                    name="periode"
                                    value="tahunan"
                                    class="{{ request('periode') == 'tahunan' ? 'bg-white shadow text-blue-700' : 'text-gray-500' }} px-4 py-1 rounded-lg text-sm font-semibold">

                                    Tahunan
                                </button>

                            </div>

                        </div>

                        {{-- Date --}}
                        <div class="flex items-center gap-2">

                            <label class="text-sm font-semibold text-gray-700">
                                Dari:
                            </label>

                            <input
                                type="date"
                                name="dari"
                                value="{{ request('dari') }}"
                                class="border rounded-lg px-3 py-2">

                        </div>

                        <div class="flex items-center gap-2">

                            <label class="text-sm font-semibold text-gray-700">
                                Sampai:
                            </label>

                            <input
                                type="date"
                                name="sampai"
                                value="{{ request('sampai') }}"
                                class="border rounded-lg px-3 py-2">

                        </div>

                        {{-- Button --}}
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                            Terapkan

                        </button>

                    </div>

                </form>

            </div>

            {{-- Table --}}
            <div class="bg-white rounded-2xl shadow-sm p-4 overflow-auto">

                <table id="printTable"
                    class="table-auto border-collapse border border-gray-400 w-full text-sm">

                    <thead class="bg-blue-600 text-white">

                        <tr>

                            <th class="border border-gray-400 px-3 py-2">NO</th>

                            <th class="border border-gray-400 px-3 py-2 text-nowrap">
                                NAMA PASIEN
                            </th>

                            <th class="border border-gray-400 px-3 py-2 text-nowrap">
                                TANGGAL KUNJUNGAN
                            </th>

                            <th class="border border-gray-400 px-3 py-2 text-nowrap">
                                NAMA DOKTER
                            </th>

                            <th class="border border-gray-400 px-3 py-2">
                                NAMA POLI
                            </th>

                            <th class="border border-gray-400 px-3 py-2">
                                NO.RM
                            </th>

                            <th class="border border-gray-400 px-3 py-2">
                                JENIS KELAMIN
                            </th>

                            <th class="border border-gray-400 px-3 py-2">
                                KELUHAN UTAMA
                            </th>

                            <th class="border border-gray-400 px-3 py-2">
                                DIAGNOSA UTAMA
                            </th>

                            <th class="border border-gray-400 px-3 py-2">
                                DIAGNOSA SEKUNDER
                            </th>

                        </tr>

                    </thead>

                    <tbody class="bg-white">

                        @forelse($laporans as $l)

                        <tr>

                            <td class="border border-gray-400 px-3 py-2 text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2">
                                {{ $l->pasien->nama_pasien ?? '-' }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2 text-nowrap">
                                {{ \Carbon\Carbon::parse($l->tanggal_kunjungan)->translatedFormat('d F Y') }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2">
                                {{ $l->dokter->nama_dokter ?? '-' }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2">
                                {{ $l->pasien->nama_poli ?? '-' }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2 text-nowrap">
                                {{ $l->pasien->no_rm ?? '-' }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2">
                                {{ $l->pasien->jenis_kelamin ?? '-' }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2">
                                {{ $l->keluhan_utama }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2">
                                {{ $l->diagnosa->diagnosa_utama ?? '-' }}
                            </td>

                            <td class="border border-gray-400 px-3 py-2 text-center">
                                {{ $l->diagnosa->diagnosa_sekunder ?? '-' }}
                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="11"
                                class="border border-gray-400 px-3 py-4 text-center text-gray-500">

                                Tidak ada data laporan

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

                {{-- Print --}}
                <div class="flex justify-center mt-6">

                    <button
                        onclick="window.print()"
                        class="bg-orange-500 hover:bg-orange-600 text-white px-6 py-2 rounded-xl shadow">

                        🖨 Print Document

                    </button>

                </div>

            </div>

        </main>

    </div>

</div>

</body>
</html>