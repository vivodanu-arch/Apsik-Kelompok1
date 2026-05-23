<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Rumah Sakit Kasih</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Content Area --}}
    <div class="flex-1 ml-64 flex flex-col">

        {{-- Navbar --}}
        @include('layouts.rsnavigation')
  </div>
{{-- Main --}}
        <main class="p-6">

            {{-- Header --}}
            <div class="bg-gradient-to-r from-indigo-600 to-blue-700 rounded-3xl p-8 text-white shadow-lg mb-6">

                <h1 class="text-4xl font-bold">
                    Dashboard Kepala Rekam Medis
                </h1>

                <p class="mt-2 text-indigo-100">
                    Monitoring data laporan dan aktivitas rumah sakit
                </p>

            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-6">

                {{-- Total Pasien --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm">

                    <p class="text-gray-500 text-sm">
                        Total Pasien
                    </p>

                    <h2 class="text-4xl font-bold text-blue-600 mt-2">
                        320
                    </h2>

                </div>

                {{-- Total Kunjungan --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm">

                    <p class="text-gray-500 text-sm">
                        Total Kunjungan
                    </p>

                    <h2 class="text-4xl font-bold text-green-600 mt-2">
                        1.245
                    </h2>

                </div>

                {{-- Dokter --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm">

                    <p class="text-gray-500 text-sm">
                        Data Dokter
                    </p>

                    <h2 class="text-4xl font-bold text-red-500 mt-2">
                        15
                    </h2>

                </div>

                {{-- Petugas --}}
                <div class="bg-white rounded-2xl p-6 shadow-sm">

                    <p class="text-gray-500 text-sm">
                        Petugas Aktif
                    </p>

                    <h2 class="text-4xl font-bold text-purple-600 mt-2">
                        8
                    </h2>

                </div>

            </div>

            {{-- Grafik --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">

                <div class="flex justify-between items-center mb-4">

                    <div>
                        <h2 class="text-xl font-bold text-gray-700">
                            Grafik Laporan Bulanan
                        </h2>

                        <p class="text-sm text-gray-500">
                            Statistik kunjungan pasien per bulan
                        </p>
                    </div>

                </div>

                <canvas id="kepalaChart" height="100"></canvas>

            </div>

            {{-- Aktivitas --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- Aktivitas Petugas --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-700 mb-4">
                        Aktivitas Petugas
                    </h2>

                    <div class="space-y-4">

                        <div class="flex items-center justify-between border-b pb-3">

                            <div>
                                <p class="font-semibold">
                                    Admin 1
                                </p>

                                <p class="text-sm text-gray-500">
                                    Menambahkan data pasien
                                </p>
                            </div>

                            <span class="text-xs text-gray-400">
                                10 menit lalu
                            </span>

                        </div>

                        <div class="flex items-center justify-between border-b pb-3">

                            <div>
                                <p class="font-semibold">
                                    Admin 2
                                </p>

                                <p class="text-sm text-gray-500">
                                    Mengupdate laporan kunjungan
                                </p>
                            </div>

                            <span class="text-xs text-gray-400">
                                30 menit lalu
                            </span>

                        </div>

                    </div>

                </div>

                {{-- Status Sistem --}}
                <div class="bg-white rounded-2xl shadow-sm p-6">

                    <h2 class="text-xl font-bold text-gray-700 mb-4">
                        Status Sistem
                    </h2>

                    <div class="space-y-4">

                        <div class="flex items-center justify-between">

                            <span>
                                Database
                            </span>

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Online
                            </span>

                        </div>

                        <div class="flex items-center justify-between">

                            <span>
                                Server Laravel
                            </span>

                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm">
                                Aktif
                            </span>

                        </div>

                        <div class="flex items-center justify-between">

                            <span>
                                Backup Data
                            </span>

                            <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-sm">
                                Pending
                            </span>

                        </div>

                    </div>

                </div>

            </div>

        </main>

    </div>

</div>

{{-- Chart --}}
<script>

const ctx = document.getElementById('kepalaChart');

new Chart(ctx, {

    type: 'bar',

    data: {

        labels: [
            'Jan',
            'Feb',
            'Mar',
            'Apr',
            'Mei',
            'Jun'
        ],

        datasets: [{

            label: 'Jumlah Kunjungan',

            data: [120, 190, 150, 220, 180, 250],

            borderWidth: 1

        }]
    }

});

</script>

</body>
</html>
</div>

</body>
</html>
Kepala RM