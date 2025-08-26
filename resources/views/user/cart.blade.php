<x-app-layout>
    <div class="max-w-5xl mx-auto py-12">
        <h1 class="text-2xl font-bold mb-6">Keranjang Saya</h1>

        <div class="overflow-x-auto">
            <table class="w-full text-left border border-gray-200">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="p-3">Produk</th>
                        <th class="p-3">Harga</th>
                        <th class="p-3">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($carts as $cart)
                        <tr class="border-t hover:bg-gray-50">
                            <td class="p-3">{{ $cart->flower->name }}</td>
                            <td class="p-3">Rp. {{ number_format($cart->flower->price, 0, ',', '.') }}</td>
                            <td class="p-3 flex gap-2">

                                {{-- Beli satu item → addToSessionCart --}}
                                <a href="{{ route('user.addToSessionCart', $cart->id) }}"
                                    class="px-3 py-1 bg-green-500 hover:bg-green-600 text-white rounded transition">
                                    Beli
                                </a>

                                {{-- Hapus item --}}
                                <div x-data="{ open: false }">
                                    <button @click="open = true"
                                        class="px-3 py-1 bg-red-500 hover:bg-red-600 text-white rounded transition">
                                        Hapus
                                    </button>

                                    <!-- Modal konfirmasi hapus -->
                                    <div x-show="open" x-transition
                                        class="fixed inset-0 flex items-center justify-center z-50">
                                        <div class="absolute inset-0 bg-black opacity-30"></div>
                                        <div class="bg-white rounded shadow-lg p-6 z-50 max-w-sm w-full">
                                            <h2 class="text-lg font-semibold mb-4">Konfirmasi Hapus</h2>
                                            <p class="mb-6">Apakah Anda yakin ingin menghapus
                                                <strong>{{ $cart->flower->name }}</strong> dari keranjang?
                                            </p>
                                            <div class="flex justify-end gap-3">
                                                <button @click="open = false"
                                                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400 transition">Batal</button>
                                                <form method="POST"
                                                    action="{{ route('user.cart.remove', $cart->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                        class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600 transition">Hapus</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($carts->count() > 0)
            {{-- Beli semua item → addAllCartToSession --}}
            <a href="{{ route('user.addAllCartToSession') }}"
                class="mt-6 inline-block text-right px-6 py-2 bg-blue-500 hover:bg-blue-600 text-white rounded transition">
                Beli Semua
            </a>
        @endif

        @if ($carts->isEmpty())
            <p class="text-gray-500 mt-6 text-center">Keranjang Anda masih kosong 😢</p>
        @endif
    </div>
</x-app-layout>
