<nav class="bg-white border-b h-20 px-8 flex items-center justify-end">

    <div class="flex items-center gap-6">

        {{-- Notif --}}
        <button class="text-gray-500 hover:text-blue-600 transition">
            🔔
        </button>

        {{-- Settings --}}
        <button class="text-gray-500 hover:text-blue-600 transition">
            ⚙️
        </button>

        {{-- About --}}
        <button class="text-gray-500 hover:text-blue-600 transition">
            ⓘ
        </button>

        {{-- User Dropdown --}}
        <div x-data="{ open: false }" class="relative">

            <button @click="open = !open"
                    class="flex items-center gap-3">

                <div class="text-right">
                    <h3 class="font-semibold text-sm text-gray-800 leading-tight">
                        {{ Auth::user()->name }}
                    </h3>

                    <p class="text-xs uppercase text-gray-500">
                        Petugas Rekam Medis
                    </p>
                </div>

                <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}"
                     class="w-12 h-12 rounded-full border border-gray-300">
            </button>

            {{-- Dropdown --}}
            <div x-show="open"
                 @click.away="open = false"
                 x-transition
                 class="absolute right-0 mt-3 w-52 bg-white rounded-xl shadow-xl border border-gray-200 overflow-hidden z-50">

                <a href="{{ route('profile.edit') }}"
                   class="block px-5 py-3 text-sm text-gray-700 hover:bg-gray-100">
                    Profile
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            class="w-full text-left px-5 py-3 text-sm text-red-600 hover:bg-red-50">
                        Logout
                    </button>
                </form>

            </div>

        </div>

    </div>

</nav>