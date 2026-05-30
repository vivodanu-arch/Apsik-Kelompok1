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

        {{-- Main --}}
        <main class="p-6 space-y-6">

            {{-- Header Banner --}}
            <div class="bg-gradient-to-r from-indigo-600 to-blue-700 rounded-2xl p-8 text-white shadow-sm">
                <h1 class="text-3xl font-bold">Dashboard Kepala Rekam Medis</h1>
                <p class="mt-1 text-indigo-200 text-sm">Monitoring data laporan dan aktivitas rumah sakit</p>
            </div>

            {{-- Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-gray-400 text-xs mb-2">Total Pasien</p>
                    <h2 class="text-3xl font-bold text-indigo-600">{{ number_format($totalPasien) }}</h2>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-gray-400 text-xs mb-2">Total Kunjungan</p>
                    <h2 class="text-3xl font-bold text-emerald-600">{{ number_format($totalKunjungan) }}</h2>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-gray-400 text-xs mb-2">Data Dokter</p>
                    <h2 class="text-3xl font-bold text-red-500">{{ $totalDokter }}</h2>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100">
                    <p class="text-gray-400 text-xs mb-2">Petugas Aktif</p>
                    <h2 class="text-3xl font-bold text-purple-600">{{ $totalPetugas }}</h2>
                </div>
            </div>

            {{-- Grafik + Petugas (berdampingan) --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                {{-- Grafik Bulanan --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-base font-semibold text-gray-700">Grafik Laporan Bulanan</h2>
                    <p class="text-xs text-gray-400 mt-0.5 mb-4">Statistik kunjungan pasien per bulan</p>
                    <canvas id="kepalaChart" height="160"></canvas>
                </div>

                {{-- Daftar Petugas --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-base font-semibold text-gray-700 mb-4">Daftar Petugas</h2>
                    <div class="space-y-1">
                        @forelse($petugasAktif as $p)
                        <div class="flex items-center justify-between py-2 border-b border-gray-100 last:border-0">
                            <div class="flex items-center gap-2.5">
                                <div class="w-7 h-7 rounded-full bg-indigo-100 flex items-center justify-center text-xs font-semibold text-indigo-700">
                                    {{ strtoupper(substr($p->name, 0, 2)) }}
                                </div>
                                <span class="text-sm text-gray-700">{{ $p->name }}</span>
                            </div>
                            <span class="bg-emerald-50 text-emerald-700 px-2.5 py-0.5 rounded-full text-xs font-medium">Aktif</span>
                        </div>
                        @empty
                        <p class="text-sm text-gray-400 py-4 text-center">Tidak ada petugas aktif</p>
                        @endforelse
                    </div>
                </div>

            </div>

            {{-- Aktivitas + Status Sistem --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">

                {{-- Aktivitas Petugas --}}
               

                {{-- Status Sistem --}}
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-base font-semibold text-gray-700 mb-4">Status Sistem</h2>
                    <div class="space-y-3">
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Database</span>
                            <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium">Online</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Server Laravel</span>
                            <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium">Aktif</span>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="text-sm text-gray-600">Backup Data</span>
                            <span class="bg-yellow-50 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                        </div>
                    </div>
                </div>

            </div>

        </main>

    </div>
</div>

{{-- Chart Script --}}
<script>
new Chart(document.getElementById('kepalaChart'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($labelBulan) !!},
        datasets: [{
            label: 'Jumlah Kunjungan',
            data: {!! json_encode($grafikData) !!},
            backgroundColor: '#4F46E5',
            borderRadius: 4,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: '#f3f4f6' },
                ticks: { font: { size: 11 }, color: '#9ca3af' }
            },
            x: {
                grid: { display: false },
                ticks: { font: { size: 11 }, color: '#9ca3af' }
            }
        }
    }
});
</script>

</body>
</html>