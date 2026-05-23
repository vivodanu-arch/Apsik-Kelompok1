<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Rumah Sakit Kasih</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Chart JS --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Content Area --}}
    <div class="flex-1 ml-64 flex flex-col">

        {{-- Navbar --}}
        @include('layouts.rsnavigation')

        {{-- Main Content --}}
        <main class="p-6">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-cyan-500 to-blue-600 rounded-3xl p-8 text-white shadow-lg mb-6">

                <h1 class="text-4xl font-bold">
                    Dashboard Dokter
                </h1>

                <p class="mt-2 text-cyan-100">
                    Selamat datang kembali, dokter 👨‍⚕️
                </p>

            </div>

            {{-- Card Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                {{-- Pasien Hari Ini --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm">

                    <p class="text-gray-500 text-sm">
                        Pasien Hari Ini
                    </p>

                    <h2 class="text-4xl font-bold text-blue-600 mt-2">
                        25
                    </h2>

                </div>

                {{-- Diagnosa --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm">

                    <p class="text-gray-500 text-sm">
                        Diagnosa Hari Ini
                    </p>

                    <h2 class="text-4xl font-bold text-green-600 mt-2">
                        18
                    </h2>

                </div>

                {{-- Jadwal --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm">

                    <p class="text-gray-500 text-sm">
                        Jadwal Hari Ini
                    </p>

                    <h2 class="text-2xl font-bold text-red-500 mt-2">
                        08.00 - 14.00
                    </h2>

                </div>

            </div>

            {{-- Grafik --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">

                <h2 class="text-xl font-bold text-gray-700 mb-4">
                    Grafik Kunjungan Pasien
                </h2>

                <canvas id="dokterChart" height="100"></canvas>

            </div>

            {{-- Tabel Pasien --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">

                <h2 class="text-xl font-bold text-gray-700 mb-4">
                    Pasien Terbaru
                </h2>

                <table class="w-full">

                    <thead>
                        <tr class="border-b">

                            <th class="text-left py-3">
                                Nama Pasien
                            </th>

                            <th class="text-left py-3">
                                Poli
                            </th>

                            <th class="text-left py-3">
                                Status
                            </th>

                        </tr>
                    </thead>

                    <tbody>

                        <tr class="border-b hover:bg-gray-50">

                            <td class="py-3">
                                Budi Santoso
                            </td>

                            <td>
                                Umum
                            </td>

                            <td>
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                    Selesai
                                </span>
                            </td>

                        </tr>

                        <tr class="border-b hover:bg-gray-50">

                            <td class="py-3">
                                Siti Aminah
                            </td>

                            <td>
                                Anak
                            </td>

                            <td>
                                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                    Menunggu
                                </span>
                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </main>

    </div>

</div>

{{-- Chart --}}
<script>

const ctx = document.getElementById('dokterChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: [
            'Sen',
            'Sel',
            'Rab',
            'Kam',
            'Jum',
            'Sab',
            'Min'
        ],

        datasets: [{

            label: 'Jumlah Pasien',

            data: [12, 19, 10, 15, 20, 14, 8],

            borderWidth: 3,
            tension: 0.4,
            fill: true

        }]
    }

});

</script>

</body>
</html>