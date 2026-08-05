<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('items.product.store', 'items.size')->first();

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->withErrors(['error' => 'Keranjang Anda kosong.']);
        }

        return view('checkout.index', compact('cart'));
    }

    public function process(Request $request)
    {
        $user = Auth::user();
        $cart = Cart::where('user_id', $user->id)->with('items.product', 'items.size')->first();

        if (!$cart || $cart->items->count() === 0) {
            return redirect()->route('cart.index')->withErrors(['error' => 'Keranjang kosong.']);
        }

        // Group items by store because each store needs its own order
        $itemsByStore = $cart->items->groupBy(function ($item) {
            return $item->product->store_id;
        });

        DB::beginTransaction();

        try {
            foreach ($itemsByStore as $storeId => $items) {
                // Create an order for this store
                $order = Order::create([
                    'user_id' => $user->id,
                    'store_id' => $storeId,
                    'status' => 'pending',
                    'total_amount' => 0, // We will update this if we had real prices
                ]);

                foreach ($items as $item) {
                    $size = $item->size;
                    
                    // Verify stock
                    if ($size->stock < $item->quantity) {
                        throw new \Exception("Stok tidak mencukupi untuk produk: " . $item->product->name . " (Ukuran: " . $size->size_label . ")");
                    }

                    // Deduct stock
                    $size->decrement('stock', $item->quantity);

                    // Create order item
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_size_id' => $item->product_size_id,
                        'quantity' => $item->quantity,
                        'price' => 0, // Mock price
                    ]);
                }
            }

            // Empty the cart
            $cart->items()->delete();

            DB::commit();

            return redirect()->route('orders.index')->with('success', 'Pesanan Anda berhasil dibuat!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->withErrors(['error' => $e->getMessage()]);
        }
    }
}
