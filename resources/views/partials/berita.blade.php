{{-- BERITA SECTION --}}
<section id="berita" class="py-20 bg-white border-t border-slate-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex flex-col md:flex-row justify-between items-end mb-12 gap-4">
            <div class="max-w-2xl">
                <h2 data-animate="fade-up" class="text-brand-600 font-semibold tracking-wide uppercase text-sm mb-3">Kabar Sekolah</h2>
                <h3 data-animate="fade-up" data-delay="100" class="text-3xl md:text-4xl font-bold text-slate-900">Berita & Agenda Terbaru</h3>
            </div>
            <a data-animate="fade-in" data-delay="200" href="#" class="hidden md:inline-flex items-center gap-2 text-brand-600 font-semibold hover:text-brand-800 transition">
                Lihat Semua Berita <i class="fa-solid fa-arrow-right"></i>
            </a>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            {{-- News Item 1 --}}
            <article data-animate="fade-up" data-delay="100" class="flex flex-col bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 border border-slate-100 h-full">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('images/berita-prestasi.jpg') }}" alt="Juara LKS" class="w-full h-full object-cover transform hover:scale-110 transition duration-700">
                    <span class="absolute top-4 left-4 bg-yellow-500 text-white text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">Prestasi</span>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center gap-3 text-xs text-slate-400 mb-3">
                        <span><i class="fa-regular fa-calendar mr-1"></i> 12 Agustus 2024</span>
                        <span>|</span>
                        <span><i class="fa-regular fa-user mr-1"></i> Admin</span>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3 leading-snug hover:text-brand-600 transition cursor-pointer">
                        Siswa RPL Sabet Juara 1 LKS Web Tech Tingkat Provinsi
                    </h4>
                    <p class="text-slate-600 text-sm mb-4 line-clamp-3 flex-1">
                        Tim Rekayasa Perangkat Lunak berhasil mengharumkan nama sekolah dengan aplikasi manajemen sampah berbasis IoT yang dikembangkan selama kompetisi.
                    </p>
                    <a href="#" class="inline-flex items-center text-brand-600 font-semibold text-sm hover:underline mt-auto">
                        Baca Selengkapnya <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </article>

            {{-- News Item 2 --}}
            <article data-animate="fade-up" data-delay="200" class="flex flex-col bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 border border-slate-100 h-full">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('images/berita-kunjungan.jpg') }}" alt="Kunjungan Industri" class="w-full h-full object-cover transform hover:scale-110 transition duration-700">
                    <span class="absolute top-4 left-4 bg-brand-600 text-white text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">Kunjungan</span>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center gap-3 text-xs text-slate-400 mb-3">
                        <span><i class="fa-regular fa-calendar mr-1"></i> 5 Agustus 2024</span>
                        <span>|</span>
                        <span><i class="fa-regular fa-user mr-1"></i> Humas</span>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3 leading-snug hover:text-brand-600 transition cursor-pointer">
                        Kunjungan Industri ke PT. Teknologi Maju Jaya Jakarta
                    </h4>
                    <p class="text-slate-600 text-sm mb-4 line-clamp-3 flex-1">
                        Sebanyak 100 siswa kelas XI TKJ melakukan studi lapangan untuk melihat langsung infrastruktur server dan data center skala enterprise.
                    </p>
                    <a href="#" class="inline-flex items-center text-brand-600 font-semibold text-sm hover:underline mt-auto">
                        Baca Selengkapnya <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </article>

            {{-- News Item 3 --}}
            <article data-animate="fade-up" data-delay="300" class="flex flex-col bg-white rounded-2xl overflow-hidden shadow-sm hover:shadow-xl hover:-translate-y-1 transition duration-300 border border-slate-100 h-full">
                <div class="relative h-56 overflow-hidden">
                    <img src="{{ asset('images/berita-pensi.jpg') }}" alt="Pentas Seni" class="w-full h-full object-cover transform hover:scale-110 transition duration-700">
                    <span class="absolute top-4 left-4 bg-purple-500 text-white text-xs font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">Agenda</span>
                </div>
                <div class="p-6 flex-1 flex flex-col">
                    <div class="flex items-center gap-3 text-xs text-slate-400 mb-3">
                        <span><i class="fa-regular fa-calendar mr-1"></i> 1 September 2024</span>
                        <span>|</span>
                        <span><i class="fa-regular fa-user mr-1"></i> OSIS</span>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3 leading-snug hover:text-brand-600 transition cursor-pointer">
                        Saksikan Pentas Seni "Nusantara Berkarya 2024"
                    </h4>
                    <p class="text-slate-600 text-sm mb-4 line-clamp-3 flex-1">
                        Jangan lewatkan penampilan bakat terbaik siswa-siswi SMKN 1 Wringin dalam acara tahunan Pensi yang akan dimeriahkan oleh bintang tamu spesial.
                    </p>
                    <a href="#" class="inline-flex items-center text-brand-600 font-semibold text-sm hover:underline mt-auto">
                        Lihat Jadwal <i class="fa-solid fa-arrow-right ml-2 text-xs"></i>
                    </a>
                </div>
            </article>
        </div>

        <div data-animate="fade-up" data-delay="400" class="mt-8 text-center md:hidden">
            <a href="#" class="inline-block px-6 py-3 rounded-full border border-slate-200 text-slate-600 font-semibold hover:border-brand-600 hover:text-brand-600 transition">
                Lihat Semua Berita
            </a>
        </div>
    </div>
</section>
