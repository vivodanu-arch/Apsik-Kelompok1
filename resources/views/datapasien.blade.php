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
            @foreach (['success', 'error'] as $msg)
                @if(session($msg))
                    <div id="alertBox"
                         class="mb-4 px-4 py-3 rounded-xl border transition-opacity duration-500
                         {{ $msg == 'success' ? 'bg-green-100 text-green-700 border-green-400' : 'bg-red-100 text-red-700 border-red-400' }}">
                        {{ session($msg) }}
                    </div>
                @endif
            @endforeach
            <script>
                setTimeout(() => {
                    const el = document.getElementById('alertBox');
                    if (el) { el.style.opacity = '0'; setTimeout(() => el.remove(), 500); }
                }, 2500);
            </script>

            {{-- Header --}}
            <div class="bg-blue-700 rounded-2xl p-6 mb-6 shadow-sm">
                <h1 class="text-3xl font-bold text-white uppercase">Data Pasien</h1>
                <p class="text-blue-100 mt-2">Daftar data pasien Rumah Sakit Kasih</p>
            </div>

            {{-- Search --}}
            <div class="bg-white rounded-2xl shadow-sm p-4 mb-5">
                <form method="GET" action="{{ route('pasien.index') }}"
                      class="flex gap-3 items-center">

                    <input type="text" name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari nama pasien atau No. RM..."
                           class="flex-1 border border-gray-300 rounded-xl px-4 py-2 text-sm
                                  focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <button type="submit"
                            class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded-xl text-sm font-semibold">
                        Cari
                    </button>

                    @if(request('search'))
                        <a href="{{ route('pasien.index') }}"
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-xl text-sm">
                            Reset
                        </a>
                    @endif
                </form>
            </div>

            {{-- Table --}}
            <div class="bg-white rounded-2xl shadow-sm overflow-hidden">

                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left" style="min-width: 750px;">

                        <thead class="bg-gray-50 text-gray-500 uppercase text-xs border-b">
                            <tr>
                                <th class="px-4 py-3 w-10">No</th>
                                <th class="px-4 py-3">No. RM</th>
                                <th class="px-4 py-3">Nama Pasien</th>
                                <th class="px-4 py-3 w-12">JK</th>
                                <th class="px-4 py-3">Tanggal Lahir</th>
                                <th class="px-4 py-3">Alamat</th>
                                <th class="px-4 py-3">Telepon</th>
                                <th class="px-4 py-3 w-20 text-center">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                        @forelse($pasien as $p)
                            <tr class="hover:bg-gray-50 transition">

                                <td class="px-4 py-4 text-gray-500">
                                    {{ ($pasien->currentPage() - 1) * $pasien->perPage() + $loop->iteration }}
                                </td>

                                <td class="px-4 py-4">
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

                                <td class="px-4 py-4 text-gray-700">
                                    {{ \Carbon\Carbon::parse($p->ttl)->translatedFormat('d F Y') }}
                                </td>

                                <td class="px-4 py-4 text-gray-600 max-w-xs">
                                    {{ \Illuminate\Support\Str::limit($p->alamat, 45, '...') }}
                                </td>

                                <td class="px-4 py-4 text-gray-600">
                                    {{ $p->telepon }}
                                </td>

                                <td class="px-4 py-4 text-center">
                                    <a href="{{ route('pasien.edit', $p->id) }}"
                                       class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg text-xs font-semibold">
                                        Edit
                                    </a>
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

                {{-- Pagination — ini yang hilang sebelumnya --}}
                <div class="px-5 py-4 border-t flex items-center justify-between">

                    <p class="text-sm text-gray-500">
                        Menampilkan
                        <strong>{{ $pasien->firstItem() ?? 0 }}–{{ $pasien->lastItem() ?? 0 }}</strong>
                        dari <strong>{{ $pasien->total() }}</strong> pasien
                        @if(request('search'))
                            untuk pencarian "<em>{{ request('search') }}</em>"
                        @endif
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
