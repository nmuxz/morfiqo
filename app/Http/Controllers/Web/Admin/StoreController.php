<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Store;
use Illuminate\Http\Request;

class StoreController extends Controller
{
    public function index()
    {
        $stores = Store::with('user')->withCount('products')->orderBy('created_at', 'desc')->paginate(20);
        
        return view('admin.stores.index', compact('stores'));
    }
}
