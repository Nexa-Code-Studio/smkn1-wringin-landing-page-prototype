{{-- BERITA SECTION --}}
<section id="berita" class="py-20 bg-white border-t border-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
            $defaultWebpImage = asset('images/webp/default_picture.webp');
            $defaultJpegImage = asset('images/alternative/default_picture.jpeg');
            $badgeClasses = [
                'bg-yellow-500',
                'bg-brand-600',
                'bg-purple-500',
            ];
        @endphp

        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-12 gap-4">
            <div class="max-w-2xl">
                <h2 data-animate="fade-up" class="text-brand-600 font-semibold tracking-wide uppercase text-sm mb-3">Kabar Sekolah</h2>
                <h3 data-animate="fade-up" data-delay="100" class="text-3xl md:text-4xl font-bold text-slate-900">Berita & Agenda Terbaru</h3>
            </div>
            <a data-animate="fade-in" data-delay="200" href="{{ route('berita') }}" class="hidden md:inline-flex items-center gap-2 text-brand-600 font-semibold hover:text-brand-800 transition">
                Lihat Semua Berita <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            @forelse (($highlightedArticles ?? []) as $index => $article)
                <a href="{{ route('berita.detail', ['slug' => $article['slug']]) }}" data-animate="fade-up" data-delay="{{ ($index + 1) * 100 }}" class="flex flex-col bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 border border-slate-100 h-full">
                    <div class="relative h-56 overflow-hidden">
                        <img src="{{ $article['cover']['webp_url'] ?? $article['cover']['jpeg_url'] ?? $defaultWebpImage }}" alt="{{ $article['cover_alt_text'] }}" class="w-full h-full object-cover transform hover:scale-110 transition duration-700" onerror="this.onerror=null;this.src='{{ $article['cover']['jpeg_url'] ?? $defaultJpegImage }}';">
                        <span class="absolute top-4 left-4 {{ $badgeClasses[$index % count($badgeClasses)] }} text-white text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">{{ $article['category'] }}</span>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <div class="flex items-center gap-3 text-xs text-slate-400 mb-3">
                            <span><i class="fa-regular fa-calendar mr-1"></i> {{ $article['published_label'] }}</span>
                            <span>|</span>
                            <span><i class="fa-regular fa-user mr-1"></i> {{ $article['submitter']['name'] ?? 'Admin' }}</span>
                        </div>
                        <h4 class="text-xl font-bold text-slate-900 mb-3 leading-snug hover:text-brand-600 transition cursor-pointer">
                            {{ $article['title'] }}
                        </h4>
                        <p class="text-slate-600 text-sm mb-4 line-clamp-3 flex-1">
                            {{ $article['excerpt'] ?: 'Baca berita selengkapnya untuk melihat informasi lengkap dari kabar sekolah ini.' }}
                        </p>
                        <span class="inline-flex items-center text-brand-600 font-semibold text-sm hover:underline mt-auto">
                            Baca Selengkapnya <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                        </span>
                    </div>
                </a>
            @empty
                <div class="md:col-span-3 rounded-2xl border border-dashed border-slate-200 bg-slate-50 px-8 py-14 text-center text-slate-500">
                    Highlight berita akan tampil di sini setelah admin memilih berita published pada modul berita.
                </div>
            @endforelse
        </div>

        <div data-animate="fade-up" data-delay="400" class="mt-8 text-center md:hidden">
            <a href="{{ route('berita') }}" class="inline-block px-6 py-3 rounded-full border border-slate-200 text-slate-600 font-semibold hover:border-brand-600 hover:text-brand-600 transition">
                Lihat Semua Berita
            </a>
        </div>
    </div>
</section>
