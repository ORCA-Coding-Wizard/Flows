<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Laporan Transaksi') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filter --}}
            <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4 mb-6 items-end">
                <div>
                    <label class="block text-sm font-medium">Start Date</label>
                    <input type="date" name="start_date" value="{{ request('start_date') }}"
                        class="mt-1 w-full px-3 py-2 border rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">End Date</label>
                    <input type="date" name="end_date" value="{{ request('end_date') }}"
                        class="mt-1 w-full px-3 py-2 border rounded">
                </div>
                <div>
                    <label class="block text-sm font-medium">Status</label>
                    <select name="status" class="mt-1 w-full px-3 py-2 border rounded">
                        <option value="">All</option>
                        <option value="pending" {{ request('status')=='pending' ? 'selected' : '' }}>Pending</option>
                        <option value="shipped" {{ request('status')=='shipped' ? 'selected' : '' }}>Shipped</option>
                        <option value="completed" {{ request('status')=='completed' ? 'selected' : '' }}>Completed
                        </option>
                        <option value="cancelled" {{ request('status')=='cancelled' ? 'selected' : '' }}>Cancelled
                        </option>
                    </select>
                </div>
                <div>
                    <button type="submit"
                        class="w-full px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition">Filter</button>
                </div>
            </form>

            {{-- Ringkasan --}}
            <div class="mb-4 text-right font-medium">
                Total Transaksi: <span class="text-lg">Rp {{ number_format($transactions->sum(fn($t) =>
                    $t->transactionDetails->sum(fn($d) => $d->price * $d->quantity)), 0, ',', '.') }}</span>
            </div>

            {{-- Tabel --}}
            <div class="overflow-x-auto rounded-lg border">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">ID</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">User</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Items</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Total</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Keterangan</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Status</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Tanggal</th>
                            <th class="px-4 py-2 text-left text-sm font-semibold text-gray-700">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @forelse($transactions as $t)
                        <tr class="hover:bg-gray-50 {{ $t->status == 'cancelled' ? 'bg-red-100' : '' }}">
                            <td class="px-4 py-2">{{ $t->id }}</td>
                            <td class="px-4 py-2">{{ $t->user->name }}</td>
                            <td class="px-4 py-2 space-y-1 text-sm">
                                @foreach ($t->transactionDetails as $d)
                                @if ($d->flower_id)
                                <div>🌸 {{ $d->flower->name }} (Qty: {{ $d->quantity }})</div>
                                @elseif($d->bouquet_package_id)
                                <div>💐 {{ $d->bouquetPackage->name }} (Qty: {{ $d->quantity }})</div>
                                @if($d->bouquetPackage && $d->bouquetPackage->flowers)
                                <ul class="list-decimal pl-5 text-xs text-gray-600">
                                    @foreach ($d->bouquetPackage->flowers as $flower)
                                    <li>{{ $flower->name }} (Rp {{ number_format($flower->price,0,',','.') }})</li>
                                    @endforeach
                                </ul>
                                @endif
                                @endif
                                @endforeach
                            </td>
                            <td class="px-4 py-2">Rp {{ number_format($t->transactionDetails->sum(fn($d) => $d->price *
                                $d->quantity),0,',','.') }}</td>
                            <td class="px-4 py-2">{{ $t->keterangan ?? '-' }}</td>
                            <td class="px-4 py-2">
                                @php
                                $statusColors = [
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'shipped' => 'bg-blue-100 text-blue-800',
                                'completed' => 'bg-green-100 text-green-800',
                                'cancelled' => 'bg-red-100 text-red-800'
                                ];
                                @endphp
                                <span
                                    class="px-2 py-1 rounded-full text-xs font-semibold {{ $statusColors[$t->status] ?? '' }}">
                                    {{ ucfirst($t->status) }}
                                </span>
                            </td>
                            <td class="px-4 py-2">{{ $t->created_at->format('d-m-Y H:i') }}</td>
                            <td class="px-4 py-2 space-y-1">
                                @if($t->status == 'pending')
                                <form action="{{ route('admin.transactions.updateStatus', $t->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="shipped">
                                    <button type="submit"
                                        class="w-full px-2 py-1 bg-yellow-500 text-white rounded hover:bg-yellow-600 transition text-xs">Set
                                        Shipped</button>
                                </form>
                                @elseif($t->status == 'shipped')
                                <form action="{{ route('admin.transactions.updateStatus', $t->id) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="completed">
                                    <button type="submit"
                                        class="w-full px-2 py-1 bg-green-600 text-white rounded hover:bg-green-700 transition text-xs">Set
                                        Completed</button>
                                </form>
                                @else
                                <span class="text-gray-500 text-xs">-</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="text-center px-4 py-2 text-gray-500">Belum ada transaksi.</td>
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