<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ ($portalMode ?? 'admin') === 'student' ? 'Portal Siswa - Builder Berita' : 'Admin - Builder Berita' }}</title>

    <link rel="icon" type="image/png" href="{{ asset('images/alternative/icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        .drag-ghost { opacity: 0.45; }
        .drag-over { border-color: #1E5460; background: #f0f9fa; }
        .component-active { border-color: #1E5460 !important; border-style: dashed !important; background-color: rgba(30, 84, 96, 0.04) !important; }
        .news-preview-content h2 {
            font-family: 'Poppins', sans-serif;
            font-size: 1.875rem;
            font-weight: 700;
            line-height: 1.3;
            color: #111827;
            margin-top: 2.5rem;
            margin-bottom: 1.25rem;
        }
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="h-screen overflow-hidden bg-slate-50 font-sans text-slate-800 antialiased">
    @php
        $isStudentPortal = ($portalMode ?? 'admin') === 'student';
        $defaultWebpImage = asset('images/webp/default_picture.webp');
        $defaultJpegImage = asset('images/alternative/default_picture.jpeg');
        $cover = $resolvedArticle['cover'] ?? null;
        $newsBlockTypeLabels = [
            'text' => 'Teks',
            'image' => 'Gambar + Keterangan',
            'image_showcase' => 'Gambar Utama + Thumbnail',
            'highlight_text' => 'Teks Sorotan',
        ];
        $indexRoute = $isStudentPortal ? route('siswa.berita.index') : route('admin.berita.index');
        $articleFormAction = $articleExists
            ? ($isStudentPortal ? route('siswa.berita.update', $article) : route('admin.berita.update', $article))
            : ($isStudentPortal ? route('siswa.berita.store') : route('admin.berita.store'));
        $articleDestroyRoute = $articleExists
            ? ($isStudentPortal ? route('siswa.berita.destroy', $article) : route('admin.berita.destroy', $article))
            : null;
        $blockStoreRoute = $articleExists
            ? ($isStudentPortal ? route('siswa.berita.blocks.store', $article) : route('admin.berita.blocks.store', $article))
            : null;
        $blockUpdateRouteTemplate = $articleExists
            ? ($isStudentPortal
                ? route('siswa.berita.blocks.update', ['article' => $article, 'block' => '__BLOCK__'])
                : route('admin.berita.blocks.update', ['article' => $article, 'block' => '__BLOCK__']))
            : null;
        $blockDeleteRouteTemplate = $articleExists
            ? ($isStudentPortal
                ? route('siswa.berita.blocks.destroy', ['article' => $article, 'block' => '__BLOCK__'])
                : route('admin.berita.blocks.destroy', ['article' => $article, 'block' => '__BLOCK__']))
            : null;
        $blockReorderRoute = $articleExists
            ? ($isStudentPortal ? route('siswa.berita.blocks.reorder', $article) : route('admin.berita.blocks.reorder', $article))
            : null;
        $editorHeading = $isStudentPortal
            ? ($articleExists ? 'Edit Berita Saya' : 'Kirim Berita Baru')
            : ($articleExists ? 'Edit Berita' : 'Tambah Berita');
    @endphp

    <div class="relative flex h-screen overflow-hidden">
        @unless ($isStudentPortal)
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
                <a href="{{ route('admin.ppdb-builder') }}" class="flex items-center gap-3 rounded-xl px-4 py-3 text-slate-500 transition-all hover:bg-brand-50 hover:text-brand-700">
                    <i data-feather="file-text" class="h-5 w-5"></i>
                    <span class="text-sm font-medium">PPDB</span>
                </a>
                <a href="{{ route('admin.berita.index') }}" class="flex items-center gap-3 rounded-xl border border-brand-100 bg-brand-50 px-4 py-3 text-brand-600 shadow-sm transition-all">
                    <i data-feather="book-open" class="h-5 w-5"></i>
                    <span class="text-sm font-bold">Berita</span>
                </a>
            </div>
            </aside>
        @endunless

        <main class="flex h-screen min-h-0 w-full flex-1 flex-col overflow-hidden bg-slate-50">
            <header class="relative z-[80] flex min-h-20 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3 sm:gap-4">
                    @unless ($isStudentPortal)
                        <button type="button" id="adminSidebarOpen" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-brand-200 hover:text-brand-600 lg:hidden">
                            <i data-feather="menu" class="h-5 w-5"></i>
                        </button>
                    @endunless
                    <div class="flex flex-wrap items-center gap-2 sm:gap-4">
                        <h1 class="text-lg font-extrabold tracking-tight text-slate-800 sm:text-xl">{{ $editorHeading }}</h1>
                        <span class="rounded-full border border-brand-100 bg-brand-50 px-3 py-1 text-[11px] font-bold text-brand-600 sm:text-xs">{{ $isStudentPortal ? 'Portal Siswa' : 'Builder Mode' }}</span>
                    </div>
                </div>

                <div class="flex items-center gap-3">
                    <a href="{{ $indexRoute }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-700 transition hover:border-brand-200 hover:text-brand-600">
                        <i data-feather="arrow-left" class="h-4 w-4"></i>
                        Kembali
                    </a>
                    @if ($articleExists && $article->workflow_status === 'published')
                        <a href="{{ route('berita.detail', ['slug' => $article->slug]) }}" target="_blank" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-4 py-3 text-sm font-bold text-white transition hover:bg-brand-700">
                            <i data-feather="external-link" class="h-4 w-4"></i>
                            Lihat Publik
                        </a>
                    @endif
                    @if ($isStudentPortal)
                        <form action="{{ route('siswa.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                                <i data-feather="log-out" class="h-4 w-4"></i>
                                Logout
                            </button>
                        </form>
                    @endif
                </div>
            </header>

            <div class="relative z-10 min-h-0 flex-1 overflow-y-auto custom-scrollbar p-4 sm:p-6 lg:p-8">
                <div class="mx-auto max-w-6xl space-y-8">
                    @if (session('success'))
                        <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700">{{ session('success') }}</div>
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
                            <h3 class="text-lg font-extrabold text-amber-900">Builder berita belum siap</h3>
                            <p class="mt-2 text-sm font-medium text-amber-800">Jalankan migrasi baru terlebih dahulu agar tabel berita tersedia.</p>
                        </div>
                    @else
                        <div x-data="{ activeTab: '{{ $articleExists ? 'builder' : 'metadata' }}' }" class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                            <div class="mb-6 flex flex-col gap-4 border-b border-slate-100 pb-4 lg:flex-row lg:items-center lg:justify-between">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-brand-600">Metadata & Builder</p>
                                    <h2 class="mt-1 text-xl font-extrabold text-slate-900">Atur identitas berita, workflow, dan susun kontennya</h2>
                                </div>
                                <div class="flex rounded-xl bg-slate-100 p-1">
                                    <button type="button" @click="activeTab = 'metadata'" :class="activeTab === 'metadata' ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="rounded-lg px-4 py-2 text-xs font-bold transition-all">Metadata</button>
                                    <button type="button" @click="activeTab = 'builder'" :class="activeTab === 'builder' ? 'bg-white text-brand-600 shadow-sm' : 'text-slate-500 hover:text-slate-700'" class="rounded-lg px-4 py-2 text-xs font-bold transition-all">Builder Konten</button>
                                </div>
                            </div>

                            <div x-show="activeTab === 'metadata'">
                                <form action="{{ $articleFormAction }}" method="POST" enctype="multipart/form-data" class="grid gap-5 lg:grid-cols-2">
                                    @csrf
                                    @if ($articleExists)
                                        @method('PUT')
                                    @endif

                                    <div class="lg:col-span-2">
                                        <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Judul Berita</label>
                                        <input type="text" name="title" value="{{ old('title', $article->title) }}" required class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-semibold text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Slug</label>
                                        <input type="text" name="slug" value="{{ old('slug', $article->slug) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" placeholder="otomatis-dari-judul">
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Kategori</label>
                                        <input type="text" name="category" maxlength="100" value="{{ old('category', $article->category_name) }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" placeholder="Contoh: Inovasi Siswa">
                                    </div>

                                    @if (! $isStudentPortal)
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Penulis</label>
                                            <input type="text" name="author_name" value="{{ old('author_name', $article->author_name) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                        </div>

                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Status Workflow</label>
                                            <select name="workflow_status" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                                @foreach (['draft' => 'Draft', 'pending_review' => 'Pending Review', 'published' => 'Published', 'rejected' => 'Rejected'] as $value => $label)
                                                    <option value="{{ $value }}" @selected(old('workflow_status', $article->workflow_status ?: 'draft') === $value)>{{ $label }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    @else
                                        <div>
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Status Review</label>
                                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm font-semibold text-slate-700">
                                                {{ str_replace('_', ' ', old('workflow_status', $article->workflow_status ?: 'pending_review')) }}
                                            </div>
                                        </div>
                                    @endif

                                    <div>
                                        <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Tanggal Publish</label>
                                        <input type="datetime-local" name="published_at" value="{{ old('published_at', $article->published_at?->format('Y-m-d\TH:i')) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                    </div>

                                    <div class="lg:col-span-2">
                                        <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Excerpt</label>
                                        <textarea name="excerpt" rows="4" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">{{ old('excerpt', $article->excerpt) }}</textarea>
                                    </div>

                                    <div class="lg:col-span-2">
                                        <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Hashtag</label>
                                        <textarea name="tags" rows="3" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" placeholder="#Teknologi&#10;#PrestasiSiswa">{{ old('tags', $tagsText) }}</textarea>
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Cover Berita</label>
                                        <input type="file" name="cover_file" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:font-bold file:text-brand-700 hover:file:bg-brand-100">
                                    </div>

                                    <div>
                                        <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Alt Text Cover</label>
                                        <input type="text" name="cover_alt_text" value="{{ old('cover_alt_text', $article->cover_alt_text) }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                    </div>

                                    <div class="lg:col-span-2 rounded-3xl border border-slate-200 bg-slate-50 p-5">
                                        <p class="text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Akun Pengirim</p>
                                        <div class="mt-4 grid gap-4 sm:grid-cols-3">
                                            <div>
                                                <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">Role</p>
                                                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $editorSubmitter['role'] ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">Nama</p>
                                                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $editorSubmitter['name'] ?? '-' }}</p>
                                            </div>
                                            <div>
                                                <p class="text-xs font-bold uppercase tracking-[0.16em] text-slate-400">Identifier</p>
                                                <p class="mt-2 text-sm font-semibold text-slate-800">{{ $editorSubmitter['identifier'] ?? '-' }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    @if (($resolvedArticle['is_student_submission'] ?? (($editorSubmitter['role'] ?? '') === 'Siswa')) && ! $isStudentPortal)
                                        <div class="lg:col-span-2">
                                            <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Catatan Penolakan</label>
                                            <textarea name="rejection_note" rows="3" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">{{ old('rejection_note', $article->rejection_note) }}</textarea>
                                        </div>
                                    @elseif (($resolvedArticle['is_student_submission'] ?? false) && $isStudentPortal && !empty($resolvedArticle['rejection_note']))
                                        <div class="lg:col-span-2 rounded-2xl border border-rose-200 bg-rose-50 px-4 py-4 text-sm text-rose-700">
                                            <p class="font-bold">Catatan Penolakan</p>
                                            <p class="mt-2 font-medium">{{ $resolvedArticle['rejection_note'] }}</p>
                                        </div>
                                    @endif

                                    @if (!empty($cover['jpeg_url']))
                                        <div class="lg:col-span-2 overflow-hidden rounded-3xl border border-slate-100 bg-slate-50">
                                            <picture>
                                                @if (!empty($cover['webp_url']))
                                                    <source srcset="{{ $cover['webp_url'] }}" type="image/webp">
                                                @endif
                                                <img src="{{ $cover['jpeg_url'] }}" alt="{{ $resolvedArticle['cover_alt_text'] ?? $article->title }}" class="h-64 w-full object-cover">
                                            </picture>
                                        </div>
                                    @endif

                                    <div class="lg:col-span-2 flex flex-wrap gap-3">
                                        <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-5 py-3 text-sm font-bold text-white shadow-sm shadow-brand-600/20 transition hover:bg-brand-700">
                                            <i data-feather="save" class="h-4 w-4"></i>
                                            {{ $articleExists ? 'Simpan Perubahan' : 'Simpan dan Lanjutkan ke Builder' }}
                                        </button>

                                        @if ($articleExists && $articleDestroyRoute)
                                            <form action="{{ $articleDestroyRoute }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-red-200 px-5 py-3 text-sm font-bold text-red-600 transition hover:bg-red-50">
                                                    <i data-feather="trash-2" class="h-4 w-4"></i>
                                                    Hapus Berita
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </form>
                            </div>

                            <div x-show="activeTab === 'builder'" x-cloak>
                                @if (! $articleExists)
                                    <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50 px-6 py-12 text-center">
                                        <p class="text-base font-bold text-slate-700">Simpan metadata dulu untuk mulai menyusun konten berita.</p>
                                        <p class="mt-1 text-sm text-slate-500">Setelah berita dibuat, builder akan aktif dan Anda bisa menambah komponen seperti pada PPDB Builder.</p>
                                    </div>
                                @else
                                    <form action="{{ $blockStoreRoute }}" method="POST" enctype="multipart/form-data" class="space-y-5 rounded-3xl border border-slate-100 bg-slate-50 p-5" id="createBlockForm">
                                        @csrf
                                        <div>
                                            <label for="block_type" class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Tipe Komponen</label>
                                            <select id="block_type" name="block_type" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                                @foreach ($newsBlockTypeLabels as $key => $label)
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
                                                <textarea name="body" rows="6" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" placeholder="Pisahkan paragraf dengan baris kosong. Gunakan awalan '- ' untuk list.">{{ old('body') }}</textarea>
                                            </div>
                                        </div>

                                        <div data-create-type="image" class="hidden space-y-4">
                                            <div>
                                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Upload Gambar</label>
                                                <input type="file" name="asset_file" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:font-bold file:text-brand-700 hover:file:bg-brand-100">
                                            </div>
                                            <div>
                                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Keterangan Gambar</label>
                                                <textarea name="caption" rows="4" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">{{ old('caption') }}</textarea>
                                            </div>
                                            <div>
                                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Alt Text</label>
                                                <input type="text" name="alt_text" value="{{ old('alt_text') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                            </div>
                                        </div>

                                        <div data-create-type="image_showcase" class="hidden space-y-4">
                                            <div>
                                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Upload Gambar Utama + Thumbnail</label>
                                                <input type="file" name="asset_files[]" multiple accept="image/jpeg,image/png,image/webp" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:font-bold file:text-brand-700 hover:file:bg-brand-100">
                                            </div>
                                            <div>
                                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Alt Text</label>
                                                <input type="text" name="alt_text" value="{{ old('alt_text') }}" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                            </div>
                                        </div>

                                        <div data-create-type="highlight_text" class="hidden space-y-4">
                                            <div>
                                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Teks Highlight</label>
                                                <textarea name="text" rows="4" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">{{ old('text') }}</textarea>
                                            </div>
                                        </div>

                                        <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-5 py-3 text-sm font-bold text-white shadow-sm shadow-brand-600/20 transition hover:bg-brand-700">
                                            <i data-feather="plus" class="h-4 w-4"></i>
                                            Tambah Komponen
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>

                        @if ($articleExists)
                            <div class="rounded-3xl border border-slate-200/80 bg-white shadow-xl overflow-hidden">
                                <div class="flex items-center justify-between border-b border-slate-200/60 bg-slate-100/80 px-4 py-3">
                                    <div class="flex items-center gap-1.5">
                                        <div class="h-3 w-3 rounded-full bg-red-400"></div>
                                        <div class="h-3 w-3 rounded-full bg-amber-400"></div>
                                        <div class="h-3 w-3 rounded-full bg-emerald-400"></div>
                                    </div>
                                    <div class="mx-2 flex items-center justify-center gap-2 rounded-lg bg-white/90 px-4 py-1 text-xs font-medium text-slate-500 sm:w-80">
                                        <i data-feather="globe" class="h-3 w-3 text-emerald-600"></i>
                                        <span class="truncate">smkn1wringin.sch.id/berita/{{ $article->slug ?: 'draft' }}</span>
                                    </div>
                                    <span class="hidden text-[10px] font-bold uppercase tracking-widest text-slate-400 sm:inline">Preview & Reorder</span>
                                </div>

                                <div class="bg-white">
                                    <header class="border-b border-slate-100 px-6 py-10 sm:px-10">
                                        <div class="mx-auto max-w-3xl">
                                            <div class="mb-4 flex flex-wrap items-center gap-3 text-xs font-bold uppercase tracking-[0.2em] text-brand-600">
                                                <span class="rounded-full bg-brand-50 px-3 py-1">{{ $resolvedArticle['category'] ?? 'Tanpa kategori' }}</span>
                                                <span class="text-slate-300">•</span>
                                                <span>{{ $resolvedArticle['published_label'] ?? 'Belum dipublish' }}</span>
                                            </div>
                                            <h2 class="font-heading text-3xl font-extrabold leading-tight text-slate-900 sm:text-4xl">{{ $resolvedArticle['title'] ?? $article->title }}</h2>
                                            @if (!empty($resolvedArticle['excerpt']))
                                                <p class="mt-5 max-w-2xl text-base leading-8 text-slate-500">{{ $resolvedArticle['excerpt'] }}</p>
                                            @endif
                                        </div>
                                    </header>

                                    <main class="px-6 py-10 sm:px-10">
                                        <div class="mx-auto max-w-3xl space-y-10">
                                            @if (!empty($cover['jpeg_url']))
                                                <figure class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-sm">
                                                    <picture>
                                                        @if (!empty($cover['webp_url']))
                                                            <source srcset="{{ $cover['webp_url'] }}" type="image/webp">
                                                        @endif
                                                        <img src="{{ $cover['jpeg_url'] }}" alt="{{ $resolvedArticle['cover_alt_text'] ?? $article->title }}" class="aspect-video w-full object-cover">
                                                    </picture>
                                                </figure>
                                            @endif

                                            <div id="newsPreviewList" class="news-preview-content space-y-6">
                                                @forelse ($blocks as $index => $block)
                                                    <article class="group relative cursor-pointer rounded-2xl border-2 border-transparent p-3 transition-all duration-200 hover:border-slate-200" data-block-preview data-block-id="{{ $block['id'] }}" draggable="true">
                                                        <div class="absolute right-2 top-2 z-20 flex items-center gap-1 rounded-xl border border-slate-200 bg-white/95 px-2 py-1 opacity-0 shadow-sm transition-opacity group-hover:opacity-100">
                                                            <span class="mr-2 text-[10px] font-bold tracking-wider text-brand-600">{{ $newsBlockTypeLabels[$block['type']] ?? $block['type'] }} #{{ $index + 1 }}</span>
                                                            <button type="button" class="rounded-lg p-1.5 text-slate-400 transition-colors hover:text-brand-600" data-drag-handle title="Geser komponen">
                                                                <i data-feather="move" class="h-3.5 w-3.5"></i>
                                                            </button>
                                                            <button type="button" class="rounded-lg p-1.5 text-slate-400 transition-colors hover:text-brand-600" title="Edit komponen">
                                                                <i data-feather="edit-2" class="h-3.5 w-3.5"></i>
                                                            </button>
                                                        </div>

                                                        <div class="pointer-events-none">
                                                            @include('pages.news_partials.block_renderer', ['block' => $block, 'isBuilderPreview' => true])
                                                        </div>
                                                    </article>
                                                @empty
                                                    <div class="rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-6 py-12 text-center">
                                                        <p class="text-base font-bold text-slate-700">Belum ada komponen berita.</p>
                                                        <p class="mt-1 text-xs font-medium text-slate-500">Tambahkan komponen pertama Anda melalui panel builder.</p>
                                                    </div>
                                                @endforelse
                                            </div>

                                            @if (!empty($resolvedArticle['tags']))
                                                <div class="flex flex-wrap gap-2 border-t border-slate-100 pt-8">
                                                    @foreach ($resolvedArticle['tags'] as $tag)
                                                        <span class="rounded-full bg-slate-100 px-4 py-2 text-sm font-medium text-slate-600">{{ $tag }}</span>
                                                    @endforeach
                                                </div>
                                            @endif
                                        </div>
                                    </main>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        </main>
    </div>

    @if ($articleExists)
        <div id="blockEditModal" class="fixed inset-0 z-[130] hidden items-center justify-center bg-slate-900/60 p-4 backdrop-blur-sm">
            <div class="max-h-[90vh] w-full max-w-3xl overflow-hidden rounded-3xl bg-white shadow-2xl">
                <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Edit Komponen</p>
                        <h3 id="modalBlockTitle" class="mt-1 text-lg font-extrabold text-slate-900">Komponen Berita</h3>
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
                            <div id="modalImagePreview" class="grid grid-cols-1 gap-3"></div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Ganti Gambar</label>
                                <input type="file" name="asset_file" accept="image/jpeg,image/png,image/webp" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:font-bold file:text-brand-700 hover:file:bg-brand-100">
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Keterangan Gambar</label>
                                <textarea name="caption" rows="4" data-modal-input="image.caption" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"></textarea>
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Alt Text</label>
                                <input type="text" name="alt_text" data-modal-input="image.alt_text" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                            </div>
                        </div>

                        <div id="modalImageShowcaseFields" class="hidden space-y-4">
                            <div id="modalImageShowcasePreview" class="grid grid-cols-2 gap-3"></div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Ganti Gambar Utama + Thumbnail</label>
                                <input type="file" name="asset_files[]" multiple accept="image/jpeg,image/png,image/webp" class="block w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-700 file:mr-4 file:rounded-xl file:border-0 file:bg-brand-50 file:px-4 file:py-2 file:font-bold file:text-brand-700 hover:file:bg-brand-100">
                            </div>
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Alt Text</label>
                                <input type="text" name="alt_text" data-modal-input="image_showcase.alt_text" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                            </div>
                        </div>

                        <div id="modalHighlightFields" class="hidden space-y-4">
                            <div>
                                <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Teks Highlight</label>
                                <textarea name="text" rows="6" data-modal-input="highlight_text.text" class="w-full rounded-2xl border border-slate-200 px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100"></textarea>
                            </div>
                        </div>

                        <div class="flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:items-center sm:justify-between">
                            <button type="submit" form="blockDeleteForm" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-red-200 px-4 py-3 text-sm font-bold text-red-600 transition hover:bg-red-50">
                                <i data-feather="trash-2" class="h-4 w-4"></i>
                                Hapus Komponen
                            </button>
                            <div class="flex flex-col gap-3 sm:flex-row">
                                <button type="button" id="cancelBlockModal" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-700 transition hover:border-brand-200 hover:text-brand-600">Batal</button>
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
        const blockTypeSelect = document.getElementById('block_type');
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

        adminSidebarOpenBtn?.addEventListener('click', openAdminSidebar);
        adminSidebarCloseBtn?.addEventListener('click', closeAdminSidebar);
        adminSidebarBackdrop?.addEventListener('click', closeAdminSidebar);
        adminProfileToggle?.addEventListener('click', (event) => {
            event.stopPropagation();
            adminProfileDropdown?.classList.toggle('hidden');
        });
        blockTypeSelect?.addEventListener('change', syncCreateBlockFields);

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

        syncCreateBlockFields();
        feather.replace();
    </script>

    @if ($articleExists)
        <script>
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const reorderUrl = @json($blockReorderRoute);
            const updateRouteTemplate = @json($blockUpdateRouteTemplate);
            const deleteRouteTemplate = @json($blockDeleteRouteTemplate);
            const blocks = @json($blocks);
            const blockTypeLabels = @json($newsBlockTypeLabels);
            const previewList = document.getElementById('newsPreviewList');
            const blockEditModal = document.getElementById('blockEditModal');
            const blockEditForm = document.getElementById('blockEditForm');
            const blockDeleteForm = document.getElementById('blockDeleteForm');
            const modalBlockTitle = document.getElementById('modalBlockTitle');
            const closeBlockModalBtn = document.getElementById('closeBlockModal');
            const cancelBlockModalBtn = document.getElementById('cancelBlockModal');
            const modalTextFields = document.getElementById('modalTextFields');
            const modalImageFields = document.getElementById('modalImageFields');
            const modalImageShowcaseFields = document.getElementById('modalImageShowcaseFields');
            const modalHighlightFields = document.getElementById('modalHighlightFields');
            const modalImagePreview = document.getElementById('modalImagePreview');
            const modalImageShowcasePreview = document.getElementById('modalImageShowcasePreview');
            let draggedBlockId = null;
            let isDragging = false;

            function routeForBlock(template, blockId) {
                return template.replace('__BLOCK__', String(blockId));
            }

            function syncModalFields(type) {
                const map = {
                    text: modalTextFields,
                    image: modalImageFields,
                    image_showcase: modalImageShowcaseFields,
                    highlight_text: modalHighlightFields,
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

            function setModalValue(key, value) {
                const field = blockEditForm?.querySelector(`[data-modal-input="${key}"]`);
                if (!field) return;
                field.value = value ?? '';
            }

            function openBlockModal(blockId) {
                const block = blocks.find((item) => Number(item.id) === Number(blockId));
                if (!block || !blockEditModal) return;

                blockEditForm.action = routeForBlock(updateRouteTemplate, block.id);
                blockDeleteForm.action = routeForBlock(deleteRouteTemplate, block.id);
                modalBlockTitle.textContent = `Edit ${blockTypeLabels[block.type] || block.type || 'Komponen Berita'}`;

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
                        ? `<div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50"><img src="${block.asset.jpeg_url}" alt="${block.alt_text || 'Gambar berita'}" class="aspect-video w-full object-cover"></div>`
                        : '<div class="rounded-2xl border border-dashed border-slate-200 px-4 py-8 text-center text-sm text-slate-400">Belum ada gambar.</div>';
                }

                if (block.type === 'image_showcase') {
                    setModalValue('image_showcase.alt_text', block.alt_text || block.items?.[0]?.alt_text || '');
                    modalImageShowcasePreview.innerHTML = (block.items || []).length
                        ? block.items.map((item) => `<div class="overflow-hidden rounded-2xl border border-slate-200 bg-slate-50"><img src="${item.asset?.jpeg_url || ''}" alt="${item.alt_text || 'Thumbnail berita'}" class="h-32 w-full object-cover"></div>`).join('')
                        : '<div class="col-span-2 p-6 text-center text-sm font-medium text-slate-400">Belum ada gambar.</div>';
                }

                if (block.type === 'highlight_text') {
                    setModalValue('highlight_text.text', block.text || '');
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
                    throw new Error('Gagal menyimpan urutan komponen berita.');
                }
            }

            closeBlockModalBtn?.addEventListener('click', closeBlockModal);
            cancelBlockModalBtn?.addEventListener('click', closeBlockModal);

            document.addEventListener('click', (event) => {
                const previewCard = event.target.closest('[data-block-preview]');
                if (previewCard && !event.target.closest('[data-drag-handle]') && !isDragging) {
                    document.querySelectorAll('[data-block-preview]').forEach((item) => item.classList.remove('component-active'));
                    previewCard.classList.add('component-active');
                    openBlockModal(previewCard.getAttribute('data-block-id'));
                }

                if (event.target === blockEditModal) {
                    closeBlockModal();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
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
                        alert(error.message || 'Gagal menyimpan urutan komponen. Halaman akan dimuat ulang.');
                        window.location.reload();
                    }
                });
            });

            blockDeleteForm?.addEventListener('submit', (event) => {
                if (!window.confirm('Hapus komponen ini?')) {
                    event.preventDefault();
                }
            });
        </script>
    @endif
</body>
</html>
