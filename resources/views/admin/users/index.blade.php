@extends('layouts.app')

@section('title', 'Admin - Daftar Pengguna')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="mb-8 flex justify-between items-center">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Dashboard Admin
            </a>
            <h1 class="text-3xl font-bold text-gray-900 mt-2">Daftar Pengguna</h1>
            <p class="text-gray-500 mt-1">Kelola seluruh pengguna (Admin, Penjual, Pembeli) di platform.</p>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Pengguna</th>
                        <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Peran (Role)</th>
                        <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Tanggal Mendaftar</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-100">
                    @forelse($users as $user)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="w-10 h-10 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center font-bold mr-4">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900">{{ $user->name }}</div>
                                        <div class="text-sm text-gray-500">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($user->hasRole('super_admin'))
                                    <span class="px-3 py-1 bg-red-100 text-red-800 font-bold rounded-full text-xs">Super Admin</span>
                                @elseif($user->hasRole('store_owner'))
                                    <span class="px-3 py-1 bg-purple-100 text-purple-800 font-bold rounded-full text-xs">Penjual (Store Owner)</span>
                                @else
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 font-bold rounded-full text-xs">Pembeli (Customer)</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm text-gray-500">
                                {{ $user->created_at->format('d M Y, H:i') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="px-6 py-10 text-center text-gray-500">
                                Belum ada pengguna.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="px-6 py-4 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection
