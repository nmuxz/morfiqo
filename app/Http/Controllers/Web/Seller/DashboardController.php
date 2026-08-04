<?php

namespace App\Http\Controllers\Web\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $store = $user->store;
        
        if (!$store) {
            abort(403, 'Anda belum memiliki toko.');
        }

        $products = Product::where('store_id', $store->id)->with('sizes')->latest()->get();

        return view('seller.dashboard', compact('store', 'products'));
    }
}
