@extends('layouts.app')

@section('title', 'Checkout')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex items-center justify-between">
        <h1 class="text-3xl font-bold text-gray-900">Checkout</h1>
        <a href="{{ route('cart.index') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Keranjang
        </a>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden mb-8">
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-800">Ringkasan Pesanan</h2>
        </div>
        <div class="p-6">
            <ul class="divide-y divide-gray-100">
                @foreach($cart->items as $item)
                <li class="py-4 flex justify-between items-center">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 mr-4">
                            <i class="fas fa-tshirt"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-gray-900">{{ $item->product->name }}</h4>
                            <p class="text-sm text-gray-500">Ukuran: {{ $item->size->size_label }} | Toko: {{ $item->product->store->name }}</p>
                        </div>
                    </div>
                    <div class="font-medium text-gray-700">
                        x{{ $item->quantity }}
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    <form action="{{ route('checkout.process') }}" method="POST">
        @csrf
        <div class="bg-indigo-50 rounded-2xl p-6 border border-indigo-100">
            <h3 class="text-lg font-bold text-indigo-900 mb-2">Simulasi Pembayaran & Pengiriman</h3>
            <p class="text-indigo-700 text-sm mb-6">Karena ini adalah purwarupa (prototype), klik tombol di bawah untuk langsung menyelesaikan pesanan. Stok produk akan otomatis terpotong.</p>
            
            <button type="submit" class="w-full bg-indigo-600 text-white py-4 rounded-xl font-bold text-lg hover:bg-indigo-700 shadow-xl transition-transform transform hover:-translate-y-1">
                <i class="fas fa-check-circle mr-2"></i> Konfirmasi Pesanan
            </button>
        </div>
    </form>
</div>
@endsection
