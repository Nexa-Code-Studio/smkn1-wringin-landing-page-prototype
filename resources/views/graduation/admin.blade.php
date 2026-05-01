<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Manajemen Kelulusan</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/icon.png') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Space+Mono&display=swap" rel="stylesheet">
    
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #020617; /* Deep Space Black */
            color: #f8fafc;
        }
        
        .glass-panel {
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.3);
        }
    </style>
</head>
<body class="flex h-screen overflow-hidden text-slate-300">

    <!-- Sidebar -->
    <aside class="w-64 glass-panel h-full flex flex-col flex-shrink-0 relative z-20">
        <!-- Logo -->
        <div class="h-20 flex items-center px-6 border-b border-white/10">
            <div class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center mr-3 shadow-[0_0_15px_rgba(37,99,235,0.5)]">
                <i data-feather="award" class="text-white w-5 h-5"></i>
            </div>
            <span class="font-bold text-lg text-white tracking-wide">EduAdmin</span>
        </div>
        
        <!-- Navigation -->
        <div class="flex-1 overflow-y-auto custom-scrollbar py-6 px-4 space-y-2">
            <p class="text-[10px] uppercase tracking-widest text-slate-500 mb-4 px-2 font-semibold">Menu Utama</p>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                <i data-feather="grid" class="w-5 h-5"></i>
                <span class="font-medium text-sm">Dashboard</span>
            </a>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-blue-600/20 text-blue-400 border border-blue-500/20 shadow-[inset_0_0_20px_rgba(37,99,235,0.1)] transition-all">
                <i data-feather="users" class="w-5 h-5"></i>
                <span class="font-medium text-sm">Data Kelulusan</span>
            </a>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                <i data-feather="file-text" class="w-5 h-5"></i>
                <span class="font-medium text-sm">Laporan</span>
            </a>
            
            <a href="#" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-400 hover:text-white hover:bg-white/5 transition-all">
                <i data-feather="settings" class="w-5 h-5"></i>
                <span class="font-medium text-sm">Pengaturan</span>
            </a>
        </div>
        
        <!-- Upgrade Card -->
        <div class="p-4">
            <div class="glass-panel p-4 rounded-2xl relative overflow-hidden group">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600/20 to-purple-600/20 opacity-0 group-hover:opacity-100 transition-opacity"></div>
                <div class="relative z-10">
                    <h4 class="text-sm font-bold text-white mb-1">Tahun Ajaran 2026</h4>
                    <p class="text-xs text-slate-400 mb-3">Sistem terhubung & aktif.</p>
                    <button class="w-full py-2 bg-blue-600 hover:bg-blue-500 text-white text-xs font-semibold rounded-lg transition-colors">Tutup Sesi</button>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full relative overflow-hidden">
        
        <!-- Ambient Light Effects -->
        <div class="absolute top-0 left-1/4 w-96 h-96 bg-blue-600/10 rounded-full blur-[100px] pointer-events-none"></div>
        <div class="absolute bottom-0 right-1/4 w-96 h-96 bg-purple-600/10 rounded-full blur-[100px] pointer-events-none"></div>
        
        <!-- Top Navbar -->
        <header class="h-20 glass-panel border-x-0 border-t-0 flex items-center justify-between px-8 relative z-10">
            <div class="flex items-center gap-4">
                <h1 class="text-xl font-bold text-white tracking-tight">Manajemen Kelulusan</h1>
                <span class="px-3 py-1 bg-white/10 text-xs rounded-full text-slate-300 font-medium">Tahun 2026</span>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Search -->
                <div class="relative hidden md:block">
                    <i data-feather="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    <input type="text" placeholder="Cari siswa atau NISN..." class="w-64 bg-slate-900/50 border border-white/10 rounded-full py-2 pl-10 pr-4 text-sm text-white placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all">
                </div>
                
                <div class="flex items-center gap-3">
                    <button class="relative p-2 text-slate-400 hover:text-white transition-colors">
                        <i data-feather="bell" class="w-5 h-5"></i>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button>
                    <div class="w-px h-6 bg-white/10 mx-1"></div>
                    <div class="flex items-center gap-3 cursor-pointer group">
                        <div class="w-9 h-9 rounded-full bg-gradient-to-tr from-blue-500 to-purple-500 p-[2px]">
                            <img src="https://ui-avatars.com/api/?name=Admin+User&background=0D8ABC&color=fff" alt="Admin" class="w-full h-full rounded-full border border-slate-900">
                        </div>
                        <div class="hidden md:block">
                            <p class="text-sm font-semibold text-white group-hover:text-blue-400 transition-colors">Admin Wringin</p>
                            <p class="text-[10px] text-slate-400">Super Administrator</p>
                        </div>
                        <i data-feather="chevron-down" class="w-4 h-4 text-slate-400"></i>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Scroll Area -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 relative z-10">
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Stat 1 -->
                <div class="glass-panel p-5 rounded-2xl flex items-center justify-between group hover:border-blue-500/30 transition-all">
                    <div>
                        <p class="text-xs text-slate-400 mb-1 font-medium uppercase tracking-wider">Total Siswa</p>
                        <h3 class="text-2xl font-bold text-white">450</h3>
                        <p class="text-[10px] text-emerald-400 mt-1 flex items-center gap-1">
                            <i data-feather="trending-up" class="w-3 h-3"></i> +12 tahun ini
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-blue-500/10 flex items-center justify-center text-blue-400 group-hover:scale-110 transition-transform">
                        <i data-feather="users" class="w-6 h-6"></i>
                    </div>
                </div>
                
                <!-- Stat 2 -->
                <div class="glass-panel p-5 rounded-2xl flex items-center justify-between group hover:border-emerald-500/30 transition-all">
                    <div>
                        <p class="text-xs text-slate-400 mb-1 font-medium uppercase tracking-wider">Lulus</p>
                        <h3 class="text-2xl font-bold text-white">435</h3>
                        <p class="text-[10px] text-emerald-400 mt-1">96.6% Persentase</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/10 flex items-center justify-center text-emerald-400 group-hover:scale-110 transition-transform">
                        <i data-feather="check-circle" class="w-6 h-6"></i>
                    </div>
                </div>
                
                <!-- Stat 3 -->
                <div class="glass-panel p-5 rounded-2xl flex items-center justify-between group hover:border-red-500/30 transition-all">
                    <div>
                        <p class="text-xs text-slate-400 mb-1 font-medium uppercase tracking-wider">Tidak Lulus</p>
                        <h3 class="text-2xl font-bold text-white">5</h3>
                        <p class="text-[10px] text-red-400 mt-1">1.1% Persentase</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-red-500/10 flex items-center justify-center text-red-400 group-hover:scale-110 transition-transform">
                        <i data-feather="x-circle" class="w-6 h-6"></i>
                    </div>
                </div>
                
                <!-- Stat 4 -->
                <div class="glass-panel p-5 rounded-2xl flex items-center justify-between group hover:border-amber-500/30 transition-all">
                    <div>
                        <p class="text-xs text-slate-400 mb-1 font-medium uppercase tracking-wider">Belum Proses</p>
                        <h3 class="text-2xl font-bold text-white">10</h3>
                        <p class="text-[10px] text-slate-500 mt-1">Menunggu verifikasi</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-amber-500/10 flex items-center justify-center text-amber-400 group-hover:scale-110 transition-transform">
                        <i data-feather="clock" class="w-6 h-6"></i>
                    </div>
                </div>
            </div>

            <!-- Main Data Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Data Table (Takes 2 columns) -->
                <div class="lg:col-span-2 glass-panel rounded-3xl overflow-hidden flex flex-col">
                    <div class="p-6 border-b border-white/5 flex items-center justify-between bg-white/[0.02]">
                        <h2 class="text-lg font-bold text-white">Daftar Status Kelulusan</h2>
                        <div class="flex gap-2">
                            <button class="px-3 py-1.5 glass-panel hover:bg-white/10 rounded-lg text-xs font-medium transition-colors flex items-center gap-2">
                                <i data-feather="filter" class="w-3 h-3"></i> Filter
                            </button>
                            <button class="px-3 py-1.5 bg-blue-600 hover:bg-blue-500 rounded-lg text-xs font-medium text-white transition-colors flex items-center gap-2 shadow-lg shadow-blue-500/20">
                                <i data-feather="plus" class="w-3 h-3"></i> Tambah Data
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-white/5 text-[10px] uppercase tracking-wider text-slate-400 bg-white/[0.01]">
                                    <th class="px-6 py-4 font-semibold">Siswa</th>
                                    <th class="px-6 py-4 font-semibold">NISN</th>
                                    <th class="px-6 py-4 font-semibold">Jurusan</th>
                                    <th class="px-6 py-4 font-semibold">Status</th>
                                    <th class="px-6 py-4 font-semibold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-white/5">
                                <!-- Row 1 -->
                                <tr class="hover:bg-white/[0.02] transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="https://ui-avatars.com/api/?name=Ahmad+Budi&background=0D8ABC&color=fff" class="w-8 h-8 rounded-full">
                                            <div>
                                                <p class="font-medium text-white group-hover:text-blue-400 transition-colors">Ahmad Budi Santoso</p>
                                                <p class="text-[10px] text-slate-500 font-mono">XII RPL 1</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-slate-300">0012345678</td>
                                    <td class="px-6 py-4 text-slate-400 text-xs">Rekayasa Perangkat Lunak</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> Lulus
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="p-1.5 text-slate-400 hover:text-blue-400 transition-colors"><i data-feather="edit-2" class="w-4 h-4"></i></button>
                                        <button class="p-1.5 text-slate-400 hover:text-red-400 transition-colors"><i data-feather="trash-2" class="w-4 h-4"></i></button>
                                    </td>
                                </tr>
                                <!-- Row 2 -->
                                <tr class="hover:bg-white/[0.02] transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="https://ui-avatars.com/api/?name=Siti+Aminah&background=b91c1c&color=fff" class="w-8 h-8 rounded-full">
                                            <div>
                                                <p class="font-medium text-white group-hover:text-blue-400 transition-colors">Siti Aminah Wijaya</p>
                                                <p class="text-[10px] text-slate-500 font-mono">XII TKJ 2</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-slate-300">0087654321</td>
                                    <td class="px-6 py-4 text-slate-400 text-xs">Teknik Komputer & Jaringan</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-medium bg-red-500/10 text-red-400 border border-red-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Tidak Lulus
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="p-1.5 text-slate-400 hover:text-blue-400 transition-colors"><i data-feather="edit-2" class="w-4 h-4"></i></button>
                                        <button class="p-1.5 text-slate-400 hover:text-red-400 transition-colors"><i data-feather="trash-2" class="w-4 h-4"></i></button>
                                    </td>
                                </tr>
                                <!-- Row 3 -->
                                <tr class="hover:bg-white/[0.02] transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="https://ui-avatars.com/api/?name=Dika+Pratama&background=f59e0b&color=fff" class="w-8 h-8 rounded-full">
                                            <div>
                                                <p class="font-medium text-white group-hover:text-blue-400 transition-colors">Dika Pratama</p>
                                                <p class="text-[10px] text-slate-500 font-mono">XII TKRO 1</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-slate-300">0099887766</td>
                                    <td class="px-6 py-4 text-slate-400 text-xs">Teknik Kendaraan Ringan</td>
                                    <td class="px-6 py-4">
                                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-medium bg-amber-500/10 text-amber-400 border border-amber-500/20">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> Diproses
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <button class="p-1.5 text-slate-400 hover:text-blue-400 transition-colors"><i data-feather="edit-2" class="w-4 h-4"></i></button>
                                        <button class="p-1.5 text-slate-400 hover:text-red-400 transition-colors"><i data-feather="trash-2" class="w-4 h-4"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-4 border-t border-white/5 bg-white/[0.01] flex items-center justify-between text-xs text-slate-400 mt-auto">
                        <p>Menampilkan 1-3 dari 450 data</p>
                        <div class="flex gap-1">
                            <button class="w-7 h-7 rounded glass-panel flex items-center justify-center hover:bg-white/10 transition-colors cursor-not-allowed opacity-50"><i data-feather="chevron-left" class="w-3 h-3"></i></button>
                            <button class="w-7 h-7 rounded bg-blue-600 text-white flex items-center justify-center font-medium">1</button>
                            <button class="w-7 h-7 rounded glass-panel flex items-center justify-center hover:bg-white/10 transition-colors">2</button>
                            <button class="w-7 h-7 rounded glass-panel flex items-center justify-center hover:bg-white/10 transition-colors">3</button>
                            <span class="w-7 h-7 flex items-center justify-center">...</span>
                            <button class="w-7 h-7 rounded glass-panel flex items-center justify-center hover:bg-white/10 transition-colors"><i data-feather="chevron-right" class="w-3 h-3"></i></button>
                        </div>
                    </div>
                </div>
                
                <!-- Side Panel (Takes 1 column) -->
                <div class="flex flex-col gap-8">
                    <!-- Import Card -->
                    <div class="glass-panel p-6 rounded-3xl relative overflow-hidden">
                        <div class="absolute -right-10 -top-10 w-32 h-32 bg-blue-500/20 rounded-full blur-2xl"></div>
                        <h3 class="text-base font-bold text-white mb-2 relative z-10">Import Data Excel</h3>
                        <p class="text-xs text-slate-400 mb-5 relative z-10">Unggah file Excel (.xlsx) untuk memperbarui data kelulusan secara massal.</p>
                        
                        <div class="border-2 border-dashed border-white/10 rounded-xl p-6 flex flex-col items-center justify-center text-center bg-black/20 hover:border-blue-500/50 hover:bg-blue-500/5 transition-all cursor-pointer relative z-10 group">
                            <div class="w-12 h-12 bg-white/5 rounded-full flex items-center justify-center mb-3 text-slate-400 group-hover:text-blue-400 group-hover:bg-blue-500/10 transition-all">
                                <i data-feather="upload-cloud" class="w-6 h-6"></i>
                            </div>
                            <p class="text-sm font-medium text-white mb-1">Klik untuk unggah</p>
                            <p class="text-[10px] text-slate-500">Maks. ukuran file 5MB</p>
                        </div>
                        
                        <button class="w-full mt-4 py-2.5 glass-panel hover:bg-white/10 text-white text-sm font-medium rounded-xl transition-colors relative z-10 flex items-center justify-center gap-2">
                            <i data-feather="download" class="w-4 h-4"></i> Unduh Template
                        </button>
                    </div>

                    <!-- Recent Activity -->
                    <div class="glass-panel p-6 rounded-3xl flex-1">
                        <h3 class="text-base font-bold text-white mb-5 flex items-center justify-between">
                            Aktivitas Terkini
                            <button class="text-[10px] text-blue-400 hover:text-blue-300 font-medium uppercase tracking-wider">Lihat Semua</button>
                        </h3>
                        
                        <div class="space-y-5">
                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-full bg-blue-500/10 flex items-center justify-center flex-shrink-0 text-blue-400 border border-blue-500/20">
                                    <i data-feather="edit" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-300"><span class="font-medium text-white">Admin Wringin</span> memperbarui status <span class="font-medium text-white">Siti Aminah</span></p>
                                    <p class="text-[10px] text-slate-500 mt-1">10 menit yang lalu</p>
                                </div>
                            </div>
                            
                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-full bg-emerald-500/10 flex items-center justify-center flex-shrink-0 text-emerald-400 border border-emerald-500/20">
                                    <i data-feather="file-plus" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-300"><span class="font-medium text-white">System</span> menambahkan 450 data baru</p>
                                    <p class="text-[10px] text-slate-500 mt-1">2 jam yang lalu</p>
                                </div>
                            </div>
                            
                            <div class="flex gap-4">
                                <div class="w-8 h-8 rounded-full bg-purple-500/10 flex items-center justify-center flex-shrink-0 text-purple-400 border border-purple-500/20">
                                    <i data-feather="settings" class="w-3.5 h-3.5"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-slate-300"><span class="font-medium text-white">Admin Wringin</span> mengubah waktu rilis</p>
                                    <p class="text-[10px] text-slate-500 mt-1">Kemarin, 14:30</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
            <!-- Footer -->
            <footer class="mt-8 pt-6 border-t border-white/5 flex flex-col md:flex-row items-center justify-between text-xs text-slate-500">
                <p>&copy; 2026 SMKN 1 Wringin. All rights reserved.</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <a href="#" class="hover:text-slate-300 transition-colors">Bantuan</a>
                    <a href="#" class="hover:text-slate-300 transition-colors">Panduan Sistem</a>
                </div>
            </footer>
            
        </div>
    </main>

    <script>
        feather.replace();
    </script>
</body>
</html>
