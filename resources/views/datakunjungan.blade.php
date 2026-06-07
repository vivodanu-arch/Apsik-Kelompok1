<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Kunjungan - Rumah Sakit Kasih</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <div class="flex-1 ml-64 flex flex-col">
        @include('layouts.rsnavigation')

        <main class="p-6">

            {{-- Header --}}
            <div class="rounded-2xl p-8 mb-6 text-white shadow-sm"
                 style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);">
                <h1 class="text-3xl font-bold">Data Kunjungan</h1>
                <p class="mt-2 text-blue-200 text-sm">Daftar data kunjungan pasien Rumah Sakit Kasih</p>
            </div>

            {{-- Card Table --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                {{-- Filter Bar --}}
                <div class="p-5 border-b bg-gray-50">
                    <form method="GET" action="{{ route('datakunjungan') }}"
                          class="flex flex-wrap items-end gap-3">

                        {{-- Filter Tanggal --}}
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Tanggal</label>
                            <input type="date" name="tanggal"
                                   value="{{ request('tanggal') }}"
                                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        {{-- Filter Poli --}}
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Poli</label>
                            <select name="poli_id"
                                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Poli</option>
                                @foreach($polis as $poli)
                                    <option value="{{ $poli->id }}"
                                        {{ request('poli_id') == $poli->id ? 'selected' : '' }}>
                                        {{ $poli->nama_poli }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Filter Status --}}
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Status</label>
                            <select name="status"
                                    class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">Semua Status</option>
                                <option value="menunggu"  {{ request('status') == 'menunggu'  ? 'selected' : '' }}>Menunggu</option>
                                <option value="diperiksa" {{ request('status') == 'diperiksa' ? 'selected' : '' }}>Diperiksa</option>
                                <option value="selesai"   {{ request('status') == 'selesai'   ? 'selected' : '' }}>Selesai</option>
                            </select>
                        </div>

                        <div class="flex gap-2 items-end">
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold">
                                Filter
                            </button>
                            <a href="{{ route('datakunjungan') }}"
                               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm">
                                Reset
                            </a>
                        </div>

                        {{-- Info jumlah --}}
                        <div class="ml-auto flex items-end">
                            <p class="text-sm text-gray-400">
                                Total: <strong class="text-gray-700">{{ $kunjungans->total() }}</strong> data
                            </p>
                        </div>

                    </form>
                </div>

                {{-- Table — overflow-x-auto agar tetap scroll jika layar kecil --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left" style="min-width: 900px;">

                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b">
                            <tr>
                                <th class="px-4 py-3 w-10">No</th>
                                <th class="px-4 py-3 w-28">Tanggal</th>
                                <th class="px-4 py-3">Nama Pasien</th>
                                {{-- ← Keluhan dibatasi max-width agar tidak melebar --}}
                                <th class="px-4 py-3 w-48">Keluhan Utama</th>
                                <th class="px-4 py-3">Dokter</th>
                                <th class="px-4 py-3">Poli</th>
                                <th class="px-4 py-3 w-28">Status</th>
                                <th class="px-4 py-3">Diagnosa</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">

                        @forelse($kunjungans as $item)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-4 py-4 text-gray-500">
                                    {{ ($kunjungans->currentPage() - 1) * $kunjungans->perPage() + $loop->iteration }}
                                </td>

                                <td class="px-4 py-4 text-gray-700 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($item->tanggal_kunjungan)->translatedFormat('d F Y') }}
                                </td>

                                <td class="px-4 py-4 font-semibold text-gray-800">
                                    {{ $item->pasien->nama_pasien ?? '-' }}
                                </td>

                                {{-- ← Keluhan dipotong dengan truncate agar tidak melebar --}}
                                <td class="px-4 py-4 text-gray-600 max-w-xs">
                                    <span title="{{ $item->keluhan_utama }}">
                                        {{ \Illuminate\Support\Str::limit($item->keluhan_utama, 50, '...') }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-gray-700">
                                    {{ $item->dokter->nama_dokter ?? '-' }}
                                </td>

                                {{-- ← kolom poli baru —tampilkan nama_poli dari relasi --}}
                                <td class="px-4 py-4">
                                    @if($item->poli)
                                        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 text-xs font-semibold px-2 py-1 rounded-full">
                                            {{ $item->poli->nama_poli }}
                                        </span>
                                    @else
                                        <span class="text-gray-400 text-xs">-</span>
                                    @endif
                                </td>

                                <td class="px-4 py-4">
                                    @php
                                        $warna = match(strtolower(trim($item->status))) {
                                            'menunggu'  => 'bg-yellow-100 text-yellow-700',
                                            'diperiksa' => 'bg-blue-100 text-blue-700',
                                            'selesai'   => 'bg-green-100 text-green-700',
                                            default     => 'bg-gray-100 text-gray-600',
                                        };
                                    @endphp
                                    <span class="px-3 py-1 rounded-full text-xs font-semibold {{ $warna }}">
                                        {{ ucfirst($item->status) }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-gray-700">
                                    @if($item->diagnosa)
                                        <div class="font-medium">{{ $item->diagnosa->diagnosa_utama }}</div>
                                        @if($item->diagnosa->kode_icd)
                                            <div class="text-xs text-gray-400 mt-0.5">{{ $item->diagnosa->kode_icd }}</div>
                                        @endif
                                    @else
                                        <span class="text-gray-400">-</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-12 text-gray-400">
                                    Belum ada data kunjungan
                                </td>
                            </tr>
                        @endforelse

                        </tbody>
                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-5 py-4 border-t flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        Halaman {{ $kunjungans->currentPage() }} dari {{ $kunjungans->lastPage() }}
                    </p>

                    <div class="flex items-center gap-1">

                        {{-- Prev --}}
                        @if ($kunjungans->onFirstPage())
                            <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-300 text-sm">‹</span>
                        @else
                            <a href="{{ $kunjungans->appends(request()->query())->previousPageUrl() }}"
                               class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-100 text-sm transition">‹</a>
                        @endif

                        {{-- Nomor halaman — tampilkan maks 7 angka --}}
                        @php
                            $current  = $kunjungans->currentPage();
                            $last     = $kunjungans->lastPage();
                            $start    = max(1, $current - 3);
                            $end      = min($last, $current + 3);
                        @endphp

                        @if($start > 1)
                            <a href="{{ $kunjungans->url(1) }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100 text-sm">1</a>
                            @if($start > 2)<span class="px-1 text-gray-400 text-sm">…</span>@endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            <a href="{{ $kunjungans->appends(request()->query())->url($i) }}"
                               class="w-9 h-9 flex items-center justify-center rounded-lg text-sm transition
                               {{ $current == $i ? 'bg-blue-600 text-white shadow' : 'border border-gray-200 text-gray-600 hover:bg-gray-100' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        @if($end < $last)
                            @if($end < $last - 1)<span class="px-1 text-gray-400 text-sm">…</span>@endif
                            <a href="{{ $kunjungans->url($last) }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100 text-sm">{{ $last }}</a>
                        @endif

                        {{-- Next --}}
                        @if ($kunjungans->hasMorePages())
                            <a href="{{ $kunjungans->appends(request()->query())->nextPageUrl() }}"
                               class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-100 text-sm transition">›</a>
                        @else
                            <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-300 text-sm">›</span>
                        @endif

                    </div>
                </div>

            </div>
        </main>
    </div>
</div>
</body>
</html>
