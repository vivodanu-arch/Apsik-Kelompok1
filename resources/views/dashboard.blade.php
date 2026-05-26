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

    @include('layouts.sidebar')

    <div class="flex-1 ml-64 flex flex-col">
        @include('layouts.rsnavigation')

        <main class="p-6">

            {{-- Header --}}
            <div class="bg-white rounded-2xl shadow-sm p-8 mb-6">
                <h1 class="text-3xl font-bold text-gray-800">Dashboard</h1>
                <p class="text-gray-500 mt-2">Selamat datang di Sistem Pelaporan Rekam Medis Rumah Sakit Kasih.</p>
            </div>

            {{-- Kartu Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
                    <div class="bg-blue-100 p-4 rounded-xl">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Pasien</p>
                        <p class="text-3xl font-bold text-blue-600">{{ $totalPasien ?? 0 }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
                    <div class="bg-green-100 p-4 rounded-xl">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Kunjungan Hari Ini</p>
                        <p class="text-3xl font-bold text-green-600">{{ $KunjunganHariIni ?? 0 }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
                    <div class="bg-red-100 p-4 rounded-xl">
                        <svg class="w-7 h-7 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0M19 21a7 7 0 00-14 0"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Data Dokter</p>
                        <p class="text-3xl font-bold text-red-600">{{ $totalDokter ?? 0 }}</p>
                    </div>
                </div>

            </div>

            {{-- Grafik 2 kolom --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                {{-- ============================================
                     GRAFIK 1: 10 Besar Penyakit (toggle pie/bar)
                     ============================================ --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">

                    {{-- Header + Toggle --}}
                    <div class="flex items-center justify-between mb-4">
                        <div>
                            <h2 class="text-lg font-bold text-gray-800">10 Besar Penyakit</h2>
                            <p class="text-xs text-gray-400 mt-0.5">Berdasarkan jumlah diagnosa</p>
                        </div>
                        <div class="flex items-center gap-1 bg-gray-100 p-1 rounded-xl">
                            <button id="btnBar"
                                    onclick="switchChart('bar')"
                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition
                                           bg-blue-600 text-white shadow">
                                {{-- Bar icon --}}
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <rect x="1" y="10" width="3" height="9" rx="1"/>
                                    <rect x="6" y="6"  width="3" height="13" rx="1"/>
                                    <rect x="11" y="3" width="3" height="16" rx="1"/>
                                    <rect x="16" y="7" width="3" height="12" rx="1"/>
                                </svg>
                                Batang
                            </button>
                            <button id="btnPie"
                                    onclick="switchChart('pie')"
                                    class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition
                                           text-gray-500 hover:bg-white">
                                {{-- Pie icon --}}
                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M10 2a8 8 0 100 16A8 8 0 0010 2zm0 2v6h6a6 6 0 01-6 6V4z"/>
                                </svg>
                                Pie
                            </button>
                        </div>
                    </div>

                    <div class="relative" style="height:340px;">
                        <canvas id="penyakitChart"></canvas>
                    </div>

                </div>

                {{-- ============================================
                     GRAFIK 2: 10 Besar Dokter (bar horizontal)
                     ============================================ --}}
                <div class="bg-white rounded-2xl shadow-sm p-5">

                    <div class="mb-4">
                        <h2 class="text-lg font-bold text-gray-800">10 Besar Dokter</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Berdasarkan jumlah pasien yang ditangani</p>
                    </div>

                    <div class="relative" style="height:340px;">
                        <canvas id="dokterChart"></canvas>
                    </div>

                </div>

            </div>

        </main>
    </div>
</div>

@php
    $penyakitLabels = $topPenyakit->map(fn($p) => $p->diagnosa_utama)->toArray();
    $penyakitData   = $topPenyakit->pluck('total')->toArray();
    $dokterLabels   = $topDokter->map(fn($d) => $d->nama_dokter)->toArray();
    $dokterData     = $topDokter->pluck('total_pasien')->toArray();
    $dokterSpesialis= $topDokter->map(fn($d) => $d->spesialis)->toArray();

    $warna10 = ['#2563eb','#16a34a','#dc2626','#ca8a04','#9333ea',
                '#0891b2','#ea580c','#4f46e5','#db2777','#059669'];
@endphp

<script>
// ─── Data dari Laravel ───────────────────────────────────────────
const penyakitLabels   = @json($penyakitLabels);
const penyakitData     = @json($penyakitData);
const dokterLabels     = @json($dokterLabels);
const dokterData       = @json($dokterData);
const dokterSpesialis  = @json($dokterSpesialis);
const warna10          = @json($warna10);

// ─── Grafik Penyakit (toggle bar/pie) ───────────────────────────
const penyakitCtx = document.getElementById('penyakitChart').getContext('2d');

const barConfig = {
    type: 'bar',
    data: {
        labels: penyakitLabels,
        datasets: [{
            label: 'Jumlah Kasus',
            data: penyakitData,
            backgroundColor: warna10,
            borderRadius: 6,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ' ' + ctx.parsed.y + ' kasus'
                }
            }
        },
        scales: {
            x: { ticks: { font: { size: 9 }, maxRotation: 30 } },
            y: { beginAtZero: true, ticks: { precision: 0 } }
        }
    }
};

const pieConfig = {
    type: 'pie',
    data: {
        labels: penyakitLabels,
        datasets: [{
            data: penyakitData,
            backgroundColor: warna10,
            borderWidth: 2,
            borderColor: '#fff',
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                position: 'right',
                labels: { font: { size: 10 }, padding: 10, boxWidth: 12 }
            },
            tooltip: {
                callbacks: {
                    label: ctx => ' ' + ctx.label + ': ' + ctx.parsed + ' kasus'
                }
            }
        }
    }
};

let penyakitChart = new Chart(penyakitCtx, barConfig);
let currentType = 'bar';

function switchChart(type) {
    if (type === currentType) return;
    currentType = type;
    penyakitChart.destroy();
    penyakitChart = new Chart(penyakitCtx, type === 'bar' ? barConfig : pieConfig);

    // Update tombol aktif
    document.getElementById('btnBar').className = (type === 'bar')
        ? 'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition bg-blue-600 text-white shadow'
        : 'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition text-gray-500 hover:bg-white';
    document.getElementById('btnPie').className = (type === 'pie')
        ? 'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition bg-blue-600 text-white shadow'
        : 'flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-semibold transition text-gray-500 hover:bg-white';
}

// ─── Grafik Dokter (bar horizontal) ─────────────────────────────
const dokterCtx = document.getElementById('dokterChart').getContext('2d');

new Chart(dokterCtx, {
    type: 'bar',
    data: {
        labels: dokterLabels,
        datasets: [{
            label: 'Jumlah Pasien',
            data: dokterData,
            backgroundColor: warna10,
            borderRadius: 6,
        }]
    },
    options: {
        indexAxis: 'y',   // ← horizontal bar
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    afterLabel: (ctx) => 'Spesialis: ' + dokterSpesialis[ctx.dataIndex]
                }
            }
        },
        scales: {
            x: { beginAtZero: true, ticks: { precision: 0 } },
            y: { ticks: { font: { size: 10 } } }
        }
    }
});
</script>

</body>
</html>