<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Rumah Sakit Kasih</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

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
            <div class="bg-white rounded-2xl shadow-sm p-8 mb-6">
                <h1 class="text-3xl font-bold text-gray-800">
                    Dashboard
                </h1>

                <p class="text-gray-500 mt-2">
                    Selamat datang di Sistem Pelaporan Rekam Medis Rumah Sakit Kasih.
                </p>
            </div>

            {{-- Card Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                {{-- Card 1 --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <h2 class="text-gray-500 text-sm">
                        Total Pasien
                    </h2>

                    <p class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $totalPasien ?? 0 }}
                    </p>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <h2 class="text-gray-500 text-sm">
                        Laporan Hari Ini
                    </h2>

                    <p class="text-3xl font-bold text-green-600 mt-2">
                        {{ $laporanHariIni ?? 0 }}
                    </p>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <h2 class="text-gray-500 text-sm">
                        Data Dokter
                    </h2>

                    <p class="text-3xl font-bold text-red-600 mt-2">
                        {{ $totalDokter ?? 0 }}
                    </p>
                </div>

            </div>

            {{-- Grafik 10 Besar Penyakit --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 mt-6">

                <h2 class="text-xl font-bold text-gray-800 mb-6">
                    Grafik 10 Besar Penyakit
                </h2>

                <canvas id="penyakitChart" height="100"></canvas>

            </div>

        </main>

    </div>

</div>

<script>

    const ctx = document.getElementById('penyakitChart');

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: @json($topPenyakit->pluck('diagnosa_utama')),

            datasets: [{

                label: 'Jumlah Kasus',

                data: @json($topPenyakit->pluck('total')),

                backgroundColor: [
                    '#2563eb',
                    '#16a34a',
                    '#dc2626',
                    '#ca8a04',
                    '#9333ea',
                    '#0891b2',
                    '#ea580c',
                    '#4f46e5',
                    '#db2777',
                    '#059669'
                ],

                borderRadius: 8

            }]

        },

        options: {

            responsive: true,

            plugins: {

                legend: {

                    display: false

                }

            },

            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        precision: 0

                    }

                }

            }

        }

    });

</script>

</body>
</html>