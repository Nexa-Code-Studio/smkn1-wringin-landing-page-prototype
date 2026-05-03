{{-- MAJORS / JURUSAN SECTION --}}
<section id="jurusan" class="py-20 bg-gradient-to-b from-white via-slate-50/70 to-white relative overflow-hidden">
    <div class="absolute -top-24 -right-24 w-72 h-72 bg-brand-600/5 rounded-full blur-3xl"></div>
    <div class="absolute bottom-10 -left-24 w-72 h-72 bg-blue-500/5 rounded-full blur-3xl"></div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="text-center max-w-3xl mx-auto mb-16">
            <h2 data-animate="fade-up" class="text-brand-600 font-semibold tracking-wide uppercase text-sm mb-3">Kompetensi Keahlian</h2>
            <h3 data-animate="fade-up" data-delay="100" class="text-3xl md:text-4xl font-bold text-slate-900 mb-4">Pilih Masa Depanmu</h3>
            <p data-animate="fade-up" data-delay="200" class="text-slate-600">Kami menyediakan berbagai program keahlian yang relevan dengan kebutuhan industri 4.0 saat ini.</p>
        </div>

        <div class="grid md:grid-cols-2 xl:grid-cols-4 gap-6 items-stretch">
            {{-- Jurusan 1: TAV --}}
            <div data-animate="fade-up" data-delay="100" class="group h-full p-7 rounded-3xl bg-white border border-slate-100 hover:border-brand-600/30 hover:bg-gradient-to-br hover:from-brand-600 hover:to-emerald-700 hover:shadow-2xl hover:shadow-brand-600/20 focus-within:border-brand-600/30 focus-within:bg-gradient-to-br focus-within:from-brand-600 focus-within:to-emerald-700 focus-within:shadow-2xl focus-within:shadow-brand-600/20 transform hover:-translate-y-2 focus-within:-translate-y-2 transition-all duration-500 ease-out relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-brand-600/5 rounded-bl-full -mr-4 -mt-4 transition-all duration-700 group-hover:scale-150 group-hover:bg-white/10 group-focus-within:scale-150 group-focus-within:bg-white/10"></div>
                <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/15 to-transparent transition-transform duration-700 ease-out group-hover:translate-x-full group-focus-within:translate-x-full"></div>
                <div class="relative w-14 h-14 bg-blue-50 rounded-xl flex items-center justify-center text-blue-600 mb-6 group-hover:bg-white/20 group-hover:text-white group-focus-within:bg-white/20 group-focus-within:text-white transition-all duration-500 ease-out group-hover:scale-110 group-hover:-rotate-3 group-focus-within:scale-110 group-focus-within:-rotate-3">
                    <i class="fa-solid fa-tv text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-white group-focus-within:text-white transition">Teknik Audio Video (TAV)</h4>
                <p class="text-slate-600 mb-6 text-sm group-hover:text-brand-50 group-focus-within:text-brand-50 transition">Mempelajari instalasi, perawatan, dan perbaikan perangkat audio, video, televisi, serta sistem elektronika.</p>
                <ul class="space-y-2 mb-6">
                    <li class="flex items-center text-xs text-slate-500 group-hover:text-brand-100 group-focus-within:text-brand-100 transition"><i class="fa-solid fa-check text-green-500 group-hover:text-white group-focus-within:text-white mr-2"></i> Praktik Elektronika</li>
                    <li class="flex items-center text-xs text-slate-500 group-hover:text-brand-100 group-focus-within:text-brand-100 transition"><i class="fa-solid fa-check text-green-500 group-hover:text-white group-focus-within:text-white mr-2"></i> Servis Audio Visual</li>
                </ul>
                <a href="{{ route('kurikulum.detail') }}" class="text-brand-600 font-semibold group-hover:text-white group-hover:underline group-focus-within:text-white flex items-center gap-2 text-sm transition">
                    Lihat Kurikulum <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1 group-focus-within:translate-x-1"></i>
                </a>
            </div>

            {{-- Jurusan 2: DKV --}}
            <div data-animate="fade-up" data-delay="200" class="group h-full p-7 rounded-3xl bg-white border border-slate-100 hover:border-brand-600/30 hover:bg-gradient-to-br hover:from-brand-600 hover:to-emerald-700 hover:shadow-2xl hover:shadow-brand-600/20 focus-within:border-brand-600/30 focus-within:bg-gradient-to-br focus-within:from-brand-600 focus-within:to-emerald-700 focus-within:shadow-2xl focus-within:shadow-brand-600/20 transform hover:-translate-y-2 focus-within:-translate-y-2 transition-all duration-500 ease-out relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-brand-600/5 rounded-bl-full -mr-4 -mt-4 transition-all duration-700 group-hover:scale-150 group-hover:bg-white/10 group-focus-within:scale-150 group-focus-within:bg-white/10"></div>
                <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/15 to-transparent transition-transform duration-700 ease-out group-hover:translate-x-full group-focus-within:translate-x-full"></div>
                <div class="absolute bottom-0 left-0 w-24 h-24 bg-brand-600/5 rounded-tr-full -ml-6 -mb-6 transition-all duration-700 group-hover:scale-150 group-hover:bg-white/10 group-focus-within:scale-150 group-focus-within:bg-white/10"></div>
                <div class="relative w-14 h-14 bg-orange-50 rounded-xl flex items-center justify-center text-orange-500 mb-6 group-hover:bg-white/20 group-hover:text-white group-focus-within:bg-white/20 group-focus-within:text-white transition-all duration-500 ease-out group-hover:scale-110 group-hover:-rotate-3 group-focus-within:scale-110 group-focus-within:-rotate-3">
                    <i class="fa-solid fa-pen-nib text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-white group-focus-within:text-white transition">Desain Komunikasi Visual (DKV)</h4>
                <p class="text-slate-600 mb-6 text-sm group-hover:text-brand-50 group-focus-within:text-brand-50 transition">Mengembangkan kreativitas dalam desain grafis, fotografi, videografi, animasi, dan konten visual digital.</p>
                <ul class="space-y-2 mb-6">
                    <li class="flex items-center text-xs text-slate-500 group-hover:text-brand-100 group-focus-within:text-brand-100 transition"><i class="fa-solid fa-check text-green-500 group-hover:text-white group-focus-within:text-white mr-2"></i> Studio Fotografi</li>
                    <li class="flex items-center text-xs text-slate-500 group-hover:text-brand-100 group-focus-within:text-brand-100 transition"><i class="fa-solid fa-check text-green-500 group-hover:text-white group-focus-within:text-white mr-2"></i> Produksi Multimedia</li>
                </ul>
                <a href="{{ route('kurikulum.detail') }}" class="text-brand-600 font-semibold group-hover:text-white group-hover:underline group-focus-within:text-white flex items-center gap-2 text-sm transition">
                    Lihat Kurikulum <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1 group-focus-within:translate-x-1"></i>
                </a>
            </div>

            {{-- Jurusan 3: TKJ --}}
            <div data-animate="fade-up" data-delay="300" class="group h-full p-7 rounded-3xl bg-white border border-slate-100 hover:border-brand-600/30 hover:bg-gradient-to-br hover:from-brand-600 hover:to-emerald-700 hover:shadow-2xl hover:shadow-brand-600/20 focus-within:border-brand-600/30 focus-within:bg-gradient-to-br focus-within:from-brand-600 focus-within:to-emerald-700 focus-within:shadow-2xl focus-within:shadow-brand-600/20 transform hover:-translate-y-2 focus-within:-translate-y-2 transition-all duration-500 ease-out relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-brand-600/5 rounded-bl-full -mr-4 -mt-4 transition-all duration-700 group-hover:scale-150 group-hover:bg-white/10 group-focus-within:scale-150 group-focus-within:bg-white/10"></div>
                <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/15 to-transparent transition-transform duration-700 ease-out group-hover:translate-x-full group-focus-within:translate-x-full"></div>
                <div class="relative w-14 h-14 bg-emerald-50 rounded-xl flex items-center justify-center text-brand-600 mb-6 group-hover:bg-white/20 group-hover:text-white group-focus-within:bg-white/20 group-focus-within:text-white transition-all duration-500 ease-out group-hover:scale-110 group-hover:-rotate-3 group-focus-within:scale-110 group-focus-within:-rotate-3">
                    <i class="fa-solid fa-network-wired text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-white group-focus-within:text-white transition">Teknik Komputer Jaringan (TKJ)</h4>
                <p class="text-slate-600 mb-6 text-sm group-hover:text-brand-50 group-focus-within:text-brand-50 transition">Mempelajari perakitan komputer, instalasi jaringan, administrasi server, dan keamanan sistem jaringan.</p>
                <ul class="space-y-2 mb-6">
                    <li class="flex items-center text-xs text-slate-500 group-hover:text-brand-100 group-focus-within:text-brand-100 transition"><i class="fa-solid fa-check text-green-500 group-hover:text-white group-focus-within:text-white mr-2"></i> Laboratorium Jaringan</li>
                    <li class="flex items-center text-xs text-slate-500 group-hover:text-brand-100 group-focus-within:text-brand-100 transition"><i class="fa-solid fa-check text-green-500 group-hover:text-white group-focus-within:text-white mr-2"></i> Administrasi Server</li>
                </ul>
                <a href="{{ route('kurikulum.detail') }}" class="text-brand-600 font-semibold group-hover:text-white group-hover:underline group-focus-within:text-white flex items-center gap-2 text-sm transition">
                    Lihat Kurikulum <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1 group-focus-within:translate-x-1"></i>
                </a>
            </div>

            {{-- Jurusan 4: TKRO --}}
            <div data-animate="fade-up" data-delay="400" class="group h-full p-7 rounded-3xl bg-white border border-slate-100 hover:border-brand-600/30 hover:bg-gradient-to-br hover:from-brand-600 hover:to-emerald-700 hover:shadow-2xl hover:shadow-brand-600/20 focus-within:border-brand-600/30 focus-within:bg-gradient-to-br focus-within:from-brand-600 focus-within:to-emerald-700 focus-within:shadow-2xl focus-within:shadow-brand-600/20 transform hover:-translate-y-2 focus-within:-translate-y-2 transition-all duration-500 ease-out relative overflow-hidden">
                <div class="absolute top-0 right-0 w-24 h-24 bg-brand-600/5 rounded-bl-full -mr-4 -mt-4 transition-all duration-700 group-hover:scale-150 group-hover:bg-white/10 group-focus-within:scale-150 group-focus-within:bg-white/10"></div>
                <div class="absolute inset-0 -translate-x-full bg-gradient-to-r from-transparent via-white/15 to-transparent transition-transform duration-700 ease-out group-hover:translate-x-full group-focus-within:translate-x-full"></div>
                <div class="relative w-14 h-14 bg-amber-50 rounded-xl flex items-center justify-center text-amber-500 mb-6 group-hover:bg-white/20 group-hover:text-white group-focus-within:bg-white/20 group-focus-within:text-white transition-all duration-500 ease-out group-hover:scale-110 group-hover:-rotate-3 group-focus-within:scale-110 group-focus-within:-rotate-3">
                    <i class="fa-solid fa-car-side text-2xl"></i>
                </div>
                <h4 class="text-xl font-bold text-slate-900 mb-3 group-hover:text-white group-focus-within:text-white transition">Teknik Kendaraan Ringan Otomotif (TKRO)</h4>
                <p class="text-slate-600 mb-6 text-sm group-hover:text-brand-50 group-focus-within:text-brand-50 transition">Mempelajari perawatan, perbaikan, dan diagnosa kendaraan ringan berbasis teknologi otomotif modern.</p>
                <ul class="space-y-2 mb-6">
                    <li class="flex items-center text-xs text-slate-500 group-hover:text-brand-100 group-focus-within:text-brand-100 transition"><i class="fa-solid fa-check text-green-500 group-hover:text-white group-focus-within:text-white mr-2"></i> Bengkel Otomotif</li>
                    <li class="flex items-center text-xs text-slate-500 group-hover:text-brand-100 group-focus-within:text-brand-100 transition"><i class="fa-solid fa-check text-green-500 group-hover:text-white group-focus-within:text-white mr-2"></i> Diagnosa Kendaraan</li>
                </ul>
                <a href="{{ route('kurikulum.detail') }}" class="text-brand-600 font-semibold group-hover:text-white group-hover:underline group-focus-within:text-white flex items-center gap-2 text-sm transition">
                    Lihat Kurikulum <i class="fa-solid fa-arrow-right text-xs transition-transform duration-300 group-hover:translate-x-1 group-focus-within:translate-x-1"></i>
                </a>
            </div>
        </div>
    </div>
</section>
