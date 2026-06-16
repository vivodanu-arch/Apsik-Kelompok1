<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Kepala RM - Rumah Sakit Kasih</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2.2.0/dist/chartjs-plugin-datalabels.min.js"></script>
</head>

<body class="bg-gray-100">
<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <div class="flex-1 ml-64 flex flex-col">
        @include('layouts.rsnavigation')

        <main class="p-6 space-y-6">

            {{-- ── Header ── --}}
            <div class="rounded-2xl p-8 text-white shadow-sm"
                 style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%)">
                <h1 class="text-3xl font-bold">Dashboard Kepala Rekam Medis</h1>
                <p class="mt-2 text-blue-100">
                    Selamat datang kembali, <strong>{{ Auth::user()->name }}</strong> 👋
                </p>
                <p class="mt-1 text-blue-200 text-sm">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </p>
            </div>

            {{-- ── Statistik 4 kartu ── --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="bg-indigo-100 p-3 rounded-xl flex-shrink-0">
                        <svg class="w-6 h-6 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Total Pasien</p>
                        <h2 class="text-2xl font-bold text-indigo-600">{{ number_format($totalPasien) }}</h2>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="bg-emerald-100 p-3 rounded-xl flex-shrink-0">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Total Kunjungan</p>
                        <h2 class="text-2xl font-bold text-emerald-600">{{ number_format($totalKunjungan) }}</h2>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="bg-red-100 p-3 rounded-xl flex-shrink-0">
                        <svg class="w-6 h-6 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0M19 21a7 7 0 00-14 0"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Total Dokter</p>
                        <h2 class="text-2xl font-bold text-red-500">{{ $totalDokter }}</h2>
                    </div>
                </div>
                <div class="bg-white rounded-2xl p-5 shadow-sm border border-gray-100 flex items-center gap-4">
                    <div class="bg-purple-100 p-3 rounded-xl flex-shrink-0">
                        <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-400 text-xs">Petugas Aktif</p>
                        <h2 class="text-2xl font-bold text-purple-600">{{ $totalPetugas }}</h2>
                    </div>
                </div>
            </div>

            {{-- ── Grafik Bulanan + Daftar Petugas ── --}}
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                    <h2 class="text-base font-semibold text-gray-700">Grafik Kunjungan Bulanan</h2>
                    <p class="text-xs text-gray-400 mt-0.5 mb-4">Statistik kunjungan pasien per bulan tahun {{ now()->year }}</p>
                    <canvas id="kepalaChart" height="160"></canvas>
                </div>
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

            {{-- ── RL 5.1 — Tabel Morbiditas ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="mb-4">
                    <h2 class="text-base font-semibold text-gray-700">RL 5.1 – Kompilasi Morbiditas Pasien Rawat Jalan</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Jumlah kasus per kelompok umur dan jenis kelamin</p>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-xs border-collapse">
                        <thead>
                            <tr class="bg-blue-600 text-white">
                                <th rowspan="2" class="border border-blue-500 px-2 py-2 text-left min-w-[180px]">Nama Penyakit</th>
                                <th rowspan="2" class="border border-blue-500 px-2 py-2 whitespace-nowrap">Kode ICD</th>
                                @foreach($rl51['kelompok_umur'] as $kel)
                                    <th colspan="2" class="border border-blue-500 px-1 py-1 text-center whitespace-nowrap">{{ $kel }}</th>
                                @endforeach
                                <th colspan="2" class="border border-blue-500 px-1 py-1 text-center">Total Kasus</th>
                                <th rowspan="2" class="border border-blue-500 px-2 py-2 text-center">Total</th>
                            </tr>
                            <tr class="bg-blue-500 text-white">
                                @foreach($rl51['kelompok_umur'] as $kel)
                                    <th class="border border-blue-400 px-1 py-1 text-center w-7">L</th>
                                    <th class="border border-blue-400 px-1 py-1 text-center w-7">P</th>
                                @endforeach
                                <th class="border border-blue-400 px-1 py-1 text-center w-7">L</th>
                                <th class="border border-blue-400 px-1 py-1 text-center w-7">P</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($rl51['rows'] as $i => $r)
                            <tr class="{{ $i % 2 === 0 ? 'bg-white' : 'bg-gray-50' }} hover:bg-blue-50 transition">
                                <td class="border border-gray-200 px-2 py-1.5 font-medium text-gray-800">{{ $r['diagnosa_utama'] }}</td>
                                <td class="border border-gray-200 px-2 py-1.5 text-center font-mono text-gray-500">{{ $r['kode_icd'] }}</td>
                                @foreach($rl51['kelompok_umur'] as $kel)
                                    <td class="border border-gray-200 px-1 py-1.5 text-center text-gray-600">{{ $r['umur'][$kel]['L'] ?: '-' }}</td>
                                    <td class="border border-gray-200 px-1 py-1.5 text-center text-gray-600">{{ $r['umur'][$kel]['P'] ?: '-' }}</td>
                                @endforeach
                                <td class="border border-gray-200 px-1 py-1.5 text-center font-semibold text-blue-700">{{ $r['total_kasus_L'] ?: '-' }}</td>
                                <td class="border border-gray-200 px-1 py-1.5 text-center font-semibold text-pink-600">{{ $r['total_kasus_P'] ?: '-' }}</td>
                                <td class="border border-gray-200 px-2 py-1.5 text-center font-bold text-gray-800">{{ $r['total_kasus'] }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="{{ 3 + count($rl51['kelompok_umur']) * 2 + 2 }}" class="text-center py-6 text-gray-400">
                                    Tidak ada data morbiditas
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <p class="text-xs text-gray-400 italic mt-3">*) L = Laki-laki, P = Perempuan</p>
            </div>

            {{-- ── RL 5.2 Pie Chart (full width, pie + legenda) ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="mb-4">
                    <h2 class="text-base font-semibold text-gray-700">RL 5.2 – 10 Besar Kasus Baru Penyakit</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Berdasarkan jumlah pasien unik per diagnosa</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                    <div class="relative" style="height:340px;">
                        <canvas id="rl52Chart"></canvas>
                    </div>
                    <div class="space-y-2 pt-2" id="rl52Legend"></div>
                </div>
            </div>

            {{-- ── RL 5.3 Pie Chart (full width, pie + legenda) ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="mb-4">
                    <h2 class="text-base font-semibold text-gray-700">RL 5.3 – 10 Besar Kunjungan Penyakit</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Berdasarkan total kunjungan per diagnosa</p>
                </div>
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-start">
                    <div class="relative" style="height:340px;">
                        <canvas id="rl53Chart"></canvas>
                    </div>
                    <div class="space-y-2 pt-2" id="rl53Legend"></div>
                </div>
            </div>

            {{-- ── 10 Besar Dokter ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <div class="mb-4">
                    <h2 class="text-base font-semibold text-gray-700">10 Besar Dokter</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Berdasarkan jumlah kunjungan yang ditangani</p>
                </div>
                <div class="relative" style="height:320px;">
                    <canvas id="dokterChart"></canvas>
                </div>
            </div>

            {{-- ── Status Sistem ── --}}
            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
                <h2 class="text-base font-semibold text-gray-700 mb-4">Status Sistem</h2>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <span class="text-sm text-gray-600">Database</span>
                        <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium">Online</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <span class="text-sm text-gray-600">Server Laravel</span>
                        <span class="bg-emerald-50 text-emerald-700 px-3 py-1 rounded-full text-xs font-medium">Aktif</span>
                    </div>
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-xl">
                        <span class="text-sm text-gray-600">Backup Data</span>
                        <span class="bg-yellow-50 text-yellow-700 px-3 py-1 rounded-full text-xs font-medium">Pending</span>
                    </div>
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

    $rl53Labels = $rl53->map(fn($p) => $p->diagnosa_utama)->toArray();
    $rl53Data   = $rl53->pluck('total')->toArray();
    $rl53Kode   = $rl53->pluck('kode_icd')->toArray();

    $dokterLabels    = $topDokter->map(fn($d) => $d->nama_dokter)->toArray();
    $dokterData      = $topDokter->pluck('total_pasien')->toArray();
    $dokterSpesialis = $topDokter->map(fn($d) => $d->spesialis)->toArray();
@endphp

<script>
Chart.register(ChartDataLabels);

const warna10 = @json($warna10);

// ── Grafik Bulanan ──────────────────────────────────────────────
new Chart(document.getElementById('kepalaChart'), {
    type: 'bar',
    data: {
        labels: @json($labelBulan),
        datasets: [{
            label: 'Kunjungan',
            data: @json($grafikData),
            backgroundColor: '#4F46E5',
            borderRadius: 6,
            borderSkipped: false,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            datalabels: {
                anchor: 'end', align: 'end',
                color: '#6b7280', font: { size: 10 },
                formatter: v => v > 0 ? v : '',
            }
        },
        scales: {
            y: { beginAtZero: true, grid: { color: '#f3f4f6' }, ticks: { precision: 0, font: { size: 11 }, color: '#9ca3af' } },
            x: { grid: { display: false }, ticks: { font: { size: 11 }, color: '#9ca3af' } }
        }
    },
    plugins: [ChartDataLabels]
});

// ── Helper: pie chart dengan persentase ────────────────────────
function buatPieChart(canvasId, legendId, labels, data, kodes) {
    const total = data.reduce((a, b) => a + b, 0);
    const ctx   = document.getElementById(canvasId).getContext('2d');

    new Chart(ctx, {
        type: 'pie',
        data: {
            labels,
            datasets: [{
                data,
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
                    formatter: value => {
                        const pct = total > 0 ? ((value / total) * 100).toFixed(1) : 0;
                        return pct >= 4 ? pct + '%' : '';
                    },
                    textShadowColor: 'rgba(0,0,0,0.4)',
                    textShadowBlur: 4,
                }
            }
        }
    });

    // Legenda manual
    const legend = document.getElementById(legendId);
    labels.forEach((label, i) => {
        const pct  = total > 0 ? ((data[i] / total) * 100).toFixed(1) : 0;
        const kode = kodes[i] ?? '';
        const div  = document.createElement('div');
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
            </div>`;
        legend.appendChild(div);
    });
}

buatPieChart('rl52Chart', 'rl52Legend', @json($rl52Labels), @json($rl52Data), @json($rl52Kode));
buatPieChart('rl53Chart', 'rl53Legend', @json($rl53Labels), @json($rl53Data), @json($rl53Kode));

// ── 10 Besar Dokter — horizontal bar ──────────────────────────
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
                anchor: 'end', align: 'end',
                color: '#374151', font: { size: 11, weight: '600' },
                formatter: v => v.toLocaleString('id-ID'),
            },
            tooltip: {
                callbacks: {
                    afterLabel: ctx => 'Spesialis: ' + @json($dokterSpesialis)[ctx.dataIndex]
                }
            }
        },
        scales: {
            x: { beginAtZero: true, ticks: { precision: 0 }, grid: { color: 'rgba(0,0,0,0.05)' } },
            y: { ticks: { font: { size: 11 } }, grid: { display: false } }
        }
    },
    plugins: [ChartDataLabels]
});
</script>
</body>
</html>