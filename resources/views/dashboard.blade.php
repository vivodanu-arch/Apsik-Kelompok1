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

            {{-- Section Grafik --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 mt-6">

                {{-- Grafik 10 Besar Penyakit --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 h-[420px]">

                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        Grafik 10 Besar Penyakit
                    </h2>

                    @php

                        $topPenyakit = \Illuminate\Support\Facades\DB::table('diagnosas')
                            ->select(
                                'diagnosa_utama',
                                \Illuminate\Support\Facades\DB::raw('COUNT(*) as total')
                            )
                            ->groupBy('diagnosa_utama')
                            ->orderByDesc('total')
                            ->limit(10)
                            ->get();

                        $labels = $topPenyakit->pluck('diagnosa_utama');
                        $data = $topPenyakit->pluck('total');

                    @endphp

                    <div class="relative h-[320px]">
                        <canvas id="penyakitChart"></canvas>
                    </div>

                </div>

                {{-- Grafik 10 Besar Penyakit Pelaporan --}}
                <div class="bg-white rounded-2xl shadow-sm p-5 h-[420px]">

                    <h2 class="text-lg font-bold text-gray-800 mb-4">
                        Grafik 10 Besar Penyakit Pelaporan
                    </h2>

                    @php

                        $laporanPenyakit = \Illuminate\Support\Facades\DB::table('kunjungans')
                            ->join('diagnosas', 'kunjungans.id', '=', 'diagnosas.kunjungan_id')
                            ->select(
                                'diagnosas.diagnosa_utama',
                                \Illuminate\Support\Facades\DB::raw('COUNT(*) as total')
                            )
                            ->groupBy('diagnosas.diagnosa_utama')
                            ->orderByDesc('total')
                            ->limit(10)
                            ->get();

                    @endphp

                    <div class="relative h-[320px]">
                        <canvas id="kunjunganChart"></canvas>
                    </div>

                </div>

            </div>

        </main>

    </div>

</div>

{{-- Grafik Penyakit --}}
<script>

    const ctx = document.getElementById('penyakitChart');

    new Chart(ctx, {

        type: 'bar',

        data: {

            labels: @json($labels),

            datasets: [{

                label: 'Jumlah Kasus',

                data: @json($data),

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
            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                }

            },

            scales: {

                x: {
                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                },

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

{{-- Grafik Laporan --}}
<script>

    const kunjunganCtx = document.getElementById('kunjunganChart');

    new Chart(kunjunganCtx, {

        type: 'bar',

        data: {

            labels: @json($laporanPenyakit->pluck('diagnosa_utama')),

            datasets: [{

                label: 'Jumlah Penyakit',

                data: @json($laporanPenyakit->pluck('total')),

                backgroundColor: [
                    '#0ea5e9',
                    '#22c55e',
                    '#ef4444',
                    '#f59e0b',
                    '#8b5cf6',
                    '#14b8a6',
                    '#f97316',
                    '#6366f1',
                    '#ec4899',
                    '#10b981'
                ],

                borderRadius: 8

            }]

        },

        options: {

            responsive: true,
            maintainAspectRatio: false,

            plugins: {

                legend: {
                    display: false
                }

            },

            scales: {

                x: {
                    ticks: {
                        font: {
                            size: 10
                        }
                    }
                },

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