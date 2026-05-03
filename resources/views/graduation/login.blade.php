<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - SMKN 1 Wringin</title>
    
    <!-- Favicon -->
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/alternative/icon.png') }}">
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
</head>
<body class="min-h-screen flex items-center justify-center relative hero-pattern font-sans antialiased text-slate-600">

    <div class="w-full max-w-md px-6 relative z-10">
        
        <!-- Header Text -->
        <div class="text-center mb-10">
            <div class="mb-6 inline-block transition-transform duration-500 hover:scale-110 drop-shadow-2xl">
                <picture>
                    <source srcset="{{ asset('images/webp/icon.webp') }}" type="image/webp">
                    <img src="{{ asset('images/alternative/icon.png') }}" alt="Logo SMKN 1 Wringin" class="w-24 h-24 object-contain">
                </picture>
            </div>
            <h1 class="text-3xl font-extrabold text-slate-800 tracking-tight mb-3">Admin <span class="text-brand-600">SMKN 1 Wringin</span></h1>
            <p class="text-slate-500 text-sm font-medium max-w-[280px] mx-auto leading-relaxed">Pusat Kendali Manajemen Konten, Berita, dan Sistem Informasi Terpadu</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white p-8 rounded-3xl shadow-[0_20px_50px_-12px_rgba(0,0,0,0.1)] border border-slate-100 relative overflow-hidden">
            <div class="absolute top-0 left-0 w-full h-1 bg-gradient-to-r from-brand-400 via-brand-600 to-brand-800"></div>
            
            @if ($errors->any())
            <div class="mb-6 p-4 rounded-xl bg-red-50 border border-red-100 text-red-600 text-sm flex items-start gap-3">
                <i data-feather="alert-circle" class="w-5 h-5 flex-shrink-0 mt-0.5 text-red-500"></i>
                <div>
                    <p class="font-bold mb-1 text-red-700">Autentikasi Gagal</p>
                    <ul class="list-disc list-inside text-xs space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
            @endif

            <form action="{{ route('admin.authenticate') }}" method="POST" class="space-y-6">
                @csrf
                <!-- Email/Username -->
                <div>
                    <label for="username" class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Username</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i data-feather="user" class="w-5 h-5"></i>
                        </div>
                        <input type="text" id="username" name="username" value="{{ old('username') }}" class="block w-full pl-11 pr-4 py-3 bg-slate-50 border {{ $errors->has('username') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20' }} rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 transition-all sm:text-sm font-medium" placeholder="Masukkan username" required autofocus>
                    </div>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="block text-xs font-bold text-slate-500 uppercase tracking-wider">Password</label>
                    </div>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i data-feather="lock" class="w-5 h-5"></i>
                        </div>
                        <input type="password" id="password" name="password" class="block w-full pl-11 pr-10 py-3 bg-slate-50 border {{ $errors->has('username') ? 'border-red-300 focus:border-red-500 focus:ring-red-500/20' : 'border-slate-200 focus:border-brand-500 focus:ring-brand-500/20' }} rounded-xl text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-4 transition-all sm:text-sm font-medium" placeholder="••••••••" required>
                        <div class="absolute inset-y-0 right-0 pr-4 flex items-center cursor-pointer text-slate-400 hover:text-brand-600 transition-colors">
                            <i data-feather="eye" class="w-4 h-4"></i>
                        </div>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="remember-me" name="remember-me" type="checkbox" class="h-4 w-4 rounded border-slate-300 bg-white text-brand-600 focus:ring-brand-500/50">
                    <label for="remember-me" class="ml-2 block text-sm font-medium text-slate-600">
                        Ingat sesi saya
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="w-full flex justify-center py-3.5 px-4 border border-transparent rounded-xl shadow-md shadow-brand-600/20 text-sm font-bold text-white bg-brand-600 hover:bg-brand-700 hover:shadow-lg hover:shadow-brand-600/30 focus:outline-none focus:ring-4 focus:ring-brand-500/50 transition-all duration-300">
                    Masuk ke Dashboard
                </button>
            </form>
        </div>
        
        <!-- Footer Info -->
        <p class="text-center text-xs font-medium text-slate-500 mt-8">
            Hanya untuk staf dan guru SMKN 1 Wringin yang memiliki wewenang.
        </p>

    </div>

    <script>
        feather.replace();
    </script>
</body>
</html>
