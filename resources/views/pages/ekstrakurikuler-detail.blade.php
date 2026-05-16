@extends('layouts.app')

@section('title', $ekstrakurikuler['name'] . ' - Ekstrakurikuler SMKN 1 Wringin')
@section('meta_description', 'Informasi kegiatan ' . $ekstrakurikuler['name'] . ' di SMKN 1 Wringin, lengkap dengan deskripsi singkat dan galeri kegiatan.')

@section('content')
    @include('partials.navbar')

    {{-- DESKRIPSI & INFO KEGIATAN --}}
    <section id="deskripsi" class="relative min-h-screen pt-32 pb-16 flex items-center overflow-hidden">
        {{-- Background Image with Overlay --}}
        <div class="absolute inset-0 z-0">
            <picture>
                @if(! empty($ekstrakurikuler['hero_image_webp']))
                    <source srcset="{{ $ekstrakurikuler['hero_image_webp'] }}" type="image/webp">
                @endif
                <img src="{{ $ekstrakurikuler['hero_image'] }}" alt="{{ $ekstrakurikuler['hero_image_alt'] }}" class="w-full h-full object-cover">
            </picture>
            <div class="absolute inset-0 bg-gradient-to-r from-slate-900/95 via-slate-900/80 to-brand-900/40"></div>
        </div>

        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center">
            
            {{-- Category Badge --}}
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 border border-white/20 text-white text-xs font-bold uppercase tracking-wide mb-6 mx-auto" data-animate="fade-up">
                <i class="fa-solid {{ $ekstrakurikuler['hero_icon'] }} text-secondary"></i>
                {{ $ekstrakurikuler['category'] }}
            </div>

            {{-- Title --}}
            <h1 class="text-4xl md:text-5xl lg:text-7xl font-bold text-white leading-tight mb-8" data-animate="fade-up" data-delay="100">
                {{ $ekstrakurikuler['name'] }}
            </h1>
            
            {{-- Deskripsi --}}
            <div class="prose prose-invert prose-slate max-w-none text-slate-200 leading-relaxed space-y-6 text-lg font-light mb-12" data-animate="fade-up" data-delay="200">
                @foreach ($ekstrakurikuler['description'] as $paragraph)
                    <p>{{ $paragraph }}</p>
                @endforeach
            </div>

            {{-- Sidebar / Quick Facts (Now as a Centered Card) --}}
            <div class="bg-white/10 backdrop-blur-xl border border-white/20 rounded-3xl p-8 shadow-2xl h-fit max-w-2xl mx-auto" data-animate="fade-up" data-delay="300">
                <h3 class="text-xl font-bold text-white mb-8 border-b border-white/10 pb-4">Informasi Kegiatan</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-8">
                    <div class="flex flex-col items-center gap-3 group">
                        <div class="w-12 h-12 bg-secondary rounded-2xl flex items-center justify-center text-slate-900 flex-shrink-0 group-hover:scale-110 transition duration-300 shadow-lg shadow-secondary/20">
                            <i class="fa-solid fa-calendar-days text-xl"></i>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-slate-400 uppercase font-bold tracking-widest mb-1">Hari Latihan</p>
                            <p class="font-bold text-white text-lg">{{ $ekstrakurikuler['days'] }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-center gap-3 group">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white flex-shrink-0 group-hover:bg-brand-500 transition duration-300 border border-white/10">
                            <i class="fa-solid fa-clock text-xl"></i>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-slate-400 uppercase font-bold tracking-widest mb-1">Jam Latihan</p>
                            <p class="font-bold text-white text-lg">{{ $ekstrakurikuler['time'] }}</p>
                        </div>
                    </div>
                    <div class="flex flex-col items-center gap-3 group">
                        <div class="w-12 h-12 bg-white/10 rounded-2xl flex items-center justify-center text-white flex-shrink-0 group-hover:bg-brand-500 transition duration-300 border border-white/10">
                            <i class="fa-solid fa-layer-group text-xl"></i>
                        </div>
                        <div class="text-center">
                            <p class="text-xs text-slate-400 uppercase font-bold tracking-widest mb-1">Kategori</p>
                            <p class="font-bold text-white text-lg">{{ $ekstrakurikuler['category'] }}</p>
                        </div>
                    </div>
                </div>

                <div class="mt-8 pt-8 border-t border-white/10">
                    <p class="text-slate-400 text-sm italic">"{{ $ekstrakurikuler['hero_description'] }}"</p>
                </div>
            </div>

        </div>
    </section>

    <section class="py-20 bg-slate-50 border-y border-slate-100">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4" data-animate="fade-up">
                <div class="max-w-2xl">
                    <h2 class="text-brand-600 font-semibold tracking-wide uppercase text-sm mb-3">Galeri Kegiatan</h2>
                    <h3 class="text-3xl md:text-4xl font-bold text-slate-900">Aktivitas {{ $ekstrakurikuler['name'] }}</h3>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 md:gap-6">
                @foreach(($ekstrakurikuler['gallery_images'] ?? []) as $index => $galleryImage)
                    <div data-animate="zoom-in" @if($index > 0) data-delay="{{ $index * 100 }}" @endif class="{{ $index === 0 ? 'col-span-2 md:col-span-2 row-span-2 h-64 md:h-full shadow-lg' : 'h-48 md:h-64 shadow-md' }} relative group overflow-hidden rounded-2xl bg-white">
                        <picture>
                            @if(! empty($galleryImage['webp_url']))
                                <source srcset="{{ $galleryImage['webp_url'] }}" type="image/webp">
                            @endif
                            <img src="{{ $galleryImage['jpeg_url'] }}" alt="{{ $galleryImage['alt'] }}" class="w-full h-full object-cover transform group-hover:scale-105 transition duration-500" loading="lazy" decoding="async">
                        </picture>
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/80 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition duration-300 flex items-end {{ $index === 0 ? 'p-6' : 'p-4' }}">
                            <span class="text-white {{ $index === 0 ? 'font-semibold text-lg' : 'font-medium text-sm' }}">{{ $galleryImage['caption'] }}</span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.footer')
@endsection
