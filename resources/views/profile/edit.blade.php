<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Profile - Rumah Sakit Kasih</title>

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

        {{-- Main Content --}}
        <main class="p-6 space-y-6">

            {{-- Header --}}
            <div class="bg-white rounded-2xl shadow-sm p-8 flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">
                        Profile
                    </h1>

                    <p class="text-gray-500 mt-2">
                        Kelola informasi akun dan keamanan profile Anda.
                    </p>
                </div>

                <a href="{{ session('profile_return_to', url('/')) }}"
                   class="flex items-center gap-2 bg-gray-200 hover:bg-gray-300 text-gray-700
                          px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>

            {{-- Update Profile --}}
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <div class="max-w-2xl">
                    @include('profile.partials.update-profile-information-form')
                </div>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <div class="max-w-2xl">
                    @include('profile.partials.update-password-form')
                </div>
            </div>

            {{-- Delete User --}}
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <div class="max-w-2xl">
                    @include('profile.partials.delete-user-form')
                </div>
            </div>

        </main>

    </div>

</div>

</body>
</html>