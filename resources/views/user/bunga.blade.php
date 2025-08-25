<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Bunga') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 py-6">
            <h1 class="text-2xl font-bold mb-6">Daftar Bunga</h1>

            {{-- Alert --}}
            @if (session('success'))
                <div class="bg-green-200 text-green-800 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-200 text-red-800 p-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            {{-- Search & Filter --}}
            <form method="GET" action="{{ route('user.flowers.index') }}" class="flex gap-4 mb-6">
                {{-- search --}}
                <input type="text" name="search" placeholder="Cari bunga..." value="{{ request('search') }}"
                    class="border rounded px-3 py-2 w-full" />

                {{-- kategori --}}
                <select name="category" class="border rounded px-3 py-2" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}"
                            {{ request('category') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </form>


            {{-- Grid bunga --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                @forelse ($flowers as $flower)
                    <div class="border rounded-lg shadow p-4 relative bg-white">
                        {{-- cart icon --}}
                        <div class="absolute top-2 right-2">
                            <form action="{{ route('user.flowers.addToCart', $flower) }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-white/80 rounded p-1 text-gray-700 hover:text-blue-600 shadow"
                                    aria-label="Keranjang">
                                    <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor"
                                        stroke-width="1.6">
                                        <circle cx="9" cy="20" r="1.5" />
                                        <circle cx="17" cy="20" r="1.5" />
                                        <path d="M3 4h2l2.4 10.2A2 2 0 0 0 9.3 16H17a2 2 0 0 0 2-1.6l1.2-6.4H6"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </button>
                            </form>
                        </div>

                        {{-- image --}}
                        <img src="{{ $flower->image }}" alt="{{ $flower->name }}"
                            class="w-full h-48 object-cover rounded">

                        {{-- info --}}
                        <h3 class="text-lg font-semibold mt-2">{{ $flower->name }}</h3>
                        <p class="text-gray-600">Rp {{ number_format($flower->price, 0, ',', '.') }}</p>

                        {{-- actions --}}
                        <div class="mt-3">
                            {{-- beli langsung --}}
                            <form action="#" method="POST">
                                @csrf
                                <button type="submit"
                                    class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
                                    Beli Sekarang
                                </button>
                            </form>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Tidak ada bunga ditemukan.</p>
                @endforelse
            </div>

        </div>
    </div>
</x-app-layout>
