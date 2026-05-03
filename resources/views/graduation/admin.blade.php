<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Kelulusan</title>
    
    <!-- Favicon -->
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/alternative/icon.png') }}">
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1; /* slate-300 */
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8; /* slate-400 */
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden bg-slate-50 text-slate-800 font-sans antialiased">

    <!-- Sidebar -->
    <aside class="w-64 bg-white border-r border-slate-200 h-full flex flex-col flex-shrink-0 relative z-20">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-slate-100">
            <div class="w-10 h-10 bg-white border border-slate-100 rounded-xl flex items-center justify-center mr-3 shadow-sm transition-transform duration-300 hover:scale-105">
                <picture>
                    <source srcset="{{ asset('images/webp/icon.webp') }}" type="image/webp">
                    <img src="{{ asset('images/alternative/icon.png') }}" alt="Logo" class="w-7 h-7 object-contain">
                </picture>
            </div>
            <span class="font-bold text-base text-slate-800 tracking-tight leading-tight">Admin <br><span class="text-brand-600">SMKN 1 Wringin</span></span>
        </div>
        
        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto custom-scrollbar py-6 px-4 space-y-2">
            <p class="text-[10px] uppercase tracking-widest text-slate-400 mb-4 px-2 font-bold">Menu Utama</p>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-brand-50 text-brand-600 border border-brand-100 shadow-sm transition-all">
                <i data-feather="grid" class="w-5 h-5"></i>
                <span class="font-bold text-sm">Dashboard</span>
            </a>
            
            <a href="{{ route('admin.graduation') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 hover:text-brand-700 hover:bg-brand-50 transition-all">
                <i data-feather="users" class="w-5 h-5"></i>
                <span class="font-medium text-sm">Data Kelulusan</span>
            </a>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 hover:text-brand-700 hover:bg-brand-50 transition-all">
                <i data-feather="file-text" class="w-5 h-5"></i>
                <span class="font-medium text-sm">Laporan</span>
            </a>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 hover:text-brand-700 hover:bg-brand-50 transition-all">
                <i data-feather="settings" class="w-5 h-5"></i>
                <span class="font-medium text-sm">Pengaturan</span>
            </a>
        </div>
        
        <!-- Logout Section -->
        <div class="p-4">
            <div class="bg-slate-50 border border-slate-200 p-4 rounded-2xl relative overflow-hidden group">
                <div class="relative z-10">
                    <h4 class="text-sm font-bold text-slate-700 mb-1">Tahun Ajaran 2026</h4>
                    <p class="text-xs text-slate-500 mb-3 font-medium">Sistem terhubung & aktif.</p>
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="w-full py-2 bg-brand-600 hover:bg-brand-700 text-white text-xs font-bold rounded-lg transition-colors shadow-sm shadow-brand-600/20">Tutup Sesi</button>
                    </form>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full relative overflow-hidden bg-slate-50">
        
        <!-- Top Navbar -->
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 relative z-10">
            <div class="flex items-center gap-4">
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Dashboard Utama</h1>
                <span class="px-3 py-1 bg-brand-50 text-brand-600 border border-brand-100 text-xs rounded-full font-bold">Admin Portal</span>
            </div>
            
            <div class="flex items-center gap-6">
                <div class="flex items-center gap-3 cursor-pointer group">
                    <div class="w-9 h-9 rounded-full bg-slate-100 p-[2px] border border-slate-200">
                        <img src="https://ui-avatars.com/api/?name=Admin+User&background=1E5460&color=fff" alt="Admin" class="w-full h-full rounded-full">
                    </div>
                    <div class="hidden md:block text-left">
                        <p class="text-sm font-bold text-slate-700 group-hover:text-brand-600 transition-colors">Admin Wringin</p>
                        <p class="text-[10px] font-medium text-slate-500">Super Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Scroll Area -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 relative z-10 hero-pattern">
            
            <!-- Welcome Widget -->
            <div class="bg-white p-8 rounded-3xl border border-slate-100 shadow-sm mb-8 relative overflow-hidden">
                <div class="absolute right-0 top-0 w-64 h-64 bg-brand-50 rounded-full -mr-20 -mt-20 blur-3xl opacity-50"></div>
                <div class="relative z-10 flex flex-col md:flex-row items-center gap-8">
                    <div class="w-24 h-24 bg-brand-100 rounded-2xl flex items-center justify-center text-brand-600 flex-shrink-0">
                        <i data-feather="zap" class="w-12 h-12"></i>
                    </div>
                    <div>
                        <h2 class="text-2xl font-extrabold text-slate-800 mb-2">Selamat Datang di Portal Admin SMKN 1 Wringin</h2>
                        <p class="text-slate-500 font-medium max-w-2xl leading-relaxed">Gunakan panel navigasi di sebelah kiri untuk mengelola konten website, berita sekolah, dan sistem pengumuman kelulusan siswa secara terpadu.</p>
                        <div class="flex gap-4 mt-6">
                            <a href="{{ route('admin.graduation') }}" class="px-5 py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-sm font-bold rounded-xl transition-all shadow-lg shadow-brand-600/20 flex items-center gap-2">
                                <i data-feather="users" class="w-4 h-4"></i> Kelola Kelulusan
                            </a>
                            <button class="px-5 py-2.5 bg-white border border-slate-200 text-slate-600 hover:bg-slate-50 text-sm font-bold rounded-xl transition-all flex items-center gap-2">
                                <i data-feather="edit-3" class="w-4 h-4"></i> Tulis Berita
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Status Cards -->
                <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                <i data-feather="globe" class="w-5 h-5"></i>
                            </div>
                            <h3 class="font-bold text-slate-800">Status Website</h3>
                        </div>
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-500">Landing Page</span>
                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full">Online</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-500">Database Siswa</span>
                                <span class="px-2 py-0.5 bg-emerald-100 text-emerald-700 text-[10px] font-bold rounded-full">Connected</span>
                            </div>
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-slate-500">Penyimpanan Foto</span>
                                <span class="px-2 py-0.5 bg-brand-100 text-brand-700 text-[10px] font-bold rounded-full">2.4 GB Free</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <i data-feather="activity" class="w-5 h-5"></i>
                            </div>
                            <h3 class="font-bold text-slate-800">Statistik Kunjungan</h3>
                        </div>
                        <div class="flex items-end gap-2">
                            <h4 class="text-3xl font-bold text-slate-800">1,240</h4>
                            <span class="text-xs text-emerald-500 font-bold mb-1 flex items-center">+12%</span>
                        </div>
                        <p class="text-[10px] text-slate-400 font-medium mt-1 uppercase tracking-wider">Pengunjung hari ini</p>
                    </div>
                </div>

                <!-- Recent Activity -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <h3 class="text-base font-bold text-slate-800 mb-5 flex items-center justify-between">
                        Aktivitas Terkini
                    </h3>
                    
                    <div class="space-y-5">
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-brand-50 flex items-center justify-center flex-shrink-0 text-brand-600">
                                <i data-feather="edit" class="w-3.5 h-3.5"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 font-medium"><span class="font-bold text-slate-800">Admin</span> memperbarui status kelulusan</p>
                                <p class="text-[10px] text-slate-400 font-medium mt-1">10 menit yang lalu</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center flex-shrink-0 text-emerald-600">
                                <i data-feather="file-plus" class="w-3.5 h-3.5"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 font-medium"><span class="font-bold text-slate-800">System</span> backup data harian</p>
                                <p class="text-[10px] text-slate-400 font-medium mt-1">2 jam yang lalu</p>
                            </div>
                        </div>
                        
                        <div class="flex gap-4">
                            <div class="w-8 h-8 rounded-full bg-amber-50 flex items-center justify-center flex-shrink-0 text-amber-600">
                                <i data-feather="settings" class="w-3.5 h-3.5"></i>
                            </div>
                            <div>
                                <p class="text-sm text-slate-600 font-medium"><span class="font-bold text-slate-800">Admin</span> login ke portal</p>
                                <p class="text-[10px] text-slate-400 font-medium mt-1">Kemarin, 14:30</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Footer -->
            <footer class="mt-8 pt-6 border-t border-slate-200 flex flex-col md:flex-row items-center justify-between text-xs font-medium text-slate-500">
                <p>&copy; 2026 SMKN 1 Wringin. All rights reserved.</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-brand-600 transition-colors">Bantuan</a>
                    <a href="#" class="hover:text-brand-600 transition-colors">Panduan Sistem</a>
                </div>
            </footer>
            
        </div>
    </main>

    <script>
        feather.replace();
    </script>
</body>
</html>
