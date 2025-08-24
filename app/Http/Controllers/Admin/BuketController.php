<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Bouquet;
use Illuminate\Http\Request;
use App\Services\SupabaseStorageService;

class BuketController extends Controller
{
    protected SupabaseStorageService $storage;

    public function __construct(SupabaseStorageService $storage)
    {
        $this->storage = $storage;
    }

    public function index(Request $request)
    {
        $query = Bouquet::query();

        if ($request->has('q') && $request->q != '') {
            $query->where('name', 'like', '%' . $request->q . '%');
        }

        $bouquets = $query->latest()->paginate(12);

        return view('admin.buket', compact('bouquets'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|integer|min:0',
            'capacity' => 'required|integer|min:0',
            'image'    => 'required|image|max:5120',
        ]);

        $imageUrl = $this->storage->upload($request->file('image'), 'bouquets/');

        Bouquet::create([
            'name'     => $request->name,
            'price'    => $request->price,
            'capacity' => $request->capacity,
            'image'    => $imageUrl,
        ]);

        return redirect()->back()->with('success', 'Bouquet berhasil ditambahkan!');
    }

    public function update(Request $request, Bouquet $buket)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'price'    => 'required|integer|min:0',
            'capacity' => 'required|integer|min:0',
            'image'    => 'nullable|image|max:5120',
        ]);

        if ($request->hasFile('image')) {
            $this->storage->delete($buket->image);
            $buket->image = $this->storage->upload($request->file('image'), 'bouquets/');
        }

        $buket->name     = $request->name;
        $buket->price    = $request->price;
        $buket->capacity = $request->capacity;
        $buket->save();

        return redirect()->back()->with('success', 'Bouquet berhasil diupdate!');
    }

    public function destroy(Bouquet $buket)
    {
        $this->storage->delete($buket->image);
        $buket->delete();

        return redirect()->back()->with('success', 'Bouquet berhasil dihapus!');
    }
}
