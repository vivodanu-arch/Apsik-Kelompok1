<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Dokter - Rumah Sakit Kasih</title>
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
            <div class="rounded-2xl p-8 text-white shadow-sm mb-6"
                 style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%)">
                <h1 class="text-4xl font-bold">Dashboard Dokter</h1>
                <p class="mt-2 text-cyan-100">
                    Selamat datang kembali,
                    <strong>{{ isset($dokter) ? $dokter->nama_dokter : auth()->user()->name }}</strong>
                    👨‍⚕️
                    @if(isset($dokter) && $dokter->spesialis)
                        <span class="ml-2 text-xs bg-white/20 rounded-full px-3 py-1">
                            {{ $dokter->spesialis }}
                        </span>
                    @endif
                </p>
                <p class="mt-1 text-cyan-200 text-sm">
                    {{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}
                </p>
            </div>

            {{-- Card Statistik --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">

                {{-- Pasien Hari Ini --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 rounded-xl bg-blue-100 flex items-center justify-content-center flex-shrink-0"
                         style="display:flex; align-items:center; justify-content:center;">
                        <svg class="w-7 h-7 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Pasien Hari Ini</p>
                        <h2 class="text-4xl font-bold text-blue-600 mt-1">{{ $pasienHariIni }}</h2>
                        <p class="text-xs text-gray-400 mt-0.5">kunjungan ke poli Anda hari ini</p>
                    </div>
                </div>

                {{-- Diagnosa Hari Ini --}}
                <div class="bg-white p-6 rounded-2xl shadow-sm flex items-center gap-5">
                    <div class="w-14 h-14 rounded-xl bg-green-100 flex-shrink-0"
                         style="display:flex; align-items:center; justify-content:center;">
                        <svg class="w-7 h-7 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-gray-500 text-sm">Diagnosa Hari Ini</p>
                        <h2 class="text-4xl font-bold text-green-600 mt-1">{{ $diagnosaHariIni }}</h2>
                        <p class="text-xs text-gray-400 mt-0.5">pasien sudah didiagnosa hari ini</p>
                    </div>
                </div>

            </div>

            {{-- Grafik --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 mb-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-700">Grafik Kunjungan Minggu Ini</h2>
                    <span class="text-xs text-gray-400 bg-gray-100 rounded-full px-3 py-1">
                        {{ \Carbon\Carbon::now()->startOfWeek(\Carbon\Carbon::MONDAY)->format('d M') }}
                        –
                        {{ \Carbon\Carbon::now()->endOfWeek(\Carbon\Carbon::SUNDAY)->format('d M Y') }}
                    </span>
                </div>
                <canvas id="dokterChart" height="90"></canvas>
            </div>

            {{-- Tabel Pasien Terbaru --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="text-xl font-bold text-gray-700">Pasien Terbaru</h2>
                    <span class="text-xs text-gray-400 bg-gray-100 rounded-full px-3 py-1">
                        10 kunjungan terakhir
                    </span>
                </div>

                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b bg-gray-50 text-gray-500 text-xs uppercase tracking-wide">
                            <th class="text-left py-3 px-3 rounded-tl-lg">Nama Pasien</th>
                            <th class="text-left py-3 px-3">No. RM</th>
                            <th class="text-left py-3 px-3">Poli</th>
                            <th class="text-left py-3 px-3">Diagnosa</th>
                            <th class="text-left py-3 px-3">Status</th>
                            <th class="text-left py-3 px-3 rounded-tr-lg">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                    @forelse($pasienTerbaru as $k)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="py-3 px-3 font-medium text-gray-800">
                                {{ $k->pasien->nama_pasien ?? '-' }}
                            </td>
                            <td class="py-3 px-3 text-gray-500 font-mono text-xs">
                                {{ $k->pasien->no_rm ?? '-' }}
                            </td>
                            <td class="py-3 px-3 text-gray-600">
                                {{ $k->poli->nama_poli ?? '-' }}
                            </td>
                            <td class="py-3 px-3 text-gray-600">
                                @if($k->diagnosa && $k->diagnosa->diagnosa_utama)
                                    <span class="inline-block max-w-[180px] truncate" title="{{ $k->diagnosa->diagnosa_utama }}">
                                        {{ $k->diagnosa->diagnosa_utama }}
                                    </span>
                                @else
                                    <span class="text-gray-300 italic text-xs">Belum ada</span>
                                @endif
                            </td>
                            <td class="py-3 px-3">
                                @php
                                    $statusColor = match($k->status) {
                                        'selesai'   => 'bg-green-100 text-green-700',
                                        'diperiksa' => 'bg-blue-100 text-blue-700',
                                        default     => 'bg-yellow-100 text-yellow-700',
                                    };
                                    $statusLabel = match($k->status) {
                                        'selesai'   => 'Selesai',
                                        'diperiksa' => 'Diperiksa',
                                        default     => 'Menunggu',
                                    };
                                @endphp
                                <span class="text-xs font-semibold px-2 py-1 rounded-full {{ $statusColor }}">
                                    {{ $statusLabel }}
                                </span>
                            </td>
                            <td class="py-3 px-3 text-gray-500 text-xs whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($k->tanggal_kunjungan)->translatedFormat('d F Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-8 text-gray-400">
                                <svg class="w-10 h-10 mx-auto mb-2 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                </svg>
                                Belum ada kunjungan pasien
                            </td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

        </main>
    </div>
</div>

{{-- Chart Script --}}
<script>
const ctx = document.getElementById('dokterChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 200);
gradient.addColorStop(0, 'rgba(37, 99, 235, 0.25)');
gradient.addColorStop(1, 'rgba(37, 99, 235, 0.01)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($labelHari) !!},
        datasets: [{
            label: 'Jumlah Pasien',
            data: {!! json_encode($grafikData) !!},
            borderColor: '#2563eb',
            backgroundColor: gradient,
            borderWidth: 3,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#2563eb',
            pointRadius: 5,
            pointHoverRadius: 7,
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false },
            tooltip: {
                callbacks: {
                    label: ctx => ` ${ctx.parsed.y} pasien`
                }
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0, stepSize: 1 },
                grid: { color: 'rgba(0,0,0,0.05)' }
            },
            x: {
                grid: { display: false }
            }
        }
    }
});
</script>

</body>
</html>