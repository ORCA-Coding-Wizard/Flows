<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Transaction;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $transactions = Transaction::with([
            'user',
            'transactionDetails.flower',
            'transactionDetails.bouquetPackage.bouquet', // tambahan: base bouquet
            'transactionDetails.bouquetPackage.flowers' // bunga dalam paket
        ])->orderBy('created_at', 'desc')
            ->when($request->status, fn($q) => $q->where('status', $request->status))
            ->when($request->start_date, fn($q) => $q->whereDate('created_at', '>=', $request->start_date))
            ->when($request->end_date, fn($q) => $q->whereDate('created_at', '<=', $request->end_date))
            ->paginate(10);

        return view('admin.laporan', compact('transactions'));
    }

    public function updateStatus(Request $request, Transaction $transaction)
    {
        $status = $request->status;

        $allowedTransitions = [
            'pending' => 'shipped',
            'shipped' => 'completed',
        ];

        if (isset($allowedTransitions[$transaction->status]) && $allowedTransitions[$transaction->status] === $status) {
            $transaction->status = $status;
            $transaction->save();

            return redirect()->back()->with('success', "Status transaksi #{$transaction->id} berhasil diubah menjadi {$status}.");
        }

        return redirect()->back()->with('error', 'Status tidak valid atau tidak bisa diubah.');
    }
}
