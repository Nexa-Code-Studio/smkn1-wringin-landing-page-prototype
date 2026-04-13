{{-- PROFIL / FASILITAS SECTION --}}
<section id="profil" class="py-20 bg-slate-50 relative overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative">
        <div class="grid lg:grid-cols-2 gap-16 items-center">
            <div class="order-2 lg:order-1 relative">
                <div class="grid grid-cols-2 gap-4">
                    <img data-animate="fade-right" src="{{ asset('images/profil-guru.jpg') }}" alt="Guru Mengajar" class="rounded-xl shadow-lg w-full h-48 object-cover">
                    <img data-animate="fade-left" data-delay="200" src="{{ asset('images/profil-praktek.jpg') }}" alt="Praktek SMK" class="rounded-xl shadow-lg w-full h-48 object-cover mt-8">
                </div>
                {{-- Experience Badge --}}
                <div data-animate="zoom-in" data-delay="300" class="absolute inset-0 flex items-center justify-center pointer-events-none">
                    <div class="bg-white p-4 rounded-full shadow-xl border-4 border-slate-50 flex flex-col items-center justify-center w-32 h-32 pointer-events-auto">
                        <span class="text-3xl font-bold text-brand-600">25</span>
                        <span class="text-xs text-slate-500 font-bold uppercase text-center leading-tight">Tahun<br>Mengabdi</span>
                    </div>
                </div>
            </div>

            <div class="order-1 lg:order-2">
                <div class="mb-6">
                    <span data-animate="fade-up" class="text-brand-600 font-bold uppercase tracking-wider text-sm">Tentang Kami</span>
                    <h2 data-animate="fade-up" data-delay="100" class="text-3xl md:text-4xl font-bold text-slate-900 mt-2">Lingkungan Belajar yang Mendukung Kreativitas</h2>
                </div>
                <p data-animate="fade-up" data-delay="200" class="text-slate-600 mb-6 text-lg">
                    Di SMKN 1 Wringin, kami percaya bahwa pendidikan bukan hanya tentang teori, tetapi juga karakter dan keterampilan nyata.
                </p>

                <div class="space-y-6">
                    <div data-animate="fade-left" data-delay="100" class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-brand-600/10 rounded-lg flex items-center justify-center text-brand-600 flex-shrink-0 mt-1">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">Guru Tersertifikasi</h4>
                            <p class="text-sm text-slate-500 mt-1">Pengajar profesional dengan sertifikasi pendidik dan pengalaman industri.</p>
                        </div>
                    </div>
                    <div data-animate="fade-left" data-delay="200" class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-brand-600/10 rounded-lg flex items-center justify-center text-brand-600 flex-shrink-0 mt-1">
                            <i class="fa-solid fa-handshake"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">Kerjasama Industri (Link & Match)</h4>
                            <p class="text-sm text-slate-500 mt-1">Kurikulum diselaraskan dengan kebutuhan dunia kerja (DUDI).</p>
                        </div>
                    </div>
                    <div data-animate="fade-left" data-delay="300" class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-brand-600/10 rounded-lg flex items-center justify-center text-brand-600 flex-shrink-0 mt-1">
                            <i class="fa-solid fa-trophy"></i>
                        </div>
                        <div>
                            <h4 class="font-bold text-slate-900">Ekstrakurikuler Berprestasi</h4>
                            <p class="text-sm text-slate-500 mt-1">Wadah pengembangan bakat siswa di bidang olahraga, seni, dan teknologi.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
