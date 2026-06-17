@extends('layouts.app')

@section('content')

{{-- Header dengan gradient, sama gaya dengan dashboard --}}
<div class="rounded-2xl p-7 mb-6 text-white shadow-sm"
     style="background: linear-gradient(135deg, #1e3a5f 0%, #2563eb 100%);">
    <div class="flex items-center gap-3">
        <div class="w-12 h-12 rounded-xl bg-white/15 flex items-center justify-center flex-shrink-0">
            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 21v-1a6 6 0 016-6h0a6 6 0 016 6v1"/>
            </svg>
        </div>
        <div>
            <h1 class="text-2xl font-bold">Tambah Pengguna Baru</h1>
            <p class="text-blue-200 text-sm mt-0.5">Buat akun untuk petugas, dokter, atau kepala rekam medis</p>
        </div>
    </div>
</div>

{{-- ERROR --}}
@if($errors->any())
    <div class="bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-xl mb-5 text-sm flex items-start gap-3">
        <svg class="w-5 h-5 flex-shrink-0 text-red-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
            <p class="font-semibold">Periksa kembali data yang Anda masukkan:</p>
            <ul class="mt-1 list-disc list-inside space-y-0.5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
@endif

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- ── Form (2 kolom) ── --}}
    <div class="lg:col-span-2 bg-white rounded-2xl shadow-sm border p-7">
        <h2 class="text-base font-semibold text-gray-700 mb-5 flex items-center gap-2">
            <span class="w-1 h-5 bg-blue-600 rounded-full inline-block"></span>
            Data Akun Pengguna
        </h2>

        <form id="registerForm" method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            {{-- NAME --}}
            <div>
                <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama Lengkap</label>
                <div class="relative mt-1.5">
                    <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full border border-gray-300 rounded-xl pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                        placeholder="Contoh: dr. Ahmad Rizaldi, Sp.PD">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                {{-- EMAIL --}}
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</label>
                    <div class="relative mt-1.5">
                        <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        <input type="email" name="email" value="{{ old('email') }}"
                            class="w-full border border-gray-300 rounded-xl pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="nama@rs.com">
                    </div>
                </div>

                {{-- ROLE --}}
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Role</label>
                    <div class="relative mt-1.5">
                        <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 6v-3a1 1 0 011-1h0a1 1 0 011 1v3"/>
                        </svg>
                        <select name="role" required id="roleSelect"
                            class="w-full border border-gray-300 rounded-xl pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition appearance-none bg-white">
                            <option value="">-- Pilih Role --</option>
                            <option value="petugas" {{ old('role') === 'petugas' ? 'selected' : '' }}>Petugas</option>
                            <option value="dokter" {{ old('role') === 'dokter' ? 'selected' : '' }}>Dokter</option>
                            <option value="kepalarm" {{ old('role') === 'kepalarm' ? 'selected' : '' }}>Kepala RM</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                {{-- PASSWORD --}}
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Password</label>
                    <div class="relative mt-1.5">
                        <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z"/>
                        </svg>
                        <input type="password" name="password" id="passwordInput"
                            class="w-full border border-gray-300 rounded-xl pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Minimal 8 karakter">
                    </div>
                </div>

                {{-- CONFIRM --}}
                <div>
                    <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Konfirmasi Password</label>
                    <div class="relative mt-1.5">
                        <svg class="w-4 h-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <input type="password" name="password_confirmation"
                            class="w-full border border-gray-300 rounded-xl pl-10 pr-3 py-2.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition"
                            placeholder="Ulangi password">
                    </div>
                </div>
            </div>

            {{-- BUTTONS --}}
            <div class="pt-3 flex gap-3 border-t border-gray-100 mt-2">
                <button type="button" onclick="bukaModalKonfirmasi()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm flex items-center gap-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan User
                </button>
                <a href="{{ route('users.index') }}"
                   class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-xl text-sm font-semibold transition">
                    Batal
                </a>
            </div>
        </form>
    </div>

    {{-- ── Panel Info Samping (1 kolom) ── --}}
    <div class="space-y-4">

        {{-- Info role --}}
        <div class="bg-white rounded-2xl shadow-sm border p-5">
            <h3 class="text-sm font-semibold text-gray-700 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Tentang Role
            </h3>
            <div class="space-y-3 text-xs text-gray-500">
                <div class="flex gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-blue-500 mt-1 flex-shrink-0"></span>
                    <div>
                        <p class="font-semibold text-gray-700">Petugas</p>
                        <p>Mengelola data pasien, kunjungan, dan laporan harian.</p>
                    </div>
                </div>
                <div class="flex gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-green-500 mt-1 flex-shrink-0"></span>
                    <div>
                        <p class="font-semibold text-gray-700">Dokter</p>
                        <p>Memeriksa pasien dan mengisi diagnosa pada kunjungan.</p>
                    </div>
                </div>
                <div class="flex gap-2.5">
                    <span class="w-2 h-2 rounded-full bg-yellow-500 mt-1 flex-shrink-0"></span>
                    <div>
                        <p class="font-semibold text-gray-700">Kepala RM</p>
                        <p>Memantau statistik dan laporan rekam medis rumah sakit.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tips password --}}
        <div class="bg-blue-50 border border-blue-100 rounded-2xl p-5">
            <h3 class="text-sm font-semibold text-blue-700 mb-2 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 10-8 0v4h8z"/>
                </svg>
                Keamanan Password
            </h3>
            <ul class="text-xs text-blue-600 space-y-1.5 list-disc list-inside">
                <li>Minimal 8 karakter</li>
                <li>Gabungkan huruf besar &amp; kecil</li>
                <li>Sertakan angka untuk lebih aman</li>
                <li>Hindari kombinasi mudah ditebak</li>
            </ul>
        </div>

    </div>
</div>

{{-- ── Modal Konfirmasi Simpan ── --}}
<div id="modalKonfirmasi" class="hidden fixed inset-0 bg-black/30 backdrop-blur-[1px] flex items-center justify-center z-[9999] p-4">
    <div id="modalKonfirmasiCard" class="bg-white rounded-3xl shadow-xl w-[420px] max-w-full p-7 transition-all duration-300">

        <div class="mx-auto w-16 h-16 rounded-full bg-blue-100 flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>

        <h2 class="text-xl font-bold text-gray-800 text-center">Simpan Pengguna Baru?</h2>
        <p class="text-sm text-gray-500 text-center mt-2">
            Pastikan data dan password yang Anda masukkan sudah benar sebelum menyimpan.
        </p>

        <div class="mt-6 flex gap-3">
            <button type="button" onclick="tutupModalKonfirmasi()"
                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition">
                Periksa Lagi
            </button>
            <button type="button" onclick="document.getElementById('registerForm').submit()"
                class="flex-1 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition">
                Ya, Simpan
            </button>
        </div>
    </div>
</div>

{{-- ── Notifikasi Pop-up Sukses ── --}}
@if(session('success'))
<div id="notifModal" class="fixed inset-0 flex items-center justify-center bg-black/20 backdrop-blur-[1px] z-[9999]">
    <div id="notifCard" class="bg-white rounded-3xl shadow-xl p-8 w-[400px] max-w-[90%] text-center transition-all duration-300">
        <div class="mx-auto w-20 h-20 rounded-full bg-green-500 flex items-center justify-center text-white text-4xl font-bold shadow-md">
            ✓
        </div>
        <h2 class="text-2xl font-bold mt-5 text-gray-800">Berhasil!</h2>
        <p class="text-gray-500 mt-2">{{ session('success') }}</p>
        <div class="mt-6 h-2 bg-gray-200 rounded-full overflow-hidden">
            <div id="progressBar" class="h-full bg-green-500 rounded-full"></div>
        </div>
    </div>
</div>
@endif

<script>
function bukaModalKonfirmasi() {
    const modal = document.getElementById('modalKonfirmasi');
    const card  = document.getElementById('modalKonfirmasiCard');
    modal.classList.remove('hidden');
    card.style.opacity = '0'; card.style.transform = 'scale(0.92) translateY(10px)';
    requestAnimationFrame(() => {
        card.style.transition = 'all 0.2s ease';
        card.style.opacity = '1'; card.style.transform = 'scale(1) translateY(0)';
    });
}
function tutupModalKonfirmasi() {
    document.getElementById('modalKonfirmasi').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function () {
    const notifModal = document.getElementById('notifModal');
    if (!notifModal) return;

    const card = document.getElementById('notifCard');
    const progress = document.getElementById('progressBar');

    card.style.opacity = '0'; card.style.transform = 'translateY(20px)';
    setTimeout(() => {
        card.style.transition = 'all 0.3s ease';
        card.style.opacity = '1'; card.style.transform = 'translateY(0)';
    }, 100);

    progress.animate([{ width: '100%' }, { width: '0%' }], { duration: 2000, fill: 'forwards' });
    setTimeout(() => {
        notifModal.style.transition = 'all .2s ease';
        notifModal.style.opacity = '0';
        card.style.transform = 'scale(.8)';
        setTimeout(() => notifModal.remove(), 400);
    }, 2000);
});
</script>

@endsection