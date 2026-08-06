@extends('layouts.app')

@section('title', 'Pesanan Saya')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Riwayat Pesanan Saya</h1>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-md">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    @if($orders->count() > 0)
        <div class="space-y-6">
            @foreach($orders as $order)
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="p-6 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                        <div>
                            <p class="text-sm text-gray-500">Nomor Pesanan: <span class="font-bold text-gray-900">#{{ str_pad($order->id, 5, '0', STR_PAD_LEFT) }}</span></p>
                            <p class="text-sm text-gray-500">Tanggal: {{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            @if($order->status == 'pending')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-yellow-100 text-yellow-800">Menunggu Diproses</span>
                            @elseif($order->status == 'processing')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Sedang Diproses</span>
                            @elseif($order->status == 'shipped')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-indigo-100 text-indigo-800">Dalam Pengiriman</span>
                            @elseif($order->status == 'delivered')
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Selesai</span>
                            @else
                                <span class="px-3 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Dibatalkan</span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="p-6">
                        <p class="font-bold text-gray-800 mb-4">Toko: <span class="text-indigo-600">{{ $order->store->name }}</span></p>
                        <ul class="divide-y divide-gray-100">
                            @foreach($order->items as $item)
                                <li class="py-4 border-b border-gray-100 last:border-0">
                                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center">
                                        <div class="flex items-center">
                                            <div class="w-12 h-12 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-400 mr-4">
                                                @if($item->product->image_path)
                                                    <img src="{{ asset('storage/' . $item->product->image_path) }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover rounded-lg">
                                                @else
                                                    <i class="fas fa-tshirt"></i>
                                                @endif
                                            </div>
                                            <div>
                                                <h4 class="font-bold text-gray-900">{{ $item->product->name }}</h4>
                                                <p class="text-sm text-gray-500">Ukuran: {{ optional($item->size)->size_label }} <span class="mx-1">|</span> x{{ $item->quantity }}</p>
                                            </div>
                                        </div>
                                        <div class="mt-4 sm:mt-0 font-medium text-gray-900">
                                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                                        </div>
                                    </div>
                                    
                                    @if($order->status == 'delivered')
                                        <div class="mt-4 bg-gray-50 p-4 rounded-xl border border-gray-100">
                                            @if($item->review)
                                                <div class="flex items-start">
                                                    <div class="mr-3 text-yellow-400">
                                                        @for($i = 1; $i <= 5; $i++)
                                                            <i class="fas fa-star {{ $i <= $item->review->rating ? '' : 'text-gray-300' }}"></i>
                                                        @endfor
                                                    </div>
                                                    <div>
                                                        <p class="text-sm text-gray-700 italic">"{{ $item->review->comment }}"</p>
                                                        <p class="text-xs text-gray-500 mt-1">Diulas pada {{ $item->review->created_at->format('d M Y') }}</p>
                                                    </div>
                                                </div>
                                            @else
                                                <form action="{{ route('reviews.store', $item->id) }}" method="POST" class="flex flex-col sm:flex-row items-start sm:items-center gap-3">
                                                    @csrf
                                                    <div class="flex-shrink-0">
                                                        <select name="rating" required class="block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                                            <option value="">Pilih Rating...</option>
                                                            <option value="5">⭐⭐⭐⭐⭐ Sangat Bagus</option>
                                                            <option value="4">⭐⭐⭐⭐ Bagus</option>
                                                            <option value="3">⭐⭐⭐ Lumayan</option>
                                                            <option value="2">⭐⭐ Buruk</option>
                                                            <option value="1">⭐ Sangat Buruk</option>
                                                        </select>
                                                    </div>
                                                    <input type="text" name="comment" placeholder="Tulis ulasan Anda (opsional)..." class="flex-1 block w-full text-sm border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                                    <button type="submit" class="w-full sm:w-auto bg-indigo-600 text-white px-4 py-2 rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors">
                                                        Kirim Ulasan
                                                    </button>
                                                </form>
                                                @error('error') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                                            @endif
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-16 bg-white rounded-2xl shadow-sm border border-gray-200">
            <div class="text-gray-300 mb-4">
                <i class="fas fa-box-open text-6xl"></i>
            </div>
            <h2 class="text-xl font-bold text-gray-900 mb-2">Belum Ada Pesanan</h2>
            <p class="text-gray-500 mb-6">Anda belum pernah melakukan pemesanan.</p>
            <a href="/" class="bg-indigo-600 text-white px-8 py-3 rounded-xl font-medium hover:bg-indigo-700 transition-colors inline-block">Belanja Sekarang</a>
        </div>
    @endif
</div>
@endsection
