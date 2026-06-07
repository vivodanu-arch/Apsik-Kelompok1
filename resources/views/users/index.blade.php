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

{{-- Notif --}}
@if(session('success'))
    <div id="notif"
         class="mb-5 flex items-center gap-3 bg-green-50 border border-green-200
                text-green-700 px-5 py-3.5 rounded-xl text-sm font-medium shadow-sm">
        <svg class="w-5 h-5 flex-shrink-0 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        {{ session('success') }}
    </div>
    <script>
        setTimeout(() => {
            const el = document.getElementById('notif');
            if (el) { el.style.opacity = '0'; el.style.transition = 'opacity 0.4s'; setTimeout(() => el.remove(), 400); }
        }, 2500);
    </script>
@endif

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

            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-6 py-12 text-center text-gray-400">
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

@endsection
