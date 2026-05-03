{{-- HERO SECTION --}}
<section id="home"
    class="relative h-screen lg:h-screen min-h-[600px] lg:min-h-0 overflow-hidden hero-pattern flex items-center pt-20">
    {{-- Background elements stay the same --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative w-full">
        <div class="grid lg:grid-cols-2 gap-8 lg:gap-12 items-center">
            {{-- Text Content --}}
            <div class="max-w-xl">
                <div data-animate="fade-up"
                    class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-orange-100 border border-orange-200 text-orange-700 text-[10px] font-bold uppercase tracking-wide mb-4">
                    <span class="w-2 h-2 rounded-full bg-orange-500 animate-pulse"></span>
                    Penerimaan Siswa Baru Tahun 2025
                </div>
                <h1 data-animate="fade-up" data-delay="100"
                    class="text-3xl lg:text-4xl xl:text-5xl font-bold text-slate-900 leading-tight mb-4">
                    SmakinOne Tempat <span class="text-brand-600">Bertumbuhnya Creativepreneur </span>Berkarakter
                </h1>
                <p data-animate="fade-up" data-delay="200" class="text-base lg:text-lg text-slate-600 mb-6 leading-relaxed">
                    Pusat pendidikan vokasi dengan fasilitas lengkap, GTK berdedikasi, serta budaya positif, yang siap menghasilkan generasi Creativepreneur berkarakter sesuai 8 Dimensi Profil Lulusan.
                </p>

                <div class="flex flex-col">
                    {{-- CTA Buttons --}}
                    <div data-animate="fade-up" data-delay="300"
                        class="order-1 flex flex-col sm:flex-row gap-3 mb-6 lg:mb-8">
                        <a href="#ppdb"
                            class="px-6 py-3 bg-brand-600 hover:bg-brand-700 text-white font-semibold rounded-full shadow-lg shadow-brand-600/30 transition transform hover:-translate-y-1 text-center text-sm">
                            Info PPDB
                        </a>
                        <a href="#jurusan"
                            class="px-6 py-3 bg-white border border-slate-200 text-slate-700 hover:border-brand-600 hover:text-brand-600 font-semibold rounded-full shadow-sm transition text-center text-sm flex items-center justify-center gap-2 group">
                            <i class="fa-solid fa-book-open text-brand-600 group-hover:scale-110 transition"></i>
                            Lihat Jurusan
                        </a>
                    </div>

                    {{-- Stats --}}
                    <div
                        class="order-2 grid grid-cols-3 gap-4 border-t border-slate-200 pt-6">
                        <div data-animate="fade-up" data-delay="100">
                            <p class="text-xl lg:text-2xl font-bold text-slate-900">25+</p>
                            <p class="text-[10px] lg:text-xs text-slate-500 font-medium whitespace-nowrap uppercase tracking-wider">Mitra Industri</p>
                        </div>
                        <div data-animate="fade-up" data-delay="200">
                            <p class="text-xl lg:text-2xl font-bold text-slate-900">32%</p>
                            <p class="text-[10px] lg:text-xs text-slate-500 font-medium whitespace-nowrap uppercase tracking-wider">Melanjutkan Kuliah</p>
                        </div>
                        <div data-animate="fade-up" data-delay="300">
                            <p class="text-xl lg:text-2xl font-bold text-slate-900">68%</p>
                            <p class="text-[10px] lg:text-xs text-slate-500 font-medium whitespace-nowrap uppercase tracking-wider">Bekerja/Berwirausaha</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Image Content - Constrained height --}}
            <div data-animate="fade-left" data-delay="200" class="relative hidden lg:block">
                <div class="absolute -top-10 -right-10 w-72 h-72 bg-brand-600/10 rounded-full blur-3xl"></div>
                
                {{-- Decorative dots --}}
                <div class="absolute -bottom-6 -left-6 text-brand-600/20 z-0">
                    <svg width="80" height="80" fill="currentColor" viewBox="0 0 100 100">
                        <pattern id="hero-dots" x="0" y="0" width="20" height="20" patternUnits="userSpaceOnUse">
                            <circle cx="2" cy="2" r="2"></circle>
                        </pattern>
                        <rect width="100" height="100" fill="url(#hero-dots)"></rect>
                    </svg>
                </div>

                <div class="relative rounded-3xl overflow-hidden shadow-2xl border-4 border-white aspect-[4/3] xl:aspect-video max-h-[450px] xl:max-h-[550px] w-full">
                    <img src="{{ asset('images/foto-sekolah.jpg') }}" alt="Sekolah SMKN 1 Wringin"
                        class="w-full h-full object-cover transform hover:scale-105 transition duration-1000">
                </div>

                {{-- Floating Card --}}
                <div data-animate="zoom-in" data-delay="400"
                    class="absolute top-8 -left-8 bg-white/95 backdrop-blur-sm p-3 rounded-2xl shadow-xl border border-white/50 flex items-center gap-3 animate-bounce shadow-brand-600/10"
                    style="animation-duration: 4s;">
                    <div class="w-10 h-10 bg-brand-600 rounded-xl flex items-center justify-center text-white shadow-lg">
                        <i class="fa-solid fa-certificate text-lg"></i>
                    </div>
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase font-bold tracking-tighter">Terakreditasi</p>
                        <p class="text-base font-bold text-slate-900 leading-none">Grade A Unggul</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>