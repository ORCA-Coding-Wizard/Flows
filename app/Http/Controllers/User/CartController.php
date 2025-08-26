<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $carts = Cart::with('flower')->where('user_id', Auth::id())->get();
        return view('user.cart', compact('carts'));
    }

    public function remove(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Item dihapus dari keranjang!');
    }

    public function checkoutOne(Cart $cart)
    {
        $cart->delete();
        return back()->with('success', 'Item berhasil dibeli!');
    }


    // Beli semua item
    public function checkoutAll()
    {
        $carts = Cart::with('flower')->where('user_id', Auth::id())->get();

        Cart::where('user_id', Auth::id())->delete();

        return back()->with('success', 'Semua item berhasil dibeli!');
    }

    public function add($flowerId)
    {
        $user = Auth::user();


        // Cek kalau item sudah ada di cart
        $cart = Cart::where('user_id', $user->id)->where('flower_id', $flowerId)->first();
        if (!$cart) {
            Cart::create([
                'user_id' => $user->id,
                'flower_id' => $flowerId,
                'quantity' => 1,
            ]);
        }

        return back()->with('success', 'Produk berhasil ditambahkan ke keranjang!');
    }
}
