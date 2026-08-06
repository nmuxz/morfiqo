<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Store;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalUsers = User::count();
        $totalStores = Store::count();
        $totalOrders = Order::count();
        
        // Count total orders value, or fallback to count
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total_amount'); // Although price is mocked as 0 for now

        $recentOrders = Order::with('user', 'store')->orderBy('created_at', 'desc')->take(5)->get();
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalStores', 'totalOrders', 'totalRevenue', 'recentOrders', 'recentUsers'));
    }
}
