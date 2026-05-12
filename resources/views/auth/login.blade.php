<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rumah Sakit Kasih</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen flex items-center justify-center bg-gradient-to-br from-blue-100 to-blue-300">

    <div class="w-full max-w-md bg-white p-8 rounded-2xl shadow-2xl">

        {{-- Logo --}}
        <div class="flex justify-center mb-4">

            {{-- GANTI DENGAN LOGO KAMU --}}
            <img src="{{ asset('images/logo1.png') }}"
                 alt="Logo Rumah Sakit"
                 class="w-24 h-24 object-contain">

        </div>

        {{-- Judul --}}
        <h1 class="text-4xl font-bold text-center text-black mb-8">
            RUMAH SAKIT KASIH
        </h1>

        {{-- Session Status --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- Email --}}
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    name="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="username"
                    placeholder="Masukkan email"
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- Password --}}
            <div class="mt-5">

                <label for="password" class="block text-sm font-medium text-gray-700">
                    Password
                </label>

                <input
                    id="password"
                    type="password"
                    name="password"
                    required
                    autocomplete="current-password"
                    placeholder="Masukkan password"
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                >

                <x-input-error :messages="$errors->get('password')" class="mt-2" />

            </div>

            {{-- Remember Me --}}
            <div class="mt-4 flex items-center">
                <input id="remember_me"
                       type="checkbox"
                       name="remember"
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">

                <label for="remember_me" class="ml-2 text-sm text-gray-600">
                    Remember me
                </label>
            </div>

            {{-- Button --}}
            <div class="flex gap-4 mt-6">

                {{-- Login --}}
                <button type="submit"
                        class="w-1/2 bg-blue-500 hover:bg-blue-600 text-white font-semibold py-2 rounded-xl transition">
                    Login
                </button>

                {{-- Register --}}
                <a href="{{ route('register') }}"
                   class="w-1/2 bg-gray-200 hover:bg-gray-300 text-center text-black font-semibold py-2 rounded-xl transition">
                    Register
                </a>

            </div>

            {{-- Forgot Password --}}
            @if (Route::has('password.request'))
                <div class="mt-5 text-center">
                    <a href="{{ route('password.request') }}"
                       class="text-sm text-gray-600 hover:text-black underline">
                        Forgot password?
                    </a>
                </div>
            @endif

        </form>

    </div>

</body>
</html>