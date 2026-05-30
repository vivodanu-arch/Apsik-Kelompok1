@php
    $dashboardRoute = match(auth()->user()->role) {
        'petugas' => route('dashboard'),
        'dokter' => route('dashboarddokter'),
        'kepalarm' => route('dashboardkepalarm'),
        default => '/'
    };
@endphp
<aside class="fixed top-0 left-0 w-64 h-screen bg-white border-r flex flex-col">

    {{-- Logo --}}
    <div class="px-6 py-5 border-b">
        <h1 class="text-lg font-bold text-blue-900 leading-tight">
            RUMAH SAKIT KASIH
        </h1>

        <p class="text-[11px] tracking-[0.25em] text-gray-400 mt-1">
            SISTEM PELAPORAN
        </p>
    </div>

    {{-- Menu --}}
    <nav class="flex-1 mt-5 px-3 space-y-2 overflow-y-auto">

        {{-- Dashboard --}}
        <a href="{{ $dashboardRoute }}"
           class="sidebar-item {{ request()->routeIs('dashboard') ? 'sidebar-active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="M4 4h6v6H4V4zm10 0h6v6h-6V4zM4 14h6v6H4v-6zm10 3h6"/>
            </svg>
            <span class="font-semibold text-xs">Dashboard</span>
        </a>

        {{-- Data Pasien --}}
        <a href="{{ route('pasien.index') }}"
           class="sidebar-item {{ request()->routeIs('pasien.*') ? 'sidebar-active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="font-semibold text-xs">Data Pasien</span>
        </a>

        {{-- Data Kunjungan --}}
        <a href="{{ route('datakunjungan') }}"
           class="sidebar-item {{ request()->routeIs('datakunjungan') ? 'sidebar-active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="M9 12l2 2 4-4m5 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="font-semibold text-xs">Data Kunjungan</span>
        </a>

        {{-- Laporan --}}
        <a href="{{ route('laporan') }}"
           class="sidebar-item {{ request()->routeIs('laporan') ? 'sidebar-active' : '' }}">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-width="2" d="M9 17v-6m4 6V7m4 10v-3M5 21h14"/>
            </svg>
            <span class="font-semibold text-xs">Laporan</span>
        </a>

        {{-- SUPER ADMIN --}}
        @auth
        @if(auth()->user()->is_super_admin == 1)

            {{-- Manajemen User --}}
            <a href="{{ route('users.index') }}"
               class="sidebar-item {{ request()->routeIs('users.*') ? 'sidebar-active' : '' }}">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M17 20h5V4H2v16h5m10 0v-6a4 4 0 00-8 0v6"/>
                </svg>
                <span class="font-semibold text-xs">Manajemen User</span>
            </a>

        @endif
        @endauth

    </nav>

</aside>