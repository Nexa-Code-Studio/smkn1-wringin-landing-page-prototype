{{-- EKSTRAKURIKULER HIGHLIGHT SECTION --}}
<section id="ekstrakurikuler" class="py-24 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

        {{-- Section Header --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-end mb-14 gap-6">
            <div class="max-w-2xl">
                <span data-animate="fade-up" class="text-brand-600 font-bold uppercase tracking-wider text-sm">Kegiatan Siswa</span>
                <h2 data-animate="fade-up" data-delay="100" class="text-3xl md:text-4xl lg:text-5xl font-bold text-slate-900 mt-2 leading-tight">
                    Lebih dari Kelas,<br class="hidden sm:block"> Temukan <span class="text-brand-600">Bakatmu</span>
                </h2>
                <p data-animate="fade-up" data-delay="200" class="text-slate-500 text-lg mt-4 max-w-lg">
                    Asah kepemimpinan, kreativitas, dan kerja sama tim melalui beragam ekstrakurikuler unggulan.
                </p>
            </div>
            <a data-animate="fade-in" data-delay="300" href="{{ route('ekstrakurikuler') }}" class="hidden md:inline-flex items-center gap-2 px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-full shadow-lg shadow-brand-600/20 transition transform hover:-translate-y-0.5">
                Lihat Semua <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        {{-- === BENTO GRID === --}}
        <div class="grid grid-cols-2 md:grid-cols-4 auto-rows-[180px] md:auto-rows-[200px] gap-3 md:gap-4" data-animate="fade-up" data-delay="200">

            {{-- 1. FEATURED CARD — Pramuka (spans 2 cols, 2 rows) --}}
            <div class="ekskul-bento-card group relative col-span-2 row-span-2 rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-2xl transition-all duration-500">
                <img src="https://images.unsplash.com/photo-1533604101087-43f1146244be?ixlib=rb-4.0.3&auto=format&fit=crop&w=900&q=80" alt="Pramuka SMKN 1 Wringin" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                {{-- Floating Tag --}}
                <div class="absolute top-4 left-4 z-20">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest border border-white/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span> Populer
                    </span>
                </div>
                <div class="relative h-full flex flex-col justify-end p-6 md:p-8 z-10 transition-transform duration-300 group-hover:-translate-y-1">
                    <span class="text-[10px] font-bold tracking-widest text-teal-300 uppercase mb-1">Organisasi</span>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-2 leading-tight">Pramuka</h3>
                    <p class="text-sm text-slate-300 line-clamp-2 max-w-sm">Bertahan hidup & tumbuh tangguh — pelajaran yang tak diajarkan di kelas.</p>
                    <div class="flex items-center gap-3 text-xs font-medium text-slate-300 border-t border-white/15 pt-4 mt-4">
                        <div class="flex items-center gap-1.5"><i class="fa-solid fa-calendar-days text-teal-400"></i> <span>Jumat, Sabtu</span></div>
                        <span class="text-white/20">|</span>
                        <div class="flex items-center gap-1.5"><i class="fa-solid fa-clock text-teal-400"></i> <span>15.30 WIB</span></div>
                    </div>
                </div>
            </div>

            {{-- 2. E-Sports --}}
            <div class="ekskul-bento-card group relative rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-2xl transition-all duration-500">
                <img src="https://images.unsplash.com/photo-1542751371-adc38448a05e?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="E-Sports SMKN 1 Wringin" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                <div class="relative h-full flex flex-col justify-end p-4 md:p-5 z-10 transition-transform duration-300 group-hover:-translate-y-1">
                    <span class="text-[9px] font-bold tracking-widest text-purple-300 uppercase mb-0.5">E-Sports</span>
                    <h3 class="text-lg md:text-xl font-bold text-white leading-tight">E-Sports Club</h3>
                    <p class="text-xs text-slate-400 line-clamp-1 mt-1">Adu strategi digital di arena profesional</p>
                </div>
            </div>

            {{-- 3. Basket --}}
            <div class="ekskul-bento-card group relative rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-2xl transition-all duration-500">
                <img src="https://images.unsplash.com/photo-1519861531473-920026073fdc?ixlib=rb-4.0.3&auto=format&fit=crop&w=600&q=80" alt="Bola Basket SMKN 1 Wringin" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                <div class="relative h-full flex flex-col justify-end p-4 md:p-5 z-10 transition-transform duration-300 group-hover:-translate-y-1">
                    <span class="text-[9px] font-bold tracking-widest text-orange-300 uppercase mb-0.5">Olahraga</span>
                    <h3 class="text-lg md:text-xl font-bold text-white leading-tight">Bola Basket</h3>
                    <p class="text-xs text-slate-400 line-clamp-1 mt-1">Cetak angka, tumbuhkan mental juara</p>
                </div>
            </div>

            {{-- 4. Stats / CTA Card — below E-Sports & Basket --}}
            <div class="ekskul-bento-card group relative col-span-2 rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-2xl transition-all duration-500 bg-gradient-to-br from-brand-600 via-brand-700 to-brand-900">
                {{-- Decorative pattern --}}
                <div class="absolute inset-0 opacity-[0.07]">
                    <svg class="w-full h-full" xmlns="http://www.w3.org/2000/svg"><defs><pattern id="grid-ekskul" width="24" height="24" patternUnits="userSpaceOnUse"><path d="M 24 0 L 0 0 0 24" fill="none" stroke="white" stroke-width="0.5"/></pattern></defs><rect width="100%" height="100%" fill="url(#grid-ekskul)"/></svg>
                </div>
                <a href="{{ route('ekstrakurikuler') }}" class="relative h-full flex flex-col md:flex-row items-center justify-between p-6 md:p-8 z-10 gap-4">
                    <div>
                        <div class="flex items-center gap-6 mb-3">
                            <div class="text-center">
                                <span class="block text-3xl md:text-4xl font-bold text-white">10+</span>
                                <span class="text-[10px] text-brand-200 uppercase tracking-wider font-semibold">Ekskul</span>
                            </div>
                            <div class="w-px h-10 bg-white/20"></div>
                            <div class="text-center">
                                <span class="block text-3xl md:text-4xl font-bold text-secondary-400">500+</span>
                                <span class="text-[10px] text-brand-200 uppercase tracking-wider font-semibold">Siswa Aktif</span>
                            </div>
                            <div class="w-px h-10 bg-white/20 hidden sm:block"></div>
                            <div class="text-center hidden sm:block">
                                <span class="block text-3xl md:text-4xl font-bold text-white">25+</span>
                                <span class="text-[10px] text-brand-200 uppercase tracking-wider font-semibold">Prestasi</span>
                            </div>
                        </div>
                        <p class="text-brand-100 text-sm max-w-sm">Bergabunglah dan temukan wadah untuk mengasah potensi terbaikmu.</p>
                    </div>
                    <div class="flex-shrink-0">
                        <span class="inline-flex items-center gap-2 px-6 py-3 bg-white text-brand-600 font-bold rounded-full shadow-xl group-hover:shadow-2xl transition transform group-hover:-translate-y-0.5 text-sm">
                            Eksplorasi Semua <i class="fa-solid fa-arrow-right transition-transform group-hover:translate-x-1"></i>
                        </span>
                    </div>
                </a>
            </div>

        </div>

        {{-- Mobile CTA --}}
        <div data-animate="fade-up" data-delay="400" class="mt-8 text-center md:hidden">
            <a href="{{ route('ekstrakurikuler') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-bold rounded-full shadow-lg transition">
                Lihat Semua Ekstrakurikuler <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>
    </div>
</section>
