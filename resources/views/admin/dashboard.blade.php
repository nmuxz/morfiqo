@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Super Admin Dashboard</h1>
        <p class="text-gray-500 mt-1">Ringkasan statistik dan aktivitas platform Morfiqo.</p>
    </div>

    <!-- Statistik Utama -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Users -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center">
            <div class="w-14 h-14 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 text-2xl mr-4">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Pengguna</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalUsers) }}</h3>
            </div>
        </div>

        <!-- Total Stores -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center">
            <div class="w-14 h-14 rounded-xl bg-purple-50 flex items-center justify-center text-purple-600 text-2xl mr-4">
                <i class="fas fa-store"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Toko</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalStores) }}</h3>
            </div>
        </div>

        <!-- Total Orders -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center">
            <div class="w-14 h-14 rounded-xl bg-green-50 flex items-center justify-center text-green-600 text-2xl mr-4">
                <i class="fas fa-shopping-bag"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Transaksi</p>
                <h3 class="text-2xl font-bold text-gray-900">{{ number_format($totalOrders) }}</h3>
            </div>
        </div>

        <!-- Total Revenue -->
        <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 flex items-center">
            <div class="w-14 h-14 rounded-xl bg-yellow-50 flex items-center justify-center text-yellow-600 text-2xl mr-4">
                <i class="fas fa-wallet"></i>
            </div>
            <div>
                <p class="text-sm font-medium text-gray-500 mb-1">Total Nilai Transaksi</p>
                <h3 class="text-2xl font-bold text-gray-900">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <!-- Dua Kolom -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        <!-- Transaksi Terbaru -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Transaksi Terbaru</h3>
                <a href="{{ route('admin.orders.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentOrders as $order)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <div>
                                <span class="font-bold text-gray-900">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-gray-500 text-sm ml-2">{{ $order->created_at->diffForHumans() }}</span>
                            </div>
                            @if($order->status == 'pending')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-yellow-100 text-yellow-800">Pending</span>
                            @elseif($order->status == 'processing')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-800">Processing</span>
                            @elseif($order->status == 'shipped')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-indigo-100 text-indigo-800">Shipped</span>
                            @elseif($order->status == 'delivered')
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-green-100 text-green-800">Delivered</span>
                            @else
                                <span class="px-2 py-1 text-xs font-semibold rounded bg-red-100 text-red-800">Cancelled</span>
                            @endif
                        </div>
                        <p class="text-sm text-gray-600">Pembeli: <span class="font-medium">{{ $order->user->name }}</span></p>
                        <p class="text-sm text-gray-600">Toko: <span class="font-medium">{{ $order->store->name }}</span></p>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500 text-sm">Belum ada transaksi di platform.</div>
                @endforelse
            </div>
        </div>

        <!-- Pengguna Baru -->
        <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                <h3 class="text-lg font-bold text-gray-900">Pengguna Baru Bergabung</h3>
                <a href="{{ route('admin.users.index') }}" class="text-sm text-indigo-600 hover:text-indigo-800 font-medium">Lihat Semua</a>
            </div>
            <div class="divide-y divide-gray-50">
                @forelse($recentUsers as $user)
                    <div class="p-6 flex items-center justify-between hover:bg-gray-50 transition-colors">
                        <div class="flex items-center">
                            <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold mr-4">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <p class="font-bold text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xs text-gray-500">{{ $user->created_at->format('d M Y') }}</div>
                            <div class="mt-1">
                                @if($user->hasRole('super_admin'))
                                    <span class="px-2 py-0.5 text-xs rounded bg-red-100 text-red-800">Admin</span>
                                @elseif($user->hasRole('store_owner'))
                                    <span class="px-2 py-0.5 text-xs rounded bg-purple-100 text-purple-800">Penjual</span>
                                @else
                                    <span class="px-2 py-0.5 text-xs rounded bg-blue-100 text-blue-800">Pembeli</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500 text-sm">Belum ada pengguna.</div>
                @endforelse
            </div>
        </div>

    </div>
</div>
@endsection
