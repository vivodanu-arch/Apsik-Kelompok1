@extends('layouts.app')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Manajemen User</h1>
        <p class="text-sm text-gray-500 mt-1">Kelola akun pengguna sistem</p>
    </div>
    <a href="{{ route('register') }}"
       class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white
              px-5 py-2.5 rounded-xl text-sm font-semibold transition shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2.5" stroke-linecap="round" d="M12 4v16m8-8H4"/>
        </svg>
        Tambah User
    </a>
</div>

{{-- Stat cards --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    @php
        $totalUser    = $users->count();
        $totalDokter  = $users->where('role','dokter')->count();
        $totalPetugas = $users->where('role','petugas')->count();
        $totalKepala  = $users->where('role','kepalarm')->count();
    @endphp

    <div class="bg-white rounded-2xl p-4 border shadow-sm">
        <p class="text-xs text-gray-400 mb-1">Total User</p>
        <p class="text-2xl font-bold text-gray-800">{{ $totalUser }}</p>
    </div>
    <div class="bg-white rounded-2xl p-4 border shadow-sm">
        <p class="text-xs text-gray-400 mb-1">Dokter</p>
        <p class="text-2xl font-bold text-green-600">{{ $totalDokter }}</p>
    </div>
    <div class="bg-white rounded-2xl p-4 border shadow-sm">
        <p class="text-xs text-gray-400 mb-1">Petugas</p>
        <p class="text-2xl font-bold text-blue-600">{{ $totalPetugas }}</p>
    </div>
    <div class="bg-white rounded-2xl p-4 border shadow-sm">
        <p class="text-xs text-gray-400 mb-1">Kepala RM</p>
        <p class="text-2xl font-bold text-yellow-600">{{ $totalKepala }}</p>
    </div>
</div>

{{-- Tabel --}}
<div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

    <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
        <p class="text-sm font-semibold text-gray-700">Daftar Pengguna</p>
        <p class="text-xs text-gray-400">{{ $totalUser }} akun terdaftar</p>
    </div>

    <table class="w-full text-sm">
        <thead>
            <tr class="border-b text-xs uppercase tracking-wide text-gray-400">
                <th class="px-6 py-3 text-left w-10">No</th>
                <th class="px-6 py-3 text-left">Nama</th>
                <th class="px-6 py-3 text-left">Email</th>
                <th class="px-6 py-3 text-left">Role</th>
                <th class="px-6 py-3 text-left">Status</th>
                <th class="px-6 py-3 text-center w-24">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100">
            @forelse($users as $u)
            <tr class="hover:bg-gray-50 transition">

                <td class="px-6 py-4 text-gray-400">{{ $loop->iteration }}</td>

                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($u->name) }}&background={{ $u->is_super_admin ? 'ef4444' : ($u->role == 'dokter' ? '16a34a' : ($u->role == 'kepalarm' ? 'ca8a04' : '3b82f6')) }}&color=fff&bold=true&size=64"
                             class="w-8 h-8 rounded-full flex-shrink-0">
                        <div>
                            <p class="font-semibold text-gray-800">{{ $u->name }}</p>
                            @if($u->is_super_admin)
                                <p class="text-[11px] text-red-500">Super Administrator</p>
                            @endif
                        </div>
                    </div>
                </td>

                <td class="px-6 py-4 text-gray-500">{{ $u->email }}</td>

                <td class="px-6 py-4">
                    @if($u->role == 'dokter')
                        <span class="inline-flex items-center gap-1 bg-green-50 text-green-700 border border-green-200 px-3 py-1 rounded-full text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-green-500"></span>
                            Dokter
                        </span>
                    @elseif($u->role == 'petugas')
                        <span class="inline-flex items-center gap-1 bg-blue-50 text-blue-700 border border-blue-200 px-3 py-1 rounded-full text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-500"></span>
                            Petugas
                        </span>
                    @elseif($u->role == 'kepalarm')
                        <span class="inline-flex items-center gap-1 bg-yellow-50 text-yellow-700 border border-yellow-200 px-3 py-1 rounded-full text-xs font-semibold">
                            <span class="w-1.5 h-1.5 rounded-full bg-yellow-500"></span>
                            Kepala RM
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4">
                    @if($u->is_super_admin)
                        <span class="inline-flex items-center gap-1 bg-red-50 text-red-600 border border-red-200 px-2.5 py-1 rounded-full text-xs font-bold">
                            ⭐ Super Admin
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 bg-gray-50 text-gray-500 border border-gray-200 px-2.5 py-1 rounded-full text-xs">
                            Aktif
                        </span>
                    @endif
                </td>

                <td class="px-6 py-4 text-center">
                    @if($u->id !== auth()->id() && !$u->is_super_admin)
                        <button type="button"
                            onclick="bukaModalHapus({{ $u->id }}, '{{ addslashes($u->name) }}', '{{ $u->role }}', {{ $jumlahKunjunganDokter[$u->id] ?? 0 }})"
                            class="bg-red-50 hover:bg-red-100 text-red-600 px-3 py-1.5 rounded-lg text-xs font-semibold transition inline-flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Hapus
                        </button>
                    @else
                        <span class="text-gray-300 text-xs italic">—</span>
                    @endif
                </td>

            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center text-gray-400">
                    <svg class="w-10 h-10 mx-auto mb-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    Belum ada data user
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

{{-- ── Modal Konfirmasi Hapus ── --}}
<div id="modalHapus" class="hidden fixed inset-0 bg-black/30 backdrop-blur-[1px] flex items-center justify-center z-[9999] p-4">
    <div id="modalHapusCard" class="bg-white rounded-3xl shadow-xl w-[440px] max-w-full p-7 transition-all duration-300">

        <div class="mx-auto w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mb-4">
            <svg class="w-8 h-8 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
            </svg>
        </div>

        <h2 class="text-xl font-bold text-gray-800 text-center">Hapus Pengguna?</h2>
        <p class="text-sm text-gray-500 text-center mt-2">
            Anda akan menghapus akun <strong id="namaUserHapus" class="text-gray-700"></strong> secara permanen. Tindakan ini tidak dapat dibatalkan.
        </p>

        {{-- Peringatan tambahan jika dokter punya kunjungan --}}
        <div id="peringatanDokter" class="hidden mt-4 bg-yellow-50 border border-yellow-200 rounded-xl px-4 py-3 text-xs text-yellow-700">
            ⚠️ Dokter ini memiliki <strong id="jumlahKunjunganText"></strong> data kunjungan pasien. Seluruh riwayat kunjungan dan diagnosa terkait akan ikut terhapus.
        </div>

        <form id="formHapusUser" method="POST" class="mt-6 flex gap-3">
            @csrf
            @method('DELETE')
            <button type="button" onclick="tutupModalHapus()"
                class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2.5 rounded-xl text-sm font-semibold transition">
                Batal
            </button>
            <button type="submit"
                class="flex-1 bg-red-600 hover:bg-red-700 text-white px-4 py-2.5 rounded-xl text-sm font-semibold transition">
                Ya, Hapus
            </button>
        </form>
    </div>
</div>

{{-- ── Notifikasi Pop-up (Success / Error) ── --}}
@if(session('success') || session('error'))
<div id="notifModal" class="fixed inset-0 flex items-center justify-center bg-black/20 backdrop-blur-[1px] z-[9999]">
    <div id="notifCard" class="bg-white rounded-3xl shadow-xl p-8 w-[400px] max-w-[90%] text-center transition-all duration-300">

        @if(session('success'))
            <div class="mx-auto w-20 h-20 rounded-full bg-green-500 flex items-center justify-center text-white text-4xl font-bold shadow-md">
                ✓
            </div>
            <h2 class="text-2xl font-bold mt-5 text-gray-800">Berhasil!</h2>
            <p class="text-gray-500 mt-2">{{ session('success') }}</p>
            <div class="mt-6 h-2 bg-gray-200 rounded-full overflow-hidden">
                <div id="progressBar" class="h-full bg-green-500 rounded-full"></div>
            </div>
        @else
            <div class="mx-auto w-20 h-20 rounded-full bg-red-500 flex items-center justify-center text-white text-4xl font-bold shadow-md">
                ✕
            </div>
            <h2 class="text-2xl font-bold mt-5 text-gray-800">Gagal!</h2>
            <p class="text-gray-500 mt-2">{{ session('error') }}</p>
            <button onclick="document.getElementById('notifModal').remove()"
                class="mt-6 bg-red-50 hover:bg-red-100 text-red-600 px-5 py-2 rounded-xl text-sm font-semibold transition">
                Tutup
            </button>
        @endif
    </div>
</div>
@endif

<script>
function bukaModalHapus(id, nama, role, jumlahKunjungan) {
    document.getElementById('namaUserHapus').textContent = '"' + nama + '"';
    document.getElementById('formHapusUser').action = '/users/' + id;

    const peringatan = document.getElementById('peringatanDokter');
    if (role === 'dokter' && jumlahKunjungan > 0) {
        document.getElementById('jumlahKunjunganText').textContent = jumlahKunjungan + ' kunjungan';
        peringatan.classList.remove('hidden');
    } else {
        peringatan.classList.add('hidden');
    }

    const modal = document.getElementById('modalHapus');
    const card  = document.getElementById('modalHapusCard');
    modal.classList.remove('hidden');
    card.style.opacity = '0'; card.style.transform = 'scale(0.92) translateY(10px)';
    requestAnimationFrame(() => {
        card.style.transition = 'all 0.2s ease';
        card.style.opacity = '1'; card.style.transform = 'scale(1) translateY(0)';
    });
}

function tutupModalHapus() {
    document.getElementById('modalHapus').classList.add('hidden');
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

    // Hanya auto-close untuk notifikasi sukses (yang punya progress bar)
    if (progress) {
        progress.animate([{ width: '100%' }, { width: '0%' }], { duration: 2200, fill: 'forwards' });
        setTimeout(() => {
            notifModal.style.transition = 'all .2s ease';
            notifModal.style.opacity = '0';
            card.style.transform = 'scale(.8)';
            setTimeout(() => notifModal.remove(), 400);
        }, 2200);
    }
});
</script>

@endsection