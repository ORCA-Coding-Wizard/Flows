<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter --}}
            <form method="GET" class="flex gap-2 mb-6 flex-wrap items-end">
                <div>
                    <label class="block text-sm font-medium">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}" class="px-3 py-2 border rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}" class="px-3 py-2 border rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Status</label>
                    <select name="status" class="px-3 py-2 border rounded">
                        <option value="">All</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="shipped" {{ request('status') == 'shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                </div>
                <div>
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded">Filter</button>
                </div>
            </form>

            {{-- Tabel Transaksi --}}
            <div class="overflow-x-auto">
                <table class="min-w-full border">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 border">ID</th>
                            <th class="px-4 py-2 border">User</th>
                            <th class="px-4 py-2 border">Items</th>
                            <th class="px-4 py-2 border">Total</th>
                            <th class="px-4 py-2 border">Keterangan</th>
                            <th class="px-4 py-2 border">Status</th>
                            <th class="px-4 py-2 border">Tanggal</th>
                            <th class="px-4 py-2 border">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $t)
                            <tr class="{{ $t->status == 'cancelled' ? 'bg-red-100' : '' }}">
                                <td class="px-4 py-2 border">{{ $t->id }}</td>
                                <td class="px-4 py-2 border">{{ $t->user->name }}</td>
                                <td class="px-4 py-2 border">
                                    @foreach ($t->transactionDetails as $d)
                                        @if ($d->flower_id)
                                            <div>Flower: {{ $d->flower->name }} (Qty: {{ $d->quantity }})</div>
                                        @elseif($d->bouquet_package_id)
                                            <div>Bouquet Package: {{ $d->bouquetPackage->name }} (Qty: {{ $d->quantity }})</div>

                                            {{-- Base Bouquet --}}
                                            @if($d->bouquetPackage && $d->bouquetPackage->bouquet)
                                                <div class="ml-4 text-sm">
                                                    Base Bouquet: {{ $d->bouquetPackage->bouquet->name }} (Qty: {{ $d->quantity }})
                                                </div>
                                            @endif

                                            {{-- List bunga di paket --}}
                                            @if ($d->bouquetPackage && $d->bouquetPackage->flowers)
                                                <ul class="list-decimal pl-5 text-sm">
                                                    @foreach ($d->bouquetPackage->flowers as $flower)
                                                        <li>{{ $flower->name }} (Rp {{ number_format($flower->price,0,',','.') }})</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        @endif
                                    @endforeach
                                </td>
                                <td class="px-4 py-2 border">
                                    Rp {{ number_format($t->transactionDetails->sum(fn($d) => $d->price * $d->quantity), 0, ',', '.') }}
                                </td>
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
                        @empty
                            <tr>
                                <td colspan="8" class="text-center px-4 py-2 border">Belum ada transaksi.</td>
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
