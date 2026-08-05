@extends('layouts.app')

@section('title', 'Keranjang Belanja')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Keranjang Belanja</h1>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-md">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    @endif
    @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-md">
            <ul class="list-disc pl-5 text-sm text-red-700 space-y-1">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if($cart->items->count() > 0)
        <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Ukuran</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @foreach($cart->items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap flex items-center">
                                <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 mr-4">
                                    <i class="fas fa-image text-2xl"></i>
                                </div>
                                <div>
                                    <h3 class="font-bold text-gray-900">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $item->product->store->name }}</p>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="font-bold text-indigo-600 border border-indigo-200 bg-indigo-50 px-3 py-1 rounded-md">
                                    {{ $item->size->size_label }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center font-medium">
                                {{ $item->quantity }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                <form action="{{ route('cart.destroy', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-2" onclick="return confirm('Hapus dari keranjang?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div class="p-6 bg-gray-50 border-t border-gray-200 flex justify-between items-center">
                <a href="/" class="text-indigo-600 font-medium hover:underline"><i class="fas fa-arrow-left mr-2"></i>Lanjut Belanja</a>
                <a href="{{ route('checkout.index') }}" class="bg-gray-900 text-white px-8 py-3 rounded-xl font-bold hover:bg-gray-800 transition-colors shadow-lg">Checkout Sekarang</a>
            </div>
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-200">
            <div class="text-gray-300 mb-4">
                <i class="fas fa-shopping-cart text-6xl"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Keranjang Anda Kosong</h2>
            <p class="text-gray-500 mb-6">Mulai pilih produk dan temukan ukuran terbaik dengan AI Smart Sizing.</p>
            <a href="/" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-medium hover:bg-indigo-700 transition-colors inline-block">Belanja Sekarang</a>
        </div>
    @endif
</div>
@endsection
