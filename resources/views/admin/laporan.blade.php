<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter Tanggal --}}
            <form method="GET" class="flex gap-2 mb-6">
                <input type="date" name="start_date" value="{{ request('start_date') }}"
                    class="px-3 py-2 border rounded">
                <input type="date" name="end_date" value="{{ request('end_date') }}"
                    class="px-3 py-2 border rounded">
                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
            </form>

            {{-- Tabel Transaksi --}}
            <div class="overflow-x-auto">
                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">User</th>
                            <th class="px-4 py-2 border">Item</th>
                            <th class="px-4 py-2 border">Qty</th>
                            <th class="px-4 py-2 border">Total</th>
                            <th class="px-4 py-2 border">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $t)
                            <tr>
                                <td class="px-4 py-2 border">{{ $t->id }}</td>
                                <td class="px-4 py-2 border">{{ $t->user->name }}</td>
                                <td class="px-4 py-2 border">
                                    @if ($t->flower_id)
                                        Flower: {{ $t->flower->name }}
                                    @elseif($t->bouquet_package_id)
                                        Bouquet: {{ $t->bouquetPackage->name }}
                                    @endif
                                </td>
                                <td class="px-4 py-2 border">{{ $t->quantity }}</td>
                                <td class="px-4 py-2 border">Rp {{ number_format($t->total_price, 0, ',', '.') }}</td>
                                <td class="px-4 py-2 border">{{ $t->created_at->format('d-m-Y H:i') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center px-4 py-2 border">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="mt-4">
                {{ $transactions->withQueryString()->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
