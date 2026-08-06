@extends('layouts.app')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="mb-8">
        <a href="{{ route('seller.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
            <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard
        </a>
        <h1 class="text-3xl font-bold text-gray-900 mt-4">Tambah Produk Baru</h1>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 sm:p-8">
            <form action="{{ route('seller.products.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                
                <div class="space-y-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700">Nama Produk</label>
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2 border">
                        @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="type" class="block text-sm font-medium text-gray-700">Tipe Pakaian</label>
                        <select name="type" id="type" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2 border bg-white">
                            <option value="top" {{ old('type') == 'top' ? 'selected' : '' }}>Atasan (Kemeja, Kaos, Jaket)</option>
                            <option value="bottom" {{ old('type') == 'bottom' ? 'selected' : '' }}>Bawahan (Celana, Rok)</option>
                        </select>
                        @error('type') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="price" class="block text-sm font-medium text-gray-700">Harga Produk (Rp)</label>
                        <input type="number" name="price" id="price" value="{{ old('price') }}" required class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2 border">
                        @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label for="image" class="block text-sm font-medium text-gray-700">Foto Produk (Opsional)</label>
                        <input type="file" name="image" id="image" accept="image/*" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2 border bg-white">
                        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                        <p class="mt-1 text-xs text-gray-500">Format: JPG, PNG, WEBP. Maks: 2MB.</p>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi Produk</label>
                        <textarea name="description" id="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm px-4 py-2 border">{{ old('description') }}</textarea>
                        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                    </div>
                </div>

                <div class="mt-8 pt-5 border-t border-gray-200 flex justify-end">
                    <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-lg font-medium hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 shadow-sm transition-colors">
                        Simpan Produk
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
