@php
    $role = auth()->user()->role;
    $dashboardRoute = match($role) {
        'petugas'  => route('dashboard'),
        'dokter'   => route('dashboarddokter'),
        'kepalarm' => route('dashboardkepalarm'),
        default    => '/'
    };
    $roleLabel = match($role) {
        'petugas'  => 'Petugas Rekam Medis',
        'dokter'   => 'Dokter',
        'kepalarm' => 'Kepala Rekam Medis',
        default    => 'User'
    };

    // Warna aktif & hover berbasis #437ecc
    $bgSidebar  = '#2c5f9e';   // base sidebar (lebih gelap sedikit dari #437ecc)
    $clrActive  = '#437ecc';   // warna item aktif / aksen
    $clrHover   = 'rgba(255,255,255,0.10)';
@endphp

{{-- ══════════════════════════════════════════════════
     CSS — inline di dalam komponen ini sendiri
     ══════════════════════════════════════════════════ --}}
<style>
    /* ── Sidebar container ── */
    #rs-sidebar {
        background: #2c5f9e;
    }

    /* ── Item menu ── */
    .nav-link {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 9px 12px;
        border-radius: 10px;
        font-size: 12px;
        font-weight: 500;
        color: rgba(255,255,255,0.60);
        position: relative;
        overflow: hidden;          /* wajib agar ripple tidak keluar */
        cursor: pointer;
        text-decoration: none;
        transition: background 0.15s ease, color 0.15s ease;
        -webkit-tap-highlight-color: transparent;
    }
    .nav-link:hover {
        background: rgba(255,255,255,0.10);
        color: rgba(255,255,255,0.95);
    }
    .nav-link:hover .nav-icon {
        background: rgba(255,255,255,0.15);
    }

    /* ── Item aktif ── */
    .nav-active {
        background: rgba(255,255,255,0.18) !important;
        color: #ffffff !important;
        font-weight: 700;
        box-shadow: inset 3px 0 0 #ffffff;
    }
    .nav-active .nav-icon {
        background: rgba(255,255,255,0.25) !important;
    }

    /* ── Kotak ikon ── */
    .nav-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 28px;
        height: 28px;
        border-radius: 7px;
        flex-shrink: 0;
        background: rgba(255,255,255,0.08);
        transition: background 0.15s ease;
    }

    /* ── Ripple effect ── */
    .nav-ripple {
        position: absolute;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.30);
        transform: scale(0);
        animation: rippleAnim 0.5s ease-out forwards;
        pointer-events: none;
    }
    @keyframes rippleAnim {
        to { transform: scale(5); opacity: 0; }
    }

    /* ── Divider label grup ── */
    .nav-group-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.12em;
        text-transform: uppercase;
        color: rgba(255,255,255,0.30);
        padding: 0 12px;
        margin-bottom: 4px;
    }
</style>

<aside id="rs-sidebar"
       class="fixed top-0 left-0 w-64 h-screen flex flex-col z-40">

    {{-- ── Logo ── --}}
    <div class="px-5 py-5 flex items-center gap-3"
        style="border-bottom: 1px solid rgba(255,255,255,0.12);">

        <div class="w-10 h-10 rounded-xl overflow-hidden flex items-center justify-center flex-shrink-0"
            style="background: rgba(255,255,255,0.18);">
            <img src="{{ asset('images/logo1.png') }}"
                alt="Logo Rumah Sakit Kasih"
                class="w-8 h-8 object-contain">
        </div>

        <div>
            <h1 class="text-sm font-bold text-white leading-tight tracking-wide">
                RUMAH SAKIT KASIH
            </h1>
            <p class="text-[10px] tracking-widest uppercase mt-0.5"
            style="color: rgba(255,255,255,0.40);">
                Sistem Pelaporan
            </p>
        </div>
    </div>

    {{-- ── Navigasi ── --}}
    <nav class="flex-1 px-3 py-4 overflow-y-auto" style="display: flex; flex-direction: column; gap: 2px;">

        <p class="nav-group-label mb-2">Menu Utama</p>

        {{-- Dashboard --}}
        <a href="{{ $dashboardRoute }}"
           class="nav-link {{ (request()->routeIs('dashboard') || request()->routeIs('dashboarddokter') || request()->routeIs('dashboardkepalarm')) ? 'nav-active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                </svg>
            </span>
            <span>Dashboard</span>
        </a>

        {{-- Data Pasien --}}
        <a href="{{ route('pasien.index') }}"
           class="nav-link {{ request()->routeIs('pasien.*') ? 'nav-active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </span>
            <span>Data Pasien</span>
        </a>

        {{-- Data Kunjungan --}}
        <a href="{{ route('datakunjungan') }}"
           class="nav-link {{ request()->routeIs('datakunjungan') ? 'nav-active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </span>
            <span>Data Kunjungan</span>
        </a>

        {{-- Laporan --}}
        <a href="{{ route('laporan') }}"
           class="nav-link {{ request()->routeIs('laporan') ? 'nav-active' : '' }}">
            <span class="nav-icon">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-width="2" d="M9 17v-6m4 6V7m4 10v-3M5 21h14a1 1 0 001-1V4a1 1 0 00-1-1H5a1 1 0 00-1 1v16a1 1 0 001 1z"/>
                </svg>
            </span>
            <span>Laporan</span>
        </a>

        {{-- Manajemen User — super admin only --}}
        @auth
        @if(auth()->user()->is_super_admin)
            <div style="margin-top: 16px; margin-bottom: 6px;">
                <p class="nav-group-label">Administrasi</p>
            </div>
            <a href="{{ route('users.index') }}"
               class="nav-link {{ request()->routeIs('users.*') ? 'nav-active' : '' }}">
                <span class="nav-icon">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                </span>
                <span>Manajemen User</span>
                <span class="ml-auto text-[10px] font-bold px-2 py-0.5 rounded-full"
                      style="background: rgba(255,255,255,0.18); color: rgba(255,255,255,0.9);">
                    ADM
                </span>
            </a>
        @endif
        @endauth

    </nav>

</aside>

{{-- ══════════════════════════════════════════════════
     Script ripple — diletakkan setelah <aside> agar
     elemen sudah ada di DOM saat script berjalan
     ══════════════════════════════════════════════════ --}}
<script>
(function () {
    // Tunggu DOM siap — pakai DOMContentLoaded jika script di <head>,
    // atau langsung jika sudah di bawah elemen
    function initRipple() {
        document.querySelectorAll('.nav-link').forEach(function (link) {
            link.addEventListener('click', function (e) {
                // Buat elemen ripple
                var ripple   = document.createElement('span');
                ripple.className = 'nav-ripple';

                var rect = this.getBoundingClientRect();
                var size = Math.max(rect.width, rect.height);
                var x    = e.clientX - rect.left - size / 2;
                var y    = e.clientY - rect.top  - size / 2;

                ripple.style.width  = size + 'px';
                ripple.style.height = size + 'px';
                ripple.style.left   = x + 'px';
                ripple.style.top    = y + 'px';

                this.appendChild(ripple);

                // Hapus elemen setelah animasi selesai
                ripple.addEventListener('animationend', function () {
                    ripple.remove();
                });
            });
        });
    }

    // Jalankan setelah DOM fully loaded
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initRipple);
    } else {
        initRipple();
    }
})();
</script>