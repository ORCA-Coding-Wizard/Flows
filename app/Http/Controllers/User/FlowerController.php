<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Flower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FlowerController extends Controller
{
    public function index(Request $request)
    {
        $query = Flower::query();
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $query->whereHas('category', function ($q) {
            $q->where('name', '!=', 'Special');
        });

        $flowers = $query->latest()->get();

        $categories = Category::where('name', '!=', 'Special')->get();

        return view('user.bunga', compact('flowers', 'categories'));
    }


    // tambah bunga ke cart
    public function addToCart(Flower $flower)
    {
        $exists = Cart::where('user_id', Auth::id())
            ->where('flower_id', $flower->id)
            ->exists();

        if ($exists) {
            return back()->with('error', 'Bunga ini sudah ada di keranjang kamu.');
        }

        Cart::create([
            'user_id' => Auth::id(),
            'flower_id' => $flower->id,
        ]);

        return back()->with('success', 'Bunga berhasil ditambahkan ke keranjang.');
    }
}
