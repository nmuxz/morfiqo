@extends('layouts.app')

@section('title', 'Edit Produk')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-8">
        <a href="{{ route('seller.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-3xl font-bold text-gray-900 mt-4">Edit Produk: {{ $product->name }}</h1>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-md">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <!-- Kolom Kiri: Edit Data Produk -->
        <div class="lg:col-span-2 space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                    <h2 class="text-lg font-semibold text-gray-800">Detail Produk</h2>
                </div>
                <div class="p-6">
                    <form action="{{ route('seller.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="space-y-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Produk</label>
                                <input type="text" name="name" value="{{ old('name', $product->name) }}" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2 border">
                            </div>

                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kategori Utama (Smart Sizing)</label>
                                    <select name="type" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2 border bg-white">
                                        <option value="top" {{ old('type', $product->type) == 'top' ? 'selected' : '' }}>Atasan (Kemeja, Kaos, Jaket)</option>
                                        <option value="bottom" {{ old('type', $product->type) == 'bottom' ? 'selected' : '' }}>Bawahan (Celana, Rok)</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Kategori Tampilan (Katalog)</label>
                                    <select name="category_id" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2 border bg-white">
                                        <option value="">Pilih Kategori</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" {{ old('category_id', $product->category_id) == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Harga Produk (Rp)</label>
                                <input type="number" name="price" value="{{ old('price', $product->price) }}" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2 border">
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Ganti Foto Produk (Opsional)</label>
                                @if($product->image_path)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/' . $product->image_path) }}" alt="Current Image" class="h-24 w-24 object-cover rounded-md border">
                                    </div>
                                @endif
                                <input type="file" name="image" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2 border bg-white">
                                <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, WEBP. Maks: 2MB.</p>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700">Deskripsi</label>
                                <textarea name="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2 border">{{ old('description', $product->description) }}</textarea>
                            </div>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 shadow-sm transition-colors w-full sm:w-auto">
                                Update Data Produk
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Kolom Kanan: Manajemen Size Chart -->
        <div class="space-y-8">
            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 bg-gray-50 flex justify-between items-center">
                    <h2 class="text-lg font-semibold text-gray-800">Tabel Ukuran (Size Chart)</h2>
                </div>
                
                <div class="p-0">
                    <ul class="divide-y divide-gray-100">
                        @forelse($product->sizes as $size)
                            <li class="p-4 flex items-center justify-between hover:bg-gray-50">
                                <div>
                                    <span class="font-bold text-lg text-indigo-600 mr-2">{{ $size->size_label }}</span>
                                    <div class="text-xs text-gray-500 mt-1">
                                        Lebar Dada: {{ $size->chest_width_cm }}cm | Panjang: {{ $size->body_length_cm }}cm
                                    </div>
                                    <div class="text-xs font-semibold text-gray-700 mt-1">Stok: {{ $size->stock }}</div>
                                </div>
                                <form action="{{ route('seller.sizes.destroy', [$product->id, $size->id]) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:text-red-700 p-2" onclick="return confirm('Hapus ukuran ini?');">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </li>
                        @empty
                            <li class="p-6 text-center text-gray-500 text-sm">Belum ada ukuran terdaftar.</li>
                        @endforelse
                    </ul>
                </div>

                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <h3 class="text-sm font-bold text-gray-700 mb-4">Tambah Ukuran Baru</h3>
                    <form action="{{ route('seller.sizes.store', $product->id) }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Label (Misal: S, M, XL)</label>
                            <input type="text" name="size_label" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2 border">
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-medium text-gray-700">Lebar Dada (cm)</label>
                                <input type="number" name="chest_width_cm" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2 border">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700">Panjang (cm)</label>
                                <input type="number" name="body_length_cm" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2 border">
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700">Stok Barang</label>
                            <input type="number" name="stock" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 text-sm p-2 border">
                        </div>
                        <button type="submit" class="w-full bg-white border border-indigo-300 text-indigo-700 px-4 py-2 rounded-md font-medium hover:bg-indigo-50 transition-colors text-sm">
                            <i class="fas fa-plus mr-1"></i> Tambah Ukuran
                        </button>
                    </form>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
