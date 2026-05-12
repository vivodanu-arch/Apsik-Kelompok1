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

    @include('layouts.sidebar')

    <div class="flex-1 ml-64 flex flex-col">

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

        <div class="flex flex-wrap items-center gap-4">

            {{-- Filter Periode --}}
            <div class="flex items-center gap-2">

                <span class="text-sm font-semibold text-gray-700">
                    Filter Periode:
                </span>

                <div class="flex bg-gray-100 rounded-lg p-1">

                    <button class="bg-white shadow text-blue-700 px-4 py-1 rounded-lg text-sm font-semibold">
                        Harian
                    </button>

                    <button class="px-4 py-1 text-sm text-gray-500">
                        Mingguan
                    </button>

                    <button class="px-4 py-1 text-sm text-gray-500">
                        Bulanan
                    </button>

                    <button class="px-4 py-1 text-sm text-gray-500">
                        Tahunan
                    </button>

                </div>

            </div>

            {{-- Date --}}
            <div class="flex items-center gap-2">

                <label class="text-sm font-semibold text-gray-700">
                    Dari:
                </label>

                <input type="date"
                    class="border rounded-lg px-3 py-2">

            </div>

            <div class="flex items-center gap-2">

                <label class="text-sm font-semibold text-gray-700">
                    Sampai:
                </label>

                <input type="date"
                    class="border rounded-lg px-3 py-2">

            </div>

            {{-- Button --}}
            <button
                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">

                Terapkan
            </button>

        </div>

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
                        NIK
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

                <tr>

                    <td class="border border-gray-400 px-3 py-2 text-center">
                        1
                    </td>

                    <td class="border border-gray-400 px-3 py-2">
                        Dansuloyo
                    </td>

                    <td class="border border-gray-400 px-3 py-2 text-nowrap">
                        25 Oktober 2030
                    </td>

                    <td class="border border-gray-400 px-3 py-2">
                        dr. Defun
                    </td>

                    <td class="border border-gray-400 px-3 py-2">
                        POLI UMUM
                    </td>

                    <td class="border border-gray-400 px-3 py-2 text-nowrap">
                        12-45-67
                    </td>

                    <td class="border border-gray-400 px-3 py-2">
                        3275010022390001
                    </td>

                    <td class="border border-gray-400 px-3 py-2">
                        Laki-laki
                    </td>

                    <td class="border border-gray-400 px-3 py-2">
                        Bersin pilek dan meriang
                    </td>

                    <td class="border border-gray-400 px-3 py-2">
                        Common Cold
                    </td>

                    <td class="border border-gray-400 px-3 py-2 text-center">
                        -
                    </td>

                </tr>

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