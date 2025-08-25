<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Flower;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil semua kategori beserta 3 flowers random per kategori
        $categories = Category::with(['flowers' => function($query) {
            $query->inRandomOrder()->take(3);
        }])->get();

        return view('user.dashboard', compact('categories'));
    }
}
