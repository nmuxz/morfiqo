@extends('layouts.app')

@section('title', 'Katalog Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Hero Section -->
    <div class="relative rounded-3xl overflow-hidden bg-gray-900 shadow-2xl mb-12 h-[400px]">
        <div class="absolute inset-0">
            <img src="https://images.unsplash.com/photo-1441984904996-e0b6ba687e04?q=80&w=2070&auto=format&fit=crop" alt="Fashion Cover" class="w-full h-full object-cover opacity-60">
        </div>
        <div class="relative z-10 flex flex-col items-center justify-center h-full text-center px-4">
            <h1 class="text-4xl md:text-6xl font-extrabold text-white tracking-tight mb-4 drop-shadow-lg">
                Temukan Ukuran Sempurna Anda
            </h1>
            <p class="text-lg md:text-xl text-gray-200 max-w-2xl font-light mb-8 drop-shadow-md">
                Tinggalkan keraguan saat berbelanja online. Teknologi Smart Sizing kami menganalisis profil tubuh Anda untuk mencocokkan pakaian yang pas secara presisi.
            </p>
            <a href="#katalog" class="bg-white text-gray-900 px-8 py-3 rounded-full font-semibold hover:bg-gray-100 transition-colors shadow-lg">
                Jelajahi Koleksi
            </a>
        </div>
    </div>

    <!-- Catalog Section -->
    <div id="katalog" class="mb-8">
        <h2 class="text-2xl font-bold text-gray-900 mb-2">Koleksi Terbaru</h2>
        <p class="text-gray-500 mb-8">Pakaian terbaik dari berbagai toko, siap dicocokkan dengan tubuh Anda.</p>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            @forelse ($products as $product)
                <a href="/products/{{ $product->id }}" class="group block">
                    <div class="relative bg-white rounded-2xl p-4 shadow-sm border border-gray-100 transition-all duration-300 hover:shadow-xl hover:-translate-y-1">
                        <!-- Image Placeholder -->
                        <div class="aspect-w-3 aspect-h-4 bg-gray-100 rounded-xl overflow-hidden mb-4 relative">
                            @php
                                // Random placeholder image based on ID
                                $imgId = 100 + $product->id;
                            @endphp
                            <img src="https://picsum.photos/id/{{ $imgId }}/400/500" alt="{{ $product->name }}" class="w-full h-full object-center object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <div class="absolute top-3 left-3">
                                <span class="bg-white/90 backdrop-blur-sm text-gray-900 text-xs font-bold px-2 py-1 rounded-lg uppercase tracking-wider shadow-sm">
                                    {{ $product->type }}
                                </span>
                            </div>
                        </div>

                        <div>
                            <p class="text-sm text-indigo-600 font-semibold mb-1">{{ $product->store->name ?? 'Toko Tidak Diketahui' }}</p>
                            <h3 class="text-lg font-bold text-gray-900 mb-1 truncate">{{ $product->name }}</h3>
                            <p class="text-gray-500 text-sm line-clamp-2">{{ $product->description }}</p>
                        </div>
                    </div>
                </a>
            @empty
                <div class="col-span-full py-12 text-center text-gray-500 bg-white rounded-2xl border border-gray-200 border-dashed">
                    <i class="fas fa-box-open text-4xl mb-3 text-gray-300"></i>
                    <p>Belum ada produk yang tersedia saat ini.</p>
                </div>
            @endforelse
        </div>
    </div>

</div>
@endsection
