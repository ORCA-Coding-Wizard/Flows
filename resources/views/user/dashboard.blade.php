<x-app-layout>
    {{-- NAVBAR (SEMUA SVG) --}}
    <header class="w-full bg-white shadow">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            {{-- kiri: menu + search --}}
            <div class="flex items-center gap-4 text-gray-800">
                {{-- menu (grid/list) --}}
                <button class="p-2 hover:text-gray-600" aria-label="Menu">
                    <svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M4 6h16M4 12h10M4 18h16" stroke-linecap="round"/>
                    </svg>
                </button>
                {{-- search --}}
                <button class="p-2 hover:text-gray-600" aria-label="Cari">
                    <svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="11" cy="11" r="7"/><path d="m21 21-3.6-3.6" stroke-linecap="round"/>
                    </svg>
                </button>
            </div>

            {{-- logo tengah (SVG) --}}
            <a href="{{ url('/') }}" class="inline-flex items-center select-none">
                <svg viewBox="0 0 280 60" class="h-10">
                    <!-- bunga -->
                    <g transform="translate(20,28) scale(1.1)" fill="none" stroke="#b91c1c" stroke-width="2">
                        <path d="M0-10c6-6 16-6 22 0-4 3-8 7-11 11-3-4-7-8-11-11z"/>
                        <path d="M11 1c-2 4-3 8-3 13M11 1c2 4 3 8 3 13" stroke="#14532d"/>
                        <circle cx="11" cy="-1" r="4" fill="#b91c1c" stroke="none"/>
                    </g>
                    <!-- teks FLOWS -->
                    <text x="70" y="36" font-size="32" font-family="Georgia, serif" fill="#14532d" letter-spacing="2">FLOWS</text>
                </svg>
            </a>

            {{-- kanan: wishlist + cart --}}
            <div class="flex items-center gap-4 text-gray-800">
                {{-- heart --}}
                <button class="p-2 hover:text-gray-600" aria-label="Wishlist">
                    <svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 21s-7-4.7-9.5-7.6A5.8 5.8 0 0 1 12 5a5.8 5.8 0 0 1 9.5 8.4C19 16.3 12 21 12 21Z" stroke-linejoin="round"/>
                    </svg>
                </button>
                {{-- cart --}}
                <button class="p-2 hover:text-gray-600" aria-label="Keranjang">
                    <svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="9" cy="20" r="1.5"/><circle cx="17" cy="20" r="1.5"/>
                        <path d="M3 4h2l2.4 10.2A2 2 0 0 0 9.3 16H17a2 2 0 0 0 2-1.6l1.2-6.4H6" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
    </header>

    {{-- HERO BANNER --}}
    <section class="w-full bg-gray-300 h-80 flex items-center justify-center">
        <p class="text-gray-600">[ Hero Banner Slider ]</p>
    </section>

    {{-- CATEGORY NAV (FLOWERS | PLANTS | GIFTS) --}}
    <section class="py-12 bg-white">
        <div class="max-w-5xl mx-auto grid grid-cols-3 gap-8 text-center">
            <a href="#" class="group flex flex-col items-center gap-2">
                {{-- flower icon --}}
                <svg viewBox="0 0 24 24" class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M12 13c-2 0-3.5-1.6-3.5-3.5S10 6 12 6s3.5 1.6 3.5 3.5S14 13 12 13Z"/>
                    <path d="M12 13c0 4-3 5-3 7h6c0-2-3-3-3-7Z" />
                    <path d="M7 9c0-2-1.5-3-3-3 0 2 1.5 3 3 3Zm10 0c0-2 1.5-3 3-3 0 2-1.5 3-3 3Z"/>
                </svg>
                <span class="font-bold tracking-wide">FLOWERS</span>
                <span class="group-hover:translate-x-1 transition">
                    <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M13 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>

            <a href="#" class="group flex flex-col items-center gap-2">
                {{-- leaf icon --}}
                <svg viewBox="0 0 24 24" class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M20 4c-8 0-12 5-12 11a5 5 0 0 0 10 0c0-2 .5-6 2-11Z" />
                    <path d="M8 15c2-1 5-2 8-2" stroke-linecap="round"/>
                </svg>
                <span class="font-bold tracking-wide">PLANTS</span>
                <span class="group-hover:translate-x-1 transition">
                    <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M13 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>

            <a href="#" class="group flex flex-col items-center gap-2">
                {{-- gift icon --}}
                <svg viewBox="0 0 24 24" class="w-12 h-12" fill="none" stroke="currentColor" stroke-width="1.5">
                    <path d="M3 9h18v11H3z"/><path d="M12 9v11M3 9h18M7 9V7a2 2 0 1 1 4 0v2M13 9V7a2 2 0 1 1 4 0v2" stroke-linecap="round"/>
                </svg>
                <span class="font-bold tracking-wide">GIFTS</span>
                <span class="group-hover:translate-x-1 transition">
                    <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M5 12h14M13 5l7 7-7 7" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </span>
            </a>
        </div>
    </section>

    {{-- SECTION PRODUK (3x, ikon wishlist+cart pakai SVG) --}}
    @foreach (['FLOWERS' => 'BUNGA X', 'PLANTS' => 'x', 'GIFTS' => 'BOUQUET'] as $kategori => $produk)
    <section class="py-12">
        <h2 class="text-center text-2xl font-bold mb-8">{{ $kategori }}</h2>
        <div class="max-w-6xl mx-auto grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-8">
            @foreach (range(1,3) as $i)
            <div class="bg-gray-300 relative rounded">
                {{-- wishlist + cart --}}
                <div class="absolute top-2 right-2 flex gap-2 text-gray-800">
                    <button class="bg-white/80 rounded p-1 hover:text-gray-600" aria-label="Suka">
                        <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6">
                            <path d="M12 21s-7-4.7-9.5-7.6A5.8 5.8 0 0 1 12 5a5.8 5.8 0 0 1 9.5 8.4C19 16.3 12 21 12 21Z" stroke-linejoin="round"/>
                        </svg>
                    </button>
                    <button class="bg-white/80 rounded p-1 hover:text-gray-600" aria-label="Keranjang">
                        <svg viewBox="0 0 24 24" class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.6">
                            <circle cx="9" cy="20" r="1.5"/><circle cx="17" cy="20" r="1.5"/>
                            <path d="M3 4h2l2.4 10.2A2 2 0 0 0 9.3 16H17a2 2 0 0 0 2-1.6l1.2-6.4H6" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </button>
                </div>
                <div class="h-56 bg-gray-400"></div>
                <div class="bg-gray-700 text-white py-4 px-4">
                    <p class="font-semibold">{{ $produk }}</p>
                    <p>Rp. x.xxx.xxx</p>
                </div>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-6">
            <a href="#"
               class="px-6 py-2 bg-gray-400 text-white rounded hover:bg-gray-500 transition">
               View All
            </a>
        </div>
    </section>
    @endforeach

    {{-- FOOTER: HUBUNGI KAMI (SVG WA & IG) --}}
    <footer class="bg-gray-900 text-white py-12 mt-16">
        <div class="max-w-7xl mx-auto px-6 grid md:grid-cols-2 gap-8 items-center">
            {{-- logo svg lagi --}}
            <div class="text-center md:text-left">
                <div class="inline-flex items-center mb-3">
                    <svg viewBox="0 0 280 60" class="h-10">
                        <g transform="translate(20,28) scale(1.1)" fill="none" stroke="#fca5a5" stroke-width="2">
                            <path d="M0-10c6-6 16-6 22 0-4 3-8 7-11 11-3-4-7-8-11-11z"/>
                            <path d="M11 1c-2 4-3 8-3 13M11 1c2 4 3 8 3 13" stroke="#86efac"/>
                            <circle cx="11" cy="-1" r="4" fill="#fca5a5" stroke="none"/>
                        </g>
                        <text x="70" y="36" font-size="32" font-family="Georgia, serif" fill="#86efac" letter-spacing="2">FLOWS</text>
                    </svg>
                </div>
                <p class="text-gray-400">Toko bunga & tanaman untuk momen spesial Anda 🌸</p>
            </div>

            {{-- Hubungi Kami --}}
            <div class="text-center md:text-right">
                <h4 class="text-lg font-semibold mb-4">Hubungi Kami</h4>
                <div class="flex md:justify-end justify-center gap-6">
                    {{-- WhatsApp --}}
                    <a href="https://wa.me/6281234567890" target="_blank" class="flex items-center gap-2 hover:text-green-400">
                        <svg viewBox="0 0 24 24" class="w-6 h-6" fill="currentColor">
                            <path d="M20.5 3.5A11 11 0 0 0 3.3 18.6L2 22l3.6-1.2A11 11 0 1 0 20.5 3.5Zm-8.9 15a9 9 0 0 1-4.6-1.3l-.3-.2-2.7.9.9-2.6-.2-.3A9 9 0 1 1 11.6 18.5Zm5-4.3c-.3-.2-1.6-.8-1.8-.9s-.4-.2-.6.2-.7.9-.9 1.1-.3.2-.6.1a7.4 7.4 0 0 1-2.2-1.4 8.2 8.2 0 0 1-1.5-1.8c-.2-.3 0-.5.1-.7l.3-.4c.1-.2.2-.3.3-.5s0-.4 0-.5l-.9-2.2c-.2-.5-.4-.5-.7-.5h-.6a1.1 1.1 0 0 0-.8.4 3.3 3.3 0 0 0-1.1 2.4 5.7 5.7 0 0 0 1.2 3.1 12.9 12.9 0 0 0 5 4.7 17.1 17.1 0 0 0 1.7.6 4.1 4.1 0 0 0 1.8.1 3 3 0 0 0 2-1.4 2.5 2.5 0 0 0 .2-1.4c-.1-.1-.3-.2-.6-.3Z"/>
                        </svg>
                        <span>WhatsApp</span>
                    </a>
                    {{-- Instagram --}}
                    <a href="https://instagram.com/flows_id" target="_blank" class="flex items-center gap-2 hover:text-pink-400">
                        <svg viewBox="0 0 24 24" class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="1.6">
                            <rect x="3" y="3" width="18" height="18" rx="5" />
                            <circle cx="12" cy="12" r="3.5"/>
                            <circle cx="17.5" cy="6.5" r="1.2" fill="currentColor" stroke="none"/>
                        </svg>
                        <span>Instagram</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="mt-8 text-center text-gray-500 text-sm">© {{ date('Y') }} Flows. All rights reserved.</div>
    </footer>
</x-app-layout>
