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
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

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
<body class="h-screen overflow-hidden bg-slate-50 text-slate-800 font-sans antialiased">

    <div class="relative flex h-screen overflow-hidden">
    <div id="adminSidebarBackdrop" class="fixed inset-0 z-30 hidden bg-slate-900/50 backdrop-blur-sm lg:hidden"></div>

    <!-- Sidebar -->
    <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-40 flex h-screen w-64 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-300 lg:static lg:z-20 lg:translate-x-0">
        <!-- Logo -->
        <div class="flex h-20 items-center justify-between border-b border-slate-100 px-6">
            <div class="flex items-center">
                <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-xl border border-slate-100 bg-white shadow-sm transition-transform duration-300 hover:scale-105">
                <picture>
                    <source srcset="{{ asset('images/webp/icon.webp') }}" type="image/webp">
                    <img src="{{ asset('images/alternative/icon.png') }}" alt="Logo" class="w-7 h-7 object-contain">
                </picture>
                </div>
                <span class="text-base font-bold leading-tight tracking-tight text-slate-800">Admin <br><span class="text-brand-600">SMKN 1 Wringin</span></span>
            </div>
            <button type="button" id="adminSidebarClose" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 lg:hidden">
                <i data-feather="x" class="h-5 w-5"></i>
            </button>
        </div>
        
        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto custom-scrollbar py-6 px-4 space-y-2">
            <p class="text-[10px] uppercase tracking-widest text-slate-400 mb-4 px-2 font-bold">Menu Utama</p>
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 {{ request()->routeIs('admin.dashboard') ? 'bg-brand-50 text-brand-600 border border-brand-100 shadow-sm' : 'text-slate-500 hover:bg-brand-50 hover:text-brand-700' }} transition-all">
                <i data-feather="grid" class="w-5 h-5"></i>
                <span class="font-bold text-sm">Dashboard</span>
            </a>

            <a href="{{ route('admin.gallery') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 {{ request()->routeIs('admin.gallery') ? 'bg-brand-50 text-brand-600 border border-brand-100 shadow-sm' : 'text-slate-500 hover:bg-brand-50 hover:text-brand-700' }} transition-all">
                <i data-feather="image" class="w-5 h-5"></i>
                <span class="font-bold text-sm">Kelola Page</span>
            </a>
            
            <a href="{{ route('admin.graduation') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 {{ request()->routeIs('admin.graduation') ? 'bg-brand-50 text-brand-600 border border-brand-100 shadow-sm' : 'text-slate-500 hover:bg-brand-50 hover:text-brand-700' }} transition-all">
                <i data-feather="users" class="w-5 h-5"></i>
                <span class="font-medium text-sm">Data Kelulusan</span>
            </a>

            <a href="{{ route('admin.ppdb-builder') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 {{ request()->routeIs('admin.ppdb-builder*') ? 'bg-brand-50 text-brand-600 border border-brand-100 shadow-sm' : 'text-slate-500 hover:bg-brand-50 hover:text-brand-700' }} transition-all">
                <i data-feather="file-text" class="w-5 h-5"></i>
                <span class="text-sm {{ request()->routeIs('admin.ppdb-builder*') ? 'font-bold' : 'font-medium' }}">PPDB</span>
            </a>

            <a href="{{ route('admin.berita.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 {{ request()->routeIs('admin.berita.*') ? 'bg-brand-50 text-brand-600 border border-brand-100 shadow-sm' : 'text-slate-500 hover:bg-brand-50 hover:text-brand-700' }} transition-all">
                <i data-feather="book-open" class="w-5 h-5"></i>
                <span class="text-sm {{ request()->routeIs('admin.berita.*') ? 'font-bold' : 'font-medium' }}">Berita</span>
            </a>
        </div>
        
    </aside>

    <!-- Main Content -->
    <main class="flex h-screen min-h-0 w-full flex-1 flex-col overflow-hidden bg-slate-50">
        
        <!-- Top Navbar -->
        <header class="relative z-[80] flex min-h-20 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 sm:gap-4">
                <button type="button" id="adminSidebarOpen" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-brand-200 hover:text-brand-600 lg:hidden">
                    <i data-feather="menu" class="h-5 w-5"></i>
                </button>
                <div class="flex flex-wrap items-center gap-2 sm:gap-4">
                    <h1 class="text-lg font-bold tracking-tight text-slate-800 sm:text-xl">Dashboard Utama</h1>
                    <span class="rounded-full border border-brand-100 bg-brand-50 px-3 py-1 text-[11px] font-bold text-brand-600 sm:text-xs">Admin Portal</span>
                </div>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-6">
                <div class="relative" id="adminProfileMenuWrapper">
                    <button type="button" id="adminProfileToggle" class="group flex cursor-pointer items-center gap-3 rounded-2xl px-2 py-1.5 transition-colors hover:bg-slate-50">
                        <div class="w-9 h-9 rounded-full bg-slate-100 p-[2px] border border-slate-200">
                            <img src="https://ui-avatars.com/api/?name=Admin+User&background=1E5460&color=fff" alt="Admin" class="w-full h-full rounded-full">
                        </div>
                        <div class="hidden md:block text-left">
                            <p class="text-sm font-bold text-slate-700 group-hover:text-brand-600 transition-colors">Admin Wringin</p>
                            <p class="text-[10px] font-medium text-slate-500">Super Administrator</p>
                        </div>
                        <i data-feather="chevron-down" class="h-4 w-4 text-slate-400 group-hover:text-brand-600"></i>
                    </button>

                    <div id="adminProfileDropdown" class="absolute right-0 top-full z-[120] mt-3 hidden w-52 overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-xl">
                        <div class="border-b border-slate-100 bg-slate-50/60 px-4 py-3">
                            <p class="text-sm font-bold text-slate-700">Admin Wringin</p>
                            <p class="text-[10px] font-medium text-slate-500">Sesi administrator aktif</p>
                        </div>
                        <form action="{{ route('admin.logout') }}" method="POST" class="p-2">
                            @csrf
                            <button type="submit" class="flex w-full items-center gap-2 rounded-xl px-3 py-2.5 text-left text-sm font-bold text-red-600 transition-colors hover:bg-red-50">
                                <i data-feather="log-out" class="h-4 w-4"></i>
                                Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Scroll Area -->
        <div class="relative z-10 min-h-0 flex-1 overflow-y-auto custom-scrollbar hero-pattern p-4 sm:p-6 lg:p-8">
            <div class="min-h-full flex flex-col">
                <div class="flex-1">
                    <div class="grid grid-cols-1 xl:grid-cols-4 gap-8 mb-8">
                        <!-- Main Stats Column -->
                        <div class="xl:col-span-3 space-y-8">
                            
                            <!-- Resource Monitoring Grid -->
                            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                                <!-- Real-time CPU & RAM Chart -->
                                <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col h-full">
                                    <div class="flex items-center justify-between mb-6">
                                        <div class="flex items-center gap-3">
                                            <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-700 flex items-center justify-center">
                                                <i data-feather="activity" class="w-5 h-5"></i>
                                            </div>
                                            <h3 class="font-bold text-slate-800">Real-time Usage</h3>
                                        </div>
                                        <div class="flex items-center gap-4">
                                            <div class="flex items-center gap-1.5">
                                                <div class="w-2 h-2 rounded-full bg-orange-500"></div>
                                                <span class="text-[10px] font-bold text-slate-400 uppercase">CPU</span>
                                            </div>
                                            <div class="flex items-center gap-1.5">
                                                <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                                                <span class="text-[10px] font-bold text-slate-400 uppercase">RAM</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-1 min-h-[200px] w-full">
                                        <canvas id="usageChart"></canvas>
                                    </div>
                                </div>

                                <!-- Current Metrics Column -->
                                <div class="flex flex-col gap-6 h-full">
                                    <!-- CPU Usage Card -->
                                    <div class="flex-1 bg-white p-5 rounded-3xl border border-slate-100 shadow-sm group flex flex-col justify-center">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-lg bg-orange-50 text-orange-600 flex items-center justify-center">
                                                    <i data-feather="cpu" class="w-4 h-4"></i>
                                                </div>
                                                <span class="text-xs font-bold text-slate-700">CPU Load</span>
                                            </div>
                                            <span class="text-sm font-black text-orange-600">{{ $serverStats['cpu_usage'] }}%</span>
                                        </div>
                                        <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden mb-3">
                                            <div id="cpu-bar" class="h-full bg-orange-500 rounded-full transition-all duration-1000" style="width: {{ $serverStats['cpu_usage'] }}%"></div>
                                        </div>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase">{{ $serverStats['cpu_cores'] }} Cores Allocated</p>
                                    </div>

                                    <!-- RAM Usage Card -->
                                    <div class="flex-1 bg-white p-5 rounded-3xl border border-slate-100 shadow-sm group flex flex-col justify-center">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="flex items-center gap-2">
                                                <div class="w-8 h-8 rounded-lg bg-blue-50 text-blue-600 flex items-center justify-center">
                                                    <i data-feather="pie-chart" class="w-4 h-4"></i>
                                                </div>
                                                <span class="text-xs font-bold text-slate-700">RAM Usage</span>
                                            </div>
                                            <span class="text-sm font-black text-blue-600">{{ $serverStats['ram_percentage'] }}%</span>
                                        </div>
                                        <div class="w-full h-1.5 bg-slate-50 rounded-full overflow-hidden mb-3">
                                            <div id="ram-bar" class="h-full bg-blue-500 rounded-full transition-all duration-1000" style="width: {{ $serverStats['ram_percentage'] }}%"></div>
                                        </div>
                                        <p class="text-[9px] text-slate-400 font-bold uppercase">{{ $serverStats['ram_used'] }} MB / {{ $serverStats['ram_total'] }} MB</p>
                                    </div>
                                </div>
                            </div>

                    <!-- Detailed Network & Stats Row -->
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        <!-- Detailed Traffic Card -->
                        <div class="lg:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center">
                                        <i data-feather="activity" class="w-5 h-5"></i>
                                    </div>
                                    <h3 class="font-bold text-slate-800">Detail Traffic (Network)</h3>
                                </div>
                                <div class="flex gap-2">
                                    <span class="px-2 py-0.5 bg-slate-50 border border-slate-100 text-[9px] font-bold text-slate-400 rounded-md">REAL-TIME</span>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Download RX -->
                                <div class="relative p-6 rounded-3xl bg-slate-50 border border-slate-100 overflow-hidden group">
                                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-emerald-100/50 rounded-full blur-2xl group-hover:bg-emerald-200/50 transition-colors"></div>
                                    <div class="relative z-10">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="w-10 h-10 rounded-2xl bg-white shadow-sm flex items-center justify-center text-emerald-500">
                                                <i data-feather="download-cloud" class="w-5 h-5"></i>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Receive (RX)</p>
                                                <h4 class="text-xl font-black text-slate-800">{{ $serverStats['traffic_rx'] }}</h4>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-1 bg-white rounded-full overflow-hidden">
                                                <div class="h-full bg-emerald-500 w-2/3"></div>
                                            </div>
                                            <span class="text-[9px] font-bold text-emerald-600">Active</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Upload TX -->
                                <div class="relative p-6 rounded-3xl bg-slate-50 border border-slate-100 overflow-hidden group">
                                    <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-blue-100/50 rounded-full blur-2xl group-hover:bg-blue-200/50 transition-colors"></div>
                                    <div class="relative z-10">
                                        <div class="flex items-center justify-between mb-4">
                                            <div class="w-10 h-10 rounded-2xl bg-white shadow-sm flex items-center justify-center text-blue-500">
                                                <i data-feather="upload-cloud" class="w-5 h-5"></i>
                                            </div>
                                            <div class="text-right">
                                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest">Transmit (TX)</p>
                                                <h4 class="text-xl font-black text-slate-800">{{ $serverStats['traffic_tx'] }}</h4>
                                            </div>
                                        </div>
                                        <div class="flex items-center gap-2">
                                            <div class="flex-1 h-1 bg-white rounded-full overflow-hidden">
                                                <div class="h-full bg-blue-500 w-1/2"></div>
                                            </div>
                                            <span class="text-[9px] font-bold text-blue-600">Active</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Bandwidth Limit Bar -->
                            <div class="mt-8 pt-6 border-t border-slate-50">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-[10px] text-slate-400 font-bold uppercase">Total Bandwidth Usage</span>
                                    <span class="text-[10px] text-slate-600 font-bold">{{ $serverStats['bandwidth_used'] }} GB / {{ $serverStats['bandwidth_total'] }} GB</span>
                                </div>
                                <div class="w-full h-2 bg-slate-50 rounded-full overflow-hidden">
                                    <div class="h-full bg-emerald-500 rounded-full" style="width: {{ $serverStats['bandwidth_percentage'] }}%"></div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Card -->
                        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm flex flex-col">
                            <h3 class="font-bold text-slate-800 mb-6">Storage Usage</h3>
                            <div class="flex-1 flex flex-col justify-center">
                                <div class="relative w-32 h-32 mx-auto mb-6">
                                    <svg class="w-full h-full -rotate-90" viewBox="0 0 36 36">
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#f1f5f9" stroke-width="3" />
                                        <path d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="#6366f1" stroke-width="3" stroke-dasharray="{{ $serverStats['storage_percentage'] }}, 100" />
                                    </svg>
                                    <div class="absolute inset-0 flex flex-col items-center justify-center">
                                        <span class="text-xl font-black text-slate-800">{{ $serverStats['storage_percentage'] }}%</span>
                                        <span class="text-[8px] text-slate-400 font-bold uppercase">Used</span>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <p class="text-sm font-bold text-slate-700">{{ $serverStats['storage_used'] }} GB Used</p>
                                    <p class="text-[10px] text-slate-400 font-medium">Of {{ $serverStats['storage_total'] }} GB total disk space</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Sidebar (Billing & Activities) -->
                <div class="xl:col-span-1 space-y-8">
                    <!-- Billing Widget -->
                    <div class="bg-gradient-to-br from-slate-900 to-slate-800 p-6 rounded-3xl shadow-xl shadow-slate-900/20 relative overflow-hidden group hover:shadow-2xl transition-all duration-500">
                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-brand-500/10 rounded-full blur-3xl group-hover:bg-brand-500/20 transition-all duration-700"></div>
                        <div class="absolute -left-10 -bottom-10 w-40 h-40 bg-amber-500/10 rounded-full blur-3xl group-hover:bg-amber-500/20 transition-all duration-700"></div>
                        
                        <div class="relative z-10">
                            <h3 class="text-white font-bold mb-8 flex items-center justify-between">
                                <span class="flex items-center gap-2">
                                    <i data-feather="credit-card" class="w-4 h-4 text-amber-400"></i>
                                    Server Billing
                                </span>
                                <span class="px-2 py-0.5 bg-white/10 text-white text-[9px] font-bold rounded-md uppercase tracking-widest border border-white/5">ACTIVE</span>
                            </h3>
                            
                            <div class="flex items-center gap-5 mb-8">
                                <div class="w-16 h-16 bg-white/5 backdrop-blur-md rounded-2xl flex flex-col items-center justify-center border border-white/10 shadow-inner group-hover:scale-105 transition-transform">
                                    <span class="text-2xl font-black text-white leading-none">{{ $serverStats['days_remaining'] }}</span>
                                    <span class="text-[9px] font-bold text-slate-400 uppercase mt-1">Days</span>
                                </div>
                                <div>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mb-1">Next Renewal</p>
                                    <p class="text-base font-bold text-white">{{ \Carbon\Carbon::parse($serverStats['next_billing'])->translatedFormat('d M Y') }}</p>
                                </div>
                            </div>

                            <div class="space-y-4 mb-8">
                                <div class="flex items-center justify-between p-3 bg-white/5 rounded-2xl border border-white/5">
                                    <span class="text-xs text-slate-400">Plan</span>
                                    <span class="text-xs text-white font-bold">Cloud VPS Pro</span>
                                </div>
                                <div class="flex items-center justify-between p-3 bg-white/5 rounded-2xl border border-white/5">
                                    <span class="text-xs text-slate-400">Provider</span>
                                    <span class="text-xs text-white font-bold">Green Cloud</span>
                                </div>
                            </div>

                            <button class="w-full py-4 bg-amber-500 hover:bg-amber-400 text-slate-900 text-xs font-black rounded-2xl transition-all shadow-lg shadow-amber-500/30 flex items-center justify-center gap-2 group/btn">
                                <i data-feather="zap" class="w-4 h-4 group-hover/btn:animate-pulse"></i> RENEW SERVER
                            </button>
                        </div>
                    </div>

                    <!-- Quick Network Info (New Sidebar Item to fill space) -->
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                        <h3 class="text-sm font-bold text-slate-800 mb-4 flex items-center gap-2">
                            <i data-feather="info" class="w-4 h-4 text-slate-400"></i>
                            Server Access
                        </h3>
                        <div class="space-y-3">
                            <div class="p-3 bg-slate-50 rounded-xl">
                                <p class="text-[9px] text-slate-400 font-bold uppercase mb-1">IPv4 Address</p>
                                <p class="text-xs font-bold text-slate-700">{{ $serverStats['server_ip'] }}</p>
                            </div>
                            <div class="p-3 bg-slate-50 rounded-xl">
                                <p class="text-[9px] text-slate-400 font-bold uppercase mb-1">IPv6 Address</p>
                                <p class="text-[10px] font-bold text-slate-700 break-all">{{ $serverStats['server_ipv6'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
                </div>

                <!-- Footer -->
                <footer class="mt-auto pt-8 border-t border-slate-200 flex flex-col md:flex-row items-center justify-between text-xs font-medium text-slate-500">
                    <p>&copy; 2026 SMKN 1 Wringin. All rights reserved.</p>
                    <div class="flex gap-4 mt-4 md:mt-0">
                        <a href="#" class="hover:text-brand-600 transition-colors">Bantuan</a>
                        <a href="#" class="hover:text-brand-600 transition-colors">Panduan Sistem</a>
                    </div>
                </footer>
            </div>
        </div>
    </main>
    </div>

    <script>
        const adminSidebar = document.getElementById('adminSidebar');
        const adminSidebarBackdrop = document.getElementById('adminSidebarBackdrop');
        const adminSidebarOpenBtn = document.getElementById('adminSidebarOpen');
        const adminSidebarCloseBtn = document.getElementById('adminSidebarClose');
        const adminProfileWrapper = document.getElementById('adminProfileMenuWrapper');
        const adminProfileToggle = document.getElementById('adminProfileToggle');
        const adminProfileDropdown = document.getElementById('adminProfileDropdown');

        function openAdminSidebar() {
            adminSidebar?.classList.remove('-translate-x-full');
            adminSidebarBackdrop?.classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        }

        function closeAdminSidebar() {
            adminSidebar?.classList.add('-translate-x-full');
            adminSidebarBackdrop?.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        }

        function closeAdminProfileMenu() {
            adminProfileDropdown?.classList.add('hidden');
        }

        function toggleAdminProfileMenu() {
            if (!adminProfileDropdown) return;

            const isOpen = !adminProfileDropdown.classList.contains('hidden');
            closeAdminProfileMenu();

            if (!isOpen) {
                adminProfileDropdown.classList.remove('hidden');
            }
        }

        adminSidebarOpenBtn?.addEventListener('click', openAdminSidebar);
        adminSidebarCloseBtn?.addEventListener('click', closeAdminSidebar);
        adminSidebarBackdrop?.addEventListener('click', closeAdminSidebar);
        adminProfileToggle?.addEventListener('click', (event) => {
            event.stopPropagation();
            toggleAdminProfileMenu();
        });

        document.addEventListener('click', (event) => {
            if (!event.target.closest('#adminProfileMenuWrapper')) {
                closeAdminProfileMenu();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeAdminProfileMenu();
                closeAdminSidebar();
            }
        });

        adminSidebar?.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeAdminSidebar();
                }
            });
        });

        feather.replace();

        // Real-time Chart Initialization
        const ctx = document.getElementById('usageChart').getContext('2d');
        const usageChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: Array(10).fill(''),
                datasets: [{
                    label: 'CPU Usage',
                    data: Array(10).fill(0),
                    borderColor: '#f97316',
                    backgroundColor: 'rgba(249, 115, 22, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }, {
                    label: 'RAM Usage',
                    data: Array(10).fill(0),
                    borderColor: '#3b82f6',
                    backgroundColor: 'rgba(59, 130, 246, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 0
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100,
                        ticks: { display: false },
                        grid: { display: false }
                    },
                    x: {
                        ticks: { display: false },
                        grid: { display: false }
                    }
                },
                animation: { duration: 800 }
            }
        });

        // Simulate Real-time Updates
        function updateStats() {
            const cpu = Math.floor(Math.random() * 30) + 10;
            const ram = Math.floor(Math.random() * 20) + 40;

            usageChart.data.datasets[0].data.push(cpu);
            usageChart.data.datasets[0].data.shift();
            usageChart.data.datasets[1].data.push(ram);
            usageChart.data.datasets[1].data.shift();
            usageChart.update();
        }

        setInterval(updateStats, 2000);
        updateStats();
    </script>
</body>
</html>
