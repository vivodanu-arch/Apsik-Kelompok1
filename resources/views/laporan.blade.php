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

            #printArea,
            #printArea * {
                visibility: visible;
            }

            #printArea {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                padding: 20px;
            }

            .no-print {
                display: none !important;
            }

            table {
                page-break-inside: auto;
            }

            tr {
                page-break-inside: avoid;
                page-break-after: auto;
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

            {{-- Filter --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-6 max-w-4xl mx-auto no-print">

                <form method="GET" action="{{ route('laporan') }}">

                    <div class="flex flex-wrap items-center justify-center gap-4">

                        {{-- Dari --}}
                        <div class="flex items-center gap-2">

                            <label class="text-sm font-semibold text-gray-700">
                                Dari:
                            </label>

                            <input
                                type="date"
                                name="dari"
                                value="{{ request('dari') }}"
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        </div>

                        {{-- Sampai --}}
                        <div class="flex items-center gap-2">

                            <label class="text-sm font-semibold text-gray-700">
                                Sampai:
                            </label>

                            <input
                                type="date"
                                name="sampai"
                                value="{{ request('sampai') }}"
                                class="border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                        </div>

                        {{-- Button --}}
                        <button
                            type="submit"
                            class="bg-blue-600 hover:bg-blue-700 transition text-white px-6 py-2 rounded-lg shadow">

                            Terapkan

                        </button>

                    </div>

                </form>

            </div>

            {{-- Print Area --}}
            <div id="printArea" class="bg-white rounded-2xl shadow-sm p-6 overflow-auto">

                {{-- KOP RUMAH SAKIT --}}
                <div class="border-b-4 border-blue-700 pb-4 mb-6">

                    <div class="flex flex-col items-center justify-center text-center">

                        {{-- Logo --}}
                        <img
                            src="{{ asset('images/logoRS.jpeg') }}"
                            alt="Logo Rumah Sakit"
                            class="w-24 h-24 object-contain mb-2">

                        {{-- Info Rumah Sakit --}}
                        <div>

                            <h1 class="text-3xl font-bold text-blue-900 uppercase">
                                Rumah Sakit Kasih
                            </h1>

                            <p class="text-sm text-gray-700">
                                Melayani Dengan Kasih, Mengutamakan Kesembuhan
                            </p>

                            <p class="text-sm text-gray-700">
                                Jl. KH. Ahmad Dahlan No. 25, Jember, Jawa Timur
                            </p>

                            <p class="text-sm text-gray-700">
                                Telp: (0331) 123456 | Email: rskasihjember@gmail.com
                            </p>

                        </div>

                    </div>

                </div>

                {{-- Judul Laporan --}}
                <div class="text-center mb-6">

                    <h2 class="text-2xl font-bold uppercase">
                        {{ $judulLaporan }}
                    </h2>

                </div>

                {{-- Table --}}
                <table
                    class="table-auto border-collapse border border-gray-400 w-full text-sm">

                    <thead class="bg-blue-600 text-white">

                        <tr>

                            <th class="border border-gray-400 px-3 py-2">
                                NO
                            </th>

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

                            <td colspan="10"
                                class="border border-gray-400 px-3 py-4 text-center text-gray-500">

                                Tidak ada data laporan

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

                {{-- Footer TTD --}}
                <div class="mt-16 flex justify-end">

                    <div class="text-center w-72">

                        {{-- Tempat dan tanggal --}}
                        <p class="mb-4">
                            Jember,
                            {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
                        </p>

                        {{-- Jabatan --}}
                        <p class="font-semibold mb-16">
                            Admin Rekam Medis
                        </p>

                        {{-- Area tanda tangan --}}
                        <div class="border-b border-black w-full mb-2"></div>

                        {{-- Nama --}}
                        <p class="text-sm text-gray-700">
                            Nama Terang
                        </p>

                    </div>

                </div>

                {{-- Print --}}
                <div class="flex justify-center mt-6 no-print">

                    <button
                        onclick="window.print()"
                        class="bg-orange-500 hover:bg-orange-600 transition text-white px-6 py-2 rounded-xl shadow">

                        🖨 Print Document

                    </button>

                </div>

            </div>

        </main>

    </div>

</div>

</body>
</html>