<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'Flows') }}</title>

     <link rel="icon" type="image/x-icon" href="{{ asset('favicon.png') }}">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    <!-- Styles / Scripts -->
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>

<body class="bg-[#FDFDFC] min-h-screen flex flex-col">
    <!-- Navbar -->
    <nav class="w-full bg-white shadow-md">
        <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">
            <a href="/">
                <x-application-logo class="w-10 h-10 fill-current text-[#E15A4F]" />
            </a>
            <div class="space-x-4">
                @guest
                <!-- Login -->
                <a href="{{ route('login') }}" class="px-4 py-2 border border-[#706F6C] text-[#706F6C] rounded-lg shadow 
                          hover:bg-[#706F6C] hover:text-white transition">
                    Login
                </a>
                <!-- Register -->
                <a href="{{ route('register') }}" class="px-4 py-2 bg-[#E15A4F] text-white rounded-lg shadow 
                          hover:bg-[#C94B42] transition">
                    Register
                </a>
                @endguest

                @auth
                <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-[#E15A4F] text-white rounded-lg shadow 
                          hover:bg-[#C94B42] transition">
                    Dashboard
                </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section
        class="flex-1 flex items-center justify-center text-center px-6 py-32 bg-gradient-to-b from-[#FDFDFC] to-[#FFD1D1]">
        <div>
            <h1 class="text-6xl md:text-7xl font-bold text-[#2C3539] mb-6">
                Beli Bunga dengan Mudah 🌸
            </h1>
            <p class="text-xl text-[#706F6C] mb-10">
                Pesan rangkaian bunga indah untuk momen spesial Anda.
            </p>
            <a href="{{ route('register') }}"
                class="px-8 py-4 bg-[#E15A4F] text-white rounded-2xl shadow-lg hover:bg-[#C94B42] transition">
                Mulai Sekarang
            </a>
        </div>
    </section>

    <!-- Kategori Bunga Section -->
    <section class="py-20 bg-[#FFD1D1]/40">
        <div class="max-w-7xl mx-auto px-6">
            <h2 class="text-4xl font-bold text-center text-[#2C3539] mb-12">Kategori Bunga</h2>
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8">

                <!-- Wedding -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition overflow-hidden">
                    <img src="https://source.unsplash.com/500x400/?wedding,flowers" alt="Wedding Flowers"
                        class="w-full h-60 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-[#E15A4F] mb-2">Wedding</h3>
                        <p class="text-[#706F6C] mb-4">
                            Rangkaian elegan untuk hari pernikahan spesial.
                        </p>
                        <a href="#"
                            class="inline-block px-4 py-2 bg-[#E15A4F] text-white rounded-lg hover:bg-[#C94B42] transition">
                            Lihat Koleksi
                        </a>
                    </div>
                </div>

                <!-- Graduation -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition overflow-hidden">
                    <img src="https://source.unsplash.com/500x400/?graduation,flowers" alt="Graduation Flowers"
                        class="w-full h-60 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-[#E15A4F] mb-2">Graduation</h3>
                        <p class="text-[#706F6C] mb-4">
                            Hadiah penuh kebanggaan untuk wisuda dan kelulusan.
                        </p>
                        <a href="#"
                            class="inline-block px-4 py-2 bg-[#E15A4F] text-white rounded-lg hover:bg-[#C94B42] transition">
                            Lihat Koleksi
                        </a>
                    </div>
                </div>

                <!-- Anniversary -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition overflow-hidden">
                    <img src="https://source.unsplash.com/500x400/?anniversary,flowers" alt="Anniversary Flowers"
                        class="w-full h-60 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-[#E15A4F] mb-2">Anniversary</h3>
                        <p class="text-[#706F6C] mb-4">
                            Rangkaian romantis untuk merayakan cinta yang abadi.
                        </p>
                        <a href="#"
                            class="inline-block px-4 py-2 bg-[#E15A4F] text-white rounded-lg hover:bg-[#C94B42] transition">
                            Lihat Koleksi
                        </a>
                    </div>
                </div>

                <!-- Custom -->
                <div class="bg-white rounded-2xl shadow-lg hover:shadow-xl transition overflow-hidden">
                    <img src="https://source.unsplash.com/500x400/?custom,flowers" alt="Custom Flowers"
                        class="w-full h-60 object-cover">
                    <div class="p-6">
                        <h3 class="text-xl font-semibold text-[#E15A4F] mb-2">Custom</h3>
                        <p class="text-[#706F6C] mb-4">
                            Rangkaian bunga sesuai permintaan untuk momen spesial Anda.
                        </p>
                        <a href="#"
                            class="inline-block px-4 py-2 bg-[#E15A4F] text-white rounded-lg hover:bg-[#C94B42] transition">
                            Chat Admin
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </section>



    <!-- Features Section -->
    <section class="py-20 bg-[#FDFDFC]">
        <div class="max-w-6xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-[#2C3539] mb-12">Kenapa Memilih Flows?</h2>
            <div class="grid md:grid-cols-3 gap-10">
                <div class="p-8 bg-white rounded-2xl shadow-md hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold text-[#E15A4F] mb-4">Kualitas Premium</h3>
                    <p class="text-[#706F6C]">Bunga segar pilihan langsung dari petani terbaik.</p>
                </div>
                <div class="p-8 bg-white rounded-2xl shadow-md hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold text-[#E15A4F] mb-4">Pengiriman Cepat</h3>
                    <p class="text-[#706F6C]">Pesanan diantar dalam hitungan jam, bukan hari.</p>
                </div>
                <div class="p-8 bg-white rounded-2xl shadow-md hover:shadow-lg transition">
                    <h3 class="text-xl font-semibold text-[#E15A4F] mb-4">Pesan Mudah</h3>
                    <p class="text-[#706F6C]">Proses order simpel hanya dalam beberapa klik.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonial Section -->
    <section class="py-20 bg-[#FFD1D1]">
        <div class="max-w-4xl mx-auto px-6 text-center">
            <h2 class="text-4xl font-bold text-[#2C3539] mb-12">Apa Kata Mereka?</h2>
            <div class="grid md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow">
                    <p class="text-[#706F6C] italic">"Bunga dari Flows selalu segar dan indah. Cocok banget buat
                        hadiah."</p>
                    <h4 class="mt-4 font-semibold text-[#E15A4F]">— Sinta, Jakarta</h4>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow">
                    <p class="text-[#706F6C] italic">"Pengiriman cepat dan pelayanan ramah. Saya pasti pesan lagi!"</p>
                    <h4 class="mt-4 font-semibold text-[#E15A4F]">— Andi, Bandung</h4>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-16 bg-[#FDFDFC] border-t">
        <div class="max-w-4xl mx-auto px-6">
            <h2 class="text-3xl font-bold text-center text-[#2C3539] mb-12">Pertanyaan Umum</h2>
            <div class="space-y-6">
                <details class="p-4 border border-gray-200 rounded-lg">
                    <summary class="cursor-pointer font-semibold text-[#E15A4F]">Berapa lama pengiriman?</summary>
                    <p class="mt-2 text-[#706F6C]">Pengiriman biasanya memakan waktu 2-4 jam tergantung lokasi Anda.</p>
                </details>
                <details class="p-4 border border-gray-200 rounded-lg">
                    <summary class="cursor-pointer font-semibold text-[#E15A4F]">Apakah bisa custom buket?</summary>
                    <p class="mt-2 text-[#706F6C]">Ya, Anda bisa request jenis bunga & desain sesuai keinginan.</p>
                </details>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="w-full bg-white text-center py-6 text-sm text-[#706F6C] border-t">
        © {{ date('Y') }} {{ config('app.name', 'Flows') }}. All rights reserved.
    </footer>
</body>

</html>