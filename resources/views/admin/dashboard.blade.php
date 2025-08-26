<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12 max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

        {{-- Greeting --}}
        <div
            class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
            {{ __("Welcome back, Admin!") }}
        </div>

        {{-- Statistik Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-6 gap-6">

            {{-- Total Transaksi --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Transaksi</h3>
                <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalTransactions }}</p>
            </div>

            {{-- Total Users --}}
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Users</h3>
                <p class="mt-2 text-2xl font-bold text-gray-900 dark:text-gray-100">{{ $totalUsers }}</p>
            </div>

            {{-- Pending --}}
            <div class="bg-yellow-100 p-6 rounded-lg shadow">
                <h3 class="text-sm font-medium text-yellow-800">Pending Orders</h3>
                <p class="mt-2 text-2xl font-bold text-yellow-900">{{ $pendingTransactions }}</p>
            </div>

            {{-- Shipped --}}
            <div class="bg-blue-100 p-6 rounded-lg shadow">
                <h3 class="text-sm font-medium text-blue-800">Shipped Orders</h3>
                <p class="mt-2 text-2xl font-bold text-blue-900">{{ $shippedTransactions }}</p>
            </div>

            {{-- Completed --}}
            <div class="bg-green-100 p-6 rounded-lg shadow">
                <h3 class="text-sm font-medium text-green-800">Completed Orders</h3>
                <p class="mt-2 text-2xl font-bold text-green-900">{{ $completedTransactions }}</p>
            </div>

            {{-- Cancelled --}}
            <div class="bg-red-100 p-6 rounded-lg shadow">
                <h3 class="text-sm font-medium text-red-800">Cancelled Orders</h3>
                <p class="mt-2 text-2xl font-bold text-red-900">{{ $cancelledTransactions }}</p>
            </div>
        </div>

        {{-- Ringkasan Pendapatan --}}
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 mt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Pendapatan Total</h3>
            <p class="text-2xl font-bold text-gray-900 dark:text-gray-100">Rp {{ number_format($totalRevenue,0,',','.')
                }}</p>
        </div>

        {{-- Pie Chart Status Transaksi --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Status Transaksi</h3>
            <canvas id="transactionStatusChart" height="150"></canvas>
        </div>

        {{-- Line Chart Pendapatan Bulanan --}}
        <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow mt-6">
            <h3 class="text-lg font-semibold text-gray-800 dark:text-gray-100 mb-4">Pendapatan Bulanan</h3>
            <canvas id="monthlyRevenueChart" height="150"></canvas>
        </div>

    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Pie Chart Status Transaksi
        const ctx = document.getElementById('transactionStatusChart').getContext('2d');
        new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: ['Pending', 'Shipped', 'Completed', 'Cancelled'],
                datasets: [{
                    label: 'Transaksi',
                    data: [
                        {{ $pendingTransactions }},
                        {{ $shippedTransactions }},
                        {{ $completedTransactions }},
                        {{ $cancelledTransactions }}
                    ],
                    backgroundColor: ['#FBBF24','#3B82F6','#22C55E','#EF4444'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                  aspectRatio: 4,
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // Line Chart Pendapatan Bulanan
        const ctx2 = document.getElementById('monthlyRevenueChart').getContext('2d');
        new Chart(ctx2, {
            type: 'line',
            data: {
                labels: {!! json_encode(array_keys($monthlyRevenue->toArray())) !!},
                datasets: [{
                    label: 'Pendapatan',
                    data: {!! json_encode(array_values($monthlyRevenue->toArray())) !!},
                    borderColor: '#3B82F6',
                    backgroundColor: 'rgba(59,130,246,0.2)',
                    fill: true,
                    tension: 0.3
                }]
            },
            options: { responsive: true }
        });
    </script>
    @endpush

</x-app-layout>