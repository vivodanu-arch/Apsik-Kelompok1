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
            <div class="bg-white shadow-sm rounded-4 p-4 mt-4 overflow-auto">

    <table class="table table-bordered table-hover align-middle text-center">

        <thead class="table-primary">

            <tr>
                <th class="p-3">No</th>
                <th class="p-3 text-nowrap" style="min-width:120px;">
    No. RM
</th>
                <th class="p-3">Nama Pasien</th>
                <th class="p-3">NIK</th>
                <th class="p-3">Jenis Kelamin</th>
                <th class="p-3 text-nowrap" style="min-width:145px;">
    Tgl Lahir
</th>
                <th class="p-3">Diagnosa</th>
                <th class="p-3">Alamat</th>
                <th class="p-3">Aksi</th>
            </tr>

        </thead>

        <tbody>

            <tr>
                <td class="p-3">1</td>
                <td class="p-3">12-45-67</td>
                <td class="p-3 fw-semibold">Dansuloyo</td>
                <td class="p-3">3275010022390001</td>
                <td class="p-3">Laki-laki</td>
                <td class="p-3">2 April 2003</td>
                <td class="p-3">
                    <span class="badge bg-success">
                        Common Cold
                    </span>
                </td>
                <td class="p-3">JEMBER</td>
                <td class="p-3">

                    <a href="/editpasien/1"
                        class="btn btn-sm btn-primary">

                        Edit
                    </a>

                </td>
            </tr>

            <tr>
                <td class="p-3">2</td>
                <td class="p-3">28-34-19</td>
                <td class="p-3 fw-semibold">Sigit</td>
                <td class="p-3">3443410080390043</td>
                <td class="p-3">Laki-laki</td>
                <td class="p-3">20 Oktober 2001</td>
                <td class="p-3">
                    <span class="badge bg-warning text-dark">
                        Astigmatisme
                    </span>
                </td>
                <td class="p-3">LUMAJANG</td>
                <td class="p-3">

                    <a href="/editpasien/2"
                        class="btn btn-sm btn-primary">

                        Edit
                    </a>

                </td>
            </tr>

            <tr>
                <td class="p-3">3</td>
                <td class="p-3">45-12-89</td>
                <td class="p-3 fw-semibold">Fransisca</td>
                <td class="p-3">3696910080390055</td>
                <td class="p-3">Perempuan</td>
                <td class="p-3">1 Mei 2000</td>
                <td class="p-3">
                    <span class="badge bg-danger">
                        Pulvitis
                    </span>
                </td>
                <td class="p-3">PASURUAN</td>
                <td class="p-3">

                    <a href="/editpasien/3"
                        class="btn btn-sm btn-primary">

                        Edit
                    </a>

                </td>
            </tr>

        </tbody>

    </table>

</div>
</div>

            </div>

        </div>

    </div>

</div>

