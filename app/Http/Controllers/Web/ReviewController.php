<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, $orderItemId)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        
        $orderItem = OrderItem::with('order')->findOrFail($orderItemId);

        // Pastikan order milik user ini dan statusnya delivered
        if ($orderItem->order->user_id !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        if ($orderItem->order->status !== 'delivered') {
            return back()->withErrors(['error' => 'Anda hanya bisa memberikan ulasan pada pesanan yang sudah selesai/dikirim.']);
        }

        // Cek apakah sudah pernah direview
        if ($orderItem->review) {
            return back()->withErrors(['error' => 'Anda sudah memberikan ulasan untuk item ini.']);
        }

        Review::create([
            'user_id' => $user->id,
            'product_id' => $orderItem->product_id,
            'order_item_id' => $orderItem->id,
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return back()->with('success', 'Ulasan berhasil ditambahkan! Terima kasih.');
    }
}
