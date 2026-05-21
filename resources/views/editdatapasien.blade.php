<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Pasien</title>

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
                    Edit Pasien
                </h1>
                <p class="text-blue-100 mt-2">
                    Ubah data pasien
                </p>
            </div>

            {{-- Form Card --}}
            <div class="bg-white rounded-2xl shadow-sm p-6 max-w-3xl">

                <form action="{{ route('pasien.update', $pasien->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-2 gap-4">

                        <div>
                            <label class="text-sm text-gray-600">No. RM</label>
                            <input type="text" name="no_rm"
                                class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2"
                                value="{{ $pasien->no_rm }}">
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Nama Pasien</label>
                            <input type="text" name="nama_pasien"
                                class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2"
                                value="{{ $pasien->nama_pasien }}">
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Jenis Kelamin</label>
                            <input type="text" name="jenis_kelamin"
                                class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2"
                                value="{{ $pasien->jenis_kelamin }}">
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Tanggal Lahir</label>
                            <input type="date" name="ttl"
                                class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2"
                                value="{{ $pasien->ttl }}">
                        </div>

                        <div class="col-span-2">
                            <label class="text-sm text-gray-600">Alamat</label>
                            <textarea name="alamat"
                                class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2">{{ $pasien->alamat }}</textarea>
                        </div>

                        <div>
                            <label class="text-sm text-gray-600">Telepon</label>
                            <input type="text" name="telepon"
                                class="w-full mt-1 border border-gray-300 rounded-lg px-3 py-2"
                                value="{{ $pasien->telepon }}">
                        </div>

                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-lg">
                            Simpan Perubahan
                        </button>

                        <a href="{{ route('pasien.index') }}"
                           class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded-lg">
                            Kembali
                        </a>
                    </div>

                </form>

            </div>

        </main>

    </div>

</div>

</body>
</html>