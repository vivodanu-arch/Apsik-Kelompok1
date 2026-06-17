@extends('layouts.app')

@section('content')

{{-- Header --}}
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="text-2xl font-bold text-gray-800">Tambah User</h1>
        <p class="text-sm text-gray-500 mt-1">Buat akun pengguna baru untuk sistem</p>
    </div>
</div>

{{-- ERROR --}}
@if($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded-xl mb-4 text-sm">
        {{ $errors->first() }}
    </div>
@endif

{{-- NOTIF SUCCESS --}}
@if(session('success'))
    <div class="bg-green-100 text-green-700 p-3 rounded-xl mb-4 text-sm">
        {{ session('success') }}
    </div>
@endif

{{-- Form --}}
<div class="bg-white rounded-2xl shadow-sm border p-6 max-w-2xl">
    <h2 class="text-base font-semibold text-gray-700 mb-4 flex items-center gap-2">
        <span class="w-1 h-5 bg-blue-600 rounded-full inline-block"></span>
        Data Akun Pengguna
    </h2>

    <form method="POST" action="{{ route('register') }}" class="grid grid-cols-2 gap-4">
        @csrf

        {{-- NAME --}}
        <div class="col-span-2">
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Nama</label>
            <input type="text" name="name" value="{{ old('name') }}"
                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Masukkan nama">
        </div>

        {{-- EMAIL --}}
        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Email</label>
            <input type="email" name="email" value="{{ old('email') }}"
                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Masukkan email">
        </div>

        {{-- ROLE --}}
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

        {{-- PASSWORD --}}
        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Password</label>
            <input type="password" name="password"
                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Masukkan password">
        </div>

        {{-- CONFIRM --}}
        <div>
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wide">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                class="w-full mt-1 border border-gray-300 rounded-xl px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="Ulangi password">
        </div>

        {{-- BUTTONS --}}
        <div class="col-span-2 mt-2 flex gap-3">
            <button type="submit"
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

@endsection