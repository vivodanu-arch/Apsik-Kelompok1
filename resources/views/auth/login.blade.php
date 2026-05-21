<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rumah Sakit Kasih</title>

    @vite(['resources/css/auth.css', 'resources/js/app.js'])
</head>

<body class="auth-page min-h-screen flex items-center justify-center relative overflow-hidden">

    <!-- BUBBLE -->
    <div class="bubbles">
        @for ($i = 0; $i < 15; $i++)
            <span></span>
        @endfor
    </div>

    <!-- CARD -->
    <div id="mainCard"
         class="card-animate relative z-10 w-full max-w-md bg-white p-8 rounded-2xl shadow-2xl">

        {{-- Logo --}}
        <div class="flex justify-center mb-4">
            <img src="{{ asset('images/logo1.png') }}"
                 class="w-24 h-24 object-contain">
        </div>

        {{-- Judul --}}
        <h1 class="text-3xl font-bold text-center text-black mb-6">
            RUMAH SAKIT KASIH
        </h1>

        {{-- STATUS --}}
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            {{-- EMAIL --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Email
                </label>

                <input type="email" name="email"
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Masukkan email">

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- PASSWORD --}}
            <div class="mt-5">
                <label class="block text-sm font-medium text-gray-700">
                    Password
                </label>

                <input type="password" name="password"
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Masukkan password">

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- REMEMBER ME --}}
            <div class="mt-4 flex items-center">
                <input id="remember_me"
                       type="checkbox"
                       name="remember"
                       class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">

                <label for="remember_me" class="ml-2 text-sm text-gray-600">
                    Remember me
                </label>
            </div>

           {{-- BUTTON --}}
            <div class="flex justify-center mt-6">
                <button type="submit"
                        class="btn-masuk w-1/2 py-2 rounded-xl font-semibold">
                    Login
                </button>
            </div>
        </form>

    </div>

</body>
</html>