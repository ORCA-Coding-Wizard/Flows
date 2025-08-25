<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Bouquet;
use App\Models\BouquetPackage;
use App\Models\Category;
use App\Models\Flower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BouquetController extends Controller
{
public function index()
{
    $bouquets = Bouquet::all();

    // Ambil category 'flower'
    $flowerCategory = Category::where('name', 'Flower')->first();

    // Ambil semua flower dengan category 'flower' saja
    $flowers = Flower::where('category_id', $flowerCategory->id)->get();

    $packages = BouquetPackage::with('bouquet', 'flowers')
        ->where('user_id', Auth::id())
        ->get();

    return view('user.buketmu', compact('bouquets', 'flowers', 'packages'));
}


    public function store(Request $request)
    {
        $request->validate([
            'bouquet_id' => 'required|exists:bouquets,id',
            'name' => 'required|string|max:255',
            'flowers' => 'required|array|min:1',
            'flowers.*' => 'exists:flowers,id',
        ]);

        $bouquet = Bouquet::findOrFail($request->bouquet_id);

        // cek jumlah bunga tidak melebihi kapasitas
        if (count($request->flowers) > $bouquet->capacity) {
            return response()->json([
                'message' => "Jumlah bunga tidak boleh lebih dari {$bouquet->capacity}"
            ], 422);
        }

        // generate signature untuk kombinasi bunga
        $signature = md5(implode(',', $request->flowers));

        // cek signature unik per user
        $exists = BouquetPackage::where('user_id', Auth::id())
            ->where('signature', $signature)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => "Anda sudah membuat bouquet dengan kombinasi bunga yang sama!"
            ], 422);
        }

        // hitung harga
        $selectedFlowers = Flower::whereIn('id', $request->flowers)->get();
        $avgPrice = $selectedFlowers->avg('price');
        $price = round($avgPrice * $bouquet->capacity + 20000);

        // simpan bouquet package
        $package = BouquetPackage::create([
            'bouquet_id' => $bouquet->id,
            'user_id' => Auth::id(),
            'name' => $request->name,
            'price' => $price,
            'signature' => $signature,
        ]);

        // attach flowers ke pivot table
        $package->flowers()->attach($request->flowers);

        // load relationship flowers supaya front-end langsung dapat
        $package->load('flowers', 'bouquet');

        return response()->json([
            'message' => 'Bouquet package berhasil dibuat!',
            'package' => $package
        ]);
    }

    public function update(Request $request, BouquetPackage $package)
    {
        $request->validate([
            'bouquet_id' => 'required|exists:bouquets,id',
            'name' => 'required|string|max:255',
            'flowers' => 'required|array|min:1',
            'flowers.*' => 'exists:flowers,id',
        ]);

        $bouquet = Bouquet::findOrFail($request->bouquet_id);

        if (count($request->flowers) > $bouquet->capacity) {
            return response()->json([
                'message' => "Jumlah bunga tidak boleh lebih dari {$bouquet->capacity}"
            ], 422);
        }

        $signature = md5(implode(',', $request->flowers));

        $exists = BouquetPackage::where('user_id', Auth::id())
            ->where('signature', $signature)
            ->where('id', '!=', $package->id)
            ->exists();

        if ($exists) {
            return response()->json([
                'message' => "Bouquet package dengan kombinasi bunga sama sudah ada!"
            ], 422);
        }

        $selectedFlowers = Flower::whereIn('id', $request->flowers)->get();
        $avgPrice = $selectedFlowers->avg('price');
        $price = round($avgPrice * $bouquet->capacity + 20000);

        $package->update([
            'bouquet_id' => $bouquet->id,
            'name' => $request->name,
            'price' => $price,
            'signature' => $signature,
        ]);

        // update flowers
        $package->flowers()->sync($request->flowers);

        $package->load('flowers', 'bouquet');

        return response()->json([
            'message' => 'Bouquet package berhasil diupdate!',
            'package' => $package
        ]);
    }

    public function destroy(BouquetPackage $package)
    {
        $package->flowers()->detach(); // pastikan pivot dibersihkan
        $package->delete();

        return response()->json([
            'message' => 'Bouquet package berhasil dihapus!'
        ]);
    }
}
