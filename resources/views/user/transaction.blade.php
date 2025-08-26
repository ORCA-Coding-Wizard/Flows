<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Form Pembayaran') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4">

            {{-- Alert --}}
            @if (session('success'))
                <div class="bg-green-200 text-green-800 p-3 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-200 text-red-800 p-3 rounded mb-4">{{ session('error') }}</div>
            @endif

            @if ($transaction && $transaction->transactionDetails->count() > 0)
                <form method="POST" action="{{ route('user.transaksi.checkout', $transaction) }}">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                        @foreach ($transaction->transactionDetails as $detail)
                            <div class="border rounded-lg shadow p-4 bg-white">
                                <img src="{{ $detail->flower_id ? $detail->flower->image : $detail->bouquetPackage->bouquet->image }}"
                                    class="h-40 w-full object-cover rounded"
                                    alt="{{ $detail->flower_id ? $detail->flower->name : $detail->bouquetPackage->name }}">

                                <h3 class="text-lg font-semibold mt-2">
                                    {{ $detail->flower_id ? $detail->flower->name : $detail->bouquetPackage->name }}
                                </h3>

                                <p>Harga per item: Rp
                                    {{ number_format($detail->flower_id ? $detail->flower->price : $detail->bouquetPackage->price, 0, ',', '.') }}
                                </p>

                                {{-- Qty input --}}
                                <div class="mt-2 flex gap-2 items-center">
                                    <input type="number" min="1" value="{{ $detail->quantity }}"
                                        class="border rounded px-2 py-1 w-20 quantity-input"
                                        data-id="{{ $detail->id }}">
                                </div>

                                <p class="mt-2 font-semibold subtotal">
                                    Subtotal: Rp {{ number_format($detail->price, 0, ',', '.') }}
                                </p>
                            </div>
                        @endforeach
                    </div>

                    {{-- Total & Checkout --}}
                    <div class="mt-4 p-4 bg-gray-100 rounded flex justify-between items-center">
                        <h3 class="text-lg font-bold total">
                            Total: Rp {{ number_format($transaction->total_price, 0, ',', '.') }}
                        </h3>
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                            Bayar Sekarang
                        </button>
                    </div>
                </form>
            @else
                <p class="text-gray-500">Belum ada item untuk dibayar.</p>
            @endif
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const qtyInputs = document.querySelectorAll('.quantity-input');

            qtyInputs.forEach(input => {
                input.addEventListener('input', function() {
                    const detailId = this.dataset.id;
                    const quantity = parseInt(this.value) || 1;

                    fetch(`/user/transaksi/detail/${detailId}/update`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({ quantity })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            // Update subtotal
                            const subtotalElem = this.closest('div.border').querySelector('.subtotal');
                            subtotalElem.textContent = 'Subtotal: Rp ' + new Intl.NumberFormat('id-ID').format(data.subtotal);

                            // Update total
                            const totalElem = document.querySelector('.total');
                            totalElem.textContent = 'Total: Rp ' + new Intl.NumberFormat('id-ID').format(data.total);
                        }
                    })
                    .catch(err => console.error(err));
                });
            });
        });
    </script>
</x-app-layout>
