<?php

namespace App\Http\Controllers\Api\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Support\Facades\Auth;

class ProductSizeController extends Controller
{
    private function getStore()
    {
        $store = Auth::user()->store;
        if (!$store) {
            abort(403, 'Anda belum memiliki toko.');
        }
        return $store;
    }

    public function store(Request $request, $productId)
    {
        $store = $this->getStore();
        
        // Pastikan produk milik store ini
        $product = Product::where('store_id', $store->id)->findOrFail($productId);

        $validated = $request->validate([
            'size_label' => 'required|string|max:10',
            'chest_width_cm' => 'required|numeric|min:0',
            'body_length_cm' => 'required|numeric|min:0',
            'waist_width_cm' => 'nullable|numeric|min:0',
            'hips_width_cm' => 'nullable|numeric|min:0',
            'inseam_cm' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $validated['product_id'] = $product->id;

        $productSize = ProductSize::create($validated);

        return response()->json([
            'message' => 'Ukuran berhasil ditambahkan',
            'size' => $productSize
        ], 201);
    }

    public function destroy($productId, $sizeId)
    {
        $store = $this->getStore();
        
        $product = Product::where('store_id', $store->id)->findOrFail($productId);
        
        $size = ProductSize::where('product_id', $product->id)->findOrFail($sizeId);
        $size->delete();

        return response()->json(['message' => 'Ukuran berhasil dihapus']);
    }
}
