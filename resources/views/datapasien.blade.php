<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien - Rumah Sakit Kasih</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <div class="flex-1 ml-64 flex flex-col">
        @include('layouts.rsnavigation')

        <main class="p-6">

            {{-- Notifikasi --}}
            @if(session('success'))
            <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black/20 backdrop-blur-[1px] z-[9999]">
                <div id="successCard" class="bg-white rounded-3xl shadow-xl p-8 w-[400px] max-w-[90%] text-center transition-all duration-300">
                    <div class="mx-auto w-20 h-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-4xl font-bold shadow-md">✓</div>
                    <h2 class="text-3xl font-bold mt-5 text-gray-800">Perubahan Berhasil</h2>
                    <p class="text-gray-500 mt-2">{{ session('success') }}</p>
                    <div class="mt-6 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div id="progressBar" class="h-full bg-green-500 rounded-full"></div>
                    </div>
                </div>
            </div>
            <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('successModal');
                const progress = document.getElementById('progressBar');
                const card = document.getElementById('successCard');
                card.style.opacity = '0';
                card.style.transform = 'translateY(20px)';
                setTimeout(() => { card.style.opacity = '1'; card.style.transform = 'translateY(0)'; }, 120);
                progress.animate([{ width: '100%' }, { width: '0%' }], { duration: 1500, fill: 'forwards' });
                setTimeout(() => {
                    modal.style.transition = 'all .2s ease';
                    modal.style.opacity = '0';
                    card.style.transform = 'scale(.8)';
                    setTimeout(() => modal.remove(), 400);
                }, 1500);
            });
            </script>
            @endif

            {{-- Header --}}
            <div class="rounded-2xl p-8 mb-6 text-white shadow-sm"
                 style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);">
                <h1 class="text-3xl font-bold">Data Pasien</h1>
                <p class="mt-2 text-blue-200 text-sm">Daftar data pasien Rumah Sakit Kasih</p>
            </div>

            {{-- Card Table --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                {{-- Filter Bar --}}
                <div class="p-5 border-b bg-gray-50">
                    <form method="GET" action="{{ route('pasien.index') }}"
                          class="flex flex-wrap items-end gap-3">

                        {{-- Search --}}
                        <div class="flex flex-col gap-1 flex-1 min-w-[240px]">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Cari Pasien</label>
                            <input type="text" name="search"
                                   value="{{ request('search') }}"
                                   placeholder="Cari nama pasien atau No. RM..."
                                   class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>

                        <div class="flex gap-2 items-end">
                            <button type="submit"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg text-sm font-semibold">
                                Cari
                            </button>
                            @if(request('search'))
                                <a href="{{ route('pasien.index') }}"
                                   class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg text-sm">
                                    Reset
                                </a>
                            @endif
                        </div>

                        {{-- Info jumlah --}}
                        <div class="ml-auto flex items-end">
                            <p class="text-sm text-gray-400">
                                Total: <strong class="text-gray-700">{{ $pasien->total() }}</strong> pasien
                                @if(request('search'))
                                    untuk "<em>{{ request('search') }}</em>"
                                @endif
                            </p>
                        </div>

                    </form>
                </div>

                {{-- Table --}}
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left" style="min-width: 900px;">

                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b">
                            <tr>
                                <th class="px-4 py-3 w-10">No</th>
                                <th class="px-4 py-3 w-28">No. RM</th>
                                <th class="px-4 py-3">Nama Pasien</th>
                                <th class="px-4 py-3 w-16">JK</th>
                                <th class="px-4 py-3 w-32">Tanggal Lahir</th>
                                <th class="px-4 py-3">Alamat</th>
                                <th class="px-4 py-3 w-32">Telepon</th>
                                <th class="px-4 py-3 w-20 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                        @forelse($pasien as $p)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-4 py-4 text-gray-500">
                                    {{ ($pasien->currentPage() - 1) * $pasien->perPage() + $loop->iteration }}
                                </td>

                                <td class="px-4 py-4 whitespace-nowrap">
                                    <span class="font-mono text-blue-700 bg-blue-50 px-2 py-0.5 rounded text-xs">
                                        {{ $p->no_rm }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 font-semibold text-gray-800">
                                    {{ $p->nama_pasien }}
                                </td>

                                <td class="px-4 py-4">
                                    <span class="px-2 py-0.5 rounded-full text-xs font-semibold
                                        {{ $p->jenis_kelamin == 'L' ? 'bg-sky-100 text-sky-700' : 'bg-pink-100 text-pink-700' }}">
                                        {{ $p->jenis_kelamin == 'L' ? 'L' : 'P' }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-gray-700 whitespace-nowrap">
                                    {{ \Carbon\Carbon::parse($p->ttl)->translatedFormat('d F Y') }}
                                </td>

                                <td class="px-4 py-4 text-gray-600 max-w-xs">
                                    <span title="{{ $p->alamat }}">
                                        {{ \Illuminate\Support\Str::limit($p->alamat, 45, '...') }}
                                    </span>
                                </td>

                                <td class="px-4 py-4 text-gray-600 whitespace-nowrap">
                                    {{ $p->telepon }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    @if(Auth::user()->role === 'petugas' || Auth::user()->role === 'dokter' || Auth::user()->is_super_admin)
                                    <a href="{{ route('pasien.edit', $p->id) }}"
                                     class="inline-flex items-center gap-2 px-3 py-1 bg-blue-50 hover:bg-blue-100 text-blue-600 rounded-2xl font-medium transition-all duration-200">
    
                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="w-4 h-4"
                                            fill="none"
                                            viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round"
                                                stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                        </svg>

                                        Edit
                                    </a>
                                    @else
                                    <span class="text-gray-300 text-xs">—</span>
                                    @endif
                                </td>

                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-12 text-gray-400">
                                    @if(request('search'))
                                        Pasien "{{ request('search') }}" tidak ditemukan
                                    @else
                                        Belum ada data pasien
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                        </tbody>

                    </table>
                </div>

                {{-- Pagination --}}
                <div class="px-5 py-4 border-t flex items-center justify-between">
                    <p class="text-sm text-gray-500">
                        Halaman {{ $pasien->currentPage() }} dari {{ $pasien->lastPage() }}
                    </p>

                    <div class="flex items-center gap-1">

                        @if ($pasien->onFirstPage())
                            <span class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-300 text-sm">‹</span>
                        @else
                            <a href="{{ $pasien->appends(request()->query())->previousPageUrl() }}"
                               class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-500 hover:bg-gray-100 text-sm transition">‹</a>
                        @endif

                        @php
                            $current = $pasien->currentPage();
                            $last    = $pasien->lastPage();
                            $start   = max(1, $current - 3);
                            $end     = min($last, $current + 3);
                        @endphp

                        @if($start > 1)
                            <a href="{{ $pasien->url(1) }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100 text-sm">1</a>
                            @if($start > 2)<span class="px-1 text-gray-400 text-sm">…</span>@endif
                        @endif

                        @for ($i = $start; $i <= $end; $i++)
                            <a href="{{ $pasien->appends(request()->query())->url($i) }}"
                               class="w-9 h-9 flex items-center justify-center rounded-lg text-sm transition
                               {{ $current == $i ? 'bg-blue-600 text-white shadow' : 'border border-gray-200 text-gray-600 hover:bg-gray-100' }}">
                                {{ $i }}
                            </a>
                        @endfor

                        @if($end < $last)
                            @if($end < $last - 1)<span class="px-1 text-gray-400 text-sm">…</span>@endif
                            <a href="{{ $pasien->url($last) }}" class="w-9 h-9 flex items-center justify-center rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-100 text-sm">{{ $last }}</a>
                        @endif

                        @if ($pasien->hasMorePages())
                            <a href="{{ $pasien->appends(request()->query())->nextPageUrl() }}"
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