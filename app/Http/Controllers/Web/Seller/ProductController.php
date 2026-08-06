<?php

namespace App\Http\Controllers\Web\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('seller.products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:top,bottom',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $user = Auth::user();
        $store = $user->store;

        if (!$store) {
            abort(403, 'Anda belum memiliki toko.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        $store->products()->create([
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'price' => $request->price,
            'image_path' => $imagePath,
        ]);

        return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $store = $user->store;

        $product = Product::where('store_id', $store->id)->with('sizes')->findOrFail($id);

        return view('seller.products.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:top,bottom',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $store = Auth::user()->store;
        $product = Product::where('store_id', $store->id)->findOrFail($id);
        
        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'description' => $request->description,
            'price' => $request->price,
        ];

        if ($request->hasFile('image')) {
            if ($product->image_path) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = Auth::user();
        $store = $user->store;

        $product = Product::where('store_id', $store->id)->findOrFail($id);
        $product->delete();

        return redirect()->route('seller.dashboard')->with('success', 'Produk berhasil dihapus.');
    }
}
