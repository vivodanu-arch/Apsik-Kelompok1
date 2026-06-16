<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Rumah Sakit Kasih</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
</head>

<body class="bg-gray-100">
<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <div class="flex-1 ml-64 flex flex-col">
        @include('layouts.rsnavigation')

        <main class="p-6">

            {{-- ── Header dengan ucapan selamat datang per user ── --}}
            <div class="rounded-2xl p-8 mb-6 text-white shadow-sm"
                 style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);">
                <h1 class="text-3xl font-bold">Dashboard</h1>
                <p class="mt-2 text-blue-100">
                    Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong> 👋
                </p>
                <p class="mt-1 text-blue-200 text-sm">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                    &nbsp;·&nbsp;
                    @if(Auth::user()->is_super_admin)
                        <span class="bg-white/20 rounded-full px-2 py-0.5 text-xs font-semibold">Super Admin</span>
                    @else
                        <span class="bg-white/20 rounded-full px-2 py-0.5 text-xs font-semibold capitalize">{{ Auth::user()->role }}</span>
                    @endif
                </p>
            </div>

            {{-- ── Kartu Statistik ── --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">

                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
                    <div class="bg-blue-100 p-4 rounded-xl flex-shrink-0">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Pasien</p>
                        <p class="text-3xl font-bold text-blue-600">{{ number_format($totalPasien) }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">terdaftar di sistem</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
                    <div class="bg-green-100 p-4 rounded-xl flex-shrink-0">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Kunjungan Hari Ini</p>
                        <p class="text-3xl font-bold text-green-600">{{ $KunjunganHariIni }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</p>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-4">
                    <div class="bg-purple-100 p-4 rounded-xl flex-shrink-0">
                        <svg class="w-7 h-7 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0M19 21a7 7 0 00-14 0"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Total Dokter</p>
                        <p class="text-3xl font-bold text-purple-600">{{ $totalDokter }}</p>
                        <p class="text-xs text-gray-400 mt-0.5">dokter aktif</p>
                    </div>
                </div>

            </div>

            {{-- ── Baris 1: RL 5.2 (full width) ── --}}
            <div class="mb-6">
                <div class="bg-white rounded-2xl shadow-sm p-5">
                    <div class="mb-4">
                        <h2 class="text-lg font-bold text-gray-800">RL 5.2 – 10 Besar Kasus Baru Penyakit</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Berdasarkan jumlah pasien unik per diagnosa</p>
                    </div>
                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                        {{-- Pie chart --}}
                        <div class="relative" style="height:340px;">
                            <canvas id="rl52Chart"></canvas>
                        </div>
                        {{-- Legenda di sebelah kanan --}}
                        <div class="space-y-2 pt-2" id="rl52Legend"></div>
                    </div>
                </div>
            </div>

            {{-- ── Baris 2: 10 Besar Dokter (full width) ── --}}
            <div class="bg-white rounded-2xl shadow-sm p-5">
                <div class="mb-4">
                    <h2 class="text-lg font-bold text-gray-800">10 Besar Dokter</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Berdasarkan jumlah kunjungan yang ditangani</p>
                </div>
                <div class="relative" style="height:320px;">
                    <canvas id="dokterChart"></canvas>
                </div>
            </div>

        </main>
    </div>
</div>

@php
    $warna10 = [
        '#2563eb','#16a34a','#dc2626','#ca8a04','#9333ea',
        '#0891b2','#ea580c','#4f46e5','#db2777','#059669'
    ];

    $rl52Labels = $rl52->map(fn($p) => $p->diagnosa_utama)->toArray();
    $rl52Data   = $rl52->pluck('total')->toArray();
    $rl52Kode   = $rl52->pluck('kode_icd')->toArray();

    $dokterLabels    = $topDokter->map(fn($d) => $d->nama_dokter)->toArray();
    $dokterData      = $topDokter->pluck('total_pasien')->toArray();
    $dokterSpesialis = $topDokter->map(fn($d) => $d->spesialis)->toArray();
@endphp

<script>
Chart.register(ChartDataLabels);

const warna10 = @json($warna10);

// ── Helper: buat pie chart dengan persentase & legenda ─────────────
function buatPieChart(canvasId, legendId, labels, data, kodes) {
    const total = data.reduce((a, b) => a + b, 0);
    const ctx   = document.getElementById(canvasId).getContext('2d');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels: labels,
            datasets: [{
                data: data,
                backgroundColor: warna10,
                borderColor: '#fff',
                borderWidth: 2,
                hoverOffset: 10,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: ctx => {
                            const pct = total > 0 ? ((ctx.parsed / total) * 100).toFixed(1) : 0;
                            return ` ${ctx.parsed} kasus (${pct}%)`;
                        },
                        title: ctx => ctx[0].label,
                    }
                },
                datalabels: {
                    color: '#fff',
                    font: { weight: 'bold', size: 11 },
                    formatter: (value) => {
                        const pct = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return pct >= 4 ? pct + '%' : '';  // sembunyikan jika terlalu kecil
                    },
                    textShadowColor: 'rgba(0,0,0,0.4)',
                    textShadowBlur: 4,
                }
            }
        }
    });

    // Legenda manual dengan persentase
    const legend = document.getElementById(legendId);
    labels.forEach((label, i) => {
        const pct = total > 0 ? ((data[i] / total) * 100).toFixed(1) : 0;
        const kode = kodes[i] ?? '';
        const div = document.createElement('div');
        div.className = 'flex items-center justify-between text-xs gap-2';
        div.innerHTML = `
            <div class="flex items-center gap-2 min-w-0">
                <span class="flex-shrink-0 w-2.5 h-2.5 rounded-full" style="background:${warna10[i]}"></span>
                <span class="text-gray-600 truncate" title="${label}">${label}</span>
                <span class="text-gray-400 flex-shrink-0">${kode}</span>
            </div>
            <div class="flex items-center gap-2 flex-shrink-0">
                <span class="font-semibold text-gray-700">${data[i]}</span>
                <span class="text-gray-400 w-10 text-right">${pct}%</span>
            </div>
        `;
        legend.appendChild(div);
    });
}

// RL 5.2
buatPieChart(
    'rl52Chart', 'rl52Legend',
    @json($rl52Labels), @json($rl52Data), @json($rl52Kode)
);

// 10 Besar Dokter — horizontal bar
new Chart(document.getElementById('dokterChart').getContext('2d'), {
    type: 'bar',
    data: {
        labels: @json($dokterLabels),
        datasets: [{
            label: 'Jumlah Kunjungan',
            data: @json($dokterData),
            backgroundColor: warna10,
            borderRadius: 6,
        }]
    },
    options: {
        indexAxis: 'y',
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: false },
            datalabels: {
                anchor: 'end',
                align: 'end',
                color: '#374151',
                font: { size: 11, weight: '600' },
                formatter: v => v.toLocaleString('id-ID'),
            },
            tooltip: {
                callbacks: {
                    afterLabel: ctx => 'Spesialis: ' + @json($dokterSpesialis)[ctx.dataIndex]
                }
            }
        },
        scales: {
            x: {
                beginAtZero: true,
                ticks: { precision: 0 },
                grid: { color: 'rgba(0,0,0,0.05)' }
            },
            y: {
                ticks: { font: { size: 11 } },
                grid: { display: false }
            }
        }
    },
    plugins: [ChartDataLabels]
});
</script>
</body>
</html>