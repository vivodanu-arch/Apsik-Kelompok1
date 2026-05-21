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
            {{-- Notif --}}
            @foreach (['success', 'error'] as $msg)
                @if(session($msg))
                    <div class="mb-4 px-4 py-3 rounded-xl 
                        {{ $msg == 'success' ? 'bg-green-100 text-green-700 border-green-400' : 'bg-red-100 text-red-700 border-red-400' }}"
                        id="alertBox">

                        {{ session($msg) }}
                    </div>
                @endif
            @endforeach

            <script>
                setTimeout(() => {
                    const alert = document.getElementById('alertBox');
                    if(alert){
                        alert.style.opacity = '0';
                        setTimeout(() => alert.remove(), 500);
                    }
                }, 2500);
            </script>

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
                <form method="GET" action="" class="flex gap-3">

                    <input
                        type="text"
                        name="search"
                        placeholder="Cari data pasien..."
                        class="w-full border border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                    >

                    <button
                        type="submit"
                        class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 rounded-xl"
                    >
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
                            <th>Jenis Kelamin</th>
                            <th>Tanggal Lahir</th>
                            <th>Alamat</th>
                            <th>Telepon</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($pasien as $p)

                        <tr class="bg-gray-50">

                            <td>{{ $loop->iteration }}</td>

                            <td>
                                {{ $p->no_rm }}
                            </td>

                            <td class="font-semibold">
                                {{ $p->nama_pasien }}
                            </td>

                            <td>
                                {{ $p->jenis_kelamin }}
                            </td>

                            <td>
                                {{ $p->ttl }}
                            </td>

                            <td>
                                {{ $p->alamat }}
                            </td>

                            <td>
                                {{ $p->telepon }}
                            </td>

                            <td>
                                <a
                                    href="{{ route('pasien.edit', $p->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg"
                                >
                                    Edit
                                </a>
                            </td>

                        </tr>

                        @empty

                        <tr>
                            <td colspan="8" class="text-center p-4 text-gray-500">
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