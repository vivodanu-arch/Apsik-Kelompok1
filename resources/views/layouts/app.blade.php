<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Rumah Sakit Kasih') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Fade ringan saat halaman pertama kali muncul — tidak ada lompatan */
        .page-fade { animation: pageFade 0.25s ease both; }
        @keyframes pageFade {
            from { opacity: 0; }
            to   { opacity: 1; }
        }
    </style>
</head>

<body class="font-sans antialiased bg-gray-100">
<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <div class="flex-1 ml-64 flex flex-col">
        @include('layouts.rsnavigation')

        @isset($header)
            <header class="bg-white shadow px-6 py-5">
                {{ $header }}
            </header>
        @endisset

        {{-- ← hapus x-data/x-show/x-transition Alpine — ganti CSS fade biasa --}}
        <main class="p-6 page-fade">
            @yield('content')
        </main>
    </div>

</div>
</body>
</html>
