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
                        120
                    </p>
                </div>

                {{-- Card 2 --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <h2 class="text-gray-500 text-sm">
                        Laporan Hari Ini
                    </h2>

                    <p class="text-3xl font-bold text-green-600 mt-2">
                        25
                    </p>
                </div>

                {{-- Card 3 --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm">
                    <h2 class="text-gray-500 text-sm">
                        Data Dokter
                    </h2>

                    <p class="text-3xl font-bold text-red-600 mt-2">
                        15
                    </p>
                </div>

            </div>

        </main>

    </div>

</div>

</body>
</html>