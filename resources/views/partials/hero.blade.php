{{-- HERO SECTION --}}
<section id="home"
    class="relative min-h-screen pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden hero-pattern flex items-end lg:items-center">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative w-full">
        <div class="grid lg:grid-cols-2 gap-12 lg:gap-8 items-center">
            {{-- Text Content --}}
            <div class="max-w-2xl">
                <div data-animate="fade-up"
                    class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-orange-100 border border-orange-200 text-orange-700 text-xs font-bold uppercase tracking-wide mb-6">
                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                    Penerimaan Siswa Baru Tahun 2025 Dibuka!
                </div>
                <h1 data-animate="fade-up" data-delay="100"
                    class="text-4xl lg:text-5xl font-bold text-slate-900 leading-tight mb-6">
                    Mencetak Generasi <span class="text-brand-600">Cerdas, Terampil</span>, & Berkarakter
                </h1>
                <p data-animate="fade-up" data-delay="200" class="text-lg text-slate-600 mb-8 leading-relaxed">
                    Bergabunglah dengan SMKN 1 Wringin untuk mendapatkan pendidikan vokasi berkualitas dengan fasilitas
                    modern dan kurikulum yang terintegrasi dengan dunia industri.
                </p>

                <div class="flex flex-col">
                    {{-- Stats (above buttons on mobile, below on desktop) --}}
                    <div
                        class="order-1 lg:order-2 grid grid-cols-3 gap-6 border-t border-b lg:border-b-0 border-slate-200 py-8 mb-8 lg:mt-12 lg:mb-0 lg:pt-8 lg:pb-0">
                        <div data-animate="fade-up" data-delay="100">
                            <p class="text-3xl font-bold text-slate-900">1.2k+</p>
                            <p class="text-sm text-slate-500 font-medium">Siswa Aktif</p>
                        </div>
                        <div data-animate="fade-up" data-delay="200">
                            <p class="text-3xl font-bold text-slate-900">50+</p>
                            <p class="text-sm text-slate-500 font-medium">Mitra Industri</p>
                        </div>
                        <div data-animate="fade-up" data-delay="300">
                            <p class="text-3xl font-bold text-slate-900">95%</p>
                            <p class="text-sm text-slate-500 font-medium">Terserap Kerja</p>
                        </div>
                    </div>

                    {{-- CTA Buttons (below stats on mobile, above on desktop) --}}
                    <div data-animate="fade-up" data-delay="300"
                        class="order-2 lg:order-1 flex flex-col sm:flex-row gap-4">
                        <a href="#ppdb"
                            class="px-8 py-4 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-full shadow-xl shadow-brand-600/30 transition transform hover:-translate-y-1 text-center">
                            Info PPDB
                        </a>
                        <a href="#jurusan"
                            class="px-8 py-4 bg-white border border-slate-200 text-slate-700 hover:border-brand-600 hover:text-brand-600 font-semibold rounded-full shadow-sm transition text-center flex items-center justify-center gap-2 group">
                            <i class="fa-solid fa-book-open text-brand-600 group-hover:scale-110 transition"></i>
                            Lihat Jurusan
                        </a>
                    </div>
                </div>
            </div>

            {{-- Image Content (pushed below fold on mobile) --}}
            <div data-animate="fade-left" data-delay="200" class="relative lg:ml-10 mt-16 lg:mt-0">
                <div class="absolute -top-10 -right-10 w-72 h-72 bg-brand-600/10 rounded-full blur-3xl"></div>
                {{-- Decorative dots --}}
                <div class="absolute -bottom-10 -left-10 text-brand-600/20">
                    <svg width="100" height="100" fill="currentColor" viewBox="0 0 100 100">
                        <pattern id="dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="2"></circle>
                        </pattern>
                        <rect width="100" height="100" fill="url(#dots)"></rect>
                    </svg>
                </div>

                <div class="relative rounded-2xl overflow-hidden shadow-2xl border-4 border-white">
                    <img src="{{ asset('images/hero-siswa.jpg') }}" alt="Siswa SMKN 1 Wringin Belajar"
                        class="w-full h-auto object-cover transform hover:scale-105 transition duration-700">
                </div>

                {{-- Floating Card --}}
                <div data-animate="zoom-in" data-delay="400"
                    class="absolute top-10 -left-10 bg-white p-4 rounded-xl shadow-xl border border-slate-100 flex items-center gap-4 animate-bounce"
                    style="animation-duration: 4s;">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-blue-600">
                        <i class="fa-solid fa-certificate text-xl"></i>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500 uppercase tracking-wide">Terakreditasi</p>
                        <p class="text-lg font-bold text-slate-900">Grade A Unggul</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>