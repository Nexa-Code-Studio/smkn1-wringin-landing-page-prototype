<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Data Kelulusan - Admin SMKN 1 Wringin</title>
    
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
            
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl text-slate-500 hover:text-brand-700 hover:bg-brand-50 transition-all">
                <i data-feather="grid" class="w-5 h-5"></i>
                <span class="font-medium text-sm">Dashboard</span>
            </a>
            
            <a href="{{ route('admin.graduation') }}" class="flex items-center gap-3 px-4 py-3 rounded-xl bg-brand-50 text-brand-600 border border-brand-100 shadow-sm transition-all">
                <i data-feather="users" class="w-5 h-5"></i>
                <span class="font-bold text-sm">Data Kelulusan</span>
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
        
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-full relative overflow-hidden bg-slate-50">
        
        <!-- Top Navbar -->
        <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-8 relative z-[80] overflow-visible">
            <div class="flex items-center gap-4">
                <h1 class="text-xl font-bold text-slate-800 tracking-tight">Manajemen Kelulusan</h1>
                <span class="px-3 py-1 bg-brand-50 text-brand-600 border border-brand-100 text-xs rounded-full font-bold">Tahun 2026</span>
            </div>
            
            <div class="flex items-center gap-6">
                <!-- Search -->
                <div class="relative hidden md:block">
                    <i data-feather="search" class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-slate-400"></i>
                    <input type="text" placeholder="Cari siswa atau NISN..." class="w-64 bg-slate-50 border border-slate-200 rounded-full py-2 pl-10 pr-4 text-sm text-slate-700 placeholder-slate-400 focus:outline-none focus:border-brand-500 focus:ring-1 focus:ring-brand-500 transition-all font-medium">
                </div>
                
                <div class="flex items-center gap-3">
                    <div class="relative" id="profileMenuWrapper">
                        <button type="button" onclick="toggleProfileMenu(event)" class="flex items-center gap-3 cursor-pointer group rounded-2xl px-2 py-1.5 hover:bg-slate-50 transition-colors">
                            <div class="w-9 h-9 rounded-full bg-slate-100 p-[2px] border border-slate-200">
                                <img src="https://ui-avatars.com/api/?name=Admin+User&background=1E5460&color=fff" alt="Admin" class="w-full h-full rounded-full">
                            </div>
                            <div class="hidden md:block text-left">
                                <p class="text-sm font-bold text-slate-700 group-hover:text-brand-600 transition-colors">Admin Wringin</p>
                                <p class="text-[10px] font-medium text-slate-500">Super Administrator</p>
                            </div>
                            <i data-feather="chevron-down" class="w-4 h-4 text-slate-400 group-hover:text-brand-600"></i>
                        </button>

                        <div id="profileDropdown" class="hidden absolute right-0 top-full mt-3 w-52 rounded-2xl border border-slate-200 bg-white shadow-xl z-[120] overflow-hidden">
                            <div class="px-4 py-3 border-b border-slate-100 bg-slate-50/60">
                                <p class="text-sm font-bold text-slate-700">Admin Wringin</p>
                                <p class="text-[10px] font-medium text-slate-500">Sesi administrator aktif</p>
                            </div>
                            <form action="{{ route('admin.logout') }}" method="POST" class="p-2">
                                @csrf
                                <button type="submit" class="w-full flex items-center gap-2 px-3 py-2.5 rounded-xl text-sm font-bold text-red-600 hover:bg-red-50 transition-colors text-left">
                                    <i data-feather="log-out" class="w-4 h-4"></i>
                                    Keluar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Scroll Area -->
        <div class="flex-1 overflow-y-auto custom-scrollbar p-8 relative z-10 hero-pattern">
            
            @if(session('success'))
            <div class="mb-8 p-4 bg-emerald-50 border border-emerald-200 text-emerald-700 rounded-2xl flex items-center gap-3 animate-fade-in-down shadow-sm">
                <i data-feather="check-circle" class="w-5 h-5 text-emerald-500"></i>
                <p class="text-sm font-bold">{{ session('success') }}</p>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-8 p-4 bg-red-50 border border-red-200 text-red-700 rounded-2xl animate-fade-in-down shadow-sm">
                <div class="flex items-center gap-3 mb-2">
                    <i data-feather="alert-circle" class="w-5 h-5 text-red-500"></i>
                    <p class="text-sm font-bold">Terjadi Kesalahan:</p>
                </div>
                <ul class="list-disc list-inside text-xs font-medium ml-8">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <!-- Stat 1 -->
                <div class="bg-white p-5 rounded-2xl flex items-center justify-between border border-slate-100 shadow-sm group hover:border-brand-300 hover:shadow-md transition-all">
                    <div>
                        <p class="text-xs text-slate-500 mb-1 font-bold uppercase tracking-wider">Total Siswa</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $stats['total'] }}</h3>
                        <p class="text-[10px] text-brand-600 font-medium mt-1 flex items-center gap-1">
                            <i data-feather="users" class="w-3 h-3"></i> Terdaftar
                        </p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-brand-50 flex items-center justify-center text-brand-600 group-hover:scale-110 transition-transform">
                        <i data-feather="users" class="w-6 h-6"></i>
                    </div>
                </div>
                
                <!-- Stat 2 -->
                <div class="bg-white p-5 rounded-2xl flex items-center justify-between border border-slate-100 shadow-sm group hover:border-emerald-300 hover:shadow-md transition-all">
                    <div>
                        <p class="text-xs text-slate-500 mb-1 font-bold uppercase tracking-wider">Lulus</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $stats['lulus'] }}</h3>
                        <p class="text-[10px] text-emerald-600 font-medium mt-1">Status Lulus</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-emerald-50 flex items-center justify-center text-emerald-500 group-hover:scale-110 transition-transform">
                        <i data-feather="check-circle" class="w-6 h-6"></i>
                    </div>
                </div>
                
                <!-- Stat 3 -->
                <div class="bg-white p-5 rounded-2xl flex items-center justify-between border border-slate-100 shadow-sm group hover:border-red-300 hover:shadow-md transition-all">
                    <div>
                        <p class="text-xs text-slate-500 mb-1 font-bold uppercase tracking-wider">Tidak Lulus</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $stats['tidak_lulus'] }}</h3>
                        <p class="text-[10px] text-red-600 font-medium mt-1">Status Tidak Lulus</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-red-50 flex items-center justify-center text-red-500 group-hover:scale-110 transition-transform">
                        <i data-feather="x-circle" class="w-6 h-6"></i>
                    </div>
                </div>
                
                <!-- Stat 4 -->
                <div onclick="showTanpaFotoModal()" class="bg-white p-5 rounded-2xl flex items-center justify-between border border-slate-100 shadow-sm group hover:border-rose-300 hover:shadow-md transition-all cursor-pointer">
                    <div>
                        <p class="text-xs text-slate-500 mb-1 font-bold uppercase tracking-wider">Tanpa Foto</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $stats['tanpa_foto'] }}</h3>
                        <p class="text-[10px] text-rose-600 font-medium mt-1">Siswa belum ada foto</p>
                    </div>
                    <div class="w-12 h-12 rounded-xl bg-rose-50 flex items-center justify-center text-rose-500 group-hover:scale-110 transition-transform">
                        <i data-feather="image" class="w-6 h-6"></i>
                    </div>
                </div>
            </div>

            <!-- Main Data Section -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                
                <!-- Data Table (Takes 2 columns) -->
                <div class="lg:col-span-2 bg-white rounded-3xl overflow-hidden flex flex-col border border-slate-100 shadow-sm">
                    <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-white">
                        <h2 class="text-lg font-bold text-slate-800">Daftar Status Kelulusan</h2>
                        <div class="flex gap-2">
                            <button class="px-3 py-1.5 bg-slate-50 border border-slate-200 text-slate-600 hover:bg-slate-100 rounded-lg text-xs font-bold transition-colors flex items-center gap-2">
                                <i data-feather="filter" class="w-3 h-3"></i> Filter
                            </button>
                        </div>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="border-b border-slate-100 text-[10px] uppercase tracking-wider text-slate-500 bg-slate-50/50">
                                    <th class="px-6 py-4 font-bold">Siswa</th>
                                    <th class="px-6 py-4 font-bold">NISN</th>
                                    <th class="px-6 py-4 font-bold">Jurusan / Kelas</th>
                                    <th class="px-6 py-4 font-bold">Status</th>
                                    <th class="px-6 py-4 font-bold text-right">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="text-sm divide-y divide-slate-50">
                                @forelse($siswas as $siswa)
                                <tr class="hover:bg-slate-50 transition-colors group">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center gap-3">
                                            <img src="{{ $siswa->photoUrl() ?: 'https://ui-avatars.com/api/?name='.urlencode($siswa->nama).'&background=1E5460&color=fff' }}" class="w-8 h-8 rounded-full object-cover">
                                            <div>
                                                <p class="font-bold text-slate-700 group-hover:text-brand-600 transition-colors">{{ $siswa->nama }}</p>
                                                <p class="text-[10px] text-slate-500 font-mono">{{ $siswa->username }}</p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 font-mono text-slate-600 font-medium">{{ $siswa->nisn }}</td>
                                    <td class="px-6 py-4 text-slate-500 text-xs font-medium">{{ $siswa->kelas }}</td>
                                    <td class="px-6 py-4">
                                        @php
                                            $statusNormalized = strtoupper(trim((string) ($siswa->status_kelulusan ?? '')));
                                        @endphp
                                        @if($statusNormalized === 'LULUS')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Lulus
                                            </span>
                                        @elseif($statusNormalized === 'TIDAK LULUS')
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-red-50 text-red-600 border border-red-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Tidak Lulus
                                            </span>
                                        @else
                                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-50 text-slate-500 border border-slate-200">
                                                <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Belum Ada
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-right">
                                        <div class="relative inline-block text-left" data-action-menu>
                                            <button type="button" class="p-1.5 text-slate-400 hover:text-brand-600 rounded-lg hover:bg-slate-100 transition-colors" data-menu-button aria-label="Aksi siswa" data-siswa-id="{{ $siswa->id }}">
                                                <i data-feather="more-vertical" class="w-4 h-4"></i>
                                            </button>
                                            <div class="hidden absolute right-0 mt-2 w-36 rounded-xl border border-slate-200 bg-white shadow-lg z-30 overflow-hidden" data-menu-dropdown>
                                                <button type="button" class="w-full px-3 py-2.5 text-left text-xs font-semibold text-slate-600 hover:bg-slate-50 transition-colors" data-action="detail" data-siswa-id="{{ $siswa->id }}">Detail</button>
                                                <button type="button" class="w-full px-3 py-2.5 text-left text-xs font-semibold text-amber-700 hover:bg-amber-50 transition-colors" data-action="edit" data-siswa-id="{{ $siswa->id }}">Edit</button>
                                                <button type="button" class="w-full px-3 py-2.5 text-left text-xs font-semibold text-red-600 hover:bg-red-50 transition-colors" data-action="delete" data-siswa-id="{{ $siswa->id }}">Hapus</button>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="px-6 py-12 text-center text-slate-500 font-medium italic">
                                        Belum ada data siswa. Silakan import dari menu di samping.
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    
                    <div class="p-4 border-t border-slate-100 bg-white flex items-center justify-between text-xs font-medium text-slate-500 mt-auto">
                        <p>Menampilkan {{ $siswas->firstItem() ?? 0 }}-{{ $siswas->lastItem() ?? 0 }} dari {{ $siswas->total() }} data</p>
                        <div class="flex gap-1">
                            {{ $siswas->links() }}
                        </div>
                    </div>
                </div>
                
                <!-- Side Panel (Takes 1 column) -->
                <div class="flex flex-col gap-8">
                    <!-- Import Data Section -->
                    <div class="space-y-8">
                        <!-- Graduation Variables Card -->
                        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden">
                            <div class="absolute -right-10 -top-10 w-32 h-32 bg-brand-500/10 rounded-full blur-2xl"></div>
                            <h3 class="text-base font-bold text-slate-800 mb-2 relative z-10">Variabel Pengumuman</h3>
                            <p class="text-xs text-slate-500 mb-5 relative z-10 font-medium">Atur data angkatan dan lulusan yang akan ditampilkan di halaman pengumuman kelulusan.</p>

                            <form action="{{ route('admin.graduation-setting.update') }}" method="POST" class="space-y-4 relative z-10">
                                @csrf
                                <div>
                                    <label for="angkatan" class="block text-[11px] font-bold uppercase tracking-wide text-slate-500 mb-1">Angkatan</label>
                                    <input
                                        type="text"
                                        id="angkatan"
                                        name="angkatan"
                                        value="{{ old('angkatan', $graduationSetting->angkatan ?? '2026') }}"
                                        class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500"
                                        placeholder="Contoh: 2026"
                                        required
                                    >
                                </div>

                                <div>
                                    <label for="lulusan" class="block text-[11px] font-bold uppercase tracking-wide text-slate-500 mb-1">Lulusan</label>
                                    <input
                                        type="text"
                                        id="lulusan"
                                        name="lulusan"
                                        value="{{ old('lulusan', $graduationSetting->lulusan ?? '2026') }}"
                                        class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm text-slate-700 focus:outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500"
                                        placeholder="Contoh: 2026"
                                        required
                                    >
                                </div>

                                <button type="submit" class="w-full py-2.5 bg-brand-600 hover:bg-brand-700 text-white text-sm font-bold rounded-xl transition-colors shadow-sm shadow-brand-600/20">
                                    Simpan Variabel
                                </button>
                            </form>
                        </div>

                        <!-- Import Card -->
                        <div class="bg-brand-600 p-6 rounded-3xl relative overflow-hidden text-white shadow-lg shadow-brand-600/20">
                            <div class="absolute -right-10 -top-10 w-32 h-32 bg-white/10 rounded-full blur-2xl"></div>
                            <h3 class="text-base font-bold mb-2 relative z-10">Import Data Siswa</h3>
                            <p class="text-xs text-brand-100 mb-5 relative z-10 font-medium">Unggah file Excel (.xlsx) atau CSV untuk memperbarui data kelulusan secara massal.</p>
                            
                            <form action="{{ route('admin.import-excel') }}" method="POST" enctype="multipart/form-data" id="excel-form">
                                @csrf
                                <label class="border-2 border-dashed border-white/30 rounded-xl p-6 flex flex-col items-center justify-center text-center bg-black/10 hover:border-white/50 hover:bg-white/5 transition-all cursor-pointer relative z-10 group mb-4">
                                    <input type="file" name="file" id="excel-input" class="hidden" onchange="confirmImport('excel')">
                                    <div class="w-12 h-12 bg-white/20 rounded-full flex items-center justify-center mb-3 text-white group-hover:scale-110 transition-transform">
                                        <i data-feather="upload-cloud" class="w-6 h-6"></i>
                                    </div>
                                    <p class="text-sm font-bold text-white mb-1">Pilih File Excel</p>
                                    <p class="text-[10px] text-brand-200 font-medium">Maks. ukuran file 10MB</p>
                                </label>
                            </form>
                            
                            <a href="{{ route('admin.template-siswa') }}" class="w-full py-2.5 bg-white text-brand-600 hover:bg-brand-50 text-sm font-bold rounded-xl transition-colors relative z-10 flex items-center justify-center gap-2 shadow-sm">
                                <i data-feather="download" class="w-4 h-4"></i> Unduh Template
                            </a>
                        </div>

                        <!-- Photo ZIP Import -->
                        <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm relative overflow-hidden">
                            <div class="absolute -right-10 -top-10 w-32 h-32 bg-amber-500/10 rounded-full blur-2xl"></div>
                            <h3 class="text-base font-bold text-slate-800 mb-2 relative z-10">Import Foto (ZIP)</h3>
                            <p class="text-xs text-slate-500 mb-5 relative z-10 font-medium">Unggah file ZIP berisi foto siswa. Nama file foto harus sesuai dengan NISN (contoh: 0012345678.jpg). Proses berjalan di background.</p>
                            
                            <form action="{{ route('admin.import-zip') }}" method="POST" enctype="multipart/form-data" id="zip-form">
                                @csrf
                                <label class="border-2 border-dashed border-slate-200 rounded-xl p-6 flex flex-col items-center justify-center text-center bg-slate-50 hover:border-brand-300 hover:bg-brand-50/30 transition-all cursor-pointer relative z-10 group">
                                    <input type="file" name="file" id="zip-input" class="hidden" onchange="confirmImport('zip')">
                                    <div class="w-12 h-12 bg-slate-100 rounded-full flex items-center justify-center mb-3 text-slate-400 group-hover:text-brand-600 group-hover:bg-brand-50 transition-all">
                                        <i data-feather="image" class="w-6 h-6"></i>
                                    </div>
                                    <p class="text-sm font-bold text-slate-700 mb-1">Pilih File ZIP</p>
                                    <p class="text-[10px] text-red-500 font-bold uppercase tracking-wider">Maks. 50MB</p>
                                </label>
                            </form>

                            <div id="photoImportProgress" class="{{ $latestPhotoImportJob ? '' : 'hidden' }} mt-5 relative z-10 rounded-2xl border border-slate-100 bg-slate-50 p-4">
                                <div class="flex items-start justify-between gap-3 mb-3">
                                    <div>
                                        <p class="text-xs font-extrabold text-slate-700">Status Import Foto</p>
                                        <p id="photoImportFilename" class="text-[10px] text-slate-500 font-medium truncate max-w-48">{{ $latestPhotoImportJob->original_filename ?? '-' }}</p>
                                    </div>
                                    <span id="photoImportStatus" class="px-2 py-1 rounded-full bg-slate-100 text-slate-600 text-[10px] font-bold uppercase">{{ $latestPhotoImportJob->status ?? 'idle' }}</span>
                                </div>

                                <div class="w-full h-2 bg-white rounded-full overflow-hidden border border-slate-100 mb-3">
                                    <div id="photoImportBar" class="h-full bg-brand-600 rounded-full transition-all duration-300" style="width: {{ $latestPhotoImportJob && $latestPhotoImportJob->total_files > 0 ? round(($latestPhotoImportJob->processed_files / $latestPhotoImportJob->total_files) * 100) : 0 }}%"></div>
                                </div>

                                <div class="grid grid-cols-3 gap-2 text-center">
                                    <div class="rounded-xl bg-white border border-slate-100 p-2">
                                        <p id="photoImportProcessed" class="text-sm font-extrabold text-slate-800">{{ $latestPhotoImportJob->processed_files ?? 0 }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase">Diproses</p>
                                    </div>
                                    <div class="rounded-xl bg-white border border-slate-100 p-2">
                                        <p id="photoImportSuccess" class="text-sm font-extrabold text-emerald-600">{{ $latestPhotoImportJob->success_count ?? 0 }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase">Sukses</p>
                                    </div>
                                    <div class="rounded-xl bg-white border border-slate-100 p-2">
                                        <p id="photoImportFailed" class="text-sm font-extrabold text-red-600">{{ $latestPhotoImportJob->failed_count ?? 0 }}</p>
                                        <p class="text-[9px] font-bold text-slate-400 uppercase">Gagal</p>
                                    </div>
                                </div>

                                <p id="photoImportMessage" class="mt-3 text-[10px] text-slate-500 font-medium">{{ $latestPhotoImportJob ? 'Menunggu pembaruan status worker...' : '' }}</p>
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
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const siswaApiBaseUrl = '/admin/api/siswa';
        const photoImportStatusUrlTemplate = @json(route('admin.import-jobs.status', ['uuid' => '__UUID__']));
        const initialPhotoImportJobUuid = @json(session('import_job_uuid') ?? ($latestPhotoImportJob->uuid ?? null));
        let siswaDeleteTargetId = null;
        let photoImportPollTimer = null;

        function confirmImport(type) {
            const modal = document.getElementById('confirmModal');
            const title = document.getElementById('modalTitle');
            const desc = document.getElementById('modalDesc');
            const confirmBtn = document.getElementById('confirmBtn');
            const fileInput = type === 'excel' ? document.getElementById('excel-input') : document.getElementById('zip-input');

            if (!fileInput.value) return;

            const fileName = fileInput.files[0].name;

            if (type === 'excel') {
                title.innerText = 'Konfirmasi Import Data';
                desc.innerHTML = `Apakah Anda yakin ingin mengimport data siswa dari file <span class="font-bold text-slate-800">${fileName}</span>? Data yang sudah ada dengan NISN yang sama akan diperbarui.`;
                confirmBtn.onclick = () => {
                    showLoading();
                    document.getElementById('excel-form').submit();
                };
            } else {
                if (fileInput.files[0].size > 50 * 1024 * 1024) {
                    alert('Ukuran file ZIP terlalu besar! Maksimal adalah 50MB. Silakan kompres ulang atau bagi menjadi beberapa bagian.');
                    closeModal();
                    return;
                }

                title.innerText = 'Konfirmasi Import Foto';
                desc.innerHTML = `Apakah Anda yakin ingin mengimport foto dari file <span class="font-bold text-slate-800">${fileName}</span>? Sistem akan mengonversi foto secara otomatis ke format WebP.`;
                confirmBtn.onclick = () => {
                    submitZipImport();
                };
            }

            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeModal() {
            const modal = document.getElementById('confirmModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.getElementById('excel-input').value = '';
            document.getElementById('zip-input').value = '';
        }

        function showLoading() {
            const confirmModal = document.getElementById('confirmModal');
            confirmModal.classList.add('hidden');
            confirmModal.classList.remove('flex');

            const loadingModal = document.getElementById('loadingModal');
            loadingModal.classList.remove('hidden');
            loadingModal.classList.add('flex');
        }

        function hideLoading() {
            const loadingModal = document.getElementById('loadingModal');
            loadingModal.classList.add('hidden');
            loadingModal.classList.remove('flex');
        }

        function showTanpaFotoModal() {
            const modal = document.getElementById('tanpaFotoModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                feather.replace();
            }, 10);
        }

        function closeTanpaFotoModal() {
            const modal = document.getElementById('tanpaFotoModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function closeAllActionMenus() {
            document.querySelectorAll('[data-menu-dropdown]').forEach((dropdown) => {
                dropdown.classList.add('hidden');
            });
        }

        function toggleProfileMenu(event) {
            event.stopPropagation();
            closeAllActionMenus();

            const dropdown = document.getElementById('profileDropdown');
            dropdown.classList.toggle('hidden');
        }

        function closeProfileMenu() {
            const dropdown = document.getElementById('profileDropdown');
            if (dropdown) {
                dropdown.classList.add('hidden');
            }
        }

        function toggleActionMenu(button) {
            const wrapper = button.closest('[data-action-menu]');
            if (!wrapper) return;

            const dropdown = wrapper.querySelector('[data-menu-dropdown]');
            if (!dropdown) return;

            const isOpen = !dropdown.classList.contains('hidden');
            closeAllActionMenus();

            if (!isOpen) {
                dropdown.classList.remove('hidden');
            }
        }

        function openDetailModal() {
            const modal = document.getElementById('detailSiswaModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                feather.replace();
            }, 10);
        }

        function closeDetailModal() {
            const modal = document.getElementById('detailSiswaModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function openEditModal() {
            const modal = document.getElementById('editSiswaModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }

        function closeEditModal() {
            const modal = document.getElementById('editSiswaModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            hideEditError();
        }

        function openDeleteModal() {
            const modal = document.getElementById('deleteSiswaModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                feather.replace();
            }, 10);
        }

        function closeDeleteModal() {
            const modal = document.getElementById('deleteSiswaModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function closeConfirmModalOnly() {
            const modal = document.getElementById('confirmModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function formatDateDisplay(dateValue) {
            if (!dateValue) return '-';

            const parsed = new Date(dateValue);
            if (Number.isNaN(parsed.getTime())) return '-';

            return parsed.toLocaleDateString('id-ID', {
                day: '2-digit',
                month: 'long',
                year: 'numeric',
            });
        }

        function buildFallbackPhoto(name) {
            return `https://ui-avatars.com/api/?name=${encodeURIComponent(name || 'Siswa')}&background=1E5460&color=fff`;
        }

        function normalizeStatusKelulusan(statusValue) {
            const raw = String(statusValue || '').trim();
            if (!raw) {
                return '';
            }

            const normalized = raw.replace(/\s+/g, ' ').toUpperCase();

            if (normalized === 'LULUS') {
                return 'Lulus';
            }

            if (normalized === 'TIDAK LULUS') {
                return 'Tidak Lulus';
            }

            return '';
        }

        async function fetchSiswaById(siswaId) {
            const response = await fetch(`${siswaApiBaseUrl}/${siswaId}`, {
                method: 'GET',
                headers: {
                    Accept: 'application/json',
                    'X-Requested-With': 'XMLHttpRequest',
                },
            });

            const result = await response.json();

            if (!response.ok || !result.success) {
                throw new Error(result.message || 'Gagal mengambil data siswa.');
            }

            return result.data;
        }

        function fillDetailModal(siswa) {
            document.getElementById('detailSiswaNama').textContent = siswa.nama || '-';
            document.getElementById('detailSiswaUsername').textContent = siswa.username || '-';
            document.getElementById('detailSiswaNisn').textContent = siswa.nisn || '-';
            document.getElementById('detailSiswaKelas').textContent = siswa.kelas || '-';
            document.getElementById('detailSiswaTempatLahir').textContent = siswa.tempat_lahir || '-';
            document.getElementById('detailSiswaTanggalLahir').textContent = formatDateDisplay(siswa.tanggal_lahir);
            const statusDisplay = normalizeStatusKelulusan(siswa.status_kelulusan);
            document.getElementById('detailSiswaStatus').textContent = statusDisplay || 'Belum Ada';

            const foto = siswa.pas_foto_url || buildFallbackPhoto(siswa.nama);
            document.getElementById('detailSiswaFoto').src = foto;
        }

        function fillEditModal(siswa) {
            const form = document.getElementById('editSiswaForm');
            form.dataset.siswaId = String(siswa.id);

            form.elements.username.value = siswa.username || '';
            form.elements.nama.value = siswa.nama || '';
            form.elements.nisn.value = siswa.nisn || '';
            form.elements.kelas.value = siswa.kelas || '';
            form.elements.tempat_lahir.value = siswa.tempat_lahir || '';
            form.elements.tanggal_lahir.value = siswa.tanggal_lahir || '';
            form.elements.status_kelulusan.value = normalizeStatusKelulusan(siswa.status_kelulusan);
        }

        function showEditError(message) {
            const box = document.getElementById('editSiswaError');
            box.textContent = message;
            box.classList.remove('hidden');
        }

        function hideEditError() {
            const box = document.getElementById('editSiswaError');
            box.textContent = '';
            box.classList.add('hidden');
        }

        async function handleMenuAction(action, siswaId) {
            closeAllActionMenus();

            try {
                const siswa = await fetchSiswaById(siswaId);

                if (action === 'detail') {
                    fillDetailModal(siswa);
                    openDetailModal();
                    return;
                }

                if (action === 'edit') {
                    fillEditModal(siswa);
                    openEditModal();
                    return;
                }

                if (action === 'delete') {
                    siswaDeleteTargetId = siswa.id;
                    document.getElementById('deleteSiswaName').textContent = siswa.nama || '-';
                    openDeleteModal();
                }
            } catch (error) {
                alert(error.message || 'Terjadi kesalahan saat memproses aksi.');
            }
        }

        async function submitEditSiswa(event) {
            event.preventDefault();

            const form = event.target;
            const siswaId = form.dataset.siswaId;
            if (!siswaId) return;

            hideEditError();

            const payload = {
                username: form.elements.username.value.trim(),
                nama: form.elements.nama.value.trim(),
                nisn: form.elements.nisn.value.trim(),
                kelas: form.elements.kelas.value.trim(),
                tempat_lahir: form.elements.tempat_lahir.value.trim(),
                tanggal_lahir: form.elements.tanggal_lahir.value,
                status_kelulusan: form.elements.status_kelulusan.value,
            };

            const submitBtn = document.getElementById('editSiswaSubmitBtn');
            const originalLabel = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = '<i data-feather="loader" class="w-4 h-4 animate-spin"></i> Menyimpan...';
            feather.replace();

            try {
                const response = await fetch(`${siswaApiBaseUrl}/${siswaId}`, {
                    method: 'PUT',
                    headers: {
                        'Content-Type': 'application/json',
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                    body: JSON.stringify(payload),
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    if (result.errors) {
                        const firstError = Object.values(result.errors).flat()[0];
                        showEditError(firstError || result.message || 'Validasi gagal.');
                    } else {
                        showEditError(result.message || 'Gagal memperbarui data siswa.');
                    }
                    return;
                }

                window.location.reload();
            } catch (error) {
                showEditError(error.message || 'Terjadi kesalahan saat menyimpan data.');
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalLabel;
                feather.replace();
            }
        }

        async function confirmDeleteSiswa() {
            if (!siswaDeleteTargetId) return;

            const deleteBtn = document.getElementById('confirmDeleteSiswaBtn');
            const originalLabel = deleteBtn.innerHTML;
            deleteBtn.disabled = true;
            deleteBtn.innerHTML = '<i data-feather="loader" class="w-4 h-4 animate-spin"></i> Menghapus...';
            feather.replace();

            try {
                const response = await fetch(`${siswaApiBaseUrl}/${siswaDeleteTargetId}`, {
                    method: 'DELETE',
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': csrfToken,
                    },
                });

                const result = await response.json();

                if (!response.ok || !result.success) {
                    alert(result.message || 'Gagal menghapus data siswa.');
                    return;
                }

                window.location.reload();
            } catch (error) {
                alert(error.message || 'Terjadi kesalahan saat menghapus data.');
            } finally {
                deleteBtn.disabled = false;
                deleteBtn.innerHTML = originalLabel;
                feather.replace();
            }
        }

        function getPhotoImportStatusUrl(uuid) {
            return photoImportStatusUrlTemplate.replace('__UUID__', encodeURIComponent(uuid));
        }

        function setPhotoImportStatusBadge(status) {
            const badge = document.getElementById('photoImportStatus');
            if (!badge) return;

            const normalized = String(status || 'idle').toLowerCase();
            badge.textContent = normalized;
            badge.className = 'px-2 py-1 rounded-full text-[10px] font-bold uppercase';

            if (normalized === 'completed') {
                badge.classList.add('bg-emerald-50', 'text-emerald-600', 'border', 'border-emerald-100');
            } else if (normalized === 'failed') {
                badge.classList.add('bg-red-50', 'text-red-600', 'border', 'border-red-100');
            } else if (normalized === 'processing' || normalized === 'uploading') {
                badge.classList.add('bg-brand-50', 'text-brand-600', 'border', 'border-brand-100');
            } else {
                badge.classList.add('bg-slate-100', 'text-slate-600');
            }
        }

        function resetPhotoImportPanel(filename, status = 'uploading') {
            const panel = document.getElementById('photoImportProgress');
            if (!panel) return;

            panel.classList.remove('hidden');
            document.getElementById('photoImportFilename').textContent = filename || '-';
            document.getElementById('photoImportBar').style.width = '0%';
            document.getElementById('photoImportProcessed').textContent = '0/0';
            document.getElementById('photoImportSuccess').textContent = '0';
            document.getElementById('photoImportFailed').textContent = '0';
            setPhotoImportStatusBadge(status);
            document.getElementById('photoImportMessage').textContent = status === 'uploading'
                ? 'Mengunggah ZIP ke server. Setelah selesai, worker akan memproses di background.'
                : 'Import masuk antrean. Menunggu worker memulai proses.';
        }

        function updatePhotoImportProgress(data) {
            const panel = document.getElementById('photoImportProgress');
            if (!panel || !data) return;

            panel.classList.remove('hidden');

            document.getElementById('photoImportFilename').textContent = data.original_filename || '-';
            document.getElementById('photoImportBar').style.width = `${data.progress || 0}%`;
            document.getElementById('photoImportProcessed').textContent = `${data.processed_files || 0}/${data.total_files || 0}`;
            document.getElementById('photoImportSuccess').textContent = data.success_count || 0;
            document.getElementById('photoImportFailed').textContent = data.failed_count || 0;

            setPhotoImportStatusBadge(data.status);

            const message = document.getElementById('photoImportMessage');
            if (data.status === 'completed') {
                message.textContent = `Import selesai. ${data.success_count || 0} foto berhasil, ${data.failed_count || 0} gagal.`;
            } else if (data.status === 'failed') {
                const firstError = data.error_summary?.[0]?.message || 'Import gagal diproses worker.';
                message.textContent = firstError;
            } else if (data.status === 'processing') {
                message.textContent = `Worker sedang memproses foto (${data.progress || 0}%). Halaman boleh ditutup, proses tetap berjalan.`;
            } else {
                message.textContent = 'Import masuk antrean. Pastikan queue worker sedang berjalan.';
            }
        }

        async function submitZipImport() {
            const form = document.getElementById('zip-form');
            const fileInput = document.getElementById('zip-input');

            if (!form || !fileInput?.files?.length) return;

            closeConfirmModalOnly();
            clearInterval(photoImportPollTimer);
            photoImportPollTimer = null;

            const file = fileInput.files[0];
            resetPhotoImportPanel(file.name, 'uploading');

            const formData = new FormData(form);

            try {
                const response = await fetch(form.action, {
                    method: 'POST',
                    headers: {
                        Accept: 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                    body: formData,
                });

                const result = await response.json().catch(() => ({}));

                if (!response.ok || !result.success) {
                    const firstError = result?.errors?.file?.[0] || result.message || 'Gagal mengunggah ZIP.';
                    document.getElementById('photoImportMessage').textContent = firstError;
                    setPhotoImportStatusBadge('failed');
                    return;
                }

                resetPhotoImportPanel(result.data?.original_filename || file.name, 'queued');
                startPhotoImportPolling(result.data.uuid);
                fileInput.value = '';
            } catch (error) {
                document.getElementById('photoImportMessage').textContent = 'Gagal mengunggah ZIP. Periksa koneksi lalu coba lagi.';
                setPhotoImportStatusBadge('failed');
            }
        }

        async function pollPhotoImportStatus(uuid) {
            if (!uuid) return;

            try {
                const response = await fetch(getPhotoImportStatusUrl(uuid), {
                    method: 'GET',
                    headers: {
                        Accept: 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });

                const result = await response.json();
                if (!response.ok || !result.success) return;

                updatePhotoImportProgress(result.data);

                if (['completed', 'failed'].includes(result.data.status)) {
                    clearInterval(photoImportPollTimer);
                    photoImportPollTimer = null;
                }
            } catch (error) {
                const message = document.getElementById('photoImportMessage');
                if (message) {
                    message.textContent = 'Gagal mengambil status import. Polling akan mencoba lagi.';
                }
            }
        }

        function startPhotoImportPolling(uuid) {
            if (!uuid) return;

            pollPhotoImportStatus(uuid);
            photoImportPollTimer = setInterval(() => pollPhotoImportStatus(uuid), 1000);
        }

        document.addEventListener('click', (event) => {
            const menuButton = event.target.closest('[data-menu-button]');
            const menuAction = event.target.closest('[data-action]');

            if (menuButton) {
                toggleActionMenu(menuButton);
                return;
            }

            if (menuAction) {
                const action = menuAction.getAttribute('data-action');
                const siswaId = menuAction.getAttribute('data-siswa-id');
                if (action && siswaId) {
                    handleMenuAction(action, siswaId);
                }
                return;
            }

            if (!event.target.closest('[data-action-menu]')) {
                closeAllActionMenus();
            }

            if (!event.target.closest('#profileMenuWrapper')) {
                closeProfileMenu();
            }
        });

        window.addEventListener('DOMContentLoaded', () => {
            const editForm = document.getElementById('editSiswaForm');
            if (editForm) {
                editForm.addEventListener('submit', submitEditSiswa);
            }

            const deleteButton = document.getElementById('confirmDeleteSiswaBtn');
            if (deleteButton) {
                deleteButton.addEventListener('click', confirmDeleteSiswa);
            }

            startPhotoImportPolling(initialPhotoImportJobUuid);

            feather.replace();
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeAllActionMenus();
                closeProfileMenu();
                closeDetailModal();
                closeEditModal();
                closeDeleteModal();
                closeTanpaFotoModal();
                closeModal();
            }
        });

    </script>

    <!-- Modal List Siswa Tanpa Foto -->
    <div id="tanpaFotoModal" class="fixed inset-0 z-[105] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 animate-fade-in">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden transform transition-all animate-scale-in flex flex-col max-h-[80vh]">
            <!-- Header -->
            <div class="p-6 border-b border-slate-100 flex items-center justify-between bg-white relative z-10">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-rose-50 text-rose-600 rounded-xl flex items-center justify-center shadow-sm">
                        <i data-feather="user-x" class="w-6 h-6"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-800">Siswa Tanpa Foto</h3>
                        <p class="text-xs text-slate-500 font-medium">Daftar siswa yang belum mengunggah pas foto.</p>
                    </div>
                </div>
                <button onclick="closeTanpaFotoModal()" class="p-2 hover:bg-slate-100 rounded-full transition-colors text-slate-400 hover:text-slate-600">
                    <i data-feather="x" class="w-6 h-6"></i>
                </button>
            </div>

            <!-- Body -->
            <div class="flex-1 overflow-y-auto custom-scrollbar p-6 bg-slate-50/30">
                <div class="bg-white rounded-2xl border border-slate-100 overflow-hidden shadow-sm">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="border-b border-slate-100 text-[10px] uppercase tracking-wider text-slate-500 bg-slate-50/50">
                                <th class="px-6 py-4 font-bold">Nama Siswa</th>
                                <th class="px-6 py-4 font-bold">NISN</th>
                                <th class="px-6 py-4 font-bold">Kelas</th>
                            </tr>
                        </thead>
                        <tbody class="text-sm divide-y divide-slate-50">
                            @forelse($siswas_tanpa_foto as $stf)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 font-bold text-slate-700">{{ $stf->nama }}</td>
                                <td class="px-6 py-4 font-mono text-slate-500 text-xs">{{ $stf->nisn }}</td>
                                <td class="px-6 py-4 text-slate-500 text-xs font-medium">{{ $stf->kelas }}</td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="3" class="px-6 py-12 text-center text-slate-400 italic font-medium">Semua siswa sudah memiliki foto.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Footer -->
            <div class="p-6 border-t border-slate-100 bg-white text-right">
                <button onclick="closeTanpaFotoModal()" class="py-2.5 px-6 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-colors text-sm">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Detail Siswa Modal -->
    <div id="detailSiswaModal" class="fixed inset-0 z-[106] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 animate-fade-in">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden transform transition-all animate-scale-in">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 bg-brand-50 text-brand-600 rounded-xl flex items-center justify-center">
                        <i data-feather="user" class="w-5 h-5"></i>
                    </div>
                    <div>
                        <h3 class="text-lg font-extrabold text-slate-800">Detail Siswa</h3>
                        <p class="text-xs text-slate-500 font-medium">Informasi lengkap data kelulusan siswa.</p>
                    </div>
                </div>
                <button onclick="closeDetailModal()" class="p-2 hover:bg-slate-100 rounded-full transition-colors text-slate-400 hover:text-slate-600">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>

            <div class="p-6 bg-slate-50/50">
                <div class="bg-white border border-slate-100 rounded-2xl p-5">
                    <div class="flex flex-col md:flex-row gap-6 items-start">
                        <img id="detailSiswaFoto" src="" alt="Foto siswa" class="w-24 h-24 rounded-2xl object-cover border border-slate-200 shadow-sm">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 w-full text-sm">
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400 mb-1">Nama</p>
                                <p id="detailSiswaNama" class="font-bold text-slate-800">-</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400 mb-1">Username</p>
                                <p id="detailSiswaUsername" class="font-medium text-slate-700">-</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400 mb-1">NISN</p>
                                <p id="detailSiswaNisn" class="font-mono text-slate-700">-</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400 mb-1">Kelas</p>
                                <p id="detailSiswaKelas" class="font-medium text-slate-700">-</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400 mb-1">Tempat Lahir</p>
                                <p id="detailSiswaTempatLahir" class="font-medium text-slate-700">-</p>
                            </div>
                            <div>
                                <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400 mb-1">Tanggal Lahir</p>
                                <p id="detailSiswaTanggalLahir" class="font-medium text-slate-700">-</p>
                            </div>
                            <div class="md:col-span-2">
                                <p class="text-[11px] font-bold uppercase tracking-wide text-slate-400 mb-1">Status Kelulusan</p>
                                <p id="detailSiswaStatus" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-brand-50 text-brand-700 border border-brand-100">Belum Ada</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-slate-100 bg-white text-right">
                <button onclick="closeDetailModal()" class="py-2.5 px-6 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-colors text-sm">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Edit Siswa Modal -->
    <div id="editSiswaModal" class="fixed inset-0 z-[107] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 animate-fade-in">
        <div class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full overflow-hidden transform transition-all animate-scale-in">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-extrabold text-slate-800">Edit Siswa</h3>
                    <p class="text-xs text-slate-500 font-medium">Perbarui data siswa dan status kelulusan.</p>
                </div>
                <button onclick="closeEditModal()" class="p-2 hover:bg-slate-100 rounded-full transition-colors text-slate-400 hover:text-slate-600">
                    <i data-feather="x" class="w-5 h-5"></i>
                </button>
            </div>

            <form id="editSiswaForm" class="p-6 bg-slate-50/50 space-y-4">
                <div id="editSiswaError" class="hidden p-3 rounded-xl bg-red-50 border border-red-200 text-red-700 text-xs font-semibold"></div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-1">Username</label>
                        <input type="text" name="username" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-1">Nama</label>
                        <input type="text" name="nama" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-1">NISN</label>
                        <input type="text" name="nisn" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm font-mono focus:outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500" required>
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-1">Kelas</label>
                        <input type="text" name="kelas" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-1">Tempat Lahir</label>
                        <input type="text" name="tempat_lahir" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                    </div>
                    <div>
                        <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-1">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold uppercase tracking-wide text-slate-500 mb-1">Status Kelulusan</label>
                    <select name="status_kelulusan" class="w-full border border-slate-200 rounded-xl px-3 py-2.5 text-sm focus:outline-none focus:ring-1 focus:ring-brand-500 focus:border-brand-500">
                        <option value="">Belum Ada</option>
                        <option value="Lulus">Lulus</option>
                        <option value="Tidak Lulus">Tidak Lulus</option>
                    </select>
                </div>

                <div class="pt-2 flex items-center justify-end gap-3">
                    <button type="button" onclick="closeEditModal()" class="py-2.5 px-5 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-colors text-sm">Batal</button>
                    <button type="submit" id="editSiswaSubmitBtn" class="py-2.5 px-5 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-colors text-sm flex items-center gap-2">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Siswa Modal -->
    <div id="deleteSiswaModal" class="fixed inset-0 z-[108] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 animate-fade-in">
        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full overflow-hidden transform transition-all animate-scale-in">
            <div class="p-8 text-center">
                <div class="w-14 h-14 bg-red-50 text-red-600 rounded-2xl flex items-center justify-center mx-auto mb-5">
                    <i data-feather="trash-2" class="w-6 h-6"></i>
                </div>
                <h3 class="text-lg font-extrabold text-slate-800 mb-2">Hapus Data Siswa</h3>
                <p class="text-sm text-slate-500 font-medium mb-6">Yakin ingin menghapus data <span id="deleteSiswaName" class="font-bold text-slate-700"></span>? Tindakan ini tidak dapat dibatalkan.</p>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" onclick="closeDeleteModal()" class="py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-colors text-sm">Batal</button>
                    <button type="button" id="confirmDeleteSiswaBtn" class="py-2.5 px-4 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl transition-colors text-sm flex items-center justify-center gap-2">Hapus</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Modal -->
    <div id="loadingModal" class="fixed inset-0 z-[110] hidden items-center justify-center bg-slate-900/60 backdrop-blur-md p-4">
        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full overflow-hidden p-8 text-center animate-scale-in">
            <div class="mb-6 relative">
                <div class="w-16 h-16 border-4 border-slate-100 border-t-brand-600 rounded-full animate-spin mx-auto"></div>
                <div class="absolute inset-0 flex items-center justify-center">
                    <i data-feather="upload-cloud" class="w-6 h-6 text-brand-600"></i>
                </div>
            </div>
            <h3 class="text-xl font-extrabold text-slate-800 mb-2">Memproses Data...</h3>
            <p class="text-sm text-slate-500 leading-relaxed font-medium">Mohon tunggu sebentar, sistem sedang mengolah file dan menyinkronkan database.</p>
        </div>
    </div>

    <!-- Confirmation Modal -->
    <div id="confirmModal" class="fixed inset-0 z-[100] hidden items-center justify-center bg-slate-900/60 backdrop-blur-sm p-4 animate-fade-in">
        <div class="bg-white rounded-3xl shadow-2xl max-w-sm w-full overflow-hidden transform transition-all animate-scale-in">
            <div class="p-8 text-center">
                <div class="w-16 h-16 bg-brand-50 text-brand-600 rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-sm">
                    <i data-feather="help-circle" class="w-8 h-8"></i>
                </div>
                <h3 id="modalTitle" class="text-xl font-extrabold text-slate-800 mb-3">Konfirmasi Import</h3>
                <p id="modalDesc" class="text-sm text-slate-500 leading-relaxed font-medium mb-8">Apakah Anda yakin ingin melanjutkan proses ini?</p>
                
                <div class="grid grid-cols-2 gap-3">
                    <button onclick="closeModal()" class="py-3 px-4 bg-slate-100 hover:bg-slate-200 text-slate-600 font-bold rounded-xl transition-colors text-sm">Batal</button>
                    <button id="confirmBtn" class="py-3 px-4 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-xl transition-all shadow-lg shadow-brand-600/20 text-sm">Ya, Lanjutkan</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
