@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Profil & Ukuran Tubuh Saya</h1>

    @if (session('success'))
        <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 rounded-md">
            <p class="text-sm text-green-700">{{ session('success') }}</p>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="p-6 border-b border-gray-200 bg-gray-50">
            <h2 class="text-lg font-semibold text-gray-800">Ubah Data Diri</h2>
            <p class="text-sm text-gray-500 mt-1">Pastikan ukuran tubuh Anda akurat agar AI Smart Sizing dapat bekerja maksimal.</p>
        </div>
        
        <form action="{{ route('profile.update') }}" method="POST" class="p-6">
            @csrf
            @method('PUT')
            
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-2">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                @error('name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Tinggi Badan (cm)</label>
                    <input type="number" name="height_cm" value="{{ old('height_cm', optional($profile)->height_cm) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('height_cm')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Berat Badan (kg)</label>
                    <input type="number" name="weight_kg" value="{{ old('weight_kg', optional($profile)->weight_kg) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('weight_kg')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lingkar Dada (cm)</label>
                    <input type="number" name="chest_circumference_cm" value="{{ old('chest_circumference_cm', optional($profile)->chest_circumference_cm) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('chest_circumference_cm')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Lingkar Perut (cm)</label>
                    <input type="number" name="waist_circumference_cm" value="{{ old('waist_circumference_cm', optional($profile)->waist_circumference_cm) }}" class="w-full rounded-xl border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('waist_circumference_cm')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-xl font-bold hover:bg-indigo-700 transition-colors shadow-md">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endsection
