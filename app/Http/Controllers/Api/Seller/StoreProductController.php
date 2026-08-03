<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class StoreProductController extends Controller
{
    private function getStore()
    {
        $store = Auth::user()->store;
        if (!$store) {
            abort(403, 'Anda belum memiliki toko.');
        }
        return $store;
    }

    public function index()
    {
        $store = $this->getStore();
        $products = Product::where('store_id', $store->id)->with('sizes')->get();
        return response()->json($products);
    }

    public function store(Request $request)
    {
        $store = $this->getStore();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|in:top,bottom,full_body',
            'description' => 'nullable|string'
        ]);

        $product = Product::create([
            'store_id' => $store->id,
            'name' => $validated['name'],
            'type' => $validated['type'],
            'description' => $validated['description'] ?? ''
        ]);

        return response()->json(['message' => 'Produk berhasil ditambahkan', 'product' => $product], 201);
    }

    public function show($id)
    {
        $store = $this->getStore();
        $product = Product::where('store_id', $store->id)->with('sizes')->findOrFail($id);
        return response()->json($product);
    }

    public function update(Request $request, $id)
    {
        $store = $this->getStore();
        $product = Product::where('store_id', $store->id)->findOrFail($id);

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'type' => 'sometimes|string|in:top,bottom,full_body',
            'description' => 'nullable|string'
        ]);

        $product->update($validated);

        return response()->json(['message' => 'Produk berhasil diperbarui', 'product' => $product]);
    }

    public function destroy($id)
    {
        $store = $this->getStore();
        $product = Product::where('store_id', $store->id)->findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
