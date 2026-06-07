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
            <div class="rounded-2xl p-8 text-white shadow-sm mb-6"
                 style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%)">

                <h1 class="text-4xl font-bold">
                    Dashboard Dokter
                </h1>

                <p class="mt-2 text-cyan-100">
                    Selamat datang kembali, dokter 👨‍⚕️
                </p>

            </div>

           {{-- Card Statistik --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <p class="text-gray-500 text-sm">Pasien Hari Ini</p>
        <h2 class="text-4xl font-bold text-blue-600 mt-2">{{ $pasienHariIni }}</h2>
    </div>
    <div class="bg-white p-6 rounded-2xl shadow-sm">
        <p class="text-gray-500 text-sm">Diagnosa Hari Ini</p>
        <h2 class="text-4xl font-bold text-green-600 mt-2">{{ $diagnosaHariIni }}</h2>
    </div>
</div>

{{-- Grafik --}}
<div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
    <h2 class="text-xl font-bold text-gray-700 mb-4">Grafik Kunjungan Minggu Ini</h2>
    <canvas id="dokterChart" height="100"></canvas>
</div>

{{-- Tabel Pasien Terbaru --}}
<div class="bg-white rounded-2xl shadow-sm p-6">
    <h2 class="text-xl font-bold text-gray-700 mb-4">Pasien Terbaru</h2>
    <table class="w-full">
        <thead>
            <tr class="border-b">
                <th class="text-left py-3">Nama Pasien</th>
                <th class="text-left py-3">Poli</th>
                <th class="text-left py-3">Tanggal</th>
            </tr>
        </thead>
        <tbody>
        @forelse($pasienTerbaru as $k)
            <tr class="border-b hover:bg-gray-50">
                <td class="py-3">{{ $k->pasien->nama_pasien ?? '-' }}</td>
                <td>{{ $k->poli->nama_poli ?? '-' }}</td>
                <td class="text-sm text-gray-500">
                    {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->translatedFormat('d F Y') }}
                </td>
            </tr>
        @empty
            <tr><td colspan="3" class="text-center py-4 text-gray-400">Belum ada data</td></tr>
        @endforelse
        </tbody>
    </table>
</div>

        </main>

    </div>

</div>

{{-- Chart --}}
<script>
new Chart(document.getElementById('dokterChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode($labelHari) !!},
        datasets: [{
            label: 'Jumlah Pasien',
            data: {!! json_encode($grafikData) !!},
            borderWidth: 3,
            tension: 0.4,
            fill: true
        }]
    }
});
</script>

</body>
</html>