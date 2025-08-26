<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Flower;
use App\Models\BouquetPackage;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Daftar transaksi user (pending & completed)
     */
    public function index()
    {
        $user = auth()->user();
        $transactions = Transaction::where('users_id', $user->id)
            ->with('transactionDetails.flower', 'transactionDetails.bouquetPackage.bouquet')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('user.transaksi', compact('transactions'));
    }

    public function cancel(Transaction $transaction)
    {
        $user = auth()->user();

        if ($transaction->users_id !== $user->id) {
            abort(403);
        }

        if ($transaction->status !== 'pending') {
            return redirect()->back()->with('error', 'Hanya transaksi pending yang bisa dibatalkan.');
        }

        $transaction->status = 'cancelled';
        $transaction->save();

        return redirect()->back()->with('success', 'Transaksi berhasil dibatalkan.');
    }


    /**
     * Detail transaksi
     */
    public function show(Transaction $transaction)
    {
        $user = auth()->user();
        if ($transaction->users_id !== $user->id) abort(403);

        $transaction->load('transactionDetails.flower', 'transactionDetails.bouquetPackage.bouquet');

        return view('user.transaction', compact('transaction'));
    }

    /**
     * Checkout transaksi
     * Hanya hapus cart yang item-nya masuk ke transaksi ini
     */
    public function checkout(Transaction $transaction)
    {
        $user = auth()->user();
        if ($transaction->users_id !== $user->id) abort(403);

        if ($transaction->transactionDetails->count() == 0) {
            return redirect()->back()->with('error', 'Tidak ada item untuk dibayar.');
        }

        $transaction->status = 'pending';
        $transaction->save();

        foreach ($transaction->transactionDetails as $detail) {
            if ($detail->flower_id) {
                Cart::where('user_id', $user->id)
                    ->where('flower_id', $detail->flower_id)
                    ->delete();
            }
        }

        return redirect()->route('user.transaksi', $transaction)
            ->with('success', 'Transaksi berhasil dibayar.');
    }

    public function updateDetail(Request $request, $detailId)
    {
        $detail = TransactionDetail::findOrFail($detailId);
        if ($detail->transaction->users_id !== auth()->id()) abort(403);

        $quantity = max(1, intval($request->quantity));
        $detail->quantity = $quantity;

        $price = $detail->flower_id ? $detail->flower->price : $detail->bouquetPackage->price;
        $detail->price = $quantity * $price;
        $detail->save();

        $transaction = $detail->transaction;
        $transaction->total_price = $transaction->transactionDetails->sum('price');
        $transaction->save();

        return response()->json([
            'success' => true,
            'subtotal' => $detail->price,
            'total' => $transaction->total_price
        ]);
    }

    /**
     * Beli bunga → selalu transaksi baru
     */
    public function buyFlower(Flower $flower)
    {
        $user = auth()->user();

        $transaction = Transaction::create([
            'users_id' => $user->id,
            'status' => 'pending',
            'total_price' => 0
        ]);

        $transaction->transactionDetails()->create([
            'flower_id' => $flower->id,
            'quantity' => 1,
            'price' => $flower->price,
        ]);

        $transaction->total_price = $transaction->transactionDetails->sum('price');
        $transaction->save();

        return redirect()->route('user.transaksi.show', $transaction)
            ->with('success', 'Bunga berhasil ditambahkan ke transaksi.');
    }

    /**
     * Beli bouquet → selalu transaksi baru
     */
    public function buyBouquet($packageId)
    {
        $user = auth()->user();
        $package = BouquetPackage::findOrFail($packageId);

        $transaction = Transaction::create([
            'users_id' => $user->id,
            'status' => 'pending',
            'total_price' => 0
        ]);

        $transaction->transactionDetails()->create([
            'bouquet_package_id' => $package->id,
            'quantity' => 1,
            'price' => $package->price,
        ]);

        $transaction->total_price = $transaction->transactionDetails->sum('price');
        $transaction->save();

        return response()->json([
            'success' => true,
            'transaction_id' => $transaction->id
        ]);
    }

    /**
     * Beli satu item dari cart → transaksi baru
     */
    public function buyFromCart($cartId)
    {
        $user = auth()->user();
        $cart = Cart::findOrFail($cartId);
        if ($cart->user_id !== $user->id) abort(403);

        $transaction = Transaction::create([
            'users_id' => $user->id,
            'status' => 'pending',
            'total_price' => 0
        ]);

        $transaction->transactionDetails()->create([
            'flower_id' => $cart->flower_id,
            'quantity' => $cart->quantity ?? 1,
            'price' => ($cart->quantity ?? 1) * $cart->flower->price,
        ]);

        $transaction->total_price = $transaction->transactionDetails->sum('price');
        $transaction->save();

        // jangan hapus cart di sini
        // $cart->delete();

        return redirect()->route('user.transaksi.show', $transaction)
            ->with('success', 'Item berhasil ditambahkan ke transaksi.');
    }


    /**
     * Beli semua item dari cart → transaksi baru
     */
    public function buyAllFromCart()
    {
        $user = auth()->user();
        $carts = Cart::where('user_id', $user->id)->get();
        if ($carts->isEmpty()) return redirect()->back()->with('error', 'Keranjang kosong!');

        $transaction = Transaction::create([
            'users_id' => $user->id,
            'status' => 'pending',
            'total_price' => 0
        ]);

        foreach ($carts as $cart) {
            $transaction->transactionDetails()->create([
                'flower_id' => $cart->flower_id,
                'quantity' => $cart->quantity ?? 1,
                'price' => ($cart->quantity ?? 1) * $cart->flower->price,
            ]);
        }

        $transaction->total_price = $transaction->transactionDetails->sum('price');
        $transaction->save();

        return redirect()->route('user.transaksi.show', $transaction)
            ->with('success', 'Semua item berhasil ditambahkan ke transaksi.');
    }
}
