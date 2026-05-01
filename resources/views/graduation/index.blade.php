<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Kelulusan SMKN 1 Wringin</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- GSAP for Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>
    
    <!-- Canvas Confetti -->
    <script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
    
    <!-- html2canvas for Download feature -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&family=Space+Mono&display=swap" rel="stylesheet">

    <style>
        html, body {
            width: 100%;
            height: 100%;
            height: 100svh;
            height: 100dvh;
            margin: 0;
            padding: 0;
            overflow: hidden;
            position: fixed;
            overscroll-behavior: none;
            -webkit-overflow-scrolling: touch;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: #020617; /* Deep Space Black */
            color: #f8fafc;
        }

        .font-mono {
            font-family: 'Space Mono', monospace;
        }

        /* Fallback for layout if Tailwind fails */
        .flex { display: flex; }
        .flex-col { flex-direction: column; }
        .items-center { align-items: center; }
        .justify-center { justify-content: center; }
        .relative { position: relative; }
        .absolute { position: absolute; }
        .inset-0 { top: 0; right: 0; bottom: 0; left: 0; }
        .w-full { width: 100%; }
        .h-screen { height: 100vh; }

        .full-viewport {
            width: 100vw;
            height: 100vh;
            height: 100svh;
            height: 100dvh;
        }

        /* 3D Perspective Container for Tilt Effect */
        .perspective-1000 {
            perspective: 1000px;
        }
        
        .transform-style-3d {
            transform-style: preserve-3d;
        }

        /* Custom Scrollbar for hidden elements */
        ::-webkit-scrollbar { width: 0px; background: transparent; }

        /* Result Card Layout Utilities */
        .info-row {
            display: flex;
            justify-content: space-between;
            padding-bottom: 0.5rem;
            margin-bottom: 0.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }
        .info-row:last-child {
            border-bottom: none;
            margin-bottom: 0;
            padding-bottom: 0;
        }
        .info-label {
            color: #94a3b8;
            font-size: 0.75rem;
        }
        .info-value {
            font-weight: 600;
            text-align: right;
            font-size: 0.75rem;
        }

        /* Space Elements */
        .star {
            position: absolute;
            background: white;
            border-radius: 50%;
            pointer-events: none;
        }

        .nebula {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.15;
            pointer-events: none;
            z-index: -1;
        }

        .shooting-star {
            position: absolute;
            width: 2px;
            height: 2px;
            background: linear-gradient(90deg, white, transparent);
            border-radius: 50%;
            pointer-events: none;
            z-index: 5;
            opacity: 0;
        }

        /* Warning for non-HTTPS */
        #https-warning {
            position: fixed;
            bottom: 10px;
            left: 10px;
            right: 10px;
            background: rgba(185, 28, 28, 0.9);
            color: white;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 11px;
            z-index: 100;
            display: none;
            text-align: center;
        }

        @keyframes sweep {
            0% { transform: translateX(-100%); }
            100% { transform: translateX(200%); }
        }
    </style>
</head>
<body class="relative overflow-hidden full-viewport">

    <!-- Ambient Background Layer -->
    <div id="bg-layer" class="absolute inset-0 bg-slate-950 transition-colors duration-1000 ease-in-out"></div>
    
    <!-- Particles/Stars Container -->
    <div id="particles" class="absolute inset-0 pointer-events-none z-0"></div>

    <!-- HTTPS Warning -->
    <div id="https-warning">
        ⚠️ Sensor Gyro membutuhkan koneksi HTTPS untuk bekerja di perangkat mobile.
    </div>

    <!-- 1. Page Structure -->
    <div class="relative flex flex-col z-10 full-viewport">
        
        <!-- HEADER SECTION -->
        <header id="page-header" class="w-full py-4 md:py-8 px-4 flex-shrink-0">
            <div class="text-center">
                <div id="logo-anim" class="w-14 h-14 md:w-20 md:h-20 mx-auto bg-white/10 rounded-full flex items-center justify-center mb-3 border border-white/20 shadow-[0_0_30px_rgba(255,255,255,0.1)]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 md:h-10 md:w-10 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z" />
                    </svg>
                </div>
                <h1 id="title-anim" class="text-xl md:text-3xl font-bold tracking-tight bg-clip-text text-transparent bg-gradient-to-r from-white to-gray-400 uppercase">SMKN 1 WRINGIN</h1>
                <p id="subtitle-anim" class="text-gray-400 text-xs md:text-sm font-light tracking-widest">Pengumuman Kelulusan 2026</p>
            </div>
        </header>

        <!-- MAIN CONTENT AREA -->
        <main class="flex-grow w-full relative overflow-hidden flex items-center justify-center px-4 pb-12">
            
            <!-- Landing View -->
            <div id="landing-view" class="w-full max-w-md transition-all duration-500">
                <div id="form-container" class="bg-white/5 backdrop-blur-md border border-white/10 rounded-2xl p-6 shadow-2xl relative overflow-hidden">
                    <div class="absolute -top-10 -left-10 w-32 h-32 bg-blue-500/20 rounded-full blur-3xl"></div>
                    <div class="absolute -bottom-10 -right-10 w-32 h-32 bg-purple-500/20 rounded-full blur-3xl"></div>

                    <div class="relative z-10">
                        <label for="nisn-input" class="block text-[10px] uppercase tracking-[0.2em] text-gray-400 mb-3 font-semibold text-center">Masukkan NISN Peserta Didik</label>
                        <input type="text" id="nisn-input" autocomplete="off" class="w-full bg-black/40 border border-white/20 rounded-lg px-4 py-3 text-white font-mono text-center text-xl tracking-widest focus:outline-none focus:border-blue-400 focus:ring-1 focus:ring-blue-400 transition-all mb-4 placeholder-gray-700" placeholder="0000000000">
                        
                        <button id="submit-btn" class="w-full relative group overflow-hidden bg-blue-600/80 hover:bg-blue-500 text-white font-bold py-4 rounded-lg transition-all duration-300 border border-blue-400/50">
                            <span class="relative z-10 flex items-center justify-center gap-2 tracking-widest text-sm uppercase">
                                Periksa Hasil
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </span>
                            <div class="absolute inset-0 h-full w-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[sweep_1s_ease-in-out_infinite]"></div>
                        </button>

                        <div id="error-msg" class="h-6 mt-3 text-center">
                            <p class="text-red-400 text-xs opacity-0 transform translate-y-2 transition-all font-medium">Data tidak ditemukan.</p>
                        </div>
                    </div>
                </div>

                <div class="text-center mt-6 text-[9px] text-gray-500 font-mono tracking-tighter">
                    MOCK: <span class="cursor-pointer hover:text-white" onclick="document.getElementById('nisn-input').value='0012345678'">0012345678 (LULUS)</span> | <span class="cursor-pointer hover:text-white" onclick="document.getElementById('nisn-input').value='0087654321'">0087654321 (TIDAK)</span>
                </div>
            </div>

            <!-- Transition View (Cinematic Scan) -->
            <div id="transition-view" class="absolute inset-0 z-20 flex flex-col items-center justify-center pointer-events-none opacity-0 bg-black/40 backdrop-blur-sm hidden">
                <div id="scanline" class="absolute top-0 left-0 w-full h-[2px] bg-blue-400 shadow-[0_0_20px_4px_#60a5fa] opacity-0"></div>
                <div class="w-64">
                    <p id="loading-text" class="text-blue-400 text-[10px] mb-3 text-center tracking-[0.4em] font-mono font-bold animate-pulse uppercase">Otentikasi Data...</p>
                    <div class="h-1 w-full bg-gray-800 rounded-full overflow-hidden">
                        <div id="progress-bar" class="h-full bg-blue-500 w-0"></div>
                    </div>
                </div>
            </div>

            <!-- Result View -->
            <div id="result-view" class="absolute inset-0 z-30 flex flex-col items-center justify-center pointer-events-none opacity-0 px-4 perspective-1000 hidden">
                
                <div id="result-actions" class="w-full max-w-md flex justify-between items-center mb-4 opacity-0">
                    <button id="btn-back" class="text-gray-400 hover:text-white text-[10px] uppercase tracking-widest flex items-center gap-2 transition-colors pointer-events-auto">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
                        Kembali
                    </button>
                    <button id="btn-download" class="bg-white/10 hover:bg-white/20 border border-white/10 text-white text-[10px] uppercase tracking-widest py-2 px-4 rounded-md flex items-center gap-2 transition-colors pointer-events-auto backdrop-blur-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                        Simpan Kartu
                    </button>
                </div>

                <div id="result-card-container" class="w-full max-w-sm transform-style-3d pointer-events-auto">
                    <div id="result-card" class="bg-white/10 backdrop-blur-xl border border-white/20 p-1 rounded-2xl shadow-2xl relative overflow-hidden">
                        <div class="bg-slate-950/80 rounded-[14px] p-6 relative z-10 h-full flex flex-col">
                            <div class="flex flex-col items-center mb-5">
                                <div class="relative mb-3">
                                    <div id="res-photo-ring" class="absolute inset-[-4px] rounded-full border-2 border-dashed border-cyan-400 animate-[spin_10s_linear_infinite]"></div>
                                    <img id="res-photo" src="" alt="Student Photo" class="w-20 h-20 rounded-full object-cover border-2 border-white/20 bg-gray-900 shadow-lg relative z-10">
                                </div>
                                <h2 id="res-nama" class="text-base font-bold text-center text-white mb-0.5 uppercase tracking-wide">Nama Siswa</h2>
                                <p id="res-nisn" class="text-gray-400 font-mono text-[10px]">NISN: 0000000000</p>
                            </div>

                            <div class="flex-grow space-y-2 mb-6 bg-black/30 p-4 rounded-xl border border-white/5">
                                <div class="info-row">
                                    <span class="info-label">Program Keahlian</span>
                                    <span id="res-jurusan" class="info-value">Jurusan</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Kelas</span>
                                    <span id="res-kelas" class="info-value">XII</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-label">Tempat, Tgl Lahir</span>
                                    <span id="res-ttl" class="info-value">Tempat, Tanggal</span>
                                </div>
                            </div>

                            <div class="mt-auto flex flex-col items-center">
                                <p class="text-[9px] text-gray-500 mb-2 uppercase tracking-[0.3em] font-semibold">Status Kelulusan</p>
                                <div id="res-status-badge" class="w-full py-3 rounded-lg text-center font-bold text-base tracking-[0.4em] border shadow-lg transition-all uppercase">
                                    STATUS
                                </div>
                            </div>
                        </div>
                        <div id="card-shine" class="absolute inset-0 bg-gradient-to-tr from-white/0 via-white/10 to-white/0 opacity-0 pointer-events-none rounded-2xl"></div>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <script>
        const studentData = {
            "0012345678": {
                nama: "Ahmad Budi Santoso",
                nisn: "0012345678",
                jurusan: "Rekayasa Perangkat Lunak",
                kelas: "XII RPL 1",
                ttl: "Bondowoso, 15 Mei 2008",
                status: "LULUS",
                photo: "https://ui-avatars.com/api/?name=Ahmad+Budi&background=0D8ABC&color=fff&size=200&font-size=0.33"
            },
            "0087654321": {
                nama: "Siti Aminah Wijaya",
                nisn: "0087654321",
                jurusan: "Teknik Komputer & Jaringan",
                kelas: "XII TKJ 2",
                ttl: "Wringin, 10 Agustus 2007",
                status: "BELUM LULUS",
                photo: "https://ui-avatars.com/api/?name=Siti+Aminah&background=b91c1c&color=fff&size=200&font-size=0.33"
            }
        };

        let currentStudent = null;

        const DOM = {
            bgLayer: document.getElementById('bg-layer'),
            particles: document.getElementById('particles'),
            landingView: document.getElementById('landing-view'),
            formContainer: document.getElementById('form-container'),
            nisnInput: document.getElementById('nisn-input'),
            submitBtn: document.getElementById('submit-btn'),
            errorMsg: document.querySelector('#error-msg p'),
            transitionView: document.getElementById('transition-view'),
            scanline: document.getElementById('scanline'),
            progressBar: document.getElementById('progress-bar'),
            loadingText: document.getElementById('loading-text'),
            resultView: document.getElementById('result-view'),
            resultActions: document.getElementById('result-actions'),
            resultCardContainer: document.getElementById('result-card-container'),
            resultCard: document.getElementById('result-card'),
            cardShine: document.getElementById('card-shine'),
            btnBack: document.getElementById('btn-back'),
            btnDownload: document.getElementById('btn-download'),
            resPhotoRing: document.getElementById('res-photo-ring'),
            resPhoto: document.getElementById('res-photo'),
            resNama: document.getElementById('res-nama'),
            resNisn: document.getElementById('res-nisn'),
            resJurusan: document.getElementById('res-jurusan'),
            resKelas: document.getElementById('res-kelas'),
            resTtl: document.getElementById('res-ttl'),
            resStatusBadge: document.getElementById('res-status-badge'),
            logoAnim: document.getElementById('logo-anim'),
            titleAnim: document.getElementById('title-anim'),
            subtitleAnim: document.getElementById('subtitle-anim'),
        };

        function init() {
            initStarfield();
            initialEntranceAnimation();
            setupEventListeners();

            if (window.innerWidth < 768 && window.location.protocol !== 'https:' && window.location.hostname !== 'localhost') {
                document.getElementById('https-warning').style.display = 'block';
            }
        }

        function initStarfield() {
            const container = DOM.particles;
            const starCount = 150;
            const colors = ['#4f46e5', '#7c3aed', '#2563eb'];
            
            for (let i = 0; i < 3; i++) {
                const nebula = document.createElement('div');
                nebula.className = 'nebula';
                const size = randomInRange(300, 600);
                gsap.set(nebula, {
                    width: size, height: size,
                    x: randomInRange(0, window.innerWidth - size),
                    y: randomInRange(0, window.innerHeight - size),
                    backgroundColor: colors[i % colors.length]
                });
                container.appendChild(nebula);
                gsap.to(nebula, { x: "+=" + randomInRange(-50, 50), y: "+=" + randomInRange(-50, 50), duration: randomInRange(20, 40), repeat: -1, yoyo: true, ease: "sine.inOut" });
            }

            for (let i = 0; i < starCount; i++) {
                const star = document.createElement('div');
                star.className = 'star';
                const size = Math.random() * 2 + 0.5;
                gsap.set(star, { width: size, height: size, x: Math.random() * window.innerWidth, y: Math.random() * window.innerHeight, opacity: randomInRange(0.1, 0.8) });
                container.appendChild(star);
                gsap.to(star, { opacity: randomInRange(0.1, 1), duration: randomInRange(1, 4), repeat: -1, yoyo: true, ease: "sine.inOut", delay: Math.random() * 5 });
            }
            setInterval(spawnShootingStar, 4000);
        }

        function spawnShootingStar() {
            const container = DOM.particles;
            const star = document.createElement('div');
            star.className = 'shooting-star';
            const x = Math.random() * window.innerWidth;
            const y = Math.random() * (window.innerHeight / 2);
            gsap.set(star, { x: x, y: y, width: randomInRange(80, 150), rotation: 20, opacity: 0 });
            container.appendChild(star);
            gsap.timeline({ onComplete: () => star.remove() })
                .to(star, { opacity: 0.8, duration: 0.1 })
                .to(star, { x: x + 400, y: y + 200, opacity: 0, duration: 0.8, ease: "power2.out" });
        }

        function randomInRange(min, max) {
            return Math.random() * (max - min) + min;
        }

        function initialEntranceAnimation() {
            const tl = gsap.timeline();
            tl.from(DOM.logoAnim, { y: -20, opacity: 0, duration: 0.8, ease: "back.out(1.5)" })
              .from([DOM.titleAnim, DOM.subtitleAnim], { y: 10, opacity: 0, duration: 0.6, stagger: 0.1 }, "-=0.4")
              .from(DOM.formContainer, { scale: 0.95, opacity: 0, duration: 0.8, ease: "power2.out" }, "-=0.2");
        }

        function setupEventListeners() {
            DOM.submitBtn.addEventListener('click', handleCheckStatus);
            DOM.nisnInput.addEventListener('keypress', (e) => { if (e.key === 'Enter') handleCheckStatus(); });
            DOM.nisnInput.addEventListener('input', () => { gsap.to(DOM.errorMsg, { opacity: 0, y: 5, duration: 0.2 }); });
            DOM.btnBack.addEventListener('click', resetToHome);
            DOM.btnDownload.addEventListener('click', downloadResult);
            DOM.resultView.addEventListener('mousemove', handleTilt);
            DOM.resultView.addEventListener('mouseleave', resetTilt);
            window.addEventListener('deviceorientation', handleOrientation);
        }

        function handleTilt(e) {
            if (window.innerWidth < 768) return;
            const rect = DOM.resultCard.getBoundingClientRect();
            const x = e.clientX - rect.left - rect.width / 2;
            const y = e.clientY - rect.top - rect.height / 2;
            gsap.to(DOM.resultCard, { rotationX: (-y / rect.height) * 15, rotationY: (x / rect.width) * 15, duration: 0.4, ease: 'power1.out', transformPerspective: 1000 });
            const mouseXPercent = ((e.clientX - rect.left) / rect.width) * 100;
            const mouseYPercent = ((e.clientY - rect.top) / rect.height) * 100;
            gsap.to(DOM.cardShine, { opacity: 0.6, background: `radial-gradient(circle at ${mouseXPercent}% ${mouseYPercent}%, rgba(255,255,255,0.2) 0%, transparent 60%)`, duration: 0.1 });
        }

        function resetTilt() {
            gsap.to(DOM.resultCard, { rotationX: 0, rotationY: 0, duration: 0.8, ease: 'elastic.out(1, 0.5)' });
            gsap.to(DOM.cardShine, { opacity: 0, duration: 0.5 });
        }

        function handleOrientation(e) {
            if (window.innerWidth >= 768) return;
            let beta = e.beta; let gamma = e.gamma;
            if (beta === null || gamma === null) return;
            let xRotate = Math.max(-15, Math.min(15, (beta - 45) * 0.4));
            let yRotate = Math.max(-15, Math.min(15, gamma * 0.4));
            gsap.to(DOM.resultCard, { rotationX: xRotate, rotationY: yRotate, duration: 0.8, ease: 'power1.out', transformPerspective: 1000 });
            gsap.to(DOM.cardShine, { opacity: 0.5, background: `radial-gradient(circle at ${50 + (gamma / 45) * 50}% ${50 + ((beta - 45) / 45) * 50}%, rgba(255,255,255,0.15) 0%, transparent 60%)`, duration: 0.5 });
        }

        async function handleCheckStatus() {
            const nisn = DOM.nisnInput.value.trim();
            if (!nisn) { showError("NISN tidak boleh kosong."); return; }
            if (window.innerWidth < 768 && typeof DeviceOrientationEvent !== 'undefined' && typeof DeviceOrientationEvent.requestPermission === 'function') {
                try { await DeviceOrientationEvent.requestPermission(); } catch (e) {}
            }
            DOM.submitBtn.disabled = true;
            DOM.submitBtn.querySelector('span').innerHTML = 'Memeriksa...';
            setTimeout(() => {
                if (studentData[nisn]) { currentStudent = studentData[nisn]; startTransition(); }
                else { showError("Data tidak ditemukan."); DOM.submitBtn.disabled = false; DOM.submitBtn.querySelector('span').innerHTML = 'Periksa Hasil'; }
            }, 800);
        }

        function startTransition() {
            const tl = gsap.timeline({ onComplete: showResult });
            tl.to(DOM.landingView, { scale: 0.9, opacity: 0, duration: 0.4, ease: "power2.inOut" })
              .set(DOM.landingView, { display: 'none' })
              .set(DOM.transitionView, { display: 'flex' })
              .to(DOM.transitionView, { opacity: 1, duration: 0.2 })
              .to(DOM.scanline, { opacity: 1, top: "100%", duration: 1.5, ease: "linear" })
              .to(DOM.progressBar, { width: "100%", duration: 1.5, ease: "power1.inOut" }, "<")
              .to(DOM.transitionView, { opacity: 0, duration: 0.3 });
        }

        function showResult() {
            DOM.resPhoto.src = currentStudent.photo;
            DOM.resNama.textContent = currentStudent.nama;
            DOM.resNisn.textContent = `NISN: ${currentStudent.nisn}`;
            DOM.resJurusan.textContent = currentStudent.jurusan;
            DOM.resKelas.textContent = currentStudent.kelas;
            DOM.resTtl.textContent = currentStudent.ttl;

            const isLulus = currentStudent.status === "LULUS";
            if (isLulus) {
                DOM.resStatusBadge.textContent = "LULUS";
                DOM.resStatusBadge.className = "w-full py-3 rounded-lg text-center font-bold text-base tracking-[0.4em] border shadow-[0_0_20px_rgba(59,130,246,0.4)] bg-gradient-to-r from-blue-700 to-indigo-600 border-blue-400 text-white";
                DOM.resPhotoRing.className = "absolute inset-[-4px] rounded-full border-2 border-dashed border-cyan-400 animate-[spin_10s_linear_infinite]";
                setTimeout(fireConfetti, 500);
            } else {
                DOM.resStatusBadge.textContent = "BELUM LULUS";
                DOM.resStatusBadge.className = "w-full py-3 rounded-lg text-center font-bold text-base tracking-[0.2em] border shadow-lg bg-gray-900 border-gray-700 text-gray-500";
                DOM.resPhotoRing.className = "absolute inset-[-4px] rounded-full border-2 border-dashed border-red-900 animate-[spin_10s_linear_infinite]";
            }

            DOM.transitionView.style.display = 'none';
            DOM.resultView.classList.remove('hidden');
            gsap.timeline()
                .set(DOM.resultView, { opacity: 1 })
                .fromTo(DOM.resultCardContainer, { scale: 0.8, opacity: 0, y: 30 }, { scale: 1, opacity: 1, y: 0, duration: 0.8, ease: "back.out(1.2)" })
                .to(DOM.resultActions, { opacity: 1, duration: 0.4 }, "-=0.4");
        }

        function fireConfetti() {
            const duration = 6 * 1000;
            const end = Date.now() + duration;
            const interval = setInterval(() => {
                if (Date.now() > end) return clearInterval(interval);
                confetti({ particleCount: 10, startVelocity: 30, spread: 360, ticks: 200, origin: { x: Math.random(), y: -0.2 }, zIndex: 9999 });
            }, 100);
        }

        function resetToHome() {
            gsap.to(DOM.resultView, { opacity: 0, duration: 0.3, onComplete: () => {
                DOM.resultView.classList.add('hidden');
                DOM.landingView.style.display = 'block';
                gsap.to(DOM.landingView, { opacity: 1, scale: 1, duration: 0.4 });
                DOM.nisnInput.value = '';
                DOM.submitBtn.disabled = false;
                DOM.submitBtn.querySelector('span').innerHTML = 'Periksa Hasil';
            }});
        }

        function downloadResult() {
            const btn = DOM.btnDownload;
            btn.innerHTML = 'Proses...';
            btn.disabled = true;
            gsap.set(DOM.resultCard, { rotationX: 0, rotationY: 0 });
            setTimeout(() => {
                html2canvas(DOM.resultCard, { backgroundColor: null, scale: 2, useCORS: true }).then(canvas => {
                    const link = document.createElement('a');
                    link.download = `PENGUMUMAN_${currentStudent.nisn}.png`;
                    link.href = canvas.toDataURL();
                    link.click();
                    btn.innerHTML = 'Simpan Kartu';
                    btn.disabled = false;
                });
            }, 200);
        }

        window.onload = init;
    </script>
</body>
</html>
