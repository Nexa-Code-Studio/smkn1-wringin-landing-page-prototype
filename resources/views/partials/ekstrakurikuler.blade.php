{{-- EKSTRAKURIKULER HIGHLIGHT SECTION --}}
@php
    $defaultWebpImage = asset('images/webp/default_picture.webp');
    $defaultJpegImage = asset('images/alternative/default_picture.jpeg');

    $featuredCatalog = [
        'Pramuka' => ['name' => 'Pramuka', 'category' => 'Organisasi', 'desc' => 'Bertahan hidup & tumbuh tangguh - pelajaran yang tak diajarkan di kelas.', 'days' => 'Jumat, Sabtu', 'time' => '15.30 WIB', 'color' => 'teal', 'image' => $defaultWebpImage],
        'Palang Merah Remaja' => ['name' => 'Palang Merah Remaja', 'category' => 'Sosial & Medis', 'desc' => 'Garda terdepan penyelamat nyawa dan kepedulian sosial siswa.', 'days' => 'Rabu, Jumat', 'time' => '16.00 WIB', 'color' => 'rose', 'image' => $defaultWebpImage],
        'Seni Hadrah' => ['name' => 'Seni Hadrah', 'category' => 'Seni & Budaya', 'desc' => 'Harmoni nada sakral dan lantunan selawat penuh kekompakan.', 'days' => 'Selasa, Kamis', 'time' => '15.30 WIB', 'color' => 'amber', 'image' => $defaultWebpImage],
        'Sepak Bola & Futsal' => ['name' => 'Sepak Bola & Futsal', 'category' => 'Olahraga', 'desc' => 'Asah taktik, stamina, dan kerja sama tim menuju kemenangan.', 'days' => 'Senin, Rabu', 'time' => '15.30 WIB', 'color' => 'blue', 'image' => $defaultWebpImage],
        'Bola Basket' => ['name' => 'Bola Basket', 'category' => 'Olahraga', 'desc' => 'Cetak angka, tumbuhkan mental juara, dan soliditas tim.', 'days' => 'Selasa, Kamis', 'time' => '16.00 WIB', 'color' => 'orange', 'image' => $defaultWebpImage],
        'Bola Voli' => ['name' => 'Bola Voli', 'category' => 'Olahraga', 'desc' => 'Kuatkan refleks, strategi, dan komunikasi di lapangan.', 'days' => 'Senin, Rabu', 'time' => '16.00 WIB', 'color' => 'cyan', 'image' => $defaultWebpImage],
        'E-Sports Club' => ['name' => 'E-Sports Club', 'category' => 'E-Sports', 'desc' => 'Adu strategi digital di arena profesional.', 'days' => 'Jumat', 'time' => '14.00 WIB', 'color' => 'purple', 'image' => $defaultWebpImage],
        'Seni Tari & Vokal' => ['name' => 'Seni Tari & Vokal', 'category' => 'Seni & Budaya', 'desc' => 'Ekspresikan jiwa lewat gerak, suara, dan panggung.', 'days' => 'Rabu, Sabtu', 'time' => '15.00 WIB', 'color' => 'pink', 'image' => $defaultWebpImage],
        'VM Media' => ['name' => 'VM Media', 'category' => 'Teknologi', 'desc' => 'Rekam momen dan ciptakan karya visual yang berdampak.', 'days' => 'Kamis', 'time' => '15.30 WIB', 'color' => 'emerald', 'image' => $defaultWebpImage],
        'Sains Club' => ['name' => 'Sains Club', 'category' => 'Akademik', 'desc' => 'Menembus batas logika dan eksplorasi inovasi sains.', 'days' => 'Selasa', 'time' => '15.30 WIB', 'color' => 'indigo', 'image' => $defaultWebpImage],
    ];

    $defaultFeatured = ['Pramuka', 'E-Sports Club', 'Bola Basket'];
    $selectedNames = array_values(array_unique(array_filter($homeContent['featured_ekskul'] ?? [])));

    foreach ($defaultFeatured as $defaultName) {
        if (count($selectedNames) >= 3) {
            break;
        }

        if (! in_array($defaultName, $selectedNames, true)) {
            $selectedNames[] = $defaultName;
        }
    }

    $selectedNames = array_slice($selectedNames, 0, 3);

    $featuredCards = array_map(function (string $name) use ($featuredCatalog) {
        return $featuredCatalog[$name] ?? [
            'name' => $name,
            'category' => 'Ekstrakurikuler',
            'desc' => 'Wadah pengembangan potensi dan kerja sama tim siswa.',
            'days' => 'Jadwal Menyusul',
            'time' => 'TBA',
            'color' => 'teal',
            'image' => $defaultWebpImage,
        ];
    }, $selectedNames);

    $firstCard = $featuredCards[0] ?? $featuredCatalog['Pramuka'];
    $secondCard = $featuredCards[1] ?? $featuredCatalog['E-Sports Club'];
    $thirdCard = $featuredCards[2] ?? $featuredCatalog['Bola Basket'];

    $totalEkskulDisplay = ($homeContent['total_ekskul'] ?? 10).'+';
    $siswaAktifDisplay = ($homeContent['siswa_aktif'] ?? 1200).'+';
    $totalPrestasiDisplay = ($homeContent['total_prestasi'] ?? 85).'+';
@endphp
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
                <img src="{{ $firstCard['image'] }}" alt="{{ $firstCard['name'] }} SMKN 1 Wringin" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" onerror="this.onerror=null;this.src='{{ $defaultJpegImage }}';">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/40 to-transparent"></div>
                {{-- Floating Tag --}}
                <div class="absolute top-4 left-4 z-20">
                    <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/15 backdrop-blur-md text-white text-[10px] font-bold uppercase tracking-widest border border-white/20">
                        <span class="w-1.5 h-1.5 rounded-full bg-teal-400 animate-pulse"></span> Populer
                    </span>
                </div>
                <div class="relative h-full flex flex-col justify-end p-6 md:p-8 z-10 transition-transform duration-300 group-hover:-translate-y-1">
                    <span class="text-[10px] font-bold tracking-widest text-{{ $firstCard['color'] }}-300 uppercase mb-1">{{ $firstCard['category'] }}</span>
                    <h3 class="text-2xl md:text-3xl font-bold text-white mb-2 leading-tight">{{ $firstCard['name'] }}</h3>
                    <p class="text-sm text-slate-300 line-clamp-2 max-w-sm">{{ $firstCard['desc'] }}</p>
                    <div class="flex items-center gap-3 text-xs font-medium text-slate-300 border-t border-white/15 pt-4 mt-4">
                        <div class="flex items-center gap-1.5"><i class="fa-solid fa-calendar-days text-{{ $firstCard['color'] }}-400"></i> <span>{{ $firstCard['days'] }}</span></div>
                        <span class="text-white/20">|</span>
                        <div class="flex items-center gap-1.5"><i class="fa-solid fa-clock text-{{ $firstCard['color'] }}-400"></i> <span>{{ $firstCard['time'] }}</span></div>
                    </div>
                </div>
            </div>

            {{-- 2. E-Sports --}}
            <div class="ekskul-bento-card group relative rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-2xl transition-all duration-500">
                <img src="{{ $secondCard['image'] }}" alt="{{ $secondCard['name'] }} SMKN 1 Wringin" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" onerror="this.onerror=null;this.src='{{ $defaultJpegImage }}';">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                <div class="relative h-full flex flex-col justify-end p-4 md:p-5 z-10 transition-transform duration-300 group-hover:-translate-y-1">
                    <span class="text-[9px] font-bold tracking-widest text-{{ $secondCard['color'] }}-300 uppercase mb-0.5">{{ $secondCard['category'] }}</span>
                    <h3 class="text-lg md:text-xl font-bold text-white leading-tight">{{ $secondCard['name'] }}</h3>
                    <p class="text-xs text-slate-400 line-clamp-1 mt-1">{{ $secondCard['desc'] }}</p>
                </div>
            </div>

            {{-- 3. Basket --}}
            <div class="ekskul-bento-card group relative rounded-3xl overflow-hidden cursor-pointer shadow-md hover:shadow-2xl transition-all duration-500">
                <img src="{{ $thirdCard['image'] }}" alt="{{ $thirdCard['name'] }} SMKN 1 Wringin" class="absolute inset-0 w-full h-full object-cover transition-transform duration-700 group-hover:scale-110" onerror="this.onerror=null;this.src='{{ $defaultJpegImage }}';">
                <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/30 to-transparent"></div>
                <div class="relative h-full flex flex-col justify-end p-4 md:p-5 z-10 transition-transform duration-300 group-hover:-translate-y-1">
                    <span class="text-[9px] font-bold tracking-widest text-{{ $thirdCard['color'] }}-300 uppercase mb-0.5">{{ $thirdCard['category'] }}</span>
                    <h3 class="text-lg md:text-xl font-bold text-white leading-tight">{{ $thirdCard['name'] }}</h3>
                    <p class="text-xs text-slate-400 line-clamp-1 mt-1">{{ $thirdCard['desc'] }}</p>
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
                                <span class="block text-3xl md:text-4xl font-bold text-white">{{ $totalEkskulDisplay }}</span>
                                <span class="text-[10px] text-brand-200 uppercase tracking-wider font-semibold">Ekskul</span>
                            </div>
                            <div class="w-px h-10 bg-white/20"></div>
                            <div class="text-center">
                                <span class="block text-3xl md:text-4xl font-bold text-secondary-400">{{ $siswaAktifDisplay }}</span>
                                <span class="text-[10px] text-brand-200 uppercase tracking-wider font-semibold">Siswa Aktif</span>
                            </div>
                            <div class="w-px h-10 bg-white/20 hidden sm:block"></div>
                            <div class="text-center hidden sm:block">
                                <span class="block text-3xl md:text-4xl font-bold text-white">{{ $totalPrestasiDisplay }}</span>
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
