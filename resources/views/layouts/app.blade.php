<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Morfiqo - @yield('title', 'Smart Sizing E-Commerce')</title>
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Alpine.js for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <style>
        body { font-family: 'Inter', sans-serif; }
        .glass-nav {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.5);
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    <!-- Navigation -->
    <nav class="glass-nav fixed w-full z-50 top-0 transition-all duration-300" x-data="{ mobileMenuOpen: false }">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                
                <!-- Logo -->
                <div class="flex-shrink-0 flex items-center">
                    <a href="/" class="text-2xl font-bold bg-clip-text text-transparent bg-gradient-to-r from-indigo-600 to-pink-500">
                        Morfiqo
                    </a>
                </div>

                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8">
                    <a href="/" class="text-gray-600 hover:text-indigo-600 font-medium transition-colors">Katalog</a>
                    
                    @auth
                        @if(auth()->user()->hasRole('store_owner') || auth()->user()->hasRole('super_admin'))
                            <a href="/seller/dashboard" class="text-gray-600 hover:text-indigo-600 font-medium transition-colors">Dashboard Penjual</a>
                        @endif
                        
                        <!-- Profile Dropdown -->
                        <div class="relative" x-data="{ open: false }">
                            <button @click="open = !open" @click.away="open = false" class="flex items-center space-x-2 focus:outline-none">
                                <div class="w-8 h-8 rounded-full bg-gradient-to-tr from-indigo-500 to-pink-500 flex items-center justify-center text-white font-bold text-sm shadow-md">
                                    {{ substr(auth()->user()->name, 0, 1) }}
                                </div>
                                <span class="font-medium text-sm text-gray-700">{{ auth()->user()->name }}</span>
                                <i class="fas fa-chevron-down text-xs text-gray-400"></i>
                            </button>

                            <div x-show="open" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-xl shadow-lg py-1 border border-gray-100 ring-1 ring-black ring-opacity-5">
                                <div class="px-4 py-2 border-b border-gray-100">
                                    <p class="text-xs text-gray-500">Masuk sebagai</p>
                                    <p class="text-sm font-semibold text-gray-800 truncate">{{ auth()->user()->email }}</p>
                                </div>
                                <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-700 transition-colors">Profil Anda</a>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 transition-colors">
                                        Keluar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-gray-600 hover:text-indigo-600 font-medium transition-colors">Masuk</a>
                        <a href="{{ route('register') }}" class="bg-gray-900 text-white px-5 py-2 rounded-full font-medium hover:bg-gray-800 shadow-md transition-transform transform hover:-translate-y-0.5">Daftar</a>
                    @endauth
                </div>

                <!-- Mobile menu button -->
                <div class="md:hidden flex items-center">
                    <button @click="mobileMenuOpen = !mobileMenuOpen" class="text-gray-600 hover:text-gray-900 focus:outline-none">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu (Alpine JS) -->
        <div x-show="mobileMenuOpen" class="md:hidden bg-white border-b border-gray-200 shadow-lg">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <a href="/" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50">Katalog</a>
                @auth
                    @if(auth()->user()->hasRole('store_owner') || auth()->user()->hasRole('super_admin'))
                        <a href="/seller/dashboard" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50">Dashboard Penjual</a>
                    @endif
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left block px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50">Keluar</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-indigo-50">Masuk</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="flex-grow pt-24 pb-12">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200 mt-auto">
        <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="flex items-center space-x-2 mb-4 md:mb-0">
                    <span class="text-xl font-bold text-gray-900">Morfiqo</span>
                    <span class="text-sm text-gray-500">© 2026</span>
                </div>
                <div class="flex space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-900"><i class="fab fa-twitter"></i></a>
                    <a href="#" class="text-gray-400 hover:text-gray-900"><i class="fab fa-instagram"></i></a>
                    <a href="#" class="text-gray-400 hover:text-gray-900"><i class="fab fa-github"></i></a>
                </div>
            </div>
        </div>
    </footer>

    <!-- For dynamic scripts -->
    <script>
        // Provide the Sanctum API token if user is logged in
        // So that frontend JS can make requests securely
        window.Morfiqo = {
            @auth
            userId: {{ auth()->id() }},
            roles: {!! json_encode(auth()->user()->getRoleNames()) !!}
            @else
            userId: null,
            roles: []
            @endauth
        };
    </script>
    @stack('scripts')
</body>
</html>
