<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Flower;
use App\Models\Category;
use App\Services\SupabaseStorageService;
use Illuminate\Http\Request;

class BungaController extends Controller
{
    protected SupabaseStorageService $storage;

    public function __construct(SupabaseStorageService $storage)
    {
        $this->storage = $storage;
    }

    // LIST SEMUA BUNGA
    public function index(Request $request)
    {
        $query = Flower::with('category');

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('q')) {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $bungas = $query->latest()->get();
        $categories = Category::all();

        return view('admin.bunga', compact('bungas', 'categories'));
    }

    // SIMPAN BUNGA (CREATE)
    public function store(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'required|image|max:2048',
        ]);

        $imageUrl = $this->storage->upload($request->file('image'), 'flowers/');

        Flower::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'image' => $imageUrl,
        ]);

        return redirect()->route('admin.bunga.index')->with('success', 'Bunga berhasil ditambahkan.');
    }

    // UPDATE BUNGA (EDIT)
    public function update(Request $request, Flower $bunga)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'price'       => 'required|integer|min:0',
            'category_id' => 'required|exists:categories,id',
            'image'       => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['name', 'price', 'category_id']);

        if ($request->hasFile('image')) {
            $this->storage->delete($bunga->image);
            $data['image'] = $this->storage->upload($request->file('image'), 'flowers/');
        }

        $bunga->update($data);

        return redirect()->route('admin.bunga.index')->with('success', 'Bunga berhasil diupdate.');
    }

    // HAPUS BUNGA
    public function destroy(Flower $bunga)
    {
        $this->storage->delete($bunga->image);
        $bunga->delete();

        return redirect()->route('admin.bunga.index')->with('success', 'Bunga berhasil dihapus.');
    }
}
