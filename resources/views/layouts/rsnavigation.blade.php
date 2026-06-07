<nav class="bg-white border-b h-16 px-6 flex items-center justify-between sticky top-0 z-30 shadow-sm">

    {{-- Breadcrumb / Judul halaman --}}
    <div class="flex items-center gap-2 text-sm text-gray-500">
        <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
        <span class="text-gray-400">/</span>
        <span class="text-gray-700 font-semibold text-sm">
            @if(request()->routeIs('dashboard') || request()->routeIs('dashboard*'))
                Dashboard
            @elseif(request()->routeIs('pasien.*'))
                Data Pasien
            @elseif(request()->routeIs('datakunjungan'))
                Data Kunjungan
            @elseif(request()->routeIs('laporan'))
                Laporan
            @elseif(request()->routeIs('users.*'))
                Manajemen User
            @else
                Halaman
            @endif
        </span>
    </div>

    {{-- Kanan: tanggal + user --}}
    <div class="flex items-center gap-5">

        {{-- Tanggal hari ini --}}
        <div class="hidden md:flex items-center gap-2 text-xs text-gray-400 bg-gray-50 px-3 py-1.5 rounded-lg border">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span>{{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}</span>
        </div>

        {{-- Divider --}}
        <div class="h-8 w-px bg-gray-200"></div>

        {{-- User dropdown --}}
        <div x-data="{ open: false }" class="relative">

            <button @click="open = !open"
                    class="flex items-center gap-3 hover:opacity-80 transition">
                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=3b82f6&color=fff&bold=true"
                     class="w-8 h-8 rounded-full ring-2 ring-blue-500/30">
                <div class="hidden md:block text-left">
                    <p class="text-sm font-semibold text-gray-800 leading-tight">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-gray-400 uppercase tracking-wide">
                        @switch(auth()->user()->role)
                            @case('petugas') Petugas RM @break
                            @case('kepalarm') Kepala RM @break
                            @case('dokter') Dokter @break
                            @default User
                        @endswitch
                    </p>
                </div>
                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>

            {{-- Dropdown --}}
            <div x-show="open"
                 @click.outside="open = false"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg border border-gray-100 overflow-hidden z-50 origin-top-right">

                <div class="px-4 py-3 border-b bg-gray-50">
                    <p class="text-xs font-semibold text-gray-800 truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-gray-400 truncate">{{ Auth::user()->email }}</p>
                </div>

                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-2 px-4 py-2.5 text-sm text-gray-700 hover:bg-gray-50 transition">
                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Profil Saya
                </a>

                <div class="border-t"></div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                            class="flex items-center gap-2 w-full px-4 py-2.5 text-sm text-red-600 hover:bg-red-50 transition">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        Logout
                    </button>
                </form>

            </div>
        </div>
    </div>
</nav>
