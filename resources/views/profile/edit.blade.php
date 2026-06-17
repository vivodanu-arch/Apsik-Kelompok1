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

    @include('layouts.sidebar')

    <div class="flex-1 ml-64 flex flex-col">
        @include('layouts.rsnavigation')

        <main class="p-6 space-y-5">

            {{-- Notifikasi sukses --}}
            @if(session('status') === 'profile-updated')
            <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black/20 backdrop-blur-[1px] z-[9999]">
                <div id="successCard" class="bg-white rounded-3xl shadow-xl p-8 w-[400px] max-w-[90%] text-center transition-all duration-300">
                    <div class="mx-auto w-20 h-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-4xl font-bold shadow-md">✓</div>
                    <h2 class="text-3xl font-bold mt-5 text-gray-800">Berhasil</h2>
                    <p class="text-gray-500 mt-2">Informasi profil berhasil diperbarui.</p>
                    <div class="mt-6 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div id="progressBar" class="h-full bg-green-500 rounded-full"></div>
                    </div>
                </div>
            </div>
            @endif

            @if(session('status') === 'password-updated')
            <div id="successModalPw" class="fixed inset-0 flex items-center justify-center bg-black/20 backdrop-blur-[1px] z-[9999]">
                <div id="successCardPw" class="bg-white rounded-3xl shadow-xl p-8 w-[400px] max-w-[90%] text-center transition-all duration-300">
                    <div class="mx-auto w-20 h-20 rounded-full bg-green-600 flex items-center justify-center text-white text-4xl font-bold shadow-md">✓</div>
                    <h2 class="text-3xl font-bold mt-5 text-gray-800">Berhasil</h2>
                    <p class="text-gray-500 mt-2">Password berhasil diperbarui.</p>
                    <div class="mt-6 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div id="progressBarPw" class="h-full bg-green-500 rounded-full"></div>
                    </div>
                </div>
            </div>
            @endif

            {{-- Header --}}
            <div class="rounded-2xl p-8 text-white shadow-sm flex items-center justify-between"
                 style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);">
                <div>
                    <h1 class="text-3xl font-bold">Profile</h1>
                    <p class="mt-2 text-blue-200 text-sm">Kelola informasi akun dan keamanan profil Anda</p>
                </div>
                <a href="{{ session('profile_return_to', url('/')) }}"
                   class="flex items-center gap-2 bg-white/15 hover:bg-white/25 text-white px-5 py-2.5 rounded-xl text-sm font-semibold transition shrink-0">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali
                </a>
            </div>

            {{-- ── Informasi Profil ── --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-base font-semibold text-gray-700 mb-1 flex items-center gap-2">
                    <span class="w-1 h-5 bg-blue-600 rounded-full inline-block"></span>
                    Informasi Profil
                </h2>
                <p class="text-xs text-gray-400 mb-5">Perbarui nama dan alamat email akun Anda.</p>

                <form id="profileForm" method="POST" action="{{ route('profile.update') }}" class="max-w-2xl">
                    @csrf
                    @method('PATCH')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</label>
                            <input type="text" name="name" id="name"
                                value="{{ old('name', $user->name) }}" required autofocus autocomplete="name"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</label>
                            <input type="email" name="email" id="email"
                                value="{{ old('email', $user->email) }}" required autocomplete="username"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('email')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror

                            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                                <div class="mt-2 text-xs text-yellow-600 bg-yellow-50 border border-yellow-200 rounded-lg px-3 py-2">
                                    Email Anda belum terverifikasi.
                                    <form id="send-verification" method="post" action="{{ route('verification.send') }}" class="inline">
                                        @csrf
                                        <button class="underline font-semibold">Kirim ulang link verifikasi</button>
                                    </form>
                                    @if (session('status') === 'verification-link-sent')
                                        <p class="mt-1 text-green-600">Link verifikasi baru telah dikirim.</p>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="button" onclick="openConfirmModal('formProfile')"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- ── Ubah Password ── --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-base font-semibold text-gray-700 mb-1 flex items-center gap-2">
                    <span class="w-1 h-5 bg-green-500 rounded-full inline-block"></span>
                    Ubah Password
                </h2>
                <p class="text-xs text-gray-400 mb-5">Gunakan password yang panjang dan acak untuk keamanan maksimal.</p>

                <form id="passwordForm" method="POST" action="{{ route('password.update') }}" class="max-w-2xl">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Password Saat Ini</label>
                            <input type="password" name="current_password" id="update_password_current_password"
                                autocomplete="current-password"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                            @error('current_password', 'updatePassword')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Password Baru</label>
                                <input type="password" name="password" id="update_password_password"
                                    autocomplete="new-password"
                                    class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('password', 'updatePassword')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>

                            <div>
                                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Konfirmasi Password Baru</label>
                                <input type="password" name="password_confirmation" id="update_password_password_confirmation"
                                    autocomplete="new-password"
                                    class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @error('password_confirmation', 'updatePassword')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                            </div>
                        </div>
                    </div>

                    <div class="mt-5">
                        <button type="button" onclick="openConfirmModal('formPassword')"
                            class="bg-green-600 hover:bg-green-700 text-white px-5 py-2 rounded-xl text-sm font-semibold">
                            Perbarui Password
                        </button>
                    </div>
                </form>
            </div>

        </main>
    </div>
</div>

{{-- ── Modal Konfirmasi (dipakai bersama untuk kedua form) ── --}}
<div id="confirmModal" class="hidden fixed inset-0 bg-black/20 flex items-center justify-center z-[9999]">
    <div class="bg-white rounded-2xl shadow-xl w-[420px] max-w-[90%] p-6">
        <div class="flex items-center gap-3 mb-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
            </div>
            <div>
                <h3 id="confirmTitle" class="font-bold text-lg text-gray-800">Simpan Perubahan?</h3>
                <p class="text-sm text-gray-500">Data akan diperbarui sekarang.</p>
            </div>
        </div>
        <div class="border-t pt-4 flex justify-end gap-3">
            <button type="button" onclick="closeConfirmModal()"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">
                Batal
            </button>
            <button type="button" onclick="submitConfirmedForm()"
                    class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">
                Ya, Simpan
            </button>
        </div>
    </div>
</div>

<script>
let formToSubmit = null;

function openConfirmModal(formKey) {
    formToSubmit = formKey === 'formProfile'
        ? document.getElementById('profileForm')
        : document.getElementById('passwordForm');

    document.getElementById('confirmTitle').textContent =
        formKey === 'formProfile' ? 'Simpan Informasi Profil?' : 'Perbarui Password?';

    document.getElementById('confirmModal').classList.remove('hidden');
}
function closeConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
}
function submitConfirmedForm() {
    if (formToSubmit) formToSubmit.submit();
}

// Notifikasi auto-close
document.addEventListener('DOMContentLoaded', function () {
    [
        { modal: 'successModal', card: 'successCard', bar: 'progressBar' },
        { modal: 'successModalPw', card: 'successCardPw', bar: 'progressBarPw' },
    ].forEach(({ modal, card, bar }) => {
        const m = document.getElementById(modal);
        if (!m) return;
        const c = document.getElementById(card);
        const p = document.getElementById(bar);
        c.style.opacity = '0'; c.style.transform = 'translateY(20px)';
        setTimeout(() => { c.style.opacity = '1'; c.style.transform = 'translateY(0)'; }, 120);
        p.animate([{ width: '100%' }, { width: '0%' }], { duration: 1800, fill: 'forwards' });
        setTimeout(() => {
            m.style.transition = 'all .2s ease'; m.style.opacity = '0';
            c.style.transform = 'scale(.8)';
            setTimeout(() => m.remove(), 400);
        }, 1800);
    });
});
</script>

</body>
</html>