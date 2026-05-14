<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menunggu Persetujuan</title>

    @vite(['resources/css/auth.css', 'resources/js/app.js'])

    {{-- Auto refresh --}}
    <meta http-equiv="refresh" content="5">
</head>

<body class="min-h-screen flex items-center justify-center bg-gray-100">

    <div class="bg-white shadow-xl rounded-2xl p-10 w-full max-w-md text-center">

        {{-- Logo --}}
        <div class="flex justify-center mb-5">
            <img src="{{ asset('images/logo1.png') }}"
                 class="w-20 h-20 object-contain">
        </div>

        {{-- Judul --}}
        <h1 class="text-xl font-bold text-gray-800 mb-3">
            Menunggu Persetujuan
        </h1>

        {{-- Deskripsi --}}
        <p class="text-gray-600 text-sm mb-6">
            Akun Anda telah terdaftar, namun belum memiliki akses ke sistem.
            Silakan menunggu hingga admin memberikan hak akses.
        </p>

        {{-- Loading --}}
        <div class="flex flex-col items-center gap-3 mb-6">

            <!-- Spinner -->
            <div class="w-8 h-8 border-4 border-blue-500 border-t-transparent rounded-full animate-spin"></div>

            <span class="text-sm text-gray-500">
                Mengecek status akun...
            </span>
        </div>

        {{-- Tombol logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                    class="bg-gray-200 hover:bg-gray-300 px-5 py-2 rounded-lg text-sm font-semibold">
                Logout
            </button>
        </form>

    </div>

</body>
</html>