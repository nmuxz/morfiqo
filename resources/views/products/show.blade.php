@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <!-- Breadcrumbs -->
    <nav class="flex mb-8" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="/" class="text-sm text-gray-500 hover:text-gray-900">Katalog</a>
            </li>
            <li>
                <div class="flex items-center">
                    <i class="fas fa-chevron-right text-gray-400 text-xs mx-2"></i>
                    <span class="text-sm text-gray-900 font-medium">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100">
        <div class="grid grid-cols-1 md:grid-cols-2">
            
            <!-- Product Image Section -->
            <div class="relative bg-gray-50 p-8 flex items-center justify-center">
                @php $imgId = 100 + $product->id; @endphp
                <img src="https://picsum.photos/id/{{ $imgId }}/600/800" alt="{{ $product->name }}" class="rounded-2xl shadow-lg object-cover w-full h-[600px]">
                
                <div class="absolute top-12 left-12">
                    <span class="bg-indigo-600 text-white text-sm font-bold px-4 py-2 rounded-full uppercase tracking-widest shadow-md">
                        {{ $product->type }}
                    </span>
                </div>
            </div>

            <!-- Product Info Section -->
            <div class="p-8 md:p-12 flex flex-col justify-center">
                <div class="mb-2 flex items-center space-x-2">
                    <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-600">
                        <i class="fas fa-store text-xs"></i>
                    </div>
                    <span class="text-indigo-600 font-semibold text-lg">{{ $product->store->name ?? 'Toko' }}</span>
                </div>
                
                <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 mb-6 tracking-tight leading-tight">
                    {{ $product->name }}
                </h1>
                
                <p class="text-gray-600 text-lg mb-8 leading-relaxed">
                    {{ $product->description }}
                </p>

                <!-- Size Chart Table -->
                <div class="mb-10">
                    <h3 class="text-lg font-bold text-gray-900 mb-4 flex items-center">
                        <i class="fas fa-ruler-horizontal mr-2 text-indigo-500"></i> Tabel Ukuran (Size Chart)
                    </h3>
                    <div class="overflow-x-auto bg-gray-50 rounded-xl border border-gray-200">
                        <table class="min-w-full divide-y divide-gray-200 text-sm">
                            <thead class="bg-gray-100">
                                <tr>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Size</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Lebar Dada</th>
                                    <th class="px-4 py-3 text-left font-semibold text-gray-700">Panjang</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                                @forelse($product->sizes as $size)
                                <tr>
                                    <td class="px-4 py-3 font-bold text-indigo-600">{{ $size->size_label }}</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $size->chest_width_cm }} cm</td>
                                    <td class="px-4 py-3 text-gray-600">{{ $size->body_length_cm }} cm</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="3" class="px-4 py-3 text-center text-gray-500">Belum ada data ukuran.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Smart Sizing Widget (Alpine.js) -->
                <div class="bg-gradient-to-br from-indigo-50 to-pink-50 p-6 rounded-2xl border border-indigo-100 relative overflow-hidden" 
                     x-data="smartSizing({{ $product->id }})">
                    
                    <div class="absolute -right-10 -top-10 text-indigo-200 opacity-20">
                        <i class="fas fa-magic text-9xl"></i>
                    </div>

                    <div class="relative z-10">
                        <h3 class="text-xl font-bold text-gray-900 mb-2">Smart Sizing AI</h3>
                        <p class="text-gray-600 text-sm mb-6">Kami akan mencocokkan profil tubuh Anda dengan dimensi baju ini secara akurat.</p>
                        
                        @auth
                            <!-- Logged In State -->
                            <div x-show="!result && !loading" class="flex flex-col sm:flex-row gap-4">
                                <!-- Dummy profile selection for demo since Budi's ID is 1 -->
                                <select x-model="profileId" class="block w-full sm:w-1/2 px-4 py-3 bg-white border border-gray-300 rounded-xl focus:ring-indigo-500 focus:border-indigo-500 shadow-sm text-gray-700 font-medium">
                                    <option value="1">Gunakan Profil: Budi Santoso</option>
                                    <!-- In reality, this would list the user's profiles -->
                                </select>
                                
                                <button @click="checkSize()" class="w-full sm:w-1/2 flex justify-center items-center px-6 py-3 border border-transparent text-base font-medium rounded-xl text-white bg-indigo-600 hover:bg-indigo-700 shadow-lg transition-transform transform hover:-translate-y-0.5 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                                    <i class="fas fa-search-magic mr-2"></i> Cek Ukuran Saya
                                </button>
                            </div>

                            <!-- Loading State -->
                            <div x-show="loading" class="py-4 flex items-center justify-center text-indigo-600 space-x-3">
                                <i class="fas fa-circle-notch fa-spin text-2xl"></i>
                                <span class="font-medium animate-pulse">Menganalisis kecocokan tubuh Anda...</span>
                            </div>

                            <!-- Error State -->
                            <div x-show="error" x-transition class="mt-4 p-4 bg-red-50 border border-red-200 rounded-xl text-red-600 text-sm flex items-start">
                                <i class="fas fa-exclamation-circle mt-1 mr-2"></i>
                                <span x-text="errorMsg"></span>
                            </div>

                            <!-- Result State -->
                            <div x-show="result" x-transition.duration.500ms class="mt-4 bg-white p-6 rounded-xl border-2 border-indigo-500 shadow-xl relative">
                                <button @click="reset()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                                    <i class="fas fa-times"></i>
                                </button>
                                
                                <div class="flex items-center space-x-4 mb-4">
                                    <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 border-4 border-white shadow-sm">
                                        <span class="text-2xl font-black" x-text="resultSize"></span>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 font-medium uppercase tracking-wider">Rekomendasi Terbaik</p>
                                        <h4 class="text-xl font-bold text-gray-900" x-text="'Ukuran ' + resultSize"></h4>
                                    </div>
                                </div>
                                
                                <div class="space-y-2">
                                    <p class="text-gray-700 bg-gray-50 p-3 rounded-lg border border-gray-100">
                                        <i class="fas fa-check-circle text-green-500 mr-2"></i> 
                                        Kesesuaian Dada: <strong class="text-gray-900" x-text="resultFit"></strong>
                                    </p>
                                    <p class="text-gray-600 text-sm italic ml-1" x-text="resultMessage"></p>
                                </div>
                            </div>
                        @else
                            <!-- Not Logged In State -->
                            <div class="bg-white p-5 rounded-xl border border-gray-200 shadow-sm flex flex-col sm:flex-row items-center justify-between">
                                <div class="flex items-center space-x-3 mb-4 sm:mb-0">
                                    <div class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center text-gray-500">
                                        <i class="fas fa-lock"></i>
                                    </div>
                                    <div>
                                        <p class="font-medium text-gray-900">Silakan masuk</p>
                                        <p class="text-xs text-gray-500">Untuk menggunakan fitur Smart Sizing</p>
                                    </div>
                                </div>
                                <a href="{{ route('login') }}" class="w-full sm:w-auto px-6 py-2 bg-gray-900 text-white rounded-lg text-sm font-medium hover:bg-gray-800 transition-colors text-center">Masuk Sekarang</a>
                            </div>
                        @endauth

                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('smartSizing', (productId) => ({
            productId: productId,
            profileId: 1, // Default for demo
            loading: false,
            result: false,
            error: false,
            errorMsg: '',
            
            resultSize: '',
            resultFit: '',
            resultMessage: '',

            async checkSize() {
                this.loading = true;
                this.result = false;
                this.error = false;
                
                // Add artificial delay for UI dramatic effect
                await new Promise(r => setTimeout(r, 800));

                try {
                    const response = await fetch(`/api/products/${this.productId}/recommend-size?profile_id=${this.profileId}`, {
                        method: 'GET',
                        headers: {
                            'Accept': 'application/json'
                        }
                    });

                    const data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || data.error || 'Terjadi kesalahan.');
                    }

                    this.resultSize = data.recommended_size;
                    this.resultFit = data.fit_details.chest;
                    this.resultMessage = data.message;
                    this.result = true;
                } catch (err) {
                    this.error = true;
                    this.errorMsg = err.message;
                } finally {
                    this.loading = false;
                }
            },
            
            reset() {
                this.result = false;
                this.error = false;
            }
        }));
    });
</script>
@endpush
