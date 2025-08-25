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
                            <th class="px-4 py-2 border">Harga</th>
                            <th class="px-4 py-2 border">Total</th>
                            <th class="px-4 py-2 border">Keterangan</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $t)
                            @foreach($t->details as $d)
                                <tr>
                                    <td class="px-4 py-2 border">{{ $t->id }}</td>
                                    <td class="px-4 py-2 border">{{ $t->user->name }}</td>
                                    <td class="px-4 py-2 border">
                                        @if ($d->flower_id)
                                            Flower: {{ $d->flower->name }}
                                        @elseif($d->bouquet_package_id)
                                            Bouquet: {{ $d->bouquetPackage->name }}
                                        @endif
                                    </td>
                                    <td class="px-4 py-2 border">{{ $d->quantity }}</td>
                                    <td class="px-4 py-2 border">Rp {{ number_format($d->price,0,',','.') }}</td>
                                    <td class="px-4 py-2 border">Rp {{ number_format($d->quantity * $d->price,0,',','.') }}</td>
                                    <td class="px-4 py-2 border">{{ $t->keterangan ?? '-' }}</td>
                                    <td class="px-4 py-2 border">{{ ucfirst($t->status) }}</td>
                                    <td class="px-4 py-2 border">{{ $t->created_at->format('d-m-Y H:i') }}</td>
                                    <td class="px-4 py-2 border">
                                        @if($t->status == 'pending')
                                            <form action="{{ route('admin.transactions.updateStatus', $t->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="shipped">
                                                <button type="submit" class="px-2 py-1 bg-yellow-500 text-white rounded">Set Shipped</button>
                                            </form>
                                        @elseif($t->status == 'shipped')
                                            <form action="{{ route('admin.transactions.updateStatus', $t->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="status" value="completed">
                                                <button type="submit" class="px-2 py-1 bg-green-600 text-white rounded">Set Completed</button>
                                            </form>
                                        @else
                                            <span class="text-gray-500">-</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="10" class="text-center px-4 py-2 border">Belum ada transaksi.</td>
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
