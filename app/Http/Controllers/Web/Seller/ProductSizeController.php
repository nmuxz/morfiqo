<?php

namespace App\Http\Controllers\Web\Seller;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductSize;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductSizeController extends Controller
{
    public function store(Request $request, $productId)
    {
        $request->validate([
            'size_label' => 'required|string|max:50',
            'chest_width_cm' => 'required|numeric|min:1',
            'body_length_cm' => 'required|numeric|min:1',
            'stock' => 'required|integer|min:0',
        ]);

        $user = Auth::user();
        $store = $user->store;

        $product = Product::where('store_id', $store->id)->findOrFail($productId);

        $product->sizes()->create([
            'size_label' => $request->size_label,
            'chest_width_cm' => $request->chest_width_cm,
            'body_length_cm' => $request->body_length_cm,
            'stock' => $request->stock,
        ]);

        return back()->with('success', 'Ukuran berhasil ditambahkan.');
    }

    public function destroy($productId, $sizeId)
    {
        $user = Auth::user();
        $store = $user->store;

        $product = Product::where('store_id', $store->id)->findOrFail($productId);
        $size = ProductSize::where('product_id', $product->id)->findOrFail($sizeId);
        
        $size->delete();

        return back()->with('success', 'Ukuran berhasil dihapus.');
    }
}
