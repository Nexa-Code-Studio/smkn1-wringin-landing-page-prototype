@extends('layouts.app')

@section('title', 'Pengumuman Kelulusan - SMKN 1 Wringin')

@push('styles')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    <style>
        .result-formal-bg {
            background-color: #f8fafc; /* slate-50 */
        }
        .data-card {
            background: #ffffff;
            border-radius: 1rem;
            padding: 1.25rem 0.75rem;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            border: 1px solid #e2e8f0; /* slate-200 */
            transition: all 0.2s ease;
        }
        .dashed-separator {
            position: relative;
            height: 1px;
            width: 100%;
            border-bottom: 2px dashed #cbd5e1; /* slate-300 */
            margin: 2rem 0;
        }
        
        .status-badge {
            width: 100%;
            padding: 1rem;
            border-radius: 0.75rem;
            font-weight: 700;
            font-size: 1.25rem;
            letter-spacing: 0.05em;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            border: 1px solid transparent;
            transition: all 0.3s ease;
        }
        .status-lulus {
            background-color: #f0fdf4; /* green-50 */
            color: #15803d; /* green-700 */
            border-color: #bcf0da; /* green-200 */
        }
        .status-tidak {
            background-color: #fef2f2; /* red-50 */
            color: #b91c1c; /* red-700 */
            border-color: #fecaca; /* red-200 */
        }
        .res-photo-container {
            position: relative;
            margin-bottom: 1.5rem;
        }
        .medal-badge {
            position: absolute;
            bottom: 0px;
            right: 0px;
            width: 2rem;
            height: 2rem;
            background: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 20;
            border: 2px solid #f8fafc;
        }
    </style>
@endpush

@section('content')
    <main class="min-h-screen py-12 flex items-center justify-center px-4 bg-slate-50 relative overflow-hidden">
        <!-- Landing View -->
        <div id="landing-view" class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-slate-100 p-8 transition-all duration-500 relative z-10">
            <header class="text-center mb-8">
                <div class="mx-auto flex items-center justify-center mb-4">
                    <img src="{{ asset('images/alternative/icon.png') }}" alt="Logo SMKN 1 Wringin" class="h-20 w-20 object-contain drop-shadow-sm">
                </div>
                <h1 class="text-2xl font-bold text-slate-800 uppercase tracking-tight">SMKN 1 WRINGIN</h1>
                <p class="text-slate-500 text-sm mt-1">Pengumuman Kelulusan {{ $graduationSetting->lulusan ?? '2026' }}</p>
            </header>

            <div class="relative">
                <label for="nisn-input" class="block text-xs font-semibold text-slate-600 mb-2 uppercase tracking-wide">Masukkan NISN</label>
                <input type="text" id="nisn-input" autocomplete="off" class="w-full bg-slate-50 border border-slate-300 rounded-lg px-4 py-3 text-slate-800 text-center text-xl tracking-widest focus:outline-none focus:border-brand-500 focus:ring-2 focus:ring-brand-500/20 transition-all mb-4 placeholder-slate-300 font-mono" placeholder="0000000000">
                
                <button id="submit-btn" class="w-full relative overflow-hidden bg-brand-600 hover:bg-brand-700 text-white font-bold py-3.5 rounded-lg transition-all duration-300 shadow-md">
                    <span class="relative z-10 flex items-center justify-center gap-2">
                        Periksa Hasil
                        <i class="fa-solid fa-arrow-right"></i>
                    </span>
                </button>

                <div id="error-msg" class="h-6 mt-3 text-center">
                    <p class="text-red-500 text-sm opacity-0 transform translate-y-2 transition-all font-medium">Data tidak ditemukan.</p>
                </div>
            </div>

            <div class="text-center mt-4 text-xs text-slate-500 font-mono">
                Contoh NISN: <span class="cursor-pointer hover:text-brand-600 font-medium transition" onclick="document.getElementById('nisn-input').value='0012345678'; document.getElementById('error-msg').querySelector('p').style.opacity = 0;">0012345678</span>
            </div>
        </div>

        <!-- Transition View -->
        <div id="transition-view" class="absolute inset-0 z-20 flex flex-col items-center justify-center opacity-0 bg-slate-50/90 backdrop-blur-sm hidden">
            <div class="w-64">
                <p class="text-brand-600 text-sm mb-3 text-center font-semibold animate-pulse tracking-wide uppercase">Memeriksa Data...</p>
                <div class="h-2 w-full bg-slate-200 rounded-full overflow-hidden">
                    <div id="progress-bar" class="h-full bg-brand-500 w-0 transition-all duration-150 ease-out"></div>
                </div>
            </div>
        </div>

        <!-- Result View -->
        <div id="result-view" class="absolute inset-0 z-30 flex flex-col items-center justify-center opacity-0 px-4 hidden py-12 result-formal-bg">
            <div id="result-actions" class="w-full max-w-md flex justify-start mb-4 opacity-0 relative z-40">
                <button id="btn-back" class="text-slate-600 hover:text-brand-600 text-sm font-semibold flex items-center gap-2 transition-colors bg-white px-4 py-2 rounded-lg shadow-sm border border-slate-200 hover:border-brand-300">
                    <i class="fa-solid fa-arrow-left"></i> Kembali
                </button>
            </div>
    
            <div id="result-card-container" class="w-full max-w-md relative z-30">
                <div id="result-card" class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden">
                    <div class="p-6 md:p-10 flex flex-col items-center">
                        <!-- Profile Section -->
                        <div class="res-photo-container">
                            <div class="relative">
                                <img id="res-photo" src="" alt="Student Photo" class="w-28 h-28 rounded-full object-cover border-4 border-slate-50 shadow-sm relative z-10">
                                <div id="medal-container" class="medal-badge">
                                    <div class="w-6 h-6 rounded-full bg-green-600 flex items-center justify-center text-white text-[10px]">
                                        <i class="fa-solid fa-medal"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-center mb-8">
                            <h2 id="res-nama" class="text-2xl font-bold text-slate-800 mb-1 uppercase tracking-tight">NAMA SISWA</h2>
                            <p class="text-slate-500 font-medium text-xs">Siswa Angkatan {{ $graduationSetting->angkatan ?? '2026' }}</p>
                        </div>
    
                        <!-- Info Grid -->
                        <div class="grid grid-cols-2 gap-4 w-full">
                            <div class="data-card">
                                <div class="w-8 h-8 rounded-lg bg-slate-50 flex items-center justify-center text-slate-400 mb-2">
                                    <i class="fa-solid fa-id-card"></i>
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
    
                        <!-- Status Section -->
                        <div class="w-full">
                            <div id="res-status-badge" class="status-badge uppercase">
                                STATUS
                            </div>
                            <div class="mt-4 text-center">
                                <p id="res-message" class="text-slate-500 text-sm font-medium leading-relaxed"></p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
    <script>
        const checkUrl = @json(route('graduation.check'));
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '';

        let currentStudent = null;

        const DOM = {
            landingView: document.getElementById('landing-view'),
            nisnInput: document.getElementById('nisn-input'),
            submitBtn: document.getElementById('submit-btn'),
            errorMsg: document.querySelector('#error-msg p'),
            transitionView: document.getElementById('transition-view'),
            progressBar: document.getElementById('progress-bar'),
            resultView: document.getElementById('result-view'),
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
        };

        function init() {
            setupEventListeners();
            gsap.from(DOM.landingView, { y: 20, opacity: 0, duration: 0.6, ease: "power2.out" });
        }

        function setupEventListeners() {
            DOM.submitBtn.addEventListener('click', handleCheckStatus);
            DOM.nisnInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') handleCheckStatus(); });
            DOM.nisnInput.addEventListener('input', () => {
                DOM.nisnInput.value = DOM.nisnInput.value.replace(/\D/g, '').slice(0, 10);
                gsap.to(DOM.errorMsg, { opacity: 0, y: 5, duration: 0.2 });
            });
            DOM.btnBack.addEventListener('click', resetToHome);
        }

        function setSubmitLoading(isLoading) {
            DOM.submitBtn.disabled = isLoading;
            DOM.submitBtn.innerHTML = isLoading
                ? '<span class="relative z-10 flex items-center justify-center gap-2"><i class="fa-solid fa-circle-notch fa-spin"></i> Memeriksa...</span>'
                : '<span class="relative z-10 flex items-center justify-center gap-2">Periksa Hasil <i class="fa-solid fa-arrow-right"></i></span>';
        }

        function handleApiError(statusCode, result) {
            if (statusCode === 429) {
                showError(result.message || 'Terlalu banyak percobaan. Coba lagi dalam 1 menit.');
                return;
            }

            if (statusCode === 422) {
                const firstError = result?.errors?.nisn?.[0] || result.message || 'Input tidak valid.';
                showError(firstError);
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
                startTransition();
            } catch (error) {
                showError('Gagal terhubung ke server. Silakan coba lagi.');
                setSubmitLoading(false);
            }
        }

        function showError(msg) {
            DOM.errorMsg.textContent = msg;
            gsap.to(DOM.errorMsg, { opacity: 1, y: 0, duration: 0.3, ease: "back.out(2)" });
        }

        function startTransition() {
            const tl = gsap.timeline({ onComplete: showResult });
            tl.to(DOM.landingView, { scale: 0.95, opacity: 0, duration: 0.3, ease: "power2.inOut" })
              .set(DOM.landingView, { display: 'none' })
              .set(DOM.transitionView, { display: 'flex' })
              .to(DOM.transitionView, { opacity: 1, duration: 0.2 })
              .to(DOM.progressBar, { width: "100%", duration: 1.0, ease: "power1.inOut" })
              .to(DOM.transitionView, { opacity: 0, duration: 0.3 });
        }

        function showResult() {
            DOM.resPhoto.src = currentStudent.photo;
            DOM.resNama.textContent = currentStudent.nama;
            DOM.resNisn.textContent = currentStudent.nisn;
            DOM.resKelas.textContent = currentStudent.kelas;
            
            const status = String(currentStudent.status || '').toUpperCase();
            if (status === 'LULUS') {
                DOM.resStatusBadge.innerHTML = '<i class="fa-solid fa-circle-check"></i> <span>LULUS</span>';
                DOM.resStatusBadge.className = "status-badge status-lulus";
                DOM.resMessage.textContent = "Selamat! Anda dinyatakan LULUS. Teruslah berprestasi dan jadilah kebanggaan sekolah serta keluarga.";
                DOM.medalContainer.style.display = 'flex';
                setTimeout(fireConfetti, 300);
            } else if (status === 'TIDAK LULUS') {
                DOM.resStatusBadge.innerHTML = '<i class="fa-solid fa-circle-xmark"></i> <span>TIDAK LULUS</span>';
                DOM.resStatusBadge.className = "status-badge status-tidak";
                DOM.resMessage.textContent = "Jangan berkecil hati. Tetap semangat dan jangan menyerah untuk masa depanmu.";
                DOM.medalContainer.style.display = 'none';
            } else {
                DOM.resStatusBadge.innerHTML = '<i class="fa-solid fa-circle-info"></i> <span>BELUM ADA</span>';
                DOM.resStatusBadge.className = "status-badge bg-slate-50 text-slate-600 border-slate-200";
                DOM.resMessage.textContent = "Status kelulusan Anda belum tersedia. Silakan hubungi pihak sekolah.";
                DOM.medalContainer.style.display = 'none';
            }

            DOM.transitionView.style.display = 'none';
            DOM.progressBar.style.width = '0%';
            DOM.resultView.classList.remove('hidden');
            
            gsap.timeline()
                .set(DOM.resultView, { opacity: 1 })
                .fromTo(DOM.resultCardContainer, { scale: 0.9, opacity: 0, y: 20 }, { scale: 1, opacity: 1, y: 0, duration: 0.5, ease: "back.out(1.2)" })
                .to(DOM.resultActions, { opacity: 1, duration: 0.3 }, "-=0.2");
        }

        function fireConfetti() {
            const duration = 3 * 1000;
            const end = Date.now() + duration;
            // Palette warna-warni yang lebih lengkap dan ceria
            const colors = [
                '#ff0000', '#00ff00', '#0000ff', '#ffff00', '#ff00ff', '#00ffff', // Basic vibrant
                '#f43f5e', '#fb923c', '#facc15', '#4ade80', '#2dd4bf', '#38bdf8', '#818cf8', '#a78bfa', '#fb7185' // Tailwind-style
            ];

            (function frame() {
                confetti({
                    particleCount: 2, // Dikurangi agar tidak terlalu padat
                    startVelocity: 15, // Ditambah agar dorongan awal ke bawah lebih cepat
                    angle: 270, 
                    ticks: 1000, 
                    origin: { 
                        x: Math.random(), 
                        y: Math.random() * 0.2 - 0.2 
                    },
                    colors: colors,
                    gravity: Math.random() * 0.5 + 1.2, // Gravitasi ditambah agar jatuh lebih cepat
                    scalar: Math.random() * 0.5 + 0.7, 
                    drift: Math.random() * 1.5 - 0.75, // Dikurangi sedikit agar lebih lurus jatuhnya
                    zIndex: 9999
                });

                if (Date.now() < end) {
                    requestAnimationFrame(frame);
                }
            }());
        }

        function resetToHome() {
            gsap.to(DOM.resultView, { opacity: 0, duration: 0.3, onComplete: () => {
                DOM.resultView.classList.add('hidden');
                DOM.landingView.style.display = 'block';
                gsap.fromTo(DOM.landingView, { scale: 0.95, opacity: 0 }, { opacity: 1, scale: 1, duration: 0.4 });
                DOM.nisnInput.value = '';
                setSubmitLoading(false);
                currentStudent = null;
            }});
        }

        window.addEventListener('load', init);
    </script>
    @endpush
@endsection
