<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Berita Saya - Portal Siswa</title>
    <link rel="icon" type="image/png" href="{{ asset('images/alternative/icon.png') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 font-sans text-slate-800 antialiased">
    <div class="mx-auto flex min-h-screen w-full max-w-6xl flex-col px-4 py-6 sm:px-6 lg:px-8">
        <header class="mb-8 flex flex-col gap-4 rounded-3xl border border-slate-200 bg-white px-6 py-5 shadow-sm sm:flex-row sm:items-center sm:justify-between">
            <div>
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-brand-600">Portal Berita Siswa</p>
                <h1 class="mt-2 text-2xl font-extrabold text-slate-900">Berita Saya</h1>
                <p class="mt-2 text-sm text-slate-500">{{ $siswa->nama }} · NISN {{ $siswa->nisn }}</p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('siswa.berita.create') }}" class="inline-flex items-center gap-2 rounded-2xl bg-brand-600 px-5 py-3 text-sm font-bold text-white transition hover:bg-brand-700">Kirim Berita Baru</a>
                <form action="{{ route('siswa.logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 px-5 py-3 text-sm font-bold text-slate-700 transition hover:border-brand-200 hover:text-brand-600">Logout</button>
                </form>
            </div>
        </header>

        @if (session('success'))
            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-bold text-emerald-700">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">{{ $errors->first() }}</div>
        @endif

        <main class="flex-1">
            <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
                @forelse ($articles as $article)
                    @php
                        $status = $article['workflow_status'] ?? 'draft';
                        $statusClasses = [
                            'draft' => 'bg-slate-100 text-slate-700',
                            'pending_review' => 'bg-amber-100 text-amber-800',
                            'published' => 'bg-emerald-100 text-emerald-800',
                            'rejected' => 'bg-rose-100 text-rose-800',
                        ];
                    @endphp
                    <article class="overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-sm">
                        @if (!empty($article['cover']['jpeg_url']))
                            <img src="{{ $article['cover']['jpeg_url'] }}" alt="{{ $article['cover_alt_text'] ?? $article['title'] }}" class="aspect-video w-full object-cover">
                        @endif
                        <div class="p-5">
                            <div class="flex items-center justify-between gap-3">
                                <span class="inline-flex rounded-full px-3 py-1 text-[11px] font-bold uppercase {{ $statusClasses[$status] ?? 'bg-slate-100 text-slate-700' }}">{{ str_replace('_', ' ', $status) }}</span>
                                <span class="text-xs font-medium text-slate-400">{{ $article['published_label'] ?? 'Belum dipublish' }}</span>
                            </div>
                            <h2 class="mt-4 text-lg font-extrabold leading-tight text-slate-900">{{ $article['title'] }}</h2>
                            @if (!empty($article['excerpt']))
                                <p class="mt-3 text-sm leading-6 text-slate-500">{{ $article['excerpt'] }}</p>
                            @endif
                            @if ($status === 'rejected')
                                <p class="mt-4 rounded-2xl border border-rose-200 bg-rose-50 px-3 py-3 text-xs font-medium text-rose-700">Berita ini pernah ditolak. Buka editor untuk melihat catatan penolakan dan kirim ulang.</p>
                            @endif
                            <div class="mt-5 flex flex-wrap gap-3">
                                @if ($status !== 'published')
                                    <a href="{{ route('siswa.berita.edit', $article['id']) }}" class="inline-flex items-center rounded-2xl border border-slate-200 px-4 py-2.5 text-sm font-bold text-slate-700 transition hover:border-brand-200 hover:text-brand-600">Edit</a>
                                @endif
                                @if ($status === 'published')
                                    <a href="{{ route('berita.detail', $article['slug']) }}" target="_blank" class="inline-flex items-center rounded-2xl bg-brand-600 px-4 py-2.5 text-sm font-bold text-white transition hover:bg-brand-700">Lihat Publik</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="md:col-span-2 xl:col-span-3 rounded-3xl border border-dashed border-slate-200 bg-white px-6 py-16 text-center">
                        <p class="text-lg font-bold text-slate-700">Belum ada berita yang Anda kirim.</p>
                        <p class="mt-2 text-sm text-slate-500">Mulai kirim berita pertama Anda untuk masuk antrean review admin.</p>
                    </div>
                @endforelse
            </div>

            @if (method_exists($articles, 'links'))
                <div class="mt-8">{{ $articles->links() }}</div>
            @endif
        </main>
    </div>
</body>
</html>
