{{-- FOOTER --}}
<footer id="contact" class="bg-slate-900 text-white pt-16 pb-8 border-t-4 border-brand-600">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid md:grid-cols-4 gap-12 mb-12">
            {{-- School Info --}}
            <div data-animate="fade-up" class="col-span-1 md:col-span-2">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 bg-brand-600 rounded-lg flex items-center justify-center text-white">
                        <i class="fa-solid fa-school text-xl"></i>
                    </div>
                    <div>
                        <span class="block font-bold text-xl leading-none">SMKN 1 Wringin</span>
                        <span class="text-xs text-slate-400">UNGGUL & BERKARAKTER</span>
                    </div>
                </div>
                <p class="text-slate-400 mb-6 max-w-sm text-sm leading-relaxed">
                    Sekolah Menengah Kejuruan Negeri yang berkomitmen mencetak lulusan siap kerja, cerdas, dan berakhlak mulia untuk menghadapi tantangan global.
                </p>
                <div class="flex gap-4">
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-brand-600 transition"><i class="fa-brands fa-facebook-f text-sm"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-brand-600 transition"><i class="fa-brands fa-instagram text-sm"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-brand-600 transition"><i class="fa-brands fa-youtube text-sm"></i></a>
                    <a href="#" class="w-8 h-8 rounded-full bg-slate-800 flex items-center justify-center hover:bg-brand-600 transition"><i class="fa-brands fa-tiktok text-sm"></i></a>
                </div>
            </div>

            {{-- Links --}}
            <div data-animate="fade-up" data-delay="100">
                <h4 class="text-base font-bold mb-6 text-white uppercase tracking-wider">Akademik</h4>
                <ul class="space-y-3 text-slate-400 text-sm">
                    <li><a href="#" class="hover:text-brand-600 transition">Kurikulum</a></li>
                    <li><a href="#" class="hover:text-brand-600 transition">E-Learning</a></li>
                    <li><a href="#" class="hover:text-brand-600 transition">Jadwal Pelajaran</a></li>
                    <li><a href="#" class="hover:text-brand-600 transition">Ekstrakurikuler</a></li>
                    <li><a href="#" class="hover:text-brand-600 transition">Info Alumni</a></li>
                </ul>
            </div>

            {{-- Contact Info --}}
            <div data-animate="fade-up" data-delay="200">
                <h4 class="text-base font-bold mb-6 text-white uppercase tracking-wider">Hubungi Kami</h4>
                <ul class="space-y-4 text-slate-400 text-sm">
                    <li class="flex items-start gap-3">
                        <i class="fa-solid fa-map-location-dot mt-1 text-brand-600"></i>
                        <span>Jl. Pendidikan No. 45,<br>Wringin, Bondowoso, Jawa Timur</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-phone text-brand-600"></i>
                        <span>(0332) 555-0199</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <i class="fa-solid fa-envelope text-brand-600"></i>
                        <span>admin@smkn1wringin.sch.id</span>
                    </li>
                </ul>
            </div>
        </div>

        <div data-animate="fade-in" class="border-t border-slate-800 pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
            <p class="text-slate-500 text-sm text-center md:text-left">&copy; {{ date('Y') }} SMKN 1 Wringin. All rights reserved.</p>
            <div class="flex gap-6 text-sm text-slate-500">
                <a href="#" class="hover:text-white">Kebijakan Privasi</a>
                <a href="#" class="hover:text-white">Peta Situs</a>
            </div>
        </div>
    </div>
</footer>
