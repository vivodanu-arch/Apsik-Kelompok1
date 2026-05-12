<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Pasien</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Content --}}
    <div class="flex-1 ml-64 flex flex-col">

        {{-- Navbar --}}
        @include('layouts.rsnavigation')

        {{-- Main --}}
        <main class="p-6">

            {{-- Header --}}
            <div class="bg-blue-700 rounded-2xl p-6 mb-6 shadow-sm">
                <h1 class="text-3xl font-bold text-white uppercase">
                    Data Pasien
                </h1>
                <p class="text-blue-100 mt-2">
                    Daftar data pasien Rumah Sakit Kasih
                </p>
            </div>

            {{-- SEARCH --}}
            <div class="bg-white rounded-2xl shadow-sm p-4 mb-6">
                <form class="flex gap-3">
                    <input type="text"
                        placeholder="Cari data pasien..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <button type="submit"
                        class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded-xl">
                        Search
                    </button>
                </form>
            </div>

            {{-- TABLE --}}
            <div class="bg-white shadow-sm rounded-2xl p-4 mt-4 overflow-auto">

                <table class="table table-bordered table-hover align-middle text-center w-full border-separate border-spacing-y-2">

                    <thead class="table-primary">
                        <tr>
                            <th>No</th>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>NIK</th>
                            <th>Jenis Kelamin</th>
                            <th>Tgl Lahir</th>
                            <th>Diagnosa</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    {{-- 🔥 INI BAGIAN DATABASE --}}
                    <tbody>
                        @forelse($pasien as $p)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $p->no_rm }}</td>
                            <td class="font-semibold">{{ $p->nama_pasien }}</td>
                            <td>{{ $p->nik }}</td>
                            <td>{{ $p->jenis_kelamin }}</td>
                            <td>{{ $p->tgl_lahir }}</td>
                            <td>
                                <span class="bg-green-500 text-white px-2 py-1 rounded">
                                    {{ $p->diagnosa }}
                                </span>
                            </td>
                            <td>{{ $p->alamat }}</td>
                            <td>
                                <a href="/editpasien/{{ $p->id }}"
                                   class="bg-blue-600 text-white px-3 py-1 rounded">
                                    Edit
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center p-4 text-gray-500">
                                Data pasien tidak ditemukan
                            </td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>

            </div>

        </main>
    </div>

</div>

</body>
</html>