<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Flower;
use App\Models\BouquetPackage;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $transactions = Transaction::where('users_id', $user->id)->latest()->get();
        return view('user.transaksi', compact('transactions'));
    }   

    public function cancel(Transaction $transaction)
    {
        // Hanya batalkan jika status masih pending
        if ($transaction->status != 'pending') {
            return redirect()->back()->with('error', 'Transaksi tidak bisa dibatalkan.');
        }

        $transaction->update(['status' => 'canceled']);

        return redirect()->back()->with('success', 'Transaksi berhasil dibatalkan.');
    }


    // Tambah bunga ke session
    public function addToSessionFlower(Flower $flower)
    {
        session()->forget('transaction_items');
        $items = session()->get('transaction_items', []);

        $items[] = [
            'type' => 'flower',
            'id' => $flower->id,
            'name' => $flower->name,
            'quantity' => 1,
            'price' => $flower->price,
            'subtotal' => $flower->price,
            'image' => $flower->image,
            'extra' => null
        ];

        session(['transaction_items' => $items]);

        return redirect()->route('user.transaction.showSession');
    }

    // Tambah bouquet ke session
    public function addToSessionBouquet(Request $request, $packageId)
    {
        session()->forget('transaction_items');
        $package = BouquetPackage::findOrFail($packageId);
        $items = session()->get('transaction_items', []);

        $items[] = [
            'type' => 'bouquet',
            'id' => $package->id,
            'name' => $package->name,
            'quantity' => 1,
            'price' => $package->price,
            'subtotal' => $package->price,
            'image' => $package->bouquet->image,
            'extra' => null
        ];

        session(['transaction_items' => $items]);

        return response()->json([
            'success' => true,
            'redirect' => route('user.transaction.showSession') // berikan URL untuk redirect di JS
        ]);
    }

    // Tambah papan ke session
    public function addToSessionPapan()
    {
        session()->forget('transaction_items');
        $specialCategory = Category::where('name', 'Special')->firstOrFail();
        $flowerPapan = Flower::where('category_id', $specialCategory->id)->firstOrFail();

        $items = session()->get('transaction_items', []);

        $items[] = [
            'type' => 'papan',
            'id' => $flowerPapan->id,
            'name' => $flowerPapan->name,
            'quantity' => 1,
            'price' => $flowerPapan->price,
            'subtotal' => $flowerPapan->price,
            'image' => asset('images/special/papan.png'),
            'extra' => [
                'keterangan' => 'Congratulation',
                'tujuan' => ''
            ]
        ];

        session(['transaction_items' => $items]);

        return redirect()->route('user.transaction.showSession');
    }

    public function addToSessionCart($cartId)
    {
        session()->forget('transaction_items');
        $cart = Cart::with('flower')->findOrFail($cartId);
        $items = session()->get('transaction_items', []);

        $items[] = [
            'type' => 'flower',
            'id' => $cart->flower->id,
            'name' => $cart->flower->name,
            'quantity' => 1,
            'price' => $cart->flower->price,
            'subtotal' => $cart->flower->price,
            'image' => $cart->flower->image,
            'extra' => null,
            'cart_id' => $cart->id, // untuk hapus cart setelah checkout
        ];

        session(['transaction_items' => $items]);

        return redirect()->route('user.transaction.showSession');
    }

    // Tambah semua cart ke session
    public function addAllCartToSession()
    {
        session()->forget('transaction_items');
        $carts = Cart::with('flower')->where('user_id', auth()->id())->get();
        if ($carts->isEmpty()) {
            return redirect()->back()->with('error', 'Keranjang kosong.');
        }

        $items = session()->get('transaction_items', []);

        foreach ($carts as $cart) {
            $items[] = [
                'type' => 'flower',
                'id' => $cart->flower->id,
                'name' => $cart->flower->name,
                'quantity' => 1,
                'price' => $cart->flower->price,
                'subtotal' => $cart->flower->price,
                'image' => $cart->flower->image,
                'extra' => null,
                'cart_id' => $cart->id,
            ];
        }

        session(['transaction_items' => $items]);

        return redirect()->route('user.transaction.showSession');
    }


    // Lihat session transaction
    public function showSession()
    {
        $items = session()->get('transaction_items', []);
        return view('user.transaction', compact('items'));
    }

    // Update quantity session item (AJAX)
    public function updateSessionItem(Request $request, $index)
    {
        $items = session()->get('transaction_items', []);
        if (!isset($items[$index])) abort(404);

        $quantity = max(1, intval($request->quantity));
        $items[$index]['quantity'] = $quantity;
        $items[$index]['subtotal'] = $items[$index]['price'] * $quantity;

        session(['transaction_items' => $items]);

        $total = array_sum(array_column($items, 'subtotal'));

        return response()->json([
            'success' => true,
            'subtotal' => $items[$index]['subtotal'],
            'total' => $total
        ]);
    }

    // Update papan keterangan dan tujuan (AJAX)
    public function updatePapanExtra(Request $request, $index)
    {
        $items = session()->get('transaction_items', []);
        if (!isset($items[$index]) || $items[$index]['type'] != 'papan') abort(404);

        $items[$index]['extra'] = [
            'keterangan' => $request->keterangan,
            'tujuan' => $request->tujuan
        ];

        session(['transaction_items' => $items]);

        return response()->json(['success' => true]);
    }

    // Checkout dari session → buat transaksi DB
    public function checkoutSession()
    {
        $user = auth()->user();
        $items = session()->get('transaction_items', []);
        if (empty($items)) return redirect()->back()->with('error', 'Belum ada item untuk dibayar.');

        $papanItem = collect($items)->firstWhere('type', 'papan');
        $keteranganPapan = $papanItem ? ($papanItem['extra']['keterangan'] . ', Ditujukan ke: ' . $papanItem['extra']['tujuan']) : null;

        $transaction = Transaction::create([
            'users_id' => $user->id,
            'status' => 'pending',
            'total_price' => array_sum(array_column($items, 'subtotal')),
            'keterangan' => $keteranganPapan,
        ]);

        foreach ($items as $item) {
            $transaction->transactionDetails()->create([
                'flower_id' => $item['type'] === 'flower' || $item['type'] === 'papan' ? $item['id'] : null,
                'bouquet_package_id' => $item['type'] === 'bouquet' ? $item['id'] : null,
                'quantity' => $item['quantity'],
                'price' => $item['subtotal'],
                'product_type' => $item['type']
            ]);

            // Hapus cart yang dibeli
            if (isset($item['cart_id'])) {
                Cart::find($item['cart_id'])?->delete();
            }
        }

        session()->forget('transaction_items');

        $transactions = Transaction::where('users_id', $user->id)->latest()->get();
        return view('user.transaksi', [
            'transactions' => $transactions,
            'success' => 'Transaksi berhasil dibuat!'
        ]);
    }
}
