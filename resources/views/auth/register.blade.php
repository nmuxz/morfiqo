<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran - Morfiqo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 py-12">

    <div class="glass-panel w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden relative" x-data="{ tab: 'customer' }">
        
        <!-- Decorative elements -->
        <div class="absolute -top-20 -right-20 w-48 h-48 bg-indigo-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
        <div class="absolute -bottom-20 -left-20 w-48 h-48 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

        <div class="relative z-10">
            <!-- Header -->
            <div class="bg-white/50 border-b border-gray-200 px-8 py-6 text-center">
                <h1 class="text-3xl font-bold text-gray-900 tracking-tight">Bergabung dengan Morfiqo</h1>
                <p class="text-sm text-gray-500 mt-2">Platform E-Commerce dengan Teknologi Smart Sizing</p>
            </div>

            <!-- Tab Selection -->
            <div class="flex border-b border-gray-200 bg-gray-50/50">
                <button @click="tab = 'customer'" :class="{ 'border-indigo-500 text-indigo-600 bg-white': tab === 'customer', 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100': tab !== 'customer' }" class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors focus:outline-none">
                    <i class="fas fa-user mr-2"></i> Daftar sebagai Pembeli
                </button>
                <button @click="tab = 'seller'" :class="{ 'border-pink-500 text-pink-600 bg-white': tab === 'seller', 'border-transparent text-gray-500 hover:text-gray-700 hover:bg-gray-100': tab !== 'seller' }" class="flex-1 py-4 px-6 text-center border-b-2 font-medium text-sm transition-colors focus:outline-none">
                    <i class="fas fa-store mr-2"></i> Daftar sebagai Penjual
                </button>
            </div>

            <div class="p-8">
                @if ($errors->any())
                    <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 rounded-md">
                        <ul class="list-disc pl-5 text-sm text-red-700 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Customer Form -->
                <form x-show="tab === 'customer'" method="POST" action="{{ route('register.customer') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Info -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Akun</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Lengkap</label>
                                <input name="name" type="text" value="{{ old('name') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Password</label>
                                <input name="password" type="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input name="password_confirmation" type="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Body Profile Info -->
                        <div class="space-y-4 bg-indigo-50/50 p-4 rounded-xl border border-indigo-100">
                            <h3 class="text-lg font-semibold text-indigo-800 border-b border-indigo-200 pb-2"><i class="fas fa-ruler text-indigo-500"></i> Profil Tubuh Anda</h3>
                            <p class="text-xs text-gray-500 mb-2">Digunakan oleh AI Smart Sizing kami.</p>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Tinggi (cm)</label>
                                    <input name="height_cm" type="number" min="50" max="300" value="{{ old('height_cm') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Berat (kg)</label>
                                    <input name="weight_kg" type="number" min="10" max="300" value="{{ old('weight_kg') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Lingkar Dada (cm)</label>
                                    <input name="chest_circumference_cm" type="number" min="30" max="200" value="{{ old('chest_circumference_cm') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Lingkar Pinggang (cm)</label>
                                    <input name="waist_circumference_cm" type="number" min="30" max="200" value="{{ old('waist_circumference_cm') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 transform hover:-translate-y-0.5 mt-6">
                        Daftar sebagai Pembeli
                    </button>
                </form>

                <!-- Seller Form -->
                <form x-show="tab === 'seller'" x-cloak method="POST" action="{{ route('register.seller') }}" class="space-y-6">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Info -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-gray-800 border-b pb-2">Informasi Pemilik</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Pemilik</label>
                                <input name="name" type="text" value="{{ old('name') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Email</label>
                                <input name="email" type="email" value="{{ old('email') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Password</label>
                                <input name="password" type="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Konfirmasi Password</label>
                                <input name="password_confirmation" type="password" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                            </div>
                        </div>

                        <!-- Store Info -->
                        <div class="space-y-4 bg-pink-50/50 p-4 rounded-xl border border-pink-100">
                            <h3 class="text-lg font-semibold text-pink-800 border-b border-pink-200 pb-2"><i class="fas fa-store text-pink-500"></i> Informasi Toko</h3>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Nama Toko</label>
                                <input name="store_name" type="text" value="{{ old('store_name') }}" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Alamat Lengkap Toko</label>
                                <textarea name="store_address" rows="4" required class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-pink-500 focus:border-pink-500 sm:text-sm">{{ old('store_address') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full py-3 px-4 border border-transparent rounded-xl shadow-sm text-sm font-bold text-white bg-pink-600 hover:bg-pink-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pink-500 transition-all duration-300 transform hover:-translate-y-0.5 mt-6">
                        Daftar sebagai Penjual
                    </button>
                </form>

            </div>
            
            <div class="bg-gray-50 border-t border-gray-200 px-8 py-4 text-center">
                <p class="text-sm text-gray-600">
                    Sudah punya akun? <a href="{{ route('login') }}" class="font-medium text-indigo-600 hover:text-indigo-500 hover:underline transition-all">Masuk di sini</a>
                </p>
                <div class="mt-2 text-center">
                    <a href="/" class="text-xs text-gray-500 hover:text-gray-700 hover:underline transition-all"><i class="fas fa-arrow-left"></i> Kembali ke Beranda</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
