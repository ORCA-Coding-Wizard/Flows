<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Total transaksi
        $totalTransactions = Transaction::count();

        // Total user
        $totalUsers = User::count();

        // Transaksi berdasarkan status
        $pendingTransactions = Transaction::where('status', 'pending')->count();
        $shippedTransactions = Transaction::where('status', 'shipped')->count();
        $completedTransactions = Transaction::where('status', 'completed')->count();
        $cancelledTransactions = Transaction::where('status', 'cancelled')->count();

        // Total pendapatan
        $totalRevenue = Transaction::sum('total_price');

        // Pendapatan bulanan (PostgreSQL)
        $monthlyRevenue = Transaction::selectRaw("EXTRACT(MONTH FROM created_at) as month, SUM(total_price) as total")
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total','month');

        return view('admin.dashboard', compact(
            'totalTransactions',
            'totalUsers',
            'pendingTransactions',
            'shippedTransactions',
            'completedTransactions',
            'cancelledTransactions',
            'totalRevenue',
            'monthlyRevenue'
        ));
    }
}
