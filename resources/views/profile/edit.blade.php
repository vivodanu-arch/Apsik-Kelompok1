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
            <div class="bg-white rounded-2xl shadow-sm p-8">
                <h1 class="text-3xl font-bold text-gray-800">
                    Profile
                </h1>

                <p class="text-gray-500 mt-2">
                    Kelola informasi akun dan keamanan profile Anda.
                </p>
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