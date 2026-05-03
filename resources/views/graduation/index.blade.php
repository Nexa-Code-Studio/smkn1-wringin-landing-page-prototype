@extends('layouts.app')

@section('title', 'Pengumuman Kelulusan - SMKN 1 Wringin')

@push('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        .graduation-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#dbe4ec 0.8px, transparent 0.8px);
            background-size: 24px 24px;
        }

        .glass-card {
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(226, 232, 240, 0.85);
            box-shadow: 0 12px 40px rgba(15, 23, 42, 0.06);
        }

        .data-card {
            background: #ffffff;
            border-radius: 1rem;
            padding: 1.25rem 0.75rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0;
        }

        .dashed-separator {
            height: 1px;
            width: 100%;
            border-bottom: 2px dashed #cbd5e1;
            margin: 2rem 0;
        }

        .status-badge {
            width: 100%;
            padding: 1rem;
            border-radius: 0.75rem;
            font-weight: 800;
            font-size: 1.125rem;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: 1px solid transparent;
        }

        .status-lulus {
            background-color: #f0fdf4;
            color: #15803d;
            border-color: #bbf7d0;
        }

        .status-tidak {
            background-color: #fef2f2;
            color: #b91c1c;
            border-color: #fecaca;
        }

        .medal-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 2rem;
            height: 2rem;
            background: white;
            border-radius: 9999px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 8px rgba(15, 23, 42, 0.14);
            z-index: 20;
            border: 2px solid #f8fafc;
        }
    </style>
@endpush

@section('content')
    @include('partials.navbar')

    <main class="graduation-pattern min-h-screen pt-28 pb-16 px-4 sm:px-6 lg:px-8">
        <noscript>
            <div class="max-w-3xl mx-auto mb-8 bg-red-50 border border-red-200 text-red-700 rounded-2xl p-4 text-sm font-medium">
                JavaScript pada browser Anda tidak aktif. Hitung mundur dan pengecekan kelulusan tidak dapat berjalan.
            </div>
        </noscript>

        <section id="countdown-section" class="max-w-4xl mx-auto text-center mb-12">
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-50 border border-brand-100 text-brand-700 text-xs sm:text-sm font-bold mb-6">
                <span class="relative flex h-2 w-2">
                    <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-brand-400 opacity-75"></span>
                    <span class="relative inline-flex rounded-full h-2 w-2 bg-brand-500"></span>
                </span>
                Tahun Pelajaran {{ $graduationSetting->lulusan ?? '2026' }}
            </div>

            <h1 class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-900 mb-6 tracking-tight">
                Menuju Pengumuman <span class="text-transparent bg-clip-text bg-gradient-to-r from-brand-600 to-brand-800">Kelulusan</span>
            </h1>

            <p class="max-w-2xl mx-auto text-base sm:text-lg text-slate-600 leading-relaxed mb-10">
                Tetap tenang, siapkan NISN, dan akses hasil kelulusan pada waktu yang telah ditentukan. Hasil ini bersifat pribadi dan rahasia.
            </p>

            <div class="bg-white rounded-3xl p-6 sm:p-10 shadow-xl border border-slate-100 relative overflow-hidden">
                <div class="absolute -top-24 -right-24 w-48 h-48 bg-brand-50 rounded-full blur-3xl opacity-70"></div>
                <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-blue-50 rounded-full blur-3xl opacity-70"></div>

                <div class="relative z-10">
                    <p id="countdown-status" class="text-slate-500 font-bold mb-8 text-sm uppercase tracking-widest">Pengumuman akan dibuka dalam:</p>

                    <div id="countdown-timer" class="grid grid-cols-2 sm:grid-cols-4 gap-4 sm:gap-6 mb-8">
                        <div class="glass-card rounded-2xl p-4 sm:p-6 flex flex-col items-center justify-center transition-transform hover:scale-105 duration-300">
                            <span id="days" class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-900 mb-1">00</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-500 uppercase tracking-widest">Hari</span>
                        </div>
                        <div class="glass-card rounded-2xl p-4 sm:p-6 flex flex-col items-center justify-center transition-transform hover:scale-105 duration-300">
                            <span id="hours" class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-900 mb-1">00</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-500 uppercase tracking-widest">Jam</span>
                        </div>
                        <div class="glass-card rounded-2xl p-4 sm:p-6 flex flex-col items-center justify-center transition-transform hover:scale-105 duration-300">
                            <span id="minutes" class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-slate-900 mb-1">00</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-500 uppercase tracking-widest">Menit</span>
                        </div>
                        <div class="glass-card rounded-2xl p-4 sm:p-6 flex flex-col items-center justify-center transition-transform hover:scale-105 duration-300">
                            <span id="seconds" class="text-4xl sm:text-5xl md:text-6xl font-extrabold text-brand-600 mb-1">00</span>
                            <span class="text-xs sm:text-sm font-bold text-slate-500 uppercase tracking-widest">Detik</span>
                        </div>
                    </div>

                    <div id="check-panel" class="hidden max-w-md mx-auto text-left">
                        <div class="text-center mb-5">
                            <p class="text-sm text-slate-500 mt-2">Masukkan NISN untuk melihat hasil kelulusan Anda.</p>
                        </div>

                        <input type="text" id="nisn-input" autocomplete="off" inputmode="numeric" class="w-full bg-slate-50 border border-slate-300 rounded-xl px-4 py-3 text-slate-800 text-center text-xl tracking-widest focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all mb-4 placeholder-slate-300 font-mono" placeholder="0000000000">

                        <button id="submit-btn" class="w-full relative overflow-hidden bg-brand-600 hover:bg-brand-700 text-white font-bold py-3.5 rounded-xl transition-all duration-300 shadow-md shadow-brand-600/20">
                            <span class="relative z-10 flex items-center justify-center gap-2">
                                <i class="fa-solid fa-file-pen"></i>
                                Periksa Hasil
                            </span>
                        </button>

                        <div id="error-msg" class="h-6 mt-3 text-center">
                            <p class="text-red-500 text-sm opacity-0 transform translate-y-2 transition-all font-medium">Data tidak ditemukan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="result-section" class="hidden max-w-md mx-auto mb-16">
            <div id="result-actions" class="w-full flex justify-start mb-4 opacity-0 relative z-40">
                <button id="btn-back" class="text-slate-600 hover:text-brand-600 text-sm font-semibold flex items-center gap-2 transition-colors bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200 hover:border-brand-300">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </button>
            </div>

            <div id="result-card-container" class="relative z-30">
                <div id="result-card" class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                    <div class="p-6 md:p-10 flex flex-col items-center">
                        <div class="relative mb-6">
                            <img id="res-photo" src="" alt="Student Photo" class="w-28 h-28 rounded-full object-cover border-4 border-slate-50 shadow-sm relative z-10">
                            <div id="medal-container" class="medal-badge">
                                <div class="w-6 h-6 rounded-full bg-green-600 flex items-center justify-center text-white text-[10px]">
                                    <i class="fa-solid fa-medal"></i>
                                </div>
                            </div>
                        </div>

                        <div class="text-center mb-8">
                            <h2 id="res-nama" class="text-2xl font-bold text-slate-800 mb-1 uppercase tracking-tight">NAMA SISWA</h2>
                            <p class="text-slate-500 font-medium text-xs">Siswa Angkatan {{ $graduationSetting->angkatan ?? '2026' }}</p>
                        </div>

                        <div class="grid grid-cols-2 gap-4 w-full">
                            <div class="data-card">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 mb-2">
                                    <i class="fa-solid fa-file-pen"></i>
                                </div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">NISN</span>
                                <span id="res-nisn" class="text-slate-700 font-bold text-sm">0000000000</span>
                            </div>

                            <div class="data-card">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 mb-2">
                                    <i class="fa-solid fa-graduation-cap"></i>
                                </div>
                                <span class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">KELAS</span>
                                <span id="res-kelas" class="text-slate-700 font-bold text-sm uppercase">XII</span>
                            </div>
                        </div>

                        <div class="dashed-separator"></div>

                        <div class="w-full">
                            <div id="res-status-badge" class="status-badge uppercase">STATUS</div>
                            <div class="mt-4 text-center">
                                <p id="res-message" class="text-slate-500 text-sm font-medium leading-relaxed"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="informasi" class="max-w-5xl mx-auto grid sm:grid-cols-3 gap-6 mb-14">
            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-file-pen text-lg"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">Siapkan NISN</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Pastikan NISN sudah benar sebelum melakukan pengecekan di sistem.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-orange-50 text-orange-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-graduation-cap text-lg"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">Akses Sesuai Jadwal</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Pengecekan hanya dapat dilakukan setelah waktu pengumuman resmi dibuka.</p>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100 hover:shadow-md transition-shadow">
                <div class="w-12 h-12 bg-brand-50 text-brand-600 rounded-xl flex items-center justify-center mb-4">
                    <i class="fa-solid fa-school text-lg"></i>
                </div>
                <h3 class="font-bold text-slate-900 text-lg mb-2">Tetap Bijak</h3>
                <p class="text-slate-600 text-sm leading-relaxed">Apapun hasilnya, tetap bersyukur dan jaga nama baik almamater SMKN 1 Wringin.</p>
            </div>
        </section>
    </main>

    @include('partials.footer')

    @push('scripts')
        <script>
            const checkUrl = @json(route('graduation.check'));
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';
            const countdownTarget = @json($countdownTarget);
            let currentStudent = null;
            let countdownInterval = null;

            const DOM = {};

            function bindDom() {
                Object.assign(DOM, {
                    countdownSection: document.getElementById('countdown-section'),
                    countdownTimer: document.getElementById('countdown-timer'),
                    countdownStatus: document.getElementById('countdown-status'),
                    checkPanel: document.getElementById('check-panel'),
                    days: document.getElementById('days'),
                    hours: document.getElementById('hours'),
                    minutes: document.getElementById('minutes'),
                    seconds: document.getElementById('seconds'),
                    nisnInput: document.getElementById('nisn-input'),
                    submitBtn: document.getElementById('submit-btn'),
                    errorMsg: document.querySelector('#error-msg p'),
                    resultSection: document.getElementById('result-section'),
                    resultActions: document.getElementById('result-actions'),
                    resultCardContainer: document.getElementById('result-card-container'),
                    btnBack: document.getElementById('btn-back'),
                    resPhoto: document.getElementById('res-photo'),
                    resNama: document.getElementById('res-nama'),
                    resNisn: document.getElementById('res-nisn'),
                    resKelas: document.getElementById('res-kelas'),
                    resStatusBadge: document.getElementById('res-status-badge'),
                    resMessage: document.getElementById('res-message'),
                    medalContainer: document.getElementById('medal-container'),
                    navbar: document.getElementById('navbar'),
                    footer: document.getElementById('contact'),
                    informasi: document.getElementById('informasi'),
                    main: document.querySelector('main')
                });
            }

            function init() {
                bindDom();
                setupEventListeners();
                startCountdown();
                gsap.from(DOM.countdownSection, { y: 20, opacity: 0, duration: 0.7, ease: 'power2.out' });
            }

            function setupEventListeners() {
                DOM.submitBtn.addEventListener('click', handleCheckStatus);
                DOM.nisnInput.addEventListener('keypress', (event) => {
                    if (event.key === 'Enter') handleCheckStatus();
                });
                DOM.nisnInput.addEventListener('input', () => {
                    DOM.nisnInput.value = DOM.nisnInput.value.replace(/\D/g, '').slice(0, 10);
                    gsap.to(DOM.errorMsg, { opacity: 0, y: 5, duration: 0.2 });
                });
                DOM.btnBack.addEventListener('click', resetToCountdown);
            }

            function startCountdown() {
                const targetTime = new Date(countdownTarget).getTime();
                const formatNumber = (value) => value < 10 ? `0${value}` : String(value);

                const tick = () => {
                    const distance = targetTime - Date.now();

                    if (distance <= 0) {
                        clearInterval(countdownInterval);
                        openCheckPanel();
                        return;
                    }

                    DOM.days.textContent = formatNumber(Math.floor(distance / (1000 * 60 * 60 * 24)));
                    DOM.hours.textContent = formatNumber(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)));
                    DOM.minutes.textContent = formatNumber(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60)));
                    DOM.seconds.textContent = formatNumber(Math.floor((distance % (1000 * 60)) / 1000));
                };

                tick();
                countdownInterval = setInterval(tick, 1000);
            }

            function openCheckPanel() {
                DOM.countdownTimer.classList.add('hidden');
                DOM.countdownStatus.textContent = 'Pengumuman kelulusan telah dibuka.';
                DOM.countdownStatus.className = 'text-brand-600 font-extrabold mb-4 text-base uppercase tracking-widest';
                DOM.checkPanel.classList.remove('hidden');
                gsap.fromTo(DOM.checkPanel, { y: 12, opacity: 0 }, { y: 0, opacity: 1, duration: 0.35, ease: 'power2.out' });
            }

            function setSubmitLoading(isLoading) {
                DOM.submitBtn.disabled = isLoading;
                DOM.submitBtn.innerHTML = isLoading
                    ? '<span class="relative z-10 flex items-center justify-center gap-2"><i class="fa-solid fa-circle-notch fa-spin"></i> Memeriksa...</span>'
                    : '<span class="relative z-10 flex items-center justify-center gap-2"><i class="fa-solid fa-file-pen"></i> Periksa Hasil</span>';
            }

            function handleApiError(statusCode, result) {
                if (statusCode === 403) {
                    showError(result.message || 'Pengumuman kelulusan belum dibuka.');
                    return;
                }
                if (statusCode === 429) {
                    showError(result.message || 'Terlalu banyak percobaan. Coba lagi dalam 1 menit.');
                    return;
                }
                if (statusCode === 422) {
                    showError(result?.errors?.nisn?.[0] || result.message || 'Input tidak valid.');
                    return;
                }
                if (statusCode === 404) {
                    showError('Data tidak ditemukan.');
                    return;
                }
                showError(result.message || 'Terjadi kesalahan pada server.');
            }

            async function handleCheckStatus() {
                const nisn = DOM.nisnInput.value.replace(/\D/g, '').trim();
                DOM.nisnInput.value = nisn;

                if (!/^\d{10}$/.test(nisn)) {
                    showError('NISN harus terdiri dari 10 digit angka.');
                    return;
                }

                setSubmitLoading(true);

                try {
                    const response = await fetch(checkUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': csrfToken,
                            'X-Requested-With': 'XMLHttpRequest',
                        },
                        body: JSON.stringify({ nisn }),
                    });

                    const result = await response.json().catch(() => ({}));

                    if (!response.ok || !result.success) {
                        handleApiError(response.status, result);
                        setSubmitLoading(false);
                        return;
                    }

                    currentStudent = result.data;
                    showResult();
                } catch (error) {
                    showError('Gagal terhubung ke server. Silakan coba lagi.');
                    setSubmitLoading(false);
                }
            }

            function showError(message) {
                DOM.errorMsg.textContent = message;
                gsap.to(DOM.errorMsg, { opacity: 1, y: 0, duration: 0.3, ease: 'back.out(2)' });
            }

            function showResult() {
                DOM.resPhoto.src = currentStudent.photo;
                DOM.resNama.textContent = currentStudent.nama;
                DOM.resNisn.textContent = currentStudent.nisn;
                DOM.resKelas.textContent = currentStudent.kelas;

                const status = String(currentStudent.status || '').toUpperCase();
                if (status === 'LULUS') {
                    DOM.resStatusBadge.innerHTML = '<i class="fa-solid fa-circle-check"></i> <span>LULUS</span>';
                    DOM.resStatusBadge.className = 'status-badge status-lulus';
                    DOM.resMessage.innerHTML = `
                        <div class="space-y-1">
                            <p class="text-slate-700">Selamat! Anda dinyatakan <span class="text-green-600 font-bold uppercase">Lulus</span>.</p>
                            <p class="text-slate-600">Terimakasih telah bertahan hingga hari ini.</p>
                            <p class="text-[11px] text-slate-500 leading-normal px-4">Lanjutkan ikhtiar di masa depan, untuk menjadi pribadi yang lebih bermanfaat bagi diri, keluarga, dan masyarakat.</p>
                            <p class="text-brand-600 font-black text-lg mt-3">Kamu Bisa!</p>
                        </div>
                    `;
                    DOM.medalContainer.style.display = 'flex';
                    setTimeout(fireConfetti, 300);
                } else if (status === 'TIDAK LULUS') {
                    DOM.resStatusBadge.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> <span>TIDAK LULUS</span>';
                    DOM.resStatusBadge.className = 'status-badge status-tidak';
                    DOM.resMessage.textContent = 'Jangan berkecil hati. Tetap semangat dan jangan menyerah untuk masa depanmu.';
                    DOM.medalContainer.style.display = 'none';
                } else {
                    DOM.resStatusBadge.innerHTML = '<i class="fa-solid fa-circle-info"></i> <span>BELUM ADA</span>';
                    DOM.resStatusBadge.className = 'status-badge bg-slate-50 text-slate-600 border-slate-200';
                    DOM.resMessage.textContent = 'Status kelulusan Anda belum tersedia. Silakan hubungi pihak sekolah.';
                    DOM.medalContainer.style.display = 'none';
                }

                DOM.resultSection.classList.remove('hidden');
                gsap.timeline()
                    .to([DOM.navbar, DOM.footer, DOM.informasi], { opacity: 0, y: -10, duration: 0.3, stagger: 0.05, onComplete: () => {
                        DOM.navbar.classList.add('hidden');
                        DOM.footer.classList.add('hidden');
                        DOM.informasi.classList.add('hidden');
                        DOM.main.classList.remove('pt-28', 'pb-16');
                        DOM.main.classList.add('flex', 'items-center', 'justify-center', 'py-12');
                    }})
                    .to(DOM.countdownSection, { opacity: 0, y: -16, duration: 0.25, onComplete: () => DOM.countdownSection.classList.add('hidden') }, '-=0.2')
                    .fromTo(DOM.resultCardContainer, { scale: 0.92, opacity: 0, y: 22 }, { scale: 1, opacity: 1, y: 0, duration: 0.5, ease: 'back.out(1.2)' })
                    .to(DOM.resultActions, { opacity: 1, duration: 0.25 }, '-=0.15');
            }

            function fireConfetti() {
                const duration = 3000;
                const end = Date.now() + duration;
                const colors = ['#f43f5e', '#fb923c', '#facc15', '#4ade80', '#2dd4bf', '#38bdf8', '#818cf8', '#a78bfa', '#fb7185'];

                (function frame() {
                    confetti({
                        particleCount: 2,
                        startVelocity: 15,
                        angle: 270,
                        ticks: 1000,
                        origin: { x: Math.random(), y: Math.random() * 0.2 - 0.2 },
                        colors,
                        gravity: Math.random() * 0.5 + 1.2,
                        scalar: Math.random() * 0.5 + 0.7,
                        drift: Math.random() * 1.5 - 0.75,
                        zIndex: 9999,
                    });

                    if (Date.now() < end) requestAnimationFrame(frame);
                })();
            }

            function resetToCountdown() {
                gsap.to(DOM.resultSection, { opacity: 0, duration: 0.25, onComplete: () => {
                    DOM.resultSection.classList.add('hidden');
                    DOM.resultSection.style.opacity = '';
                    
                    DOM.navbar.classList.remove('hidden');
                    DOM.footer.classList.remove('hidden');
                    DOM.informasi.classList.remove('hidden');
                    DOM.main.classList.add('pt-28', 'pb-16');
                    DOM.main.classList.remove('flex', 'items-center', 'justify-center', 'py-12');
                    
                    gsap.to([DOM.navbar, DOM.footer, DOM.informasi], { opacity: 1, y: 0, duration: 0.3 });
                    
                    DOM.countdownSection.classList.remove('hidden');
                    gsap.fromTo(DOM.countdownSection, { opacity: 0, y: -12 }, { opacity: 1, y: 0, duration: 0.35 });
                    DOM.nisnInput.value = '';
                    setSubmitLoading(false);
                    currentStudent = null;
                }});
            }

            window.addEventListener('load', init);
        </script>
    @endpush
@endsection
