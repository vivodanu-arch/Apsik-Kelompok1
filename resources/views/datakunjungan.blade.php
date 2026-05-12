<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Data Kunjungan - Rumah Sakit Kasih</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Content --}}
    <div class="flex-1 ml-64 flex flex-col">

        {{-- Navbar --}}
        @include('layouts.rsnavigation')

        {{-- Main --}}
        <main class="p-6">

            {{-- Header --}}
            <div class="bg-blue-700 rounded-2xl p-6 mb-6 shadow-sm">

                <h1 class="text-3xl font-bold text-white uppercase">
                    Data Kunjungan
                </h1>

                <p class="text-blue-100 mt-2">
                    Daftar data kunjungan pasien Rumah Sakit Kasih
                </p>

            </div>

            {{-- Card Table --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                {{-- Top Action --}}
                <div class="flex items-center justify-between p-5 border-b">

                    {{-- Filter --}}
                    <button class="bg-gray-100 hover:bg-gray-200 transition px-4 py-2 rounded-xl text-sm font-semibold text-gray-700">
                        ☰ Filter Tanggal
                    </button>

                    {{-- Info --}}
                    <p class="text-sm text-gray-400">
                        Menampilkan {{ count($kunjungans ?? []) }} data
                    </p>

                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">

                    <table class="w-full text-sm text-left">

                        {{-- Head --}}
                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs">

                            <tr>

                                <th class="px-6 py-4">
                                    No
                                </th>

                                <th class="px-6 py-4">
                                    Tanggal
                                </th>

                                <th class="px-6 py-4">
                                    Nama Pasien
                                </th>

                                <th class="px-6 py-4">
                                    Poli Tujuan
                                </th>

                                <th class="px-6 py-4">
                                    Dokter
                                </th>

                                <th class="px-6 py-4">
                                    Diagnosa
                                </th>

                            </tr>

                        </thead>

                        {{-- Body --}}
                        <tbody class="divide-y divide-gray-100">

                        @forelse($kunjungans as $item)

                            <tr class="hover:bg-gray-50 transition">

                                {{-- No --}}
                                <td class="px-6 py-5 text-gray-600">
                                    {{ $loop->iteration }}
                                </td>

                                {{-- Tanggal --}}
                                <td class="px-6 py-5">

                                    <div class="text-gray-700 font-medium">
                                        {{ \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d F Y') }}
                                    </div>

                                    <div class="text-red-500 text-xs mt-1">
                                        {{ $item->jam }}
                                    </div>

                                </td>

                                {{-- Nama --}}
                                <td class="px-6 py-5 font-semibold text-gray-800">
                                    {{ $item->nama_pasien }}
                                </td>

                                {{-- Poli --}}
                                <td class="px-6 py-5">

                                    @php
                                        $warna = match($item->poli_tujuan) {
                                            'POLI UMUM' => 'bg-orange-100 text-orange-600',
                                            'POLI MATA' => 'bg-pink-100 text-pink-600',
                                            'POLI GIGI' => 'bg-blue-100 text-blue-600',
                                            'POLI THT' => 'bg-purple-100 text-purple-600',
                                            'POLI PENYAKIT DALAM' => 'bg-green-100 text-green-700',
                                            default => 'bg-gray-100 text-gray-600'
                                        };
                                    @endphp

                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $warna }}">
                                        {{ $item->poli_tujuan }}
                                    </span>

                                </td>

                                {{-- Dokter --}}
                                <td class="px-6 py-5 text-gray-700">
                                    {{ $item->dokter }}
                                </td>

                                {{-- Diagnosa --}}
                                <td class="px-6 py-5 text-gray-700">
                                    {{ $item->diagnosa }}
                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-10 text-gray-400">

                                    Belum ada data kunjungan

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

                {{-- Pagination Dummy --}}
                <div class="flex items-center justify-center gap-3 p-6 border-t">

                    <button class="w-10 h-10 rounded-full border hover:bg-gray-100">
                        ‹
                    </button>

                    <button class="w-10 h-10 rounded-full bg-blue-700 text-white font-semibold">
                        1
                    </button>

                    <button class="w-10 h-10 rounded-full border hover:bg-gray-100">
                        2
                    </button>

                    <button class="w-10 h-10 rounded-full border hover:bg-gray-100">
                        3
                    </button>

                    <button class="w-10 h-10 rounded-full border hover:bg-gray-100">
                        ›
                    </button>

                </div>

            </div>

        </main>

    </div>

</div>

</body>
</html>