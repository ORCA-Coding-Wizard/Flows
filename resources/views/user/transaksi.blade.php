<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                    {{ session('error') }}
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">

                    <h3 class="font-semibold mb-4">Daftar Transaksi</h3>

                    @if($transactions->isEmpty())
                        <p>Belum ada transaksi.</p>
                    @else
                        <div class="space-y-4">
                            @foreach($transactions as $transaction)
                                <div class="border rounded p-4">
                                    <div class="flex justify-between items-center mb-2">
                                        <div>
                                            <span class="font-semibold">ID:</span> {{ $transaction->id }}<br>
                                            <span class="font-semibold">Tanggal:</span> {{ $transaction->created_at->format('d/m/Y H:i') }}<br>
                                            <span class="font-semibold">Status:</span> 
                                            @if($transaction->status === 'pending')
                                                <span class="text-yellow-500">{{ ucfirst($transaction->status) }}</span>
                                            @elseif($transaction->status === 'cancelled')
                                                <span class="text-red-500">{{ ucfirst($transaction->status) }}</span>
                                            @else
                                                <span class="text-green-500">{{ ucfirst($transaction->status) }}</span>
                                            @endif
                                        </div>

                                        @if($transaction->status === 'pending')
                                            <form action="{{ route('user.transaksi.cancel', $transaction->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                    class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 transition">
                                                    Cancel
                                                </button>
                                            </form>
                                        @endif
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="w-full text-sm text-left border">
                                            <thead class="bg-gray-100">
                                                <tr>
                                                    <th class="px-3 py-1 border">Item</th>
                                                    <th class="px-3 py-1 border">Qty</th>
                                                    <th class="px-3 py-1 border">Harga</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($transaction->transactionDetails as $detail)
                                                    <tr>
                                                        <td class="px-3 py-1 border">
                                                            @if($detail->flower_id)
                                                                {{ $detail->flower->name }}
                                                            @elseif($detail->bouquet_package_id)
                                                                {{ $detail->bouquetPackage->name }}
                                                            @endif
                                                        </td>
                                                        <td class="px-3 py-1 border">{{ $detail->quantity }}</td>
                                                        <td class="px-3 py-1 border">Rp. {{ number_format($detail->price, 0, ',', '.') }}</td>
                                                    </tr>
                                                @endforeach
                                                <tr class="font-semibold">
                                                    <td colspan="2" class="px-3 py-1 border text-right">Total</td>
                                                    <td class="px-3 py-1 border">Rp. {{ number_format($transaction->total_price, 0, ',', '.') }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
