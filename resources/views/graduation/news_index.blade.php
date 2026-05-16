<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Berita</title>

    <link rel="icon" type="image/png" href="{{ asset('images/alternative/icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/feather-icons"></script>

    <style>
        .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
        .custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
        .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 9999px; }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
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

        <main class="flex h-screen min-h-0 w-full flex-1 flex-col overflow-hidden bg-slate-50">
            <header class="relative z-[80] flex min-h-20 items-center justify-between border-b border-slate-200 bg-white px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-3 sm:gap-4">
                    <button type="button" id="adminSidebarOpen" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-slate-200 bg-white text-slate-500 shadow-sm transition hover:border-brand-200 hover:text-brand-600 lg:hidden">
                        <i data-feather="menu" class="h-5 w-5"></i>
                    </button>
                    <div class="flex flex-wrap items-center gap-2 sm:gap-4">
                        <h1 class="text-lg font-extrabold tracking-tight text-slate-800 sm:text-xl">Admin Berita</h1>
                        <span class="rounded-full border border-brand-100 bg-brand-50 px-3 py-1 text-[11px] font-bold text-brand-600 sm:text-xs">Editorial Desk</span>
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

            <div class="relative z-10 min-h-0 flex-1 overflow-y-auto custom-scrollbar p-4 sm:p-6 lg:p-8">
                <div class="mx-auto max-w-7xl space-y-8">
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
                            <h3 class="text-lg font-extrabold text-amber-900">Modul berita belum siap</h3>
                            <p class="mt-2 text-sm font-medium text-amber-800">Jalankan migrasi baru terlebih dahulu agar tabel berita tersedia.</p>
                        </div>
                    @else
                        <section class="grid gap-5 sm:grid-cols-2 xl:grid-cols-5">
                            @foreach ([
                                ['label' => 'Total Berita', 'value' => $stats['total'], 'icon' => 'book-open'],
                                ['label' => 'Published', 'value' => $stats['published'], 'icon' => 'check-circle'],
                                ['label' => 'Pending Review', 'value' => $stats['pending_review'], 'icon' => 'clock'],
                                ['label' => 'Draft', 'value' => $stats['draft'], 'icon' => 'edit-3'],
                                ['label' => 'Rejected', 'value' => $stats['rejected'], 'icon' => 'slash'],
                            ] as $stat)
                                <div class="rounded-3xl border border-slate-100 bg-white p-5 shadow-sm">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">{{ $stat['label'] }}</p>
                                            <p class="mt-3 text-3xl font-extrabold text-slate-900">{{ $stat['value'] }}</p>
                                        </div>
                                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-50 text-brand-600">
                                            <i data-feather="{{ $stat['icon'] }}" class="h-5 w-5"></i>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </section>

                        <section class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                            <div class="mb-6 flex flex-col gap-4 border-b border-slate-100 pb-4 lg:flex-row lg:items-center lg:justify-between">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-brand-600">Highlight Berita</p>
                                    <h2 class="mt-1 text-xl font-extrabold text-slate-900">Atur 4 berita yang tampil di bagian atas halaman publik</h2>
                                </div>
                                <a href="{{ route('berita') }}" target="_blank" class="inline-flex items-center justify-center gap-2 rounded-2xl border border-slate-200 px-4 py-3 text-sm font-bold text-slate-700 transition hover:border-brand-200 hover:text-brand-600">
                                    <i data-feather="external-link" class="h-4 w-4"></i>
                                    Buka Halaman Berita
                                </a>
                            </div>

                            @php
                                $assignedSlots = $featuredSlots->mapWithKeys(fn ($slot) => [$slot->slot_order => $slot->news_article_id]);
                            @endphp

                            <form action="{{ route('admin.berita.highlights.update') }}" method="POST" class="grid gap-5 xl:grid-cols-4">
                                @csrf
                                @method('PUT')
                                @for ($slot = 1; $slot <= 4; $slot++)
                                    <div class="rounded-2xl border border-slate-200 bg-slate-50 p-4">
                                        <label for="slot_{{ $slot }}" class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Slot {{ $slot }}</label>
                                        <select id="slot_{{ $slot }}" name="slots[]" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                            <option value="">Belum dipilih</option>
                                            @foreach ($featuredOptions as $option)
                                                <option value="{{ $option->id }}" @selected((int) ($assignedSlots[$slot] ?? 0) === $option->id)>{{ $option->title }} ({{ $option->category_name ?: 'Tanpa kategori' }})</option>
                                            @endforeach
                                        </select>
                                    </div>
                                @endfor
                                <div class="xl:col-span-4">
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-5 py-3 text-sm font-bold text-white shadow-sm shadow-brand-600/20 transition hover:bg-brand-700">
                                        <i data-feather="save" class="h-4 w-4"></i>
                                        Simpan Highlight
                                    </button>
                                </div>
                            </form>
                        </section>

                        <section class="rounded-3xl border border-slate-100 bg-white p-6 shadow-sm">
                            <div class="mb-6 flex flex-col gap-4 border-b border-slate-100 pb-4 lg:flex-row lg:items-center lg:justify-between">
                                <div>
                                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-brand-600">Daftar Berita</p>
                                    <h2 class="mt-1 text-xl font-extrabold text-slate-900">Kelola berita, status editorial, dan sumber kiriman</h2>
                                </div>
                                <a href="{{ route('admin.berita.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-brand-600 px-5 py-3 text-sm font-bold text-white shadow-sm shadow-brand-600/20 transition hover:bg-brand-700">
                                    <i data-feather="plus" class="h-4 w-4"></i>
                                    Tambah Berita
                                </a>
                            </div>

                            <form method="GET" action="{{ route('admin.berita.index') }}" class="mb-6 grid gap-4 rounded-2xl border border-slate-100 bg-slate-50 p-4 lg:grid-cols-5">
                                <div class="lg:col-span-2">
                                    <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Cari Judul</label>
                                    <input type="text" name="q" value="{{ $filters['q'] }}" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100" placeholder="Cari berita...">
                                </div>
                                <div>
                                    <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Status</label>
                                    <select name="status" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                        <option value="">Semua</option>
                                        @foreach (['draft' => 'Draft', 'pending_review' => 'Pending Review', 'published' => 'Published', 'rejected' => 'Rejected'] as $value => $label)
                                            <option value="{{ $value }}" @selected($filters['status'] === $value)>{{ $label }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Kategori</label>
                                    <select name="category" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                        <option value="">Semua</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category }}" @selected($filters['category'] === $category)>{{ $category }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="mb-2 block text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500">Sumber</label>
                                    <select name="source" class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-800 focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-100">
                                        <option value="">Semua</option>
                                        <option value="admin" @selected($filters['source'] === 'admin')>Admin</option>
                                        <option value="student" @selected($filters['source'] === 'student')>Siswa</option>
                                    </select>
                                </div>
                                <div class="lg:col-span-5 flex flex-wrap gap-3">
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-3 text-sm font-bold text-white transition hover:bg-slate-800">
                                        <i data-feather="search" class="h-4 w-4"></i>
                                        Terapkan Filter
                                    </button>
                                    <a href="{{ route('admin.berita.index') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-brand-200 hover:text-brand-600">
                                        Reset
                                    </a>
                                </div>
                            </form>

                            <div class="overflow-hidden rounded-3xl border border-slate-100">
                                <div class="hidden grid-cols-[minmax(0,2fr)_160px_120px_120px_140px] gap-4 bg-slate-50 px-5 py-4 text-[11px] font-bold uppercase tracking-[0.2em] text-slate-500 lg:grid">
                                    <span>Artikel</span>
                                    <span>Kategori</span>
                                    <span>Status</span>
                                    <span>Sumber</span>
                                    <span>Aksi</span>
                                </div>

                                @forelse ($articles as $article)
                                    @php
                                        $statusClasses = [
                                            'draft' => 'bg-slate-100 text-slate-700',
                                            'pending_review' => 'bg-amber-100 text-amber-800',
                                            'published' => 'bg-emerald-100 text-emerald-800',
                                            'rejected' => 'bg-rose-100 text-rose-800',
                                        ];
                                    @endphp
                                    <div class="grid gap-4 border-t border-slate-100 px-5 py-5 lg:grid-cols-[minmax(0,2fr)_160px_120px_120px_140px] lg:items-center">
                                        <div>
                                            <h3 class="text-base font-bold text-slate-900">{{ $article->title }}</h3>
                                            <div class="mt-2 flex flex-wrap items-center gap-2 text-xs text-slate-500">
                                                <span>Slug: {{ $article->slug }}</span>
                                                <span>•</span>
                                                <span>{{ $article->published_at?->translatedFormat('d M Y H:i') ?? 'Belum dipublish' }}</span>
                                            </div>
                                        </div>
                                        <div class="text-sm font-medium text-slate-600">{{ $article->category_name ?: 'Tanpa kategori' }}</div>
                                        <div><span class="inline-flex rounded-full px-3 py-1 text-xs font-bold uppercase {{ $statusClasses[$article->workflow_status] ?? 'bg-slate-100 text-slate-700' }}">{{ str_replace('_', ' ', $article->workflow_status) }}</span></div>
                                        <div class="text-sm font-semibold text-slate-600">{{ $article->source_type === 'student' ? 'Siswa' : 'Admin' }}</div>
                                        <div class="flex flex-wrap gap-2">
                                            <a href="{{ route('admin.berita.edit', $article) }}" class="inline-flex items-center gap-1 rounded-xl border border-slate-200 px-3 py-2 text-xs font-bold text-slate-700 transition hover:border-brand-200 hover:text-brand-600">
                                                <i data-feather="edit-2" class="h-3.5 w-3.5"></i>
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.berita.destroy', $article) }}" method="POST" onsubmit="return confirm('Hapus berita ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-1 rounded-xl border border-red-200 px-3 py-2 text-xs font-bold text-red-600 transition hover:bg-red-50">
                                                    <i data-feather="trash-2" class="h-3.5 w-3.5"></i>
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                @empty
                                    <div class="border-t border-slate-100 px-6 py-14 text-center">
                                        <p class="text-base font-bold text-slate-700">Belum ada berita.</p>
                                        <p class="mt-2 text-sm text-slate-500">Mulai dengan membuat berita pertama Anda.</p>
                                    </div>
                                @endforelse
                            </div>

                            @if (method_exists($articles, 'links'))
                                <div class="mt-6">{{ $articles->links() }}</div>
                            @endif
                        </section>
                    @endif
                </div>
            </div>
        </main>
    </div>

    <script>
        const adminSidebar = document.getElementById('adminSidebar');
        const adminSidebarBackdrop = document.getElementById('adminSidebarBackdrop');
        const adminSidebarOpenBtn = document.getElementById('adminSidebarOpen');
        const adminSidebarCloseBtn = document.getElementById('adminSidebarClose');
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

        adminSidebarOpenBtn?.addEventListener('click', openAdminSidebar);
        adminSidebarCloseBtn?.addEventListener('click', closeAdminSidebar);
        adminSidebarBackdrop?.addEventListener('click', closeAdminSidebar);
        adminProfileToggle?.addEventListener('click', (event) => {
            event.stopPropagation();
            adminProfileDropdown?.classList.toggle('hidden');
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

        feather.replace();
    </script>
</body>
</html>
