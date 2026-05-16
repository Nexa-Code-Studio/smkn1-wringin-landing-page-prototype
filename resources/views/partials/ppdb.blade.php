{{-- CALL TO ACTION PPDB --}}
<section id="ppdb" class="py-20 relative bg-brand-600 overflow-hidden">
    {{-- Abstract shapes background --}}
    <div class="absolute inset-0 opacity-10">
        <svg class="h-full w-full" viewBox="0 0 100 100" preserveAspectRatio="none">
            <path d="M0 100 C 20 0 50 0 100 100 Z" fill="white" />
        </svg>
    </div>

    <div class="max-w-4xl mx-auto px-4 relative text-center">
        <h2 data-animate="fade-up" class="text-3xl md:text-4xl font-bold text-white mb-6">Siap Menjadi Bagian dari Keluarga Besar Kami?</h2>
        <p data-animate="fade-up" data-delay="100" class="text-brand-100 text-lg mb-10 max-w-2xl mx-auto">
            @php
                $tahunPpdb = intval($homeContent['tahun_ppdb'] ?? date('Y'));
                $tahunBerikutnya = $tahunPpdb + 1;
            @endphp
            Penerimaan Peserta Didik Baru (PPDB) Tahun Ajaran {{ $tahunPpdb }}/{{ $tahunBerikutnya }} telah dibuka. Segera daftarkan diri Anda sebelum kuota terpenuhi.
        </p>
        <div data-animate="zoom-in" data-delay="200" class="flex flex-col sm:flex-row justify-center gap-4">
            <a href="#" class="px-8 py-4 bg-white text-brand-600 font-bold rounded-full shadow-lg hover:bg-slate-100 transition transform hover:-translate-y-1">
                Daftar Online Sekarang
            </a>
            @php
                $waPhone = trim((string) ($homeContent['nomor_telepon'] ?? '')) ?: '(0332) 555-0199';
                $waNumber = preg_replace('/[^0-9]/', '', $waPhone);
                if (str_starts_with($waNumber, '0')) {
                    $waNumber = '62' . substr($waNumber, 1);
                }
            @endphp
            <a href="https://wa.me/{{ $waNumber }}" target="_blank" rel="noopener noreferrer" class="px-8 py-4 bg-transparent border-2 border-white text-white font-bold rounded-full hover:bg-white/10 transition">
                <i class="fa-brands fa-whatsapp mr-2"></i> Chat Panitia
            </a>
        </div>
    </div>
</section>
