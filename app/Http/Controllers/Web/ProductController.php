<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function show($id)
    {
        $product = Product::with(['store', 'sizes'])->findOrFail($id);
        
        // Pass to view
        return view('products.show', compact('product'));
    }
}
