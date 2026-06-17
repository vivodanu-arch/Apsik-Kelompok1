<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah User - Rumah Sakit Kasih</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100">
<div class="flex min-h-screen">

    @include('layouts.sidebar')

    <div class="flex-1 ml-64 flex flex-col">
        @include('layouts.rsnavigation')

        <main class="p-6 space-y-5">

            {{-- Notifikasi sukses --}}
            @if(session('success'))
            <div id="successModal" class="fixed inset-0 flex items-center justify-center bg-black/20 backdrop-blur-[1px] z-[9999]">
                <div id="successCard" class="bg-white rounded-3xl shadow-xl p-8 w-[400px] max-w-[90%] text-center transition-all duration-300">
                    <div class="mx-auto w-20 h-20 rounded-full bg-blue-600 flex items-center justify-center text-white text-4xl font-bold shadow-md">✓</div>
                    <h2 class="text-3xl font-bold mt-5 text-gray-800">Berhasil</h2>
                    <p class="text-gray-500 mt-2">{{ session('success') }}</p>
                    <div class="mt-6 h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div id="progressBar" class="h-full bg-green-500 rounded-full"></div>
                    </div>
                </div>
            </div>
            <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('successModal');
                const card  = document.getElementById('successCard');
                card.style.opacity = '0'; card.style.transform = 'translateY(20px)';
                setTimeout(() => { card.style.opacity = '1'; card.style.transform = 'translateY(0)'; }, 120);
                document.getElementById('progressBar').animate([{width:'100%'},{width:'0%'}],{duration:1800,fill:'forwards'});
                setTimeout(() => {
                    modal.style.transition = 'all .2s ease'; modal.style.opacity = '0';
                    card.style.transform = 'scale(.8)';
                    setTimeout(() => modal.remove(), 400);
                }, 1800);
            });
            </script>
            @endif

            {{-- Notifikasi error validasi --}}
            @if($errors->any())
            <div class="rounded-xl bg-red-50 border border-red-200 text-red-700 text-sm px-4 py-3">
                <p class="font-semibold mb-1">Periksa kembali data yang Anda masukkan:</p>
                <ul class="list-disc list-inside space-y-0.5">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            {{-- Header --}}
            <div class="rounded-2xl p-8 text-white shadow-sm"
                 style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);">
                <h1 class="text-3xl font-bold">Tambah User</h1>
                <p class="mt-2 text-blue-200 text-sm">Buat akun pengguna baru untuk sistem Rumah Sakit Kasih</p>
            </div>

            {{-- ── Form Data Akun (mengikuti gaya editdatapasien) ── --}}
            <div class="bg-white rounded-2xl shadow-sm p-6">
                <h2 class="text-base font-semibold text-gray-700 mb-1 flex items-center gap-2">
                    <span class="w-1 h-5 bg-blue-600 rounded-full inline-block"></span>
                    Data Akun Pengguna
                </h2>
                <p class="text-xs text-gray-400 mb-5">Lengkapi informasi berikut untuk membuat akun baru.</p>

                <form id="registerForm" method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="grid grid-cols-2 gap-4">

                        <div class="col-span-2">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</label>
                            <input type="text" name="name" value="{{ old('name') }}"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan nama lengkap">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</label>
                            <input type="email" name="email" value="{{ old('email') }}"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan email">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Role</label>
                            <select name="role" required
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="">-- Pilih Role --</option>
                                <option value="petugas" {{ old('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                                <option value="dokter" {{ old('role') === 'dokter' ? 'selected' : '' }}>Dokter</option>
                                <option value="kepalarm" {{ old('role') === 'kepalarm' ? 'selected' : '' }}>Kepala RM</option>
                            </select>
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Password</label>
                            <input type="password" name="password"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Masukkan password">
                        </div>

                        <div>
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Konfirmasi Password</label>
                            <input type="password" name="password_confirmation"
                                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                                placeholder="Ulangi password">
                        </div>

                    </div>

                    <div class="mt-6 flex gap-3">
                        <button type="button" onclick="openConfirmModal()"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded-xl text-sm font-semibold">
                            Simpan User
                        </button>
                        <a href="{{ route('users.index') }}"
                           class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-5 py-2 rounded-xl text-sm font-semibold">
                            Batal
                        </a>
                    </div>
                </form>
            </div>

        </main>
    </div>
</div>

{{-- ── Modal Konfirmasi ── --}}
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
                <h3 class="font-bold text-lg text-gray-800">Simpan User Baru?</h3>
                <p class="text-sm text-gray-500">Pastikan data yang dimasukkan sudah benar.</p>
            </div>
        </div>
        <div class="border-t pt-4 flex justify-end gap-3">
            <button type="button" onclick="closeConfirmModal()"
                    class="px-4 py-2 rounded-lg bg-gray-200 hover:bg-gray-300 text-gray-700">
                Periksa Lagi
            </button>
            <button type="button" onclick="document.getElementById('registerForm').submit()"
                    class="px-4 py-2 rounded-lg bg-blue-600 hover:bg-blue-700 text-white">
                Ya, Simpan
            </button>
        </div>
    </div>
</div>

<script>
function openConfirmModal() {
    document.getElementById('confirmModal').classList.remove('hidden');
}
function closeConfirmModal() {
    document.getElementById('confirmModal').classList.add('hidden');
}
</script>

</body>
</html>