<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - Kelola Page</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/alternative/icon.png') }}">
    
    <!-- Vite CSS -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Feather Icons -->
    <script src="https://unpkg.com/feather-icons"></script>
    
    <!-- Cropper.js -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
        .image-preview-container {
            max-height: 400px;
            overflow: hidden;
            border-radius: 1rem;
        }
        #cropper-image {
            max-width: 100%;
            display: block;
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
        <!-- Header -->
        <header class="relative z-[80] flex min-h-20 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 sm:gap-4">
                <button type="button" id="adminSidebarOpen" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-brand-200 hover:text-brand-600 lg:hidden">
                    <i data-feather="menu" class="h-5 w-5"></i>
                </button>
                <div class="flex flex-wrap items-center gap-2 sm:gap-4">
                    <h1 class="text-lg font-extrabold tracking-tight text-slate-800 sm:text-xl">Kelola Page</h1>
                    <span class="rounded-full border border-brand-100 bg-brand-50 px-3 py-1 text-[11px] font-bold text-brand-600 sm:text-xs">Image Manager</span>
                </div>
            </div>
            
            <div class="flex items-center gap-3 sm:gap-4">
                <button id="open-preview" class="flex items-center gap-2 rounded-xl border border-slate-200 bg-slate-100 px-3 py-2 text-xs font-bold text-slate-700 transition-all group hover:bg-slate-200 sm:px-4">
                    <i data-feather="eye" class="w-4 h-4 group-hover:text-brand-600"></i>
                    <span class="hidden sm:inline">Lihat Preview</span>
                </button>

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

        <!-- Preview Modal (Webview) -->
        <div id="preview-modal" class="fixed inset-0 z-[110] hidden items-center justify-center p-4 md:p-12 bg-slate-900/60 backdrop-blur-sm">
            <div class="bg-white w-full h-full rounded-[2.5rem] shadow-2xl flex flex-col overflow-hidden animate-in fade-in zoom-in duration-300">
                <!-- Modal Header -->
                <div class="p-4 md:px-8 md:py-6 border-b border-slate-100 flex items-center justify-between bg-white">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-brand-50 text-brand-600 flex items-center justify-center">
                            <i data-feather="monitor" class="w-5 h-5"></i>
                        </div>
                        <div>
                            <h3 class="text-base font-bold text-slate-800">Live Preview</h3>
                            <p id="preview-url-text" class="text-[10px] text-slate-400 font-medium">http://127.0.0.1:8000/</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden md:flex items-center gap-1.5 px-3 py-1.5 bg-slate-50 rounded-full border border-slate-100 mr-4">
                            <div class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></div>
                            <span class="text-[10px] font-bold text-slate-500 uppercase tracking-wider">Tersambung</span>
                        </div>
                        <button onclick="closePreview()" class="w-10 h-10 rounded-full bg-slate-50 text-slate-400 hover:text-slate-600 hover:bg-slate-100 flex items-center justify-center transition-all">
                            <i data-feather="x" class="w-5 h-5"></i>
                        </button>
                    </div>
                </div>
                <!-- Modal Body (Webview) -->
                <div class="flex-1 bg-slate-100 relative">
                    <div id="preview-loader" class="absolute inset-0 flex flex-col items-center justify-center bg-white z-10 transition-opacity duration-500">
                        <div class="w-12 h-12 border-4 border-brand-100 border-t-brand-600 rounded-full animate-spin mb-4"></div>
                        <p class="text-xs font-bold text-slate-400 uppercase tracking-widest">Memuat Pratinjau...</p>
                    </div>
                    <iframe id="preview-frame" src="" class="w-full h-full border-none shadow-inner" onload="document.getElementById('preview-loader').classList.add('opacity-0'); setTimeout(() => document.getElementById('preview-loader').classList.add('hidden'), 500)"></iframe>
                </div>
            </div>
        </div>

        <!-- Content Area -->
        <div class="relative z-10 min-h-0 flex-1 overflow-y-auto custom-scrollbar p-4 sm:p-6 lg:p-8">
            <div class="max-w-5xl mx-auto space-y-8">
                
                <!-- Page Selection -->
                <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-6">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-2xl bg-brand-50 text-brand-600 flex items-center justify-center border border-brand-100">
                                <i data-feather="layout" class="w-6 h-6"></i>
                            </div>
                            <div>
                                <h2 class="text-lg font-bold text-slate-800">Pilih Halaman</h2>
                                <p class="text-xs text-slate-400 font-medium">Pilih halaman yang ingin diperbarui gambarnya</p>
                            </div>
                        </div>
                        
                        <div class="w-full md:w-auto flex items-center gap-3">
                            <div id="home-content-save-wrapper" class="hidden w-full md:w-auto">
                                <button id="save-home-content" class="w-full md:w-auto px-5 py-3 bg-brand-600 hover:bg-brand-700 text-white text-sm font-bold rounded-2xl transition-all shadow-lg shadow-brand-600/20 flex items-center justify-center gap-2">
                                    <i data-feather="save" class="w-4 h-4"></i>
                                    Simpan
                                </button>
                            </div>

                            <div class="w-full md:w-72 relative">
                                <button id="dropdown-button" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-2xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 flex items-center justify-between p-4 transition-all duration-300 group hover:bg-white hover:shadow-md">
                                    <div class="flex items-center gap-3">
                                        <i data-feather="file-text" class="w-4 h-4 text-brand-600"></i>
                                        <span id="selected-page-name" class="font-bold">Landing Page (Beranda)</span>
                                    </div>
                                    <i data-feather="chevron-down" class="w-4 h-4 text-slate-400 group-hover:text-brand-600 transition-transform duration-300" id="dropdown-arrow"></i>
                                </button>
                                
                                <!-- Dropdown Menu -->
                                <div id="dropdown-menu" class="absolute left-0 right-0 mt-3 bg-white border border-slate-100 rounded-3xl shadow-2xl shadow-slate-200/50 hidden z-50 overflow-hidden animate-in fade-in slide-in-from-top-2 duration-200">
                                    <div class="p-2">
                                        @foreach($pages as $key => $page)
                                            <div class="dropdown-option flex items-center gap-3 p-3 rounded-2xl hover:bg-brand-50 cursor-pointer transition-all group/opt" data-value="{{ $key }}" data-name="{{ $page['name'] }}">
                                                <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center group-hover/opt:bg-brand-100 group-hover/opt:text-brand-600 transition-colors">
                                                    <i data-feather="{{ $page['icon'] ?? 'file-text' }}" class="w-4 h-4"></i>
                                                </div>
                                                <span class="text-sm font-bold text-slate-600 group-hover/opt:text-brand-700">{{ $page['name'] }}</span>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Hidden Select for form compatibility if needed -->
                                <select id="page-selector" class="hidden">
                                    @foreach($pages as $key => $page)
                                        <option value="{{ $key }}">{{ $page['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>


                        </div>
                    </div>
                </div>

                <!-- Section: School Stats (Only for Landing Page) -->
                <div id="stats-section" class="hidden animate-in slide-in-from-top-4 duration-500">
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                        <h3 class="text-sm font-bold text-slate-800 mb-6 flex items-center gap-2">
                            <i data-feather="bar-chart" class="w-4 h-4 text-brand-600"></i>
                            Statistik Sekolah
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Total Ekskul</label>
                                <input id="stat-total-ekskul" type="number" value="{{ $homeContent['total_ekskul'] ?? 10 }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 p-3 font-bold" placeholder="Contoh: 10">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Siswa Aktif</label>
                                <input id="stat-siswa-aktif" type="number" value="{{ $homeContent['siswa_aktif'] ?? 1200 }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 p-3 font-bold" placeholder="Contoh: 1240">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Total Prestasi</label>
                                <input id="stat-total-prestasi" type="number" value="{{ $homeContent['total_prestasi'] ?? 85 }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 p-3 font-bold" placeholder="Contoh: 50">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Mitra Industri</label>
                                <input id="stat-mitra-industri" type="text" value="{{ $homeContent['mitra_industri'] ?? '25+' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 p-3 font-bold" placeholder="Contoh: 25+">
                            </div>
                            <div class="md:col-span-3">
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Alamat Sekolah</label>
                                <textarea id="stat-alamat" rows="3" maxlength="500" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 p-3 font-bold" placeholder="Contoh: Jl. Pendidikan No. 45, Wringin, Bondowoso, Jawa Timur">{{ $homeContent['alamat'] ?? 'Jl. Pendidikan No. 45, Wringin, Bondowoso, Jawa Timur' }}</textarea>
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Nomor Telepon</label>
                                <input id="stat-nomor-telepon" type="text" maxlength="50" value="{{ $homeContent['nomor_telepon'] ?? '(0332) 555-0199' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 p-3 font-bold" placeholder="Contoh: (0332) 555-0199">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Email Sekolah</label>
                                <input id="stat-email" type="email" maxlength="120" value="{{ $homeContent['email'] ?? 'admin@smkn1wringin.sch.id' }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 p-3 font-bold" placeholder="Contoh: admin@smkn1wringin.sch.id">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Melanjutkan Kuliah (%)</label>
                                <input id="stat-melanjutkan-kuliah" type="number" value="{{ $homeContent['persen_melanjutkan_kuliah'] ?? 32 }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 p-3 font-bold" placeholder="Contoh: 32">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Bekerja/Berwirausaha (%)</label>
                                <input id="stat-bekerja-berwirausaha" type="number" value="{{ $homeContent['persen_bekerja_berwirausaha'] ?? 68 }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 p-3 font-bold" placeholder="Contoh: 68">
                            </div>
                            <div>
                                <label class="block text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-2">Tahun Mengabdi</label>
                                <input id="stat-tahun-mengabdi" type="number" value="{{ $homeContent['tahun_mengabdi'] ?? 25 }}" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 p-3 font-bold" placeholder="Contoh: 25">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Section: Featured Extracurriculars (Only for Landing Page) -->
                <div id="ekskul-section" class="hidden animate-in slide-in-from-top-4 duration-500">
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                <i data-feather="star" class="w-4 h-4 text-amber-500"></i>
                                Ekskul Unggulan (Pilih 3)
                            </h3>
                            <span id="ekskul-count" class="text-[10px] font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-md">0 / 3 TERPILIH</span>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                            @foreach($ekskulList as $ekskul)
                                <label class="relative flex items-center gap-3 p-3 bg-slate-50 border border-slate-100 rounded-xl cursor-pointer hover:bg-white hover:border-brand-200 transition-all group">
                                    <input type="checkbox" name="featured_ekskul[]" value="{{ $ekskul }}" @checked(in_array($ekskul, $homeContent['featured_ekskul'] ?? [], true)) class="ekskul-checkbox w-4 h-4 text-brand-600 bg-white border-slate-300 rounded focus:ring-brand-500">
                                    <span class="text-xs font-bold text-slate-600 group-hover:text-brand-600">{{ $ekskul }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Section: Content Variables (All Pages) -->
                <div id="content-fields-section" class="hidden animate-in slide-in-from-top-4 duration-500">
                    <div class="bg-white p-6 rounded-3xl border border-slate-100 shadow-sm">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-sm font-bold text-slate-800 flex items-center gap-2">
                                <i data-feather="sliders" class="w-4 h-4 text-brand-600"></i>
                                Variabel Konten Beranda
                            </h3>
                            <span id="content-field-count" class="text-[10px] font-bold text-slate-500 bg-slate-100 px-2 py-0.5 rounded-md">0 VARIABEL</span>
                        </div>
                        <div id="content-fields-grid" class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <!-- Content variables rendered by JS -->
                        </div>
                    </div>
                </div>

                <!-- Image List Section -->
                <div class="space-y-4">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 px-2">
                        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest">Daftar Slot Gambar</h3>
                        
                        <div id="jurusan-selector-wrapper" class="hidden w-full md:w-72 relative z-40">
                            <button id="jurusan-dropdown-button" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-2xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 flex items-center justify-between p-4 transition-all duration-300 group hover:bg-white hover:shadow-md">
                                <div class="flex items-center gap-3">
                                    <i data-feather="briefcase" class="w-4 h-4 text-brand-600"></i>
                                    <span id="selected-jurusan-name" class="font-bold">Teknik Audio Video (TAV)</span>
                                </div>
                                <i data-feather="chevron-down" class="w-4 h-4 text-slate-400 group-hover:text-brand-600 transition-transform duration-300" id="jurusan-dropdown-arrow"></i>
                            </button>
                            
                            <!-- Dropdown Menu -->
                            <div id="jurusan-dropdown-menu" class="absolute right-0 left-0 mt-3 bg-white border border-slate-100 rounded-3xl shadow-2xl shadow-slate-200/50 hidden z-50 overflow-hidden animate-in fade-in slide-in-from-top-2 duration-200">
                                <div class="p-2" id="jurusan-dropdown-options">
                                    <!-- Options injected by JS -->
                                </div>
                            </div>

                            <!-- Hidden Select for existing JS compatibility -->
                            <select id="jurusan-selector" class="hidden">
                                <option value="tav">Teknik Audio Video (TAV)</option>
                            </select>
                        </div>

                        <div id="ekstrakurikuler-selector-wrapper" class="hidden w-full md:w-72 relative z-40">
                            <button id="ekstrakurikuler-dropdown-button" class="w-full bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-2xl focus:ring-2 focus:ring-brand-500/20 focus:border-brand-500 flex items-center justify-between p-4 transition-all duration-300 group hover:bg-white hover:shadow-md">
                                <div class="flex items-center gap-3">
                                    <i data-feather="activity" class="w-4 h-4 text-brand-600"></i>
                                    <span id="selected-ekstrakurikuler-name" class="font-bold">Pramuka</span>
                                </div>
                                <i data-feather="chevron-down" class="w-4 h-4 text-slate-400 group-hover:text-brand-600 transition-transform duration-300" id="ekstrakurikuler-dropdown-arrow"></i>
                            </button>

                            <div id="ekstrakurikuler-dropdown-menu" class="absolute right-0 left-0 mt-3 bg-white border border-slate-100 rounded-3xl shadow-2xl shadow-slate-200/50 hidden z-50 overflow-hidden animate-in fade-in slide-in-from-top-2 duration-200">
                                <div class="p-2" id="ekstrakurikuler-dropdown-options">
                                    <!-- Options injected by JS -->
                                </div>
                            </div>

                            <select id="ekstrakurikuler-selector" class="hidden">
                                <option value="pramuka">Pramuka</option>
                            </select>
                        </div>
                    </div>
                    
                    <div id="image-slots" class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Content will be injected by JS -->
                    </div>
                </div>
            </div>
        </div>
    </main>
    </div>

    <!-- Upload & Crop Modal -->
    <div id="crop-modal" class="fixed inset-0 z-[100] hidden items-center justify-center p-4 bg-slate-900/60 backdrop-blur-sm">
        <div class="bg-white w-full max-w-2xl rounded-3xl shadow-2xl overflow-hidden animate-in fade-in zoom-in duration-300">
            <div class="p-6 border-b border-slate-100 flex items-center justify-between">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-brand-50 text-brand-600 flex items-center justify-center">
                        <i data-feather="crop" class="w-4 h-4"></i>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Sesuaikan Gambar</h3>
                </div>
                <button onclick="closeModal()" class="w-8 h-8 rounded-full bg-slate-50 text-slate-400 hover:text-slate-600 flex items-center justify-center transition-colors">
                    <i data-feather="x" class="w-4 h-4"></i>
                </button>
            </div>
            
            <div class="p-6">
                <div class="image-preview-container bg-slate-100 flex items-center justify-center relative border-2 border-dashed border-slate-200 rounded-2xl min-h-[300px]">
                    <img id="cropper-image" src="" alt="Source image">
                </div>
                
                <div class="mt-6 flex flex-col md:flex-row items-center justify-between gap-4">
                    <p class="text-xs text-slate-500 font-medium italic">
                        <i data-feather="info" class="w-3 h-3 inline mr-1"></i>
                        Sesuaikan area crop agar pas dengan kontainer di landing page.
                    </p>
                    <div class="flex items-center gap-3">
                        <button onclick="closeModal()" class="px-6 py-2.5 bg-slate-50 text-slate-600 text-sm font-bold rounded-xl hover:bg-slate-100 transition-all">Batal</button>
                        <button id="save-crop" class="px-8 py-2.5 bg-brand-600 text-white text-sm font-bold rounded-xl hover:bg-brand-700 transition-all shadow-lg shadow-brand-600/20">Simpan Gambar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hidden Input for File -->
    <input type="file" id="image-input" class="hidden" accept="image/*">

    <script>
        feather.replace();

        const dropdownButton = document.getElementById('dropdown-button');
        const dropdownMenu = document.getElementById('dropdown-menu');
        const dropdownArrow = document.getElementById('dropdown-arrow');
        const selectedPageName = document.getElementById('selected-page-name');
        const dropdownOptions = document.querySelectorAll('.dropdown-option');
        const jurusanSelectorWrapper = document.getElementById('jurusan-selector-wrapper');
        const jurusanSelector = document.getElementById('jurusan-selector');
        const ekstrakurikulerSelectorWrapper = document.getElementById('ekstrakurikuler-selector-wrapper');
        const ekstrakurikulerSelector = document.getElementById('ekstrakurikuler-selector');

        const pagesData = @json($pages);
        const existingImages = @json($existingImages ?? []);
        const pageSelector = document.getElementById('page-selector');
        const imageSlots = document.getElementById('image-slots');
        const imageInput = document.getElementById('image-input');
        const cropModal = document.getElementById('crop-modal');
        const cropperImage = document.getElementById('cropper-image');
        const saveCropBtn = document.getElementById('save-crop');
        
        const statsSection = document.getElementById('stats-section');
        const ekskulSection = document.getElementById('ekskul-section');
        const contentFieldsSection = document.getElementById('content-fields-section');
        const contentFieldsGrid = document.getElementById('content-fields-grid');
        const contentFieldCount = document.getElementById('content-field-count');
        const ekskulCheckboxes = document.querySelectorAll('.ekskul-checkbox');
        const ekskulCountDisplay = document.getElementById('ekskul-count');
        const statInputs = {
            total_ekskul: document.getElementById('stat-total-ekskul'),
            siswa_aktif: document.getElementById('stat-siswa-aktif'),
            total_prestasi: document.getElementById('stat-total-prestasi'),
            mitra_industri: document.getElementById('stat-mitra-industri'),
            alamat: document.getElementById('stat-alamat'),
            nomor_telepon: document.getElementById('stat-nomor-telepon'),
            email: document.getElementById('stat-email'),
            persen_melanjutkan_kuliah: document.getElementById('stat-melanjutkan-kuliah'),
            persen_bekerja_berwirausaha: document.getElementById('stat-bekerja-berwirausaha'),
            tahun_mengabdi: document.getElementById('stat-tahun-mengabdi'),
        };
        const homeContentSaveWrapper = document.getElementById('home-content-save-wrapper');
        const saveHomeContentBtn = document.getElementById('save-home-content');

        const openPreviewBtn = document.getElementById('open-preview');
        const previewModal = document.getElementById('preview-modal');
        const previewFrame = document.getElementById('preview-frame');
        const previewLoader = document.getElementById('preview-loader');
        const previewUrlText = document.getElementById('preview-url-text');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
        const adminSidebar = document.getElementById('adminSidebar');
        const adminSidebarBackdrop = document.getElementById('adminSidebarBackdrop');
        const adminSidebarOpenBtn = document.getElementById('adminSidebarOpen');
        const adminSidebarCloseBtn = document.getElementById('adminSidebarClose');
        const adminProfileToggle = document.getElementById('adminProfileToggle');
        const adminProfileDropdown = document.getElementById('adminProfileDropdown');
        
        let currentCropper = null;
        let currentTargetId = null;
        let currentTargetSlot = null;
        let selectedJurusanSlug = 'tav';
        let selectedEkstrakurikulerSlug = 'pramuka';
        const slotRegistry = {};

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

        adminSidebar?.querySelectorAll('a').forEach((link) => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    closeAdminSidebar();
                }
            });
        });

        // Preview Webview Logic
        openPreviewBtn.addEventListener('click', () => {
            const pageKey = pageSelector.value;
            const page = pagesData[pageKey];
            let previewUrl = page.url;

            if (pageKey === 'jurusan_detail' && page.jurusan_urls && selectedJurusanSlug) {
                previewUrl = page.jurusan_urls[selectedJurusanSlug] || previewUrl;
            }

            if (pageKey === 'ekstrakurikuler_detail' && page.ekstrakurikuler_urls && selectedEkstrakurikulerSlug) {
                previewUrl = page.ekstrakurikuler_urls[selectedEkstrakurikulerSlug] || previewUrl;
            }
            
            previewUrlText.innerText = previewUrl;
            previewFrame.src = previewUrl;
            
            previewLoader.classList.remove('hidden', 'opacity-0');
            previewModal.classList.remove('hidden');
            previewModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        });

        window.closePreview = () => {
            previewModal.classList.add('hidden');
            previewModal.classList.remove('flex');
            document.body.style.overflow = 'auto';
            previewFrame.src = '';
        };

        // Custom Dropdown Logic
        dropdownButton.addEventListener('click', () => {
            dropdownMenu.classList.toggle('hidden');
            dropdownArrow.classList.toggle('rotate-180');
        });

        dropdownOptions.forEach(opt => {
            opt.addEventListener('click', () => {
                const value = opt.getAttribute('data-value');
                const name = opt.getAttribute('data-name');
                
                selectedPageName.innerText = name;
                pageSelector.value = value;
                
                dropdownMenu.classList.add('hidden');
                dropdownArrow.classList.remove('rotate-180');

                if (value !== 'jurusan_detail') {
                    selectedJurusanSlug = 'tav';
                }

                if (value !== 'ekstrakurikuler_detail') {
                    selectedEkstrakurikulerSlug = 'pramuka';
                }
                
                renderSlots(value);
            });
        });

        window.addEventListener('click', (e) => {
            if (!e.target.closest('#adminProfileMenuWrapper')) {
                closeAdminProfileMenu();
            }

            if (!dropdownButton.contains(e.target) && !dropdownMenu.contains(e.target)) {
                dropdownMenu.classList.add('hidden');
                dropdownArrow.classList.remove('rotate-180');
            }
            
            const jurusanDropdownBtn = document.getElementById('jurusan-dropdown-button');
            const jurusanDropdownMenu = document.getElementById('jurusan-dropdown-menu');
            const jurusanDropdownArrow = document.getElementById('jurusan-dropdown-arrow');
            
            if (jurusanDropdownBtn && jurusanDropdownMenu && !jurusanDropdownBtn.contains(e.target) && !jurusanDropdownMenu.contains(e.target)) {
                jurusanDropdownMenu.classList.add('hidden');
                if (jurusanDropdownArrow) jurusanDropdownArrow.classList.remove('rotate-180');
            }

            const ekstrakurikulerDropdownBtn = document.getElementById('ekstrakurikuler-dropdown-button');
            const ekstrakurikulerDropdownMenu = document.getElementById('ekstrakurikuler-dropdown-menu');
            const ekstrakurikulerDropdownArrow = document.getElementById('ekstrakurikuler-dropdown-arrow');

            if (ekstrakurikulerDropdownBtn && ekstrakurikulerDropdownMenu && !ekstrakurikulerDropdownBtn.contains(e.target) && !ekstrakurikulerDropdownMenu.contains(e.target)) {
                ekstrakurikulerDropdownMenu.classList.add('hidden');
                if (ekstrakurikulerDropdownArrow) ekstrakurikulerDropdownArrow.classList.remove('rotate-180');
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeAdminProfileMenu();
                closeAdminSidebar();
            }
        });

        const jurusanDropdownBtn = document.getElementById('jurusan-dropdown-button');
        if (jurusanDropdownBtn) {
            jurusanDropdownBtn.addEventListener('click', () => {
                const menu = document.getElementById('jurusan-dropdown-menu');
                const arrow = document.getElementById('jurusan-dropdown-arrow');
                if (menu) menu.classList.toggle('hidden');
                if (arrow) arrow.classList.toggle('rotate-180');
            });
        }

        const ekstrakurikulerDropdownBtn = document.getElementById('ekstrakurikuler-dropdown-button');
        if (ekstrakurikulerDropdownBtn) {
            ekstrakurikulerDropdownBtn.addEventListener('click', () => {
                const menu = document.getElementById('ekstrakurikuler-dropdown-menu');
                const arrow = document.getElementById('ekstrakurikuler-dropdown-arrow');
                if (menu) menu.classList.toggle('hidden');
                if (arrow) arrow.classList.toggle('rotate-180');
            });
        }

        const statFieldKeys = new Set([
            'total_ekskul',
            'siswa_aktif',
            'total_prestasi',
            'mitra_industri',
            'alamat',
            'nomor_telepon',
            'email',
            'persen_melanjutkan_kuliah',
            'persen_bekerja_berwirausaha',
            'tahun_mengabdi',
        ]);

        function getFieldMap(page) {
            const map = {};
            (page.content_fields || []).forEach(field => {
                map[field.key] = field.value;
            });
            return map;
        }

        function escapeHtml(value) {
            return String(value)
                .replaceAll('&', '&amp;')
                .replaceAll('<', '&lt;')
                .replaceAll('>', '&gt;')
                .replaceAll('"', '&quot;')
                .replaceAll("'", '&#039;');
        }

        function syncStatsInputs(page) {
            const fieldMap = getFieldMap(page);
            const fallback = {
                total_ekskul: '10',
                siswa_aktif: '1200',
                total_prestasi: '85',
                mitra_industri: '25+',
                alamat: 'Jl. Pendidikan No. 45, Wringin, Bondowoso, Jawa Timur',
                nomor_telepon: '(0332) 555-0199',
                email: 'admin@smkn1wringin.sch.id',
                persen_melanjutkan_kuliah: '32',
                persen_bekerja_berwirausaha: '68',
                tahun_mengabdi: '25',
            };

            Object.entries(statInputs).forEach(([key, input]) => {
                if (!input) return;
                input.value = fieldMap[key] ?? fallback[key] ?? '';
            });
        }

        function renderContentFields(pageKey, page) {
            if (!['landing', 'profil'].includes(pageKey)) {
                contentFieldsSection.classList.add('hidden');
                contentFieldsGrid.innerHTML = '';
                contentFieldCount.innerText = '0 VARIABEL';
                homeContentSaveWrapper.classList.add('hidden');
                return;
            }

            const fields = (page.content_fields || []).filter(field => !(page.stats && statFieldKeys.has(field.key)));

            if (!fields.length) {
                contentFieldsSection.classList.add('hidden');
                contentFieldsGrid.innerHTML = '';
                contentFieldCount.innerText = '0 VARIABEL';
                homeContentSaveWrapper.classList.add('hidden');
                return;
            }

            contentFieldsSection.classList.remove('hidden');
            homeContentSaveWrapper.classList.remove('hidden');
            contentFieldCount.innerText = `${fields.length} VARIABEL`;
            contentFieldsGrid.innerHTML = '';

            fields.forEach(field => {
                const wrapper = document.createElement('div');
                wrapper.className = 'bg-slate-50 border border-slate-200 rounded-2xl p-4';
                const isTextArea = field.type === 'textarea';
                const isBoolean = field.type === 'boolean';
                const value = escapeHtml(field.value ?? '');
                const label = escapeHtml(field.label);
                const key = escapeHtml(field.key);

                wrapper.innerHTML = `
                    <div class="flex items-center justify-between gap-3 mb-2">
                        <label class="text-[10px] font-bold text-slate-500 uppercase tracking-widest">${label}</label>
                        <span class="text-[10px] font-bold text-slate-400 bg-white border border-slate-200 rounded-md px-2 py-0.5">${key}</span>
                    </div>
                    ${isBoolean
                        ? `<div class="flex items-center justify-between p-3 bg-white border border-slate-200 rounded-xl">
                               <span class="text-sm font-semibold text-slate-700">Tampilkan Badge</span>
                               <label class="relative inline-flex items-center cursor-pointer">
                                   <input type="checkbox" data-home-field-key="${key}" class="sr-only peer" ${field.value ? 'checked' : ''}>
                                   <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-brand-300 rounded-full peer peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:bg-brand-600 after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border after:border-slate-300 after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                               </label>
                           </div>`
                        : isTextArea
                        ? `<textarea data-home-field-key="${key}" class="w-full bg-white border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 p-3 font-medium min-h-[120px]" placeholder="Isi ${label}">${value}</textarea>`
                        : `<input type="${field.type === 'number' ? 'number' : 'text'}" value="${value}" data-home-field-key="${key}" class="w-full bg-white border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-brand-500 focus:border-brand-500 p-3 font-medium" placeholder="Isi ${label}">`
                    }
                `;
                contentFieldsGrid.appendChild(wrapper);
            });
        }

        // Function to render image slots and toggle sections
        function renderSlots(pageKey) {
            const page = pagesData[pageKey];
            Object.keys(slotRegistry).forEach(key => delete slotRegistry[key]);

            let renderImages = page.images || [];

            if (pageKey === 'jurusan_detail' && page.images_by_slug) {
                const jurusanOptions = page.jurusan_options || [];
                const availableSlugs = jurusanOptions.map(item => item.slug);

                if (!availableSlugs.includes(selectedJurusanSlug)) {
                    selectedJurusanSlug = availableSlugs[0] || 'tav';
                }

                jurusanSelector.innerHTML = jurusanOptions
                    .map(item => `<option value="${item.slug}">${item.name}</option>`)
                    .join('');
                jurusanSelector.value = selectedJurusanSlug;
                
                const selectedJurusanObj = jurusanOptions.find(item => item.slug === selectedJurusanSlug) || jurusanOptions[0];
                const selectedJurusanNameEl = document.getElementById('selected-jurusan-name');
                if (selectedJurusanObj && selectedJurusanNameEl) {
                    selectedJurusanNameEl.innerText = selectedJurusanObj.name;
                }

                const jurusanDropdownOptions = document.getElementById('jurusan-dropdown-options');
                if (jurusanDropdownOptions) {
                    jurusanDropdownOptions.innerHTML = jurusanOptions.map(item => `
                        <div class="jurusan-dropdown-option flex items-center gap-3 p-3 rounded-2xl hover:bg-brand-50 cursor-pointer transition-all group/opt" data-value="${item.slug}" data-name="${item.name}">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center group-hover/opt:bg-brand-100 group-hover/opt:text-brand-600 transition-colors">
                                <i data-feather="briefcase" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-600 group-hover/opt:text-brand-700">${item.name}</span>
                        </div>
                    `).join('');
                    
                    document.querySelectorAll('.jurusan-dropdown-option').forEach(opt => {
                        opt.addEventListener('click', () => {
                            const value = opt.getAttribute('data-value');
                            const name = opt.getAttribute('data-name');
                            
                            selectedJurusanSlug = value;
                            document.getElementById('selected-jurusan-name').innerText = name;
                            jurusanSelector.value = value;
                            
                            document.getElementById('jurusan-dropdown-menu').classList.add('hidden');
                            document.getElementById('jurusan-dropdown-arrow').classList.remove('rotate-180');
                            
                            renderSlots('jurusan_detail');
                        });
                    });
                }
                
                jurusanSelectorWrapper.classList.remove('hidden');
                ekstrakurikulerSelectorWrapper.classList.add('hidden');
                ekstrakurikulerSelector.innerHTML = '';

                renderImages = page.images_by_slug[selectedJurusanSlug] || [];
            } else if (pageKey === 'ekstrakurikuler_detail' && page.images_by_slug) {
                const ekstrakurikulerOptions = page.ekstrakurikuler_options || [];
                const availableSlugs = ekstrakurikulerOptions.map(item => item.slug);

                if (!availableSlugs.includes(selectedEkstrakurikulerSlug)) {
                    selectedEkstrakurikulerSlug = availableSlugs[0] || 'pramuka';
                }

                ekstrakurikulerSelector.innerHTML = ekstrakurikulerOptions
                    .map(item => `<option value="${item.slug}">${item.name}</option>`)
                    .join('');
                ekstrakurikulerSelector.value = selectedEkstrakurikulerSlug;

                const selectedEkstrakurikulerObj = ekstrakurikulerOptions.find(item => item.slug === selectedEkstrakurikulerSlug) || ekstrakurikulerOptions[0];
                const selectedEkstrakurikulerNameEl = document.getElementById('selected-ekstrakurikuler-name');
                if (selectedEkstrakurikulerObj && selectedEkstrakurikulerNameEl) {
                    selectedEkstrakurikulerNameEl.innerText = selectedEkstrakurikulerObj.name;
                }

                const ekstrakurikulerDropdownOptions = document.getElementById('ekstrakurikuler-dropdown-options');
                if (ekstrakurikulerDropdownOptions) {
                    ekstrakurikulerDropdownOptions.innerHTML = ekstrakurikulerOptions.map(item => `
                        <div class="ekstrakurikuler-dropdown-option flex items-center gap-3 p-3 rounded-2xl hover:bg-brand-50 cursor-pointer transition-all group/opt" data-value="${item.slug}" data-name="${item.name}">
                            <div class="w-8 h-8 rounded-lg bg-slate-50 text-slate-400 flex items-center justify-center group-hover/opt:bg-brand-100 group-hover/opt:text-brand-600 transition-colors">
                                <i data-feather="activity" class="w-4 h-4"></i>
                            </div>
                            <span class="text-sm font-bold text-slate-600 group-hover/opt:text-brand-700">${item.name}</span>
                        </div>
                    `).join('');

                    document.querySelectorAll('.ekstrakurikuler-dropdown-option').forEach(opt => {
                        opt.addEventListener('click', () => {
                            const value = opt.getAttribute('data-value');
                            const name = opt.getAttribute('data-name');

                            selectedEkstrakurikulerSlug = value;
                            document.getElementById('selected-ekstrakurikuler-name').innerText = name;
                            ekstrakurikulerSelector.value = value;

                            document.getElementById('ekstrakurikuler-dropdown-menu').classList.add('hidden');
                            document.getElementById('ekstrakurikuler-dropdown-arrow').classList.remove('rotate-180');

                            renderSlots('ekstrakurikuler_detail');
                        });
                    });
                }

                jurusanSelectorWrapper.classList.add('hidden');
                jurusanSelector.innerHTML = '';
                ekstrakurikulerSelectorWrapper.classList.remove('hidden');

                renderImages = page.images_by_slug[selectedEkstrakurikulerSlug] || [];
            } else {
                jurusanSelectorWrapper.classList.add('hidden');
                jurusanSelector.innerHTML = '';
                ekstrakurikulerSelectorWrapper.classList.add('hidden');
                ekstrakurikulerSelector.innerHTML = '';
            }
            
            // Toggle Sections
            if (page.stats) {
                statsSection.classList.remove('hidden');
                syncStatsInputs(page);
            } else {
                statsSection.classList.add('hidden');
            }
            
            if (page.featured_ekskul) {
                ekskulSection.classList.remove('hidden');
            } else {
                ekskulSection.classList.add('hidden');
            }

            renderContentFields(pageKey, page);

            imageSlots.innerHTML = '';

            if (!renderImages.length) {
                imageSlots.innerHTML = `
                    <div class="md:col-span-2 bg-white p-8 rounded-3xl border border-dashed border-slate-200 text-center">
                        <div class="w-12 h-12 mx-auto mb-3 rounded-2xl bg-slate-50 text-slate-400 flex items-center justify-center">
                            <i data-feather="image" class="w-6 h-6"></i>
                        </div>
                        <h4 class="text-sm font-bold text-slate-700 mb-1">Belum ada slot gambar untuk halaman ini</h4>
                        <p class="text-xs text-slate-400 font-medium">Tambahkan mapping gambar di konfigurasi frontend jika halaman ini mulai memakai gambar.</p>
                    </div>
                `;
                feather.replace();
                return;
            }

            const groupedBySection = renderImages.reduce((acc, img) => {
                const sectionName = img.section || 'Lainnya';
                if (!acc[sectionName]) {
                    acc[sectionName] = [];
                }
                acc[sectionName].push(img);
                return acc;
            }, {});

            Object.entries(groupedBySection).forEach(([sectionName, sectionImages]) => {
                const sectionWrapper = document.createElement('div');
                sectionWrapper.className = 'md:col-span-2 bg-white p-6 rounded-3xl border border-slate-100 shadow-sm';
                sectionWrapper.innerHTML = `
                    <div class="flex items-center justify-between mb-5">
                        <h4 class="text-xs font-bold text-slate-500 uppercase tracking-widest">${sectionName}</h4>
                        <span class="text-[10px] font-bold text-brand-600 bg-brand-50 px-2 py-0.5 rounded-md">${sectionImages.length} SLOT</span>
                    </div>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6" data-role="section-grid"></div>
                `;

                const sectionGrid = sectionWrapper.querySelector('[data-role="section-grid"]');

                sectionImages.forEach(img => {
                    slotRegistry[img.id] = {
                        page_key: pageKey,
                        slot_key: img.key,
                        title: img.title,
                        section: img.section,
                        jurusan_slug: pageKey === 'jurusan_detail' ? selectedJurusanSlug : null,
                        ekstrakurikuler_slug: pageKey === 'ekstrakurikuler_detail' ? selectedEkstrakurikulerSlug : null,
                    };

                    let existingKey = `${pageKey}.${img.key}`;

                    if (pageKey === 'jurusan_detail') {
                        existingKey = `${pageKey}.${selectedJurusanSlug}.${img.key}`;
                    }

                    if (pageKey === 'ekstrakurikuler_detail') {
                        existingKey = `${pageKey}.${selectedEkstrakurikulerSlug}.${img.key}`;
                    }

                    const existingImage = existingImages[existingKey] || null;
                    const previewSrc = existingImage?.jpeg_url || '';
                    const hasImage = Boolean(previewSrc);

                    const card = document.createElement('div');
                    card.className = "bg-white p-6 rounded-3xl border border-slate-100 shadow-sm hover:border-brand-200 transition-all group";
                    card.innerHTML = `
                        <div class="flex items-start justify-between mb-6">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl bg-slate-50 text-slate-500 flex items-center justify-center group-hover:bg-brand-50 group-hover:text-brand-600 transition-colors">
                                    <i data-feather="image" class="w-5 h-5"></i>
                                </div>
                                <div>
                                    <h4 class="text-sm font-bold text-slate-800">${img.title}</h4>
                                    <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mt-0.5">Ratio: ${img.ratio} • Key: ${img.key}</p>
                                </div>
                            </div>
                        </div>

                        <div class="relative aspect-video bg-slate-50 rounded-2xl border-2 border-dashed border-slate-100 flex items-center justify-center overflow-hidden mb-6">
                            <img id="preview-${img.id}" class="absolute inset-0 w-full h-full object-cover ${hasImage ? '' : 'opacity-0'} transition-opacity duration-300" src="${previewSrc}" alt="${existingImage?.alt_text || img.title}">
                            <div id="placeholder-${img.id}" class="flex flex-col items-center gap-2 ${hasImage ? 'hidden' : ''}">
                                <i data-feather="plus-circle" class="w-8 h-8 text-slate-200"></i>
                                <span class="text-[10px] text-slate-300 font-bold uppercase tracking-widest">Belum ada gambar</span>
                            </div>
                        </div>

                        <button onclick="triggerUpload(${img.id}, ${img.ratio_val || 1})" class="w-full py-3 bg-slate-50 hover:bg-brand-600 hover:text-white text-slate-600 text-xs font-bold rounded-2xl transition-all border border-slate-100 hover:border-brand-600 flex items-center justify-center gap-2">
                            <i data-feather="upload" class="w-3.5 h-3.5"></i> GANTI GAMBAR
                        </button>
                    `;
                    sectionGrid.appendChild(card);
                });

                imageSlots.appendChild(sectionWrapper);
            });
            feather.replace();
        }

        function updateEkskulSelectionState() {
            const checked = document.querySelectorAll('.ekskul-checkbox:checked');
            ekskulCountDisplay.innerText = `${checked.length} / 3 TERPILIH`;

            if (checked.length >= 3) {
                ekskulCheckboxes.forEach(checkbox => {
                    if (!checkbox.checked) checkbox.disabled = true;
                });
            } else {
                ekskulCheckboxes.forEach(checkbox => {
                    checkbox.disabled = false;
                });
            }
        }

        // Handle Ekskul selection limit (max 3)
        ekskulCheckboxes.forEach(cb => {
            cb.addEventListener('change', updateEkskulSelectionState);
        });

        function collectHomeFields() {
            const data = {};
            document.querySelectorAll('[data-home-field-key]').forEach(el => {
                const key = el.getAttribute('data-home-field-key');
                if (!key) return;

                if (el.type === 'checkbox') {
                    data[key] = !!el.checked;
                } else {
                    data[key] = el.value;
                }
            });

            return data;
        }

        saveHomeContentBtn?.addEventListener('click', async () => {
            const currentPageKey = pageSelector.value;

            if (!['landing', 'profil'].includes(currentPageKey)) {
                return;
            }

            const homeFields = collectHomeFields();

            let requestUrl = '{{ route('admin.gallery.page-content.update') }}';
            let requestBody = {};

            if (currentPageKey === 'landing') {
                const checkedEkskul = Array.from(document.querySelectorAll('.ekskul-checkbox:checked')).map(el => el.value);
                if (checkedEkskul.length !== 3) {
                    alert('Pilih tepat 3 ekskul unggulan untuk Beranda.');
                    return;
                }

                requestUrl = '{{ route('admin.gallery.home-settings.update') }}';
                requestBody = {
                    hero_badge_text: homeFields.hero_badge_text ?? '',
                    is_badge_visible: Boolean(homeFields.is_badge_visible),
                    total_ekskul: Number(statInputs.total_ekskul?.value || 0),
                    siswa_aktif: Number(statInputs.siswa_aktif?.value || 0),
                    total_prestasi: Number(statInputs.total_prestasi?.value || 0),
                    mitra_industri: String(statInputs.mitra_industri?.value || '0+'),
                    alamat: String(statInputs.alamat?.value || ''),
                    nomor_telepon: String(statInputs.nomor_telepon?.value || ''),
                    email: String(statInputs.email?.value || ''),
                    persen_melanjutkan_kuliah: Number(statInputs.persen_melanjutkan_kuliah?.value || 0),
                    persen_bekerja_berwirausaha: Number(statInputs.persen_bekerja_berwirausaha?.value || 0),
                    tahun_mengabdi: Number(statInputs.tahun_mengabdi?.value || 0),
                    featured_ekskul: checkedEkskul,
                };
            } else if (currentPageKey === 'profil') {
                requestBody = {
                    page_key: 'profil',
                    title: 'Tentang Kami - SMKN 1 Wringin',
                    fields: {
                        hero_badge_text: String(homeFields.hero_badge_text || ''),
                        hero_title: String(homeFields.hero_title || ''),
                        hero_description: String(homeFields.hero_description || ''),
                        sejarah_title: String(homeFields.sejarah_title || ''),
                        sejarah_body: String(homeFields.sejarah_body || ''),
                        keunggulan_intro: String(homeFields.keunggulan_intro || ''),
                        keunggulan_items: String(homeFields.keunggulan_items || ''),
                        visi_title: String(homeFields.visi_title || ''),
                        visi_body: String(homeFields.visi_body || ''),
                        misi_items: String(homeFields.misi_items || ''),
                        motto_text: String(homeFields.motto_text || ''),
                        cta_title: String(homeFields.cta_title || ''),
                        cta_description: String(homeFields.cta_description || ''),
                    },
                };
            }

            saveHomeContentBtn.disabled = true;
            const originalLabel = saveHomeContentBtn.innerHTML;
            saveHomeContentBtn.innerHTML = '<i data-feather="loader" class="w-4 h-4 animate-spin"></i> Menyimpan...';
            feather.replace();

            try {
                const response = await fetch(requestUrl, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify(requestBody),
                });

                const payload = await response.json();

                if (!response.ok || !payload.success) {
                    throw new Error(payload.message || 'Gagal menyimpan konten beranda.');
                }

                alert(currentPageKey === 'landing' ? 'Konten beranda berhasil disimpan.' : 'Konten halaman profil berhasil disimpan.');
            } catch (error) {
                alert(error.message || 'Terjadi kesalahan saat menyimpan konten halaman.');
            } finally {
                saveHomeContentBtn.disabled = false;
                saveHomeContentBtn.innerHTML = originalLabel;
                feather.replace();
            }
        });

        // Trigger upload
        window.triggerUpload = (id, ratio) => {
            currentTargetId = id;
            currentTargetSlot = slotRegistry[id] || null;
            imageInput.setAttribute('data-ratio', ratio);
            imageInput.click();
        };

        jurusanSelector?.addEventListener('change', () => {
            selectedJurusanSlug = jurusanSelector.value;
            renderSlots(pageSelector.value);
        });

        ekstrakurikulerSelector?.addEventListener('change', () => {
            selectedEkstrakurikulerSlug = ekstrakurikulerSelector.value;
            renderSlots(pageSelector.value);
        });

        // Handle file selection
        imageInput.addEventListener('change', (e) => {
            const file = e.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = (event) => {
                cropperImage.src = event.target.result;
                openModal();
                
                const ratio = parseFloat(imageInput.getAttribute('data-ratio'));
                
                if (currentCropper) currentCropper.destroy();
                currentCropper = new Cropper(cropperImage, {
                    aspectRatio: ratio,
                    viewMode: 2,
                    background: false,
                    responsive: true,
                });
            };
            reader.readAsDataURL(file);
        });

        function openModal() {
            cropModal.classList.remove('hidden');
            cropModal.classList.add('flex');
            document.body.style.overflow = 'hidden';
        }

        window.closeModal = () => {
            cropModal.classList.add('hidden');
            cropModal.classList.remove('flex');
            document.body.style.overflow = 'auto';
            imageInput.value = '';
        };

        // Save crop
        saveCropBtn.addEventListener('click', async () => {
            if (!currentCropper || !currentTargetSlot) {
                alert('Slot gambar tidak valid. Silakan pilih ulang slot gambar.');
                return;
            }

            saveCropBtn.disabled = true;
            const originalLabel = saveCropBtn.innerHTML;
            saveCropBtn.innerHTML = '<i data-feather="loader" class="w-3.5 h-3.5 animate-spin"></i> MENYIMPAN...';
            feather.replace();

            const canvas = currentCropper.getCroppedCanvas({
                width: 1200, // Reasonable max width
            });
            
            const croppedImageData = canvas.toDataURL('image/jpeg');

            try {
                const response = await fetch('{{ route('admin.gallery.upload-image') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                    },
                    body: JSON.stringify({
                        page_key: currentTargetSlot.page_key,
                        slot_key: currentTargetSlot.slot_key,
                        jurusan_slug: currentTargetSlot.jurusan_slug,
                        ekstrakurikuler_slug: currentTargetSlot.ekstrakurikuler_slug,
                        title: currentTargetSlot.title,
                        section: currentTargetSlot.section,
                        image_data: croppedImageData,
                    }),
                });

                const payload = await response.json();

                if (!response.ok || !payload.success) {
                    throw new Error(payload.message || 'Gagal menyimpan gambar.');
                }

                const previewImg = document.getElementById(`preview-${currentTargetId}`);
                const placeholder = document.getElementById(`placeholder-${currentTargetId}`);
                previewImg.src = payload.data.jpeg_url;
                previewImg.classList.remove('opacity-0');
                placeholder.classList.add('hidden');

                closeModal();
            } catch (error) {
                alert(error.message || 'Terjadi kesalahan saat menyimpan gambar.');
            } finally {
                saveCropBtn.disabled = false;
                saveCropBtn.innerHTML = originalLabel;
                feather.replace();
            }
        });

        // Initial render
        renderSlots(pageSelector.value);
        updateEkskulSelectionState();

    </script>
</body>
</html>
