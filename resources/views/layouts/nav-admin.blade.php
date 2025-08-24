<div class="flex justify-between h-16">
    <div class="flex">
        <!-- Logo -->
        <div class="shrink-0 flex items-center ms-12 me-14">
            <a href="{{ route('dashboard') }}">
                <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
            </a>
        </div>

        <div class="hidden sm:flex space-x-6">
            <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-nav-link>

            <x-nav-link :href="route('admin.kelola-admin.index')" :active="request()->routeIs('admin.index')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5V4H2v16h5m10 0v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6h10z" />
                </svg>
                {{ __('Kelola Admin') }}
            </x-nav-link>

            <x-nav-link :href="route('admin.kategori.index')" :active="request()->routeIs('admin.kategori')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
                </svg>
                {{ __('Kelola Kategori') }}
            </x-nav-link>

            <x-nav-link :href="route('admin.bunga.index')" :active="request()->routeIs('admin.bunga')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6l4 2" />
                </svg>
                {{ __('Kelola Bunga') }}
            </x-nav-link>

            <x-nav-link :href="route('admin.buket.index')" :active="request()->routeIs('admin.buket')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7h18M3 12h18M3 17h18" />
                </svg>
                {{ __('Kelola Buket') }}
            </x-nav-link>

            <x-nav-link :href="route('admin.laporan')" :active="request()->routeIs('admin.laporan')">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 inline-block mr-2" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17v-6h13v6H9zM5 10h2V4H5v6z" />
                </svg>
                {{ __('Laporan') }}
            </x-nav-link>
        </div>
    </div>

    <!-- ✅ Settings Dropdown tetap di dalam flex justify-between -->
    <div class="hidden sm:flex sm:items-center sm:ms-6 me-14">
        <x-dropdown align="right" width="40">
            <x-slot name="trigger">
                <button class="inline-flex items-center px-3 py-2 ...">
                    <div>{{ Auth::user()->name }}</div>
                    <div class="ms-1">⌄</div>
                </button>
            </x-slot>
            <x-slot name="content">
                <x-dropdown-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-dropdown-link>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-dropdown-link :href="route('logout')"
                        onclick="event.preventDefault(); this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-dropdown-link>
                </form>
            </x-slot>
        </x-dropdown>
    </div>
</div>