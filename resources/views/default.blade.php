<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pelaporan Rumah Sakit</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gradient-to-br from-blue-100 to-blue-300 min-h-screen flex items-center justify-center">

    <div class="bg-white shadow-2xl rounded-3xl p-10 w-full max-w-2xl text-center">

        {{-- Icon --}}
        <div class="flex justify-center mb-6">
            <img src="{{ asset('images/logo1.png') }}"
                alt="Logo Rumah Sakit"
                class="w-32 h-32 object-cover rounded-full shadow-xl border-4 border-white">
        </div>

        {{-- Judul --}}
        <h1 class="text-4xl font-bold text-gray-800 mb-4">
            Sistem Pelaporan Rumah Sakit
        </h1>

        {{-- Deskripsi --}}
        <p class="text-gray-600 text-lg mb-8 leading-relaxed">
            Aplikasi untuk membantu proses pencatatan, pengelolaan,
            dan pelaporan data rumah sakit secara cepat dan efisien.
        </p>

        {{-- Button --}}
        <div class="flex justify-center gap-4">

            <a href="{{ route('login') }}"
               class="bg-blue-600 hover:bg-blue-700 text-white px-8 py-3 rounded-xl font-semibold shadow-md transition duration-300">
                Masuk
            </a>

        </div>

    </div>

</body>
</html>