<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Rumah Sakit Kasih</title>

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

        <form method="POST" action="{{ route('register') }}">
            @csrf

            {{-- NAME --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Nama
                </label>

                <input type="text" name="name"
                    value="{{ old('name') }}"
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Masukkan nama">

                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            {{-- EMAIL --}}
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">
                    Email
                </label>

                <input type="email" name="email"
                    value="{{ old('email') }}"
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Masukkan email">

                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            {{-- PASSWORD --}}
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">
                    Password
                </label>

                <input type="password" name="password"
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Masukkan password">

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            {{-- CONFIRM PASSWORD --}}
            <div class="mt-4">
                <label class="block text-sm font-medium text-gray-700">
                    Konfirmasi Password
                </label>

                <input type="password" name="password_confirmation"
                    class="mt-2 w-full rounded-xl border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                    placeholder="Ulangi password">

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            {{-- BUTTON --}}
            <div class="mt-6">
                <button type="submit"
                        class="btn-masuk w-full py-2 rounded-xl font-semibold">
                    Register
                </button>
            </div>

        </form>

    </div>

</body>
</html>