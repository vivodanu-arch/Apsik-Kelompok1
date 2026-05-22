@extends('layouts.app')

@section('content')

<div class="p-6">

    {{-- HEADER --}}
    <div class="bg-blue-600 text-white rounded-2xl p-5 mb-5">
        <h1 class="text-xl font-bold">MANAJEMEN USER</h1>
        <p class="text-sm opacity-80">Kelola akun pengguna sistem</p>
    </div>

    {{-- NOTIF --}}
    @if(session('success'))
    <div id="notif"
        class="fixed top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 
        bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg z-50">

        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('notif')?.remove();
        }, 2000);
    </script>
    @endif

    {{-- TOOLBAR --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 mb-4">
    
        {{-- SEARCH --}}
        <input type="text"
            name="search"
            value="{{ request('search') }}"
            placeholder="Cari nama atau email..."
            class="w-full md:w-1/3 rounded-xl border-gray-300 shadow-sm px-4 py-2 text-sm">

        {{-- BUTTON --}}
        <a href="{{ route('register') }}"
            class="bg-blue-600 text-white px-5 py-2 rounded-xl text-sm font-semibold 
            hover:bg-blue-700 transition whitespace-nowrap">
            + Tambah User
        </a>

    </div>

    {{-- TABLE --}}
    <div class="bg-white rounded-2xl shadow overflow-hidden">
        <table class="w-full text-sm text-center">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="p-3">No</th>
                    <th class="p-3">Nama</th>
                    <th class="p-3">Email</th>
                    <th class="p-3">Role</th>
                </tr>
            </thead>

            <tbody>
                @forelse($users as $u)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="p-3">{{ $loop->iteration }}</td>

                    <td class="p-3 font-semibold">
                        {{ $u->name }}
                    </td>

                    <td class="p-3 text-gray-600">
                        {{ $u->email }}
                    </td>

                    <td class="p-3">
                        @if($u->is_super_admin == 1)
                            <span class="bg-red-100 text-red-600 px-3 py-1 rounded-full text-xs font-bold">
                                SUPER ADMIN
                            </span>
                        @elseif($u->role == 'petugas')
                            <span class="bg-blue-100 text-blue-600 px-3 py-1 rounded-full text-xs font-semibold">
                                Petugas
                            </span>
                        @elseif($u->role == 'dokter')
                            <span class="bg-green-100 text-green-600 px-3 py-1 rounded-full text-xs font-semibold">
                                Dokter
                            </span>
                        @elseif($u->role == 'kepalarm')
                            <span class="bg-yellow-100 text-yellow-600 px-3 py-1 rounded-full text-xs font-semibold">
                                Kepala RM
                            </span>
                        @endif
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-gray-500">
                        Belum ada data user
                    </td>
                </tr>
                @endforelse
            </tbody>

        </table>
    </div>

</div>

@endsection