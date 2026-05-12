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
                    <form method="GET" action="{{ route('datakunjungan') }}" class="flex items-center gap-3">

                    <input type="date"
                        name="tanggal"
                        value="{{ request('tanggal') }}"
                        class="border border-gray-300 rounded-lg px-4 py-2 text-sm">

                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-semibold">
                        Filter
                    </button>

                    <a href="{{ route('datakunjungan') }}"
                        class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm">
                            Reset
                    </a>

                </form>

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
                                    {{ ($kunjungans->currentPage() - 1) * $kunjungans->perPage() + $loop->iteration }}
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
                                        $warna =match(strtoupper(trim($item->poli_tujuan))) {
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
                <div class="mt-8 flex justify-center items-center gap-2">

                    {{-- Prev --}}
                    @if ($kunjungans->onFirstPage())
                        <span class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-300">
                            ‹
                        </span>
                    @else
                        <a href="{{ $kunjungans->previousPageUrl() }}"
                        class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 transition">
                            ‹
                        </a>
                    @endif

                    {{-- Number --}}
                    @for ($i = 1; $i <= $kunjungans->lastPage(); $i++)
                        <a href="{{ $kunjungans->url($i) }}"
                        class="w-10 h-10 flex items-center justify-center rounded-full transition
                        {{ $kunjungans->currentPage() == $i
                                ? 'bg-blue-600 text-white shadow'
                                : 'border border-gray-200 text-gray-600 hover:bg-gray-100' }}">
                            {{ $i }}
                        </a>
                    @endfor

                    {{-- Next --}}
                    @if ($kunjungans->hasMorePages())
                        <a href="{{ $kunjungans->nextPageUrl() }}"
                        class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-500 hover:bg-gray-100 transition">
                            ›
                        </a>
                    @else
                        <span class="w-10 h-10 flex items-center justify-center rounded-full border border-gray-200 text-gray-300">
                            ›
                        </span>
                    @endif

                </div>

            </div>

        </main>

    </div>

</div>

</body>
</html>