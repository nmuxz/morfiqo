<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Morfiqo</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
        }
        .glass-panel {
            background: rgba(255, 255, 255, 0.85);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4">

    <div class="glass-panel w-full max-w-md rounded-2xl shadow-2xl p-8 relative overflow-hidden">
        
        <!-- Decorative element -->
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-indigo-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-pink-500 rounded-full mix-blend-multiply filter blur-2xl opacity-50 animate-blob animation-delay-2000"></div>

        <div class="relative z-10">
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-gray-900 tracking-tight">Morfiqo</h1>
                <p class="text-sm text-gray-500 mt-2">Smart Sizing E-Commerce</p>
            </div>

            @if ($errors->any())
                <div class="mb-4 p-4 bg-red-50 border-l-4 border-red-500 rounded-md">
                    <p class="text-sm text-red-700">{{ $errors->first() }}</p>
                </div>
            @endif

            <form method="POST" action="/login" class="space-y-6">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700">Email Address</label>
                    <div class="mt-1">
                        <select id="email" name="email" class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-white/50 backdrop-blur-sm transition-all duration-200">
                            <option value="budi@example.com">budi@example.com (Pembeli)</option>
                            <option value="owner@morfiqo.com">owner@morfiqo.com (Penjual)</option>
                            <option value="admin@morfiqo.com">admin@morfiqo.com (Admin Utama)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                    <div class="mt-1">
                        <input id="password" name="password" type="password" value="password" readonly required class="appearance-none block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm bg-gray-50 transition-all duration-200">
                    </div>
                    <p class="text-xs text-gray-400 mt-1">Default password for demo is filled automatically.</p>
                </div>

                <div>
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-all duration-300 hover:shadow-lg transform hover:-translate-y-0.5">
                        Sign in
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <a href="/" class="text-sm text-indigo-600 hover:text-indigo-500 hover:underline transition-all">Kembali ke Beranda</a>
            </div>
        </div>
    </div>

</body>
</html>
