<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;

use App\Models\Category;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('store');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where('name', 'ilike', '%' . $search . '%')
                  ->orWhere('description', 'ilike', '%' . $search . '%');
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->latest()->get();
        $categories = Category::orderBy('name')->get();

        return view('home', compact('products', 'categories'));
    }
}
