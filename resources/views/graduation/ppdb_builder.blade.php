<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin - PPDB Builder</title>

    <link rel="icon" type="image/png" href="{{ asset('images/alternative/icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
            background: #cbd5e1;
            border-radius: 9999px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .article-content p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
            color: #334155;
            font-size: 1.125rem;
        }

        .article-content h2 {
            font-size: 1.875rem;
            font-weight: 800;
            color: #0f172a;
            margin-top: 3rem;
            margin-bottom: 1rem;
        }

        .article-content ul {
            list-style-type: disc;
            padding-left: 1.5rem;
            margin-bottom: 1.5rem;
            color: #334155;
            font-size: 1.125rem;
            line-height: 1.8;
        }

        .article-content li {
            margin-bottom: 0.5rem;
        }

        .builder-preview a {
            pointer-events: none;
        }

        .drag-ghost {
            opacity: 0.45;
        }

        .drag-over {
            border-color: #1E5460;
            background: #f0f9fa;
        }

        .component-active {
            border-color: #1E5460 !important;
            border-style: dashed !important;
            background-color: rgba(30, 84, 96, 0.04) !important;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</head>
<body class="h-screen overflow-hidden bg-slate-50 font-sans text-slate-800 antialiased">
    <div class="relative flex h-screen overflow-hidden">
        <div id="adminSidebarBackdrop" class="fixed inset-0 z-30 hidden bg-slate-900/50 backdrop-blur-sm lg:hidden"></div>

        <aside id="adminSidebar" class="fixed inset-y-0 left-0 z-40 flex h-screen w-64 -translate-x-full flex-col border-r border-slate-200 bg-white transition-transform duration-300 lg:static lg:z-20 lg:translate-x-0">
            <div class="flex h-20 items-center justify-between border-b border-slate-100 px-6">
                <div class="flex items-center">
                    <div class="mr-3 flex h-10 w-10 items-center justify-center rounded-xl border border-slate-100 bg-white shadow-sm">
                        <picture>
                            <source srcset="{{ asset('images/webp/icon.webp') }}" type="image/webp">
                            <img src="{{ asset('images/alternative/icon.png') }}" alt="Logo" class="h-7 w-7 object-contain">
                        </picture>
                    </div>
                    <span class="text-base font-bold leading-tight tracking-tight text-slate-800">Admin <br><span class="text-brand-600">SMKN 1 Wringin</span></span>
                </div>
                <button type="button" id="adminSidebarClose" class="inline-flex h-10 w-10 items-center justify-center rounded-xl text-slate-400 transition hover:bg-slate-100 hover:text-slate-700 lg:hidden">
                    <i data-feather="x" class="h-5 w-5"></i>
                </button>
            </div>

            <div class="custom-scrollbar flex-1 space-y-2 overflow-y-auto px-4 py-6">
                <p class="mb-4 px-2 text-[10px] font-bold uppercase tracking-widest text-slate-400">Menu Utama</p>

                <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-slate-500 transition-all hover:bg-brand-50 hover:text-brand-700">
                    <i data-feather="grid" class="h-5 w-5"></i>
                    <span class="text-sm font-medium">Dashboard</span>
                </a>

                <a href="{{ route('admin.gallery') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-slate-500 transition-all hover:bg-brand-50 hover:text-brand-700">
                    <i data-feather="image" class="h-5 w-5"></i>
                    <span class="text-sm font-medium">Kelola Page</span>
                </a>

                <a href="{{ route('admin.graduation') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-slate-500 transition-all hover:bg-brand-50 hover:text-brand-700">
                    <i data-feather="users" class="h-5 w-5"></i>
                    <span class="text-sm font-medium">Data Kelulusan</span>
                </a>

                <a href="{{ route('admin.ppdb-builder') }}" class="flex items-center gap-3 rounded-xl border border-brand-100 bg-brand-50 px-4 py-3 text-brand-600 shadow-sm transition-all">
                    <i data-feather="file-text" class="h-5 w-5"></i>
                    <span class="text-sm font-bold">PPDB</span>
                </a>

                <a href="{{ route('admin.berita.index') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 {{ request()->routeIs('admin.berita.*') ? 'border border-brand-100 bg-brand-50 text-brand-600 shadow-sm' : 'text-slate-500 hover:bg-brand-50 hover:text-brand-700' }} transition-all">
                    <i data-feather="book-open" class="h-5 w-5"></i>
                    <span class="text-sm {{ request()->routeIs('admin.berita.*') ? 'font-bold' : 'font-medium' }}">Berita</span>
                </a>
            </div>
        </aside>

        <main class="flex h-screen min-h-0 w-full flex-1 flex-col overflow-hidden bg-slate-50">
            <header class="relative z-[80] flex min-h-20 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3 sm:gap-4">
                    <button type="button" id="adminSidebarOpen" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-brand-200 hover:text-brand-600 lg:hidden">
                        <i data-feather="menu" class="h-5 w-5"></i>
                    </button>
                    <div class="flex flex-wrap items-center gap-2 sm:gap-4">
                        <h1 class="text-lg font-extrabold tracking-tight text-slate-800 sm:text-xl">PPDB Builder</h1>
                        <span class="rounded-full border border-brand-100 bg-brand-50 px-3 py-1 text-[11px] font-bold text-brand-600 sm:text-xs">Preview & Edit</span>
                    </div>
                </div>

                <div class="relative" id="adminProfileMenuWrapper">
                    <button type="button" id="adminProfileToggle" class="group flex cursor-pointer items-center gap-3 rounded-2xl px-2 py-1.5 transition-colors hover:bg-slate-50">
                        <div class="h-9 w-9 rounded-full border border-slate-200 bg-slate-100 p-[2px]">
                            <img src="https://ui-avatars.com/api/?name=Admin+User&background=1E5460&color=fff" alt="Admin" class="h-full w-full rounded-full">
                        </div>
                        <div class="hidden text-left md:block">
                            <p class="text-sm font-bold text-slate-700 transition-colors group-hover:text-brand-600">Admin Wringin</p>
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
            </header>

            <div class="relative z-10 min-h-0 flex-1 overflow-y-auto custom-scrollbar hero-pattern p-4 sm:p-6 lg:p-8">
                <div class="mx-auto max-w-5xl space-y-8">


                    @if (session('success'))
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                            <p class="mb-2 font-bold">Ada input yang perlu diperbaiki:</p>
                            <ul class="list-disc pl-5 font-medium">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    @if (! $builderReady)
                        <div class="rounded-3xl border border-amber-200 bg-amber-50 p-6 shadow-sm">
                            <h3 class="text-lg font-extrabold text-amber-900">Builder belum siap</h3>
                            <p class="mt-2 text-sm font-medium text-amber-800">Jalankan migrasi baru terlebih dahulu agar tabel `page_contents`, `page_blocks`, dan `page_assets` tersedia.</p>
                        </div>
                    @else
                        <!-- SATU CARD UNTUK MENAMBAH KOMPONEN DIATAS -->
                        <div x-data="{ activeTab: 'tambah' }" class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                            <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between border-b border-slate-100 pb-4">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-brand-600">Komponen & Pengaturan</p>
                                    <h3 class="mt-1 text-lg font-extrabold text-slate-900">Tambahkan Komponen & Atur Halaman</h3>
                                </div>
                                <div class="flex flex-wrap items-center gap-2">
                                    <a href="{{ route('ppdb') }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 rounded-xl bg-brand-600 px-3.5 py-2 text-xs font-bold text-white shadow-sm shadow-brand-600/20 transition hover:bg-brand-700">
                                        <i data-feather="external-link" class="h-3.5 w-3.5"></i>
                                        Buka Halaman PPDB
                                    </a>
                                    <div class="flex rounded-xl bg-slate-100 p-1">
                                        <button type="button" @click="activeTab = 'tambah'" :class="activeTab === 'tambah' ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="rounded-lg px-4 py-2 text-xs font-bold transition-all">Tambah Komponen</button>
                                        <button type="button" @click="activeTab = 'header'" :class="activeTab === 'header' ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="rounded-lg px-4 py-2 text-xs font-bold transition-all">Header Halaman</button>
                                    </div>
                                </div>
                            </div>

                            <!-- Tab Konten: Tambah Komponen -->
                            <div x-show="activeTab === 'tambah'" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                                <form action="{{ route('admin.ppdb-builder.blocks.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5" id="createBlockForm">
                                    @csrf
                                    <div>
                                        <label for="block_type" class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Tipe Komponen</label>
                                        <select id="block_type" name="block_type" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                            @foreach (['text' => 'Text', 'image' => 'Image', 'file' => 'File', 'link' => 'Link'] as $key => $label)
                                                <option value="{{ $key }}" @selected(old('block_type') === $key)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div data-create-type="text" class="space-y-4">
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Heading</label>
                                            <input type="text" name="heading" value="{{ old('heading') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                        </div>
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Body</label>
                                            <textarea name="body" rows="6" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" placeholder="Pisahkan paragraf dengan baris kosong. Gunakan awalan '- ' untuk item list.">{{ old('body') }}</textarea>
                                        </div>
                                    </div>

                                    <div data-create-type="image" class="hidden space-y-4">
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Upload Gambar</label>
                                            <input type="file" name="asset_file" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:font-bold file:text-brand-700 hover:file:bg-brand-100">
                                            <p class="mt-2 text-xs font-medium text-slate-400">Sistem akan generate JPEG + WEBP dan publik memakai elemen `picture`.</p>
                                        </div>
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Caption</label>
                                            <input type="text" name="caption" value="{{ old('caption') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                        </div>
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Alt Text</label>
                                            <input type="text" name="alt_text" value="{{ old('alt_text') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                        </div>
                                    </div>

                                    <div data-create-type="file" class="hidden space-y-4">
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Upload File</label>
                                            <input type="file" name="asset_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:font-bold file:text-brand-700 hover:file:bg-brand-100">
                                        </div>
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Label</label>
                                            <input type="text" name="label" value="{{ old('label') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                        </div>
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Deskripsi</label>
                                            <input type="text" name="description" value="{{ old('description') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                        </div>
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Teks Tombol</label>
                                            <input type="text" name="button_text" value="{{ old('button_text', 'Unduh File') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                        </div>
                                    </div>

                                    <div data-create-type="link" class="hidden space-y-4">
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Label</label>
                                            <input type="text" name="label" value="{{ old('label') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                        </div>
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">URL</label>
                                            <input type="url" name="url" value="{{ old('url') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                        </div>
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Deskripsi</label>
                                            <input type="text" name="description" value="{{ old('description') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                        </div>
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Style</label>
                                            <select name="style_variant" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                                <option value="brand" @selected(old('style_variant', 'brand') === 'brand')>Brand</option>
                                                <option value="outline" @selected(old('style_variant') === 'outline')>Outline</option>
                                            </select>
                                        </div>
                                    </div>

                                    <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-5 py-3 text-sm font-bold text-white shadow-sm shadow-brand-600/20 transition hover:bg-brand-700">
                                        <i data-feather="plus" class="h-4 w-4"></i>
                                        Tambah Blok
                                    </button>
                                </form>
                            </div>

                            <!-- Tab Konten: Header Halaman -->
                            <div x-show="activeTab === 'header'" x-cloak x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 translate-y-1" x-transition:enter-end="opacity-100 translate-y-0">
                                <form action="{{ route('admin.ppdb-builder.header.update') }}" method="POST" class="space-y-4">
                                    @csrf
                                    @method('PUT')
                                    <div>
                                        <label for="title" class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Judul Halaman PPDB</label>
                                        <input id="title" name="title" type="text" value="{{ old('title', $title) }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                                    </div>
                                    <div>
                                        <label for="badge_text" class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Badge</label>
                                        <input id="badge_text" name="badge_text" type="text" value="{{ old('badge_text', $badgeText) }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" required>
                                    </div>
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-5 py-3 text-sm font-bold text-white shadow-sm shadow-brand-600/20 transition hover:bg-brand-700">
                                        <i data-feather="save" class="h-4 w-4"></i>
                                        Simpan Header
                                    </button>
                                </form>
                            </div>
                        </div>

                        <!-- SATU MASTER CARD BESAR YANG ISINYA MEREPRESENTASIKAN PAGE PPDB ASLI -->
                        <div class="rounded-3xl border border-slate-200/80 bg-white shadow-xl overflow-hidden">
                            <!-- Mockup Window Bar -->
                            <div class="flex items-center justify-between bg-slate-100/80 px-4 py-3 border-b border-slate-200/60">
                                <div class="flex items-center gap-1.5">
                                    <div class="h-3 w-3 rounded-full bg-red-400"></div>
                                    <div class="h-3 w-3 rounded-full bg-amber-400"></div>
                                    <div class="h-3 w-3 rounded-full bg-emerald-400"></div>
                                </div>
                                <div class="flex items-center gap-2 rounded-lg bg-white/90 px-4 py-1 text-xs font-medium text-slate-500 shadow-2xs sm:w-80 justify-center mx-2">
                                    <i data-feather="lock" class="h-3 w-3 text-emerald-600"></i>
                                    <span class="truncate">smkn1wringin.sch.id/ppdb</span>
                                </div>
                                <div class="flex items-center gap-2">
                                    <span class="text-[10px] font-bold uppercase tracking-widest text-slate-400 hidden sm:inline">Live Master Preview</span>
                                </div>
                            </div>

                            <!-- Isi Representasi Page PPDB Asli -->
                            <div class="bg-white">
                                <!-- Bagian Header PPDB Asli -->
                                <header class="bg-white pb-8 pt-12 border-b border-slate-100">
                                    <div class="mx-auto max-w-3xl px-4 text-center sm:px-6 lg:px-8">
                                        <div class="mb-4 inline-flex items-center gap-2 rounded-full border border-brand-100 bg-brand-50 px-3 py-1 text-xs font-bold uppercase tracking-wide text-brand-600">
                                            <i class="fa-solid fa-calendar-check text-secondary"></i>
                                            {{ $badgeText ?? 'Informasi Resmi PPDB' }}
                                        </div>

                                        <h1 class="mb-6 text-3xl font-extrabold leading-tight text-slate-900 md:text-4xl">
                                            {{ $title ?? 'Informasi PPDB' }}
                                        </h1>

                                        <div class="flex flex-wrap items-center justify-center gap-4 text-xs font-medium text-slate-500">
                                            <div class="flex items-center gap-2">
                                                <div class="flex h-6 w-6 items-center justify-center rounded-full bg-brand-600 text-[10px] text-white">
                                                    <i class="fa-solid fa-user-shield"></i>
                                                </div>
                                                <span>Panitia PPDB</span>
                                            </div>
                                            <span class="hidden sm:inline">•</span>
                                            <span>Diperbarui {{ !empty($updatedAt) ? \Illuminate\Support\Carbon::parse($updatedAt)->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}</span>
                                            <span class="hidden sm:inline">•</span>
                                            <span><i class="fa-regular fa-clock"></i> {{ !empty($updatedAt) ? \Illuminate\Support\Carbon::parse($updatedAt)->translatedFormat('H:i') . ' WIB' : now()->translatedFormat('H:i') . ' WIB' }}</span>
                                        </div>
                                    </div>
                                </header>

                                <!-- Bagian Konten Utama PPDB Asli -->
                                <main class="py-10">
                                    <div class="article-content mx-auto max-w-3xl px-4 sm:px-6 lg:px-8" id="ppdbPreviewList">
                                        @forelse ($blocks as $index => $block)
                                            <article
                                                class="relative group transition-all duration-200 rounded-2xl p-3 sm:p-5 my-4 border-2 border-transparent cursor-pointer hover:border-slate-200"
                                                data-block-preview
                                                data-block-id="{{ $block['id'] }}"
                                                draggable="true"
                                            >
                                                <!-- Overlay/Toolbar interaktif -->
                                                <div class="absolute top-2 right-2 z-20 opacity-0 group-hover:opacity-100 transition-opacity flex items-center gap-1 bg-white/95 backdrop-blur-sm px-2 py-1 rounded-xl border border-slate-200 shadow-sm">
                                                    <span class="text-[10px] font-bold uppercase tracking-wider text-brand-600 mr-2">{{ strtoupper($block['type']) }} #{{ $index + 1 }}</span>
                                                    <button type="button" class="p-1.5 text-slate-400 hover:text-brand-600 rounded-lg transition-colors" data-drag-handle title="Geser blok">
                                                        <i data-feather="move" class="h-3.5 w-3.5"></i>
                                                    </button>
                                                    <button type="button" class="p-1.5 text-slate-400 hover:text-brand-600 rounded-lg transition-colors" title="Edit blok">
                                                        <i data-feather="edit-2" class="h-3.5 w-3.5"></i>
                                                    </button>
                                                </div>

                                                <!-- Render asli dari blok -->
                                                <div class="builder-preview pointer-events-none">
                                                    @include('pages.ppdb_partials.block_renderer', ['block' => $block, 'isBuilderPreview' => true])
                                                </div>
                                            </article>
                                        @empty
                                            <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-6 py-12 text-center">
                                                <p class="text-base font-bold text-slate-700">Belum ada komponen/blok kustom.</p>
                                                <p class="mt-1 text-xs font-medium text-slate-500">Tambahkan komponen pertama Anda melalui card di atas.</p>
                                            </div>
                                        @endforelse
                                    </div>
                                </main>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </main>
    </div>

    @if ($builderReady)
        <div id="blockEditModal" class="fixed inset-0 z-[130] hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
            <div class="max-h-[90vh] w-full max-w-3xl overflow-hidden rounded-3xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Edit Blok</p>
                        <h3 id="modalBlockTitle" class="mt-1 text-lg font-extrabold text-slate-900">Blok PPDB</h3>
                    </div>
                    <button type="button" id="closeBlockModal" class="inline-flex h-10 w-10 items-center justify-center rounded-2xl bg-slate-50 text-slate-400 transition hover:bg-slate-100 hover:text-slate-600">
                        <i data-feather="x" class="h-5 w-5"></i>
                    </button>
                </div>

                <div class="custom-scrollbar max-h-[calc(90vh-96px)] overflow-y-auto px-6 py-6">
                    <form id="blockEditForm" method="POST" enctype="multipart/form-data" class="space-y-5">
                        @csrf
                        @method('PUT')

                        <div id="modalTextFields" class="hidden space-y-4">
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Heading</label>
                                <input type="text" name="heading" data-modal-input="text.heading" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Body</label>
                                <textarea name="body" rows="8" data-modal-input="text.body" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"></textarea>
                            </div>
                        </div>

                        <div id="modalImageFields" class="hidden space-y-4">
                            <div id="modalImagePreview" class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50"></div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Ganti Gambar</label>
                                <input type="file" name="asset_file" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:font-bold file:text-brand-700 hover:file:bg-brand-100">
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Caption</label>
                                <input type="text" name="caption" data-modal-input="image.caption" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Alt Text</label>
                                <input type="text" name="alt_text" data-modal-input="image.alt_text" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                            </div>
                        </div>

                        <div id="modalFileFields" class="hidden space-y-4">
                            <div id="modalFileInfo" class="rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600"></div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Ganti File</label>
                                <input type="file" name="asset_file" accept=".pdf,.doc,.docx,.xls,.xlsx,.zip" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:font-bold file:text-brand-700 hover:file:bg-brand-100">
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Label</label>
                                <input type="text" name="label" data-modal-input="file.label" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Deskripsi</label>
                                <input type="text" name="description" data-modal-input="file.description" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Teks Tombol</label>
                                <input type="text" name="button_text" data-modal-input="file.button_text" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                            </div>
                        </div>

                        <div id="modalLinkFields" class="hidden space-y-4">
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Label</label>
                                <input type="text" name="label" data-modal-input="link.label" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">URL</label>
                                <input type="url" name="url" data-modal-input="link.url" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Deskripsi</label>
                                <input type="text" name="description" data-modal-input="link.description" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Style</label>
                                <select name="style_variant" data-modal-input="link.style_variant" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                    <option value="brand">Brand</option>
                                    <option value="outline">Outline</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                            <button type="submit" form="blockDeleteForm" id="deleteBlockBtn" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-red-200 px-4 py-3 text-sm font-bold text-red-600 transition hover:bg-red-50">
                                <i data-feather="trash-2" class="h-4 w-4"></i>
                                Hapus Blok
                            </button>

                            <div class="flex flex-col gap-3 sm:flex-row">
                                <button type="button" id="cancelBlockModal" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-700 transition hover:border-brand-200 hover:text-brand-600">
                                    Batal
                                </button>
                                <button type="submit" form="blockEditForm" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-600 px-5 py-3 text-sm font-bold text-white shadow-sm shadow-brand-600/20 transition hover:bg-brand-700">
                                    <i data-feather="save" class="h-4 w-4"></i>
                                    Simpan Perubahan
                                </button>
                            </div>
                        </div>
                    </form>
                    <form id="blockDeleteForm" method="POST" class="hidden">
                        @csrf
                        @method('DELETE')
                    </form>
                </div>
            </div>
        </div>
    @endif

    <script>
        const adminSidebar = document.getElementById('adminSidebar');
        const adminSidebarBackdrop = document.getElementById('adminSidebarBackdrop');
        const adminSidebarOpenBtn = document.getElementById('adminSidebarOpen');
        const adminSidebarCloseBtn = document.getElementById('adminSidebarClose');
        const adminProfileToggle = document.getElementById('adminProfileToggle');
        const adminProfileDropdown = document.getElementById('adminProfileDropdown');
        const blockTypeSelect = document.getElementById('block_type');
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
        const reorderUrl = @json(route('admin.ppdb-builder.blocks.reorder'));
        const updateRouteTemplate = @json(route('admin.ppdb-builder.blocks.update', ['block' => '__BLOCK__']));
        const deleteRouteTemplate = @json(route('admin.ppdb-builder.blocks.destroy', ['block' => '__BLOCK__']));
        const ppdbBlocks = @json($blocks);

        const previewList = document.getElementById('ppdbPreviewList');
        const blockEditModal = document.getElementById('blockEditModal');
        const blockEditForm = document.getElementById('blockEditForm');
        const blockDeleteForm = document.getElementById('blockDeleteForm');
        const modalBlockTitle = document.getElementById('modalBlockTitle');
        const closeBlockModalBtn = document.getElementById('closeBlockModal');
        const cancelBlockModalBtn = document.getElementById('cancelBlockModal');
        const modalTextFields = document.getElementById('modalTextFields');
        const modalImageFields = document.getElementById('modalImageFields');
        const modalFileFields = document.getElementById('modalFileFields');
        const modalLinkFields = document.getElementById('modalLinkFields');
        const modalImagePreview = document.getElementById('modalImagePreview');
        const modalFileInfo = document.getElementById('modalFileInfo');
        let draggedBlockId = null;
        let isDragging = false;

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

        function syncCreateBlockFields() {
            const selectedType = blockTypeSelect?.value || 'text';
            document.querySelectorAll('[data-create-type]').forEach((section) => {
                const isActive = section.getAttribute('data-create-type') === selectedType;
                section.classList.toggle('hidden', !isActive);
                section.querySelectorAll('input, textarea, select').forEach((field) => {
                    field.disabled = !isActive;
                });
            });
        }

        function syncModalFields(type) {
            const map = {
                text: modalTextFields,
                image: modalImageFields,
                file: modalFileFields,
                link: modalLinkFields,
            };

            Object.entries(map).forEach(([key, section]) => {
                if (!section) return;
                const isActive = key === type;
                section.classList.toggle('hidden', !isActive);
                section.querySelectorAll('input, textarea, select').forEach((field) => {
                    field.disabled = !isActive;
                    if (!isActive && field.type === 'file') {
                        field.value = '';
                    }
                });
            });
        }

        function routeForBlock(template, blockId) {
            return template.replace('__BLOCK__', String(blockId));
        }

        function setModalValue(key, value) {
            const field = blockEditForm?.querySelector(`[data-modal-input="${key}"]`);
            if (!field) return;
            field.value = value ?? '';
        }

        function openBlockModal(blockId) {
            const block = ppdbBlocks.find((item) => Number(item.id) === Number(blockId));
            if (!block || !blockEditModal || !blockEditForm || !blockDeleteForm) {
                return;
            }

            blockEditForm.action = routeForBlock(updateRouteTemplate, block.id);
            blockDeleteForm.action = routeForBlock(deleteRouteTemplate, block.id);
            modalBlockTitle.textContent = `Edit Blok ${String(block.type || '').toUpperCase()}`;

            blockEditForm.reset();
            syncModalFields(block.type);

            if (block.type === 'text') {
                setModalValue('text.heading', block.heading || '');
                setModalValue('text.body', block.body || '');
            }

            if (block.type === 'image') {
                setModalValue('image.caption', block.caption || '');
                setModalValue('image.alt_text', block.alt_text || '');
                modalImagePreview.innerHTML = block.asset?.jpeg_url
                    ? `<picture>${block.asset?.webp_url ? `<source srcset="${block.asset.webp_url}" type="image/webp">` : ''}<img src="${block.asset.jpeg_url}" alt="${block.alt_text || 'Gambar PPDB'}" class="h-64 w-full object-cover"></picture>`
                    : '<div class="p-6 text-center text-sm font-medium text-slate-400">Belum ada gambar.</div>';
            }

            if (block.type === 'file') {
                setModalValue('file.label', block.label || '');
                setModalValue('file.description', block.description || '');
                setModalValue('file.button_text', block.button_text || 'Unduh File');
                modalFileInfo.innerHTML = `<p class="font-bold text-slate-800">${block.asset?.name || 'Belum ada file'}</p><p class="mt-1 text-xs font-medium text-slate-500">${block.asset?.size_label || '-'}${block.asset?.mime_type ? ` • ${block.asset.mime_type}` : ''}</p>`;
            }

            if (block.type === 'link') {
                setModalValue('link.label', block.label || '');
                setModalValue('link.url', block.url || '');
                setModalValue('link.description', block.description || '');
                setModalValue('link.style_variant', block.style_variant || 'brand');
            }

            blockEditModal.classList.remove('hidden');
            blockEditModal.classList.add('flex');
            document.body.classList.add('overflow-hidden');
            feather.replace();
        }

        function closeBlockModal() {
            if (!blockEditModal) return;
            blockEditModal.classList.add('hidden');
            blockEditModal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }

        async function persistPreviewOrder() {
            if (!previewList) return;

            const blockIds = Array.from(previewList.querySelectorAll('[data-block-preview]')).map((item) => Number(item.getAttribute('data-block-id'))).filter(Boolean);
            if (!blockIds.length) return;

            const response = await fetch(reorderUrl, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': csrfToken,
                    'X-Requested-With': 'XMLHttpRequest',
                },
                body: JSON.stringify({ block_ids: blockIds }),
            });

            if (!response.ok) {
                throw new Error('Gagal menyimpan urutan blok PPDB.');
            }
        }

        adminSidebarOpenBtn?.addEventListener('click', openAdminSidebar);
        adminSidebarCloseBtn?.addEventListener('click', closeAdminSidebar);
        adminSidebarBackdrop?.addEventListener('click', closeAdminSidebar);
        adminProfileToggle?.addEventListener('click', (event) => {
            event.stopPropagation();
            toggleAdminProfileMenu();
        });
        blockTypeSelect?.addEventListener('change', syncCreateBlockFields);
        closeBlockModalBtn?.addEventListener('click', closeBlockModal);
        cancelBlockModalBtn?.addEventListener('click', closeBlockModal);

        document.addEventListener('click', (event) => {
            if (!event.target.closest('#adminProfileMenuWrapper')) {
                closeAdminProfileMenu();
            }

            const previewCard = event.target.closest('[data-block-preview]');
            if (previewCard && !event.target.closest('[data-drag-handle]') && !isDragging) {
                document.querySelectorAll('[data-block-preview]').forEach((item) => {
                    item.classList.remove('component-active');
                });
                previewCard.classList.add('component-active');

                openBlockModal(previewCard.getAttribute('data-block-id'));
            }

            if (event.target === blockEditModal) {
                closeBlockModal();
            }
        });

        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeAdminProfileMenu();
                closeAdminSidebar();
                closeBlockModal();
            }
        });

        previewList?.querySelectorAll('[data-block-preview]').forEach((item) => {
            item.addEventListener('dragstart', () => {
                draggedBlockId = item.getAttribute('data-block-id');
                isDragging = true;
                item.classList.add('drag-ghost');
            });

            item.addEventListener('dragend', () => {
                draggedBlockId = null;
                isDragging = false;
                item.classList.remove('drag-ghost');
                previewList.querySelectorAll('[data-block-preview]').forEach((block) => block.classList.remove('drag-over'));
            });

            item.addEventListener('dragover', (event) => {
                event.preventDefault();
                item.classList.add('drag-over');
            });

            item.addEventListener('dragleave', () => {
                item.classList.remove('drag-over');
            });

            item.addEventListener('drop', async (event) => {
                event.preventDefault();
                item.classList.remove('drag-over');

                if (!previewList || !draggedBlockId || draggedBlockId === item.getAttribute('data-block-id')) {
                    return;
                }

                const draggedElement = previewList.querySelector(`[data-block-id="${draggedBlockId}"]`);
                if (!draggedElement) {
                    return;
                }

                const rect = item.getBoundingClientRect();
                const shouldInsertAfter = event.clientY > rect.top + rect.height / 2;
                previewList.insertBefore(draggedElement, shouldInsertAfter ? item.nextSibling : item);

                try {
                    await persistPreviewOrder();
                } catch (error) {
                    alert(error.message || 'Gagal menyimpan urutan blok. Halaman akan dimuat ulang.');
                    window.location.reload();
                }
            });
        });

        blockDeleteForm?.addEventListener('submit', (event) => {
            if (!window.confirm('Hapus blok ini?')) {
                event.preventDefault();
            }
        });

        syncCreateBlockFields();
        feather.replace();
    </script>
</body>
</html>
