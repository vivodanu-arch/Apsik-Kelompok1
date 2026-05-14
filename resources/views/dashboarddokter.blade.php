<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard - Rumah Sakit Kasih</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">

<div class="flex min-h-screen">

    {{-- Sidebar --}}
    @include('layouts.sidebar')

    {{-- Content Area --}}
    <div class="flex-1 ml-64 flex flex-col">

        {{-- Navbar --}}
        @include('layouts.rsnavigation')
  </div>

</div>

</body>
</html>
Dokter