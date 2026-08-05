<?php

namespace App\Http\Controllers\Web\Seller;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $store = $user->store;

        $orders = Order::where('store_id', $store->id)
            ->with('items.product', 'items.size', 'user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('seller.orders.index', compact('orders'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,delivered,cancelled'
        ]);

        $user = Auth::user();
        $store = $user->store;

        $order = Order::where('store_id', $store->id)->findOrFail($id);
        $order->update(['status' => $request->status]);

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
