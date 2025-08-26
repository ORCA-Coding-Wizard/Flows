{{-- layouts/nav-admin.blade.php --}}
<aside x-data="{ open: true, dropdownOpen: false }"
    class="bg-white text-gray-800 min-h-screen flex flex-col justify-between border-r border-gray-200 transition-all duration-300"
    :class="open ? 'w-64' : 'w-16'">

    <!-- TOP : Logo & Toggle -->
    <div>
        <div class="flex items-center justify-between px-4 py-4 border-b border-gray-200">
            <!-- Logo hanya muncul saat open -->
            <div x-show="open" x-transition>
                <a href="{{ route('dashboard') }}">
                    <x-application-logo class="h-9 w-auto fill-current text-gray-800" />
                </a>
            </div>

            <!-- Tombol toggle selalu muncul -->
            <button @click="open = !open" class="text-gray-600 hover:text-gray-900 ml-auto">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <!-- Ikon close -->
                    <path x-show="open" x-transition stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12" />
                    <!-- Ikon menu -->
                    <path x-show="!open" x-transition stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>


        <!-- MENU -->
        <nav class="mt-4 space-y-1">
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 rounded-md {{ request()->routeIs('dashboard') ? 'bg-gray-200 font-semibold' : '' }}">
                <span>📊</span>
                <span x-show="open" x-transition>{{ __('Dashboard') }}</span>
            </a>

            <a href="{{ route('admin.kelola-admin.index') }}"
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 rounded-md {{ request()->routeIs('admin.index') ? 'bg-gray-200 font-semibold' : '' }}">
                <span>👤</span>
                <span x-show="open" x-transition>{{ __('Kelola Admin') }}</span>
            </a>

            <a href="{{ route('admin.kategori.index') }}"
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 rounded-md {{ request()->routeIs('admin.kategori') ? 'bg-gray-200 font-semibold' : '' }}">
                <span>📂</span>
                <span x-show="open" x-transition>{{ __('Kelola Kategori') }}</span>
            </a>

            <a href="{{ route('admin.bunga.index') }}"
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 rounded-md {{ request()->routeIs('admin.bunga') ? 'bg-gray-200 font-semibold' : '' }}">
                <span>🌸</span>
                <span x-show="open" x-transition>{{ __('Kelola Bunga') }}</span>
            </a>

            <a href="{{ route('admin.buket.index') }}"
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 rounded-md {{ request()->routeIs('admin.buket') ? 'bg-gray-200 font-semibold' : '' }}">
                <span>💐</span>
                <span x-show="open" x-transition>{{ __('Kelola Buket') }}</span>
            </a>

            <a href="{{ route('admin.transactions.index') }}"
                class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100 rounded-md {{ request()->routeIs('admin.laporan') ? 'bg-gray-200 font-semibold' : '' }}">
                <span>📑</span>
                <span x-show="open" x-transition>{{ __('Laporan') }}</span>
            </a>
        </nav>
    </div>

    <!-- BOTTOM : Profile + Logout -->
    <div class="p-4 border-t border-gray-200 relative">
        <div x-data="{ openDropdown: false }" class="relative w-full">
            <!-- Trigger -->
            <button @click="openDropdown = !openDropdown"
                class="flex items-center w-full justify-between px-2 py-2 rounded hover:bg-gray-100">
                <span x-show="open" x-transition>{{ Auth::user()->name }}</span>
                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>

            <!-- Dropdown (DROP UP) -->
            <div x-show="openDropdown" @click.outside="openDropdown = false" x-transition
                class="absolute bottom-full left-0 mb-2 w-48 bg-white border border-gray-200 rounded-md shadow-lg z-50">
                <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                    {{ __('Profile') }}
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full text-left block px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>

</aside>
