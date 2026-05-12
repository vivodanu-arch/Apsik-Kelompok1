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
        

        {{-- TITLE --}}
        <div class="p-4">

            <div class="bg-primary text-white p-3 rounded shadow-sm">
                <h3 class="mb-0 fw-bold">
                    DATA PASIEN
                </h3>
            </div>

            {{-- TABLE --}}
            <div class="bg-white shadow-sm rounded-4 p-4 mt-4 overflow-auto">

    <div class="bg-white shadow-sm rounded-4 p-4 mt-4">

    <h4 class="fw-bold mb-4">
        Form Edit Pasien
    </h4>

    <form action="#" method="POST">

        @csrf

        <div class="mb-3">
            <label class="form-label">
                No. RM
            </label>

            <input type="text"
                class="form-control"
                value="12-45-67">
        </div>

        <div class="mb-3">
            <label class="form-label">
                Nama Pasien
            </label>

            <input type="text"
                class="form-control"
                value="Dansuloyo">
        </div>

        <div class="mb-3">
            <label class="form-label">
                Diagnosa
            </label>

            <input type="text"
                class="form-control"
                value="Common Cold">
        </div>

        <div class="mb-3">
            <label class="form-label">
                Alamat
            </label>

            <textarea class="form-control"
                rows="3">Jember</textarea>
        </div>

        <button type="submit"
            class="btn btn-primary">

            Simpan Perubahan
        </button>

        <a href="/datapasien"
            class="btn btn-secondary">

            Kembali
        </a>

    </form>

</div>
</div>
</div>

            </div>

        </div>

    </div>

</div>

