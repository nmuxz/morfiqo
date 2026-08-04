@extends('layouts.app')

@section('title', 'Seller Dashboard')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="mb-8 flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Dashboard Penjual</h1>
            <p class="text-gray-500 mt-1">Kelola produk dan tabel ukuran (size chart) untuk toko <span class="font-semibold text-indigo-600">{{ $store->name }}</span>.</p>
        </div>
        <div class="mt-4 md:mt-0">
            <button class="bg-indigo-600 text-white px-6 py-2.5 rounded-lg shadow-sm hover:bg-indigo-700 transition-colors font-medium flex items-center cursor-not-allowed opacity-70" title="Fitur penambahan produk via UI sedang dalam pengembangan">
                <i class="fas fa-plus mr-2"></i> Tambah Produk
            </button>
        </div>
    </div>

    <!-- Product List -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-800">Daftar Produk Anda</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-white">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Produk</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tipe</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Tabel Ukuran</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($products as $product)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10 bg-indigo-100 rounded-lg flex items-center justify-center text-indigo-500">
                                    <i class="fas fa-tshirt"></i>
                                </div>
                                <div class="ml-4">
                                    <div class="text-sm font-bold text-gray-900">{{ $product->name }}</div>
                                    <div class="text-sm text-gray-500 truncate w-48" title="{{ $product->description }}">{{ $product->description }}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800 uppercase">
                                {{ $product->type }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <div class="flex flex-wrap gap-1">
                                @forelse($product->sizes as $size)
                                    <span class="inline-block bg-gray-100 border border-gray-200 text-gray-800 text-xs px-2 py-1 rounded shadow-sm" title="LD: {{ $size->chest_width_cm }}cm">
                                        {{ $size->size_label }}
                                    </span>
                                @empty
                                    <span class="text-sm text-red-500 italic">Belum ada ukuran</span>
                                @endforelse
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <a href="/products/{{ $product->id }}" class="text-indigo-600 hover:text-indigo-900 mr-3" title="Lihat di Halaman Pembeli">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-indigo-600 mr-3 cursor-not-allowed">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="#" class="text-gray-400 hover:text-red-600 cursor-not-allowed">
                                <i class="fas fa-trash"></i>
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-12 text-center">
                            <i class="fas fa-box-open text-4xl text-gray-300 mb-3"></i>
                            <p class="text-gray-500">Anda belum memiliki produk.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
@endsection
