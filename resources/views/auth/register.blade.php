<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Rumah Sakit Kasih</title>

    @vite(['resources/css/auth.css', 'resources/js/app.js'])
</head>

<body class="auth-page min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- BUBBLE -->
    <div class="bubbles">
        @for ($i = 0; $i < 15; $i++)
            <span></span>
        @endfor
    </div>

    <!-- CARD -->
    <div id="mainCard"
        class="relative z-10 w-full max-w-xl bg-white p-5 rounded-2xl shadow-xl">

        {{-- Logo --}}
        <div class="flex justify-center mb-3">
            <img src="{{ asset('images/logo1.png') }}"
                 class="w-24 h-24 object-contain">
        </div>

        {{-- Judul --}}
        <h1 class="text-xl font-bold text-center text-black mb-4">
            RUMAH SAKIT KASIH
        </h1>

        {{-- STATUS --}}
        <x-auth-session-status class="mb-3" :status="session('status')" />

        <form method="POST" action="{{ route('register') }}" 
              class="grid grid-cols-2 gap-3">
            @csrf

            {{-- NAME --}}
            <div class="col-span-2">
                <label class="block text-xs font-medium text-gray-700">
                    Nama
                </label>
                <input type="text" name="name"
                    value="{{ old('name') }}"
                    class="mt-1 w-full rounded-xl border-gray-300 shadow-sm 
                    focus:border-blue-500 focus:ring-blue-500 text-sm py-1.5"
                    placeholder="Masukkan nama">

                <x-input-error :messages="$errors->get('name')" class="mt-1" />
            </div>

            {{-- EMAIL --}}
            <div>
                <label class="block text-xs font-medium text-gray-700">
                    Email
                </label>
                <input type="email" name="email"
                    value="{{ old('email') }}"
                    class="mt-1 w-full rounded-xl border-gray-300 shadow-sm 
                    focus:border-blue-500 focus:ring-blue-500 text-sm py-1.5"
                    placeholder="Masukkan email">

                <x-input-error :messages="$errors->get('email')" class="mt-1" />
            </div>

            {{-- ROLE --}}
            <div>
                <label class="block text-xs font-medium text-gray-700">
                    Role
                </label>
                <select name="role" required
                    class="mt-1 w-full rounded-xl border-gray-300 shadow-sm 
                    focus:border-blue-500 focus:ring-blue-500 text-sm py-1.5">

                    <option value="">-- Pilih Role --</option>
                    <option value="petugas">Petugas</option>
                    <option value="dokter">Dokter</option>
                    <option value="kepalarm">Kepala RM</option>
                </select>

                <x-input-error :messages="$errors->get('role')" class="mt-1" />
            </div>

            {{-- PASSWORD --}}
            <div>
                <label class="block text-xs font-medium text-gray-700">
                    Password
                </label>
                <input type="password" name="password"
                    class="mt-1 w-full rounded-xl border-gray-300 shadow-sm 
                    focus:border-blue-500 focus:ring-blue-500 text-sm py-1.5"
                    placeholder="Masukkan password">

                <x-input-error :messages="$errors->get('password')" class="mt-1" />
            </div>

            {{-- CONFIRM PASSWORD --}}
            <div>
                <label class="block text-xs font-medium text-gray-700">
                    Konfirmasi Password
                </label>
                <input type="password" name="password_confirmation"
                    class="mt-1 w-full rounded-xl border-gray-300 shadow-sm 
                    focus:border-blue-500 focus:ring-blue-500 text-sm py-1.5"
                    placeholder="Ulangi password">

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-1" />
            </div>

            {{-- BUTTON --}}
            <div class="col-span-2 mt-2">
                <button type="submit"
                    class="btn-masuk w-full py-1.5 rounded-xl font-semibold text-sm">
                    Register
                </button>
            </div>

        </form>

    </div>

</body>
</html>