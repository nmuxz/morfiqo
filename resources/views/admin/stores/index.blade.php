@extends('layouts.app')

@section('title', 'Admin - Daftar Toko')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard Admin
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">Daftar Toko</h1>
            <p class="text-gray-500 mt-1">Pantau semua toko yang terdaftar di platform Morfiqo.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Toko</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pemilik</th>
                        <th class="px-6 py-3 text-center text-xs font-bold text-gray-500 uppercase tracking-wider">Jumlah Produk</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Bergabung</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($stores as $store)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-bold text-gray-900">{{ $store->name }}</div>
                                <div class="text-sm text-gray-500 mt-1 max-w-xs truncate">{{ $store->description }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="font-medium text-gray-900">{{ $store->user->name }}</div>
                                <div class="text-xs text-gray-500">{{ $store->user->email }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-center">
                                <span class="px-3 py-1 bg-indigo-50 text-indigo-700 font-bold rounded-full">
                                    {{ $store->products_count }} Produk
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                {{ $store->created_at->format('d M Y') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-gray-500">
                                <div class="text-gray-300 mb-2"><i class="fas fa-store-slash text-4xl"></i></div>
                                Belum ada toko yang terdaftar.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $stores->links() }}
        </div>
    </div>
</div>
@endsection
