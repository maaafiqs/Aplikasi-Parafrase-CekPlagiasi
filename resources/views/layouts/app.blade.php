<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TulCek (Tulis dan Cek) — Toolkit Profesional Karir & Teks')</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/TulCek Blue.png') }}">
    
    <!-- Google Fonts: Plus Jakarta Sans & JetBrains Mono -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS (via Vite) & Lucide Icons -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://unpkg.com/lucide@latest"></script>
    
    <!-- SweetAlert2 for premium popup alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @stack('scripts-top')

    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-attachment: fixed;
        }
        .code-font {
            font-family: 'JetBrains Mono', monospace;
        }
        /* Custom scrollbar for textarea & lists */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: rgba(0, 0, 0, 0.05);
            border-radius: 99px;
        }
        .dark ::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.02);
        }
        ::-webkit-scrollbar-thumb {
            background: rgba(0, 0, 0, 0.15);
            border-radius: 99px;
        }
        .dark ::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
        }
        ::-webkit-scrollbar-thumb:hover {
            background: rgba(0, 0, 0, 0.25);
        }
        .dark ::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.2);
        }
        /* SweetAlert2 Theme Overrides matching the app design */
        .swal2-popup {
            font-family: 'Plus Jakarta Sans', sans-serif !important;
            border-radius: 1.25rem !important;
            background: #ffffff !important;
            color: #1e293b !important; /* slate-800 */
            border: 1px solid #e2e8f0 !important; /* slate-200 */
            box-shadow: 0 20px 25px -5px rgb(0 0 0 / 0.1), 0 8px 10px -6px rgb(0 0 0 / 0.1) !important;
        }
        .dark .swal2-popup {
            background: #18181b !important; /* zinc-900 */
            color: #f4f4f5 !important; /* zinc-100 */
            border: 1px solid #27272a !important; /* zinc-800 */
            box-shadow: 0 25px 50px -12px rgb(0 0 0 / 0.5) !important;
        }
        .swal2-title {
            color: #0f172a !important; /* slate-900 */
            font-weight: 700 !important;
        }
        .dark .swal2-title {
            color: #ffffff !important;
        }
        .swal2-html-container {
            color: #64748b !important; /* slate-500 */
        }
        .dark .swal2-html-container {
            color: #a1a1aa !important; /* zinc-400 */
        }
        
        @stack('styles')
    </style>
</head>
<body class="bg-slate-50 dark:bg-zinc-950 text-slate-800 dark:text-zinc-100 min-h-screen transition-colors duration-300 relative overflow-x-hidden">

    <!-- Decorative Gradients -->
    <div class="absolute top-0 left-1/4 w-[500px] h-[500px] bg-indigo-500/10 dark:bg-indigo-600/5 rounded-full blur-[120px] pointer-events-none -translate-x-1/2 -translate-y-1/2"></div>
    <div class="absolute top-1/3 right-0 w-[400px] h-[400px] bg-emerald-500/10 dark:bg-emerald-600/5 rounded-full blur-[100px] pointer-events-none translate-x-1/2"></div>
    <div class="absolute bottom-0 left-1/3 w-[600px] h-[600px] bg-violet-500/10 dark:bg-violet-600/5 rounded-full blur-[150px] pointer-events-none translate-y-1/3"></div>

    <div class="max-w-7xl mx-auto px-3.5 sm:px-6 lg:px-8 py-4 sm:py-8 relative z-10 flex flex-col min-h-screen justify-between">
        
        <!-- Header Section -->
        <header class="relative z-50 flex items-center justify-between mb-6 sm:mb-8 border-b border-slate-200/60 dark:border-zinc-800/60 pb-4 sm:pb-6 gap-2 sm:gap-4">
            <a href="{{ url('/') }}" class="flex items-center gap-2.5 sm:gap-3 group min-w-0">
                <div class="w-9 h-9 sm:w-10 sm:h-10 flex items-center justify-center flex-shrink-0 group-hover:scale-105 transition-transform">
                    <img src="{{ asset('images/TulCek Blue.png') }}" alt="TulCek Logo" class="w-9 h-9 sm:w-10 sm:h-10 object-contain dark:hidden">
                    <img src="{{ asset('images/TulCek White.png') }}" alt="TulCek Logo" class="w-9 h-9 sm:w-10 sm:h-10 object-contain hidden dark:block">
                </div>
                <div class="min-w-0">
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <span class="text-base sm:text-xl font-bold tracking-tight text-slate-900 dark:text-white">TulCek</span>
                        <span class="text-xs font-medium text-slate-400 dark:text-zinc-500 hidden md:inline">(Tulis dan Cek)</span>
                        <button type="button" id="btnChangelog" class="text-[10px] font-semibold bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 px-1.5 sm:px-2 py-0.5 rounded-full uppercase tracking-wider hover:bg-emerald-200 dark:hover:bg-emerald-900 transition-all cursor-pointer border-none shadow-sm hover:-translate-y-0.5 flex-shrink-0">v1.4</button>
                    </div>
                    <p class="text-[10px] sm:text-xs text-slate-500 dark:text-zinc-400 truncate">Toolkit Profesional Karir & Teks</p>
                </div>
            </a>
            
            <!-- Navbar Controls (Menu Alat & Theme Toggle unified) -->
            <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                <!-- Dropdown Menu -->
                <div class="relative" id="navDropdownContainer">
                    <button type="button" id="navDropdownBtn" class="flex items-center gap-1.5 sm:gap-2 px-3 sm:px-4 py-2 sm:py-2.5 rounded-xl text-xs sm:text-sm font-semibold bg-white dark:bg-zinc-900 border border-slate-200/60 dark:border-zinc-800/60 text-slate-700 dark:text-zinc-200 hover:bg-slate-50 dark:hover:bg-zinc-800 transition-all shadow-sm active:scale-95 cursor-pointer">
                        <i data-lucide="layout-grid" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-indigo-500 dark:text-emerald-400"></i>
                        <span>Menu Alat</span>
                        <i id="navChevron" data-lucide="chevron-down" class="w-3.5 h-3.5 sm:w-4 sm:h-4 opacity-50 transition-transform duration-200"></i>
                    </button>
                    
                    <nav id="navMenu" class="absolute top-full right-0 mt-2 w-56 sm:w-60 bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 rounded-2xl shadow-xl overflow-hidden hidden flex-col z-50 p-2">
                        <a href="{{ url('/') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2.5 transition-all {{ request()->is('/') ? 'bg-indigo-50 dark:bg-zinc-800/80 text-indigo-600 dark:text-emerald-400' : 'text-slate-600 hover:bg-slate-50 dark:text-zinc-400 dark:hover:bg-zinc-800/50' }}">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            Analisis Teks
                        </a>
                        <a href="{{ url('/surat-lamaran') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2.5 transition-all {{ request()->is('surat-lamaran') ? 'bg-indigo-50 dark:bg-zinc-800/80 text-indigo-600 dark:text-emerald-400' : 'text-slate-600 hover:bg-slate-50 dark:text-zinc-400 dark:hover:bg-zinc-800/50' }}">
                            <i data-lucide="mail" class="w-4 h-4"></i>
                            Surat Lamaran
                        </a>
                        <a href="{{ url('/parafrase') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2.5 transition-all {{ request()->is('parafrase') ? 'bg-indigo-50 dark:bg-zinc-800/80 text-indigo-600 dark:text-emerald-400' : 'text-slate-600 hover:bg-slate-50 dark:text-zinc-400 dark:hover:bg-zinc-800/50' }}">
                            <i data-lucide="repeat" class="w-4 h-4"></i>
                            Parafrase Teks
                        </a>
                        <a href="{{ url('/cv-ats') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2.5 transition-all {{ request()->is('cv-ats') ? 'bg-indigo-50 dark:bg-zinc-800/80 text-indigo-600 dark:text-emerald-400' : 'text-slate-600 hover:bg-slate-50 dark:text-zinc-400 dark:hover:bg-zinc-800/50' }}">
                            <i data-lucide="user-check" class="w-4 h-4"></i>
                            Buat CV ATS
                        </a>
                        <a href="{{ url('/ats-checker') }}" class="px-3.5 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2.5 transition-all {{ request()->is('ats-checker') ? 'bg-indigo-50 dark:bg-zinc-800/80 text-indigo-600 dark:text-emerald-400' : 'text-slate-600 hover:bg-slate-50 dark:text-zinc-400 dark:hover:bg-zinc-800/50' }}">
                            <i data-lucide="check-circle" class="w-4 h-4"></i>
                            ATS Checker
                        </a>

                        <!-- Coming Soon Menu -->
                        <div class="px-3.5 py-2.5 rounded-xl text-xs font-semibold flex items-center justify-between gap-2 transition-all text-slate-400 dark:text-zinc-500 cursor-not-allowed opacity-80 bg-slate-50/50 dark:bg-zinc-900/30" title="Fitur sedang dalam tahap pengembangan">
                            <div class="flex items-center gap-2">
                                <i data-lucide="shield-alert" class="w-4 h-4"></i>
                                Cek Plagiasi
                            </div>
                            <span class="text-[9px] px-1.5 py-0.5 rounded-md bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 font-bold uppercase tracking-wider">Segera</span>
                        </div>
                        
                        <div class="h-px bg-slate-100 dark:bg-zinc-800 my-1"></div>
                        <button type="button" id="btnChangelogMenu" class="w-full text-left px-3.5 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2.5 transition-all text-slate-600 hover:bg-slate-50 dark:text-zinc-400 dark:hover:bg-zinc-800/50 cursor-pointer">
                            <i data-lucide="history" class="w-4 h-4"></i>
                            Riwayat Versi (v1.4)
                        </button>
                    </nav>
                </div>

                <!-- Theme Toggle Button -->
                <button type="button" id="themeToggle" aria-label="Ganti Tema" class="p-2 sm:p-2.5 rounded-xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-slate-600 dark:text-zinc-400 hover:text-indigo-500 dark:hover:text-emerald-400 hover:border-indigo-200 dark:hover:border-zinc-700 transition-all shadow-sm flex items-center justify-center active:scale-95 cursor-pointer">
                    <i id="themeIcon" data-lucide="sun" class="w-4.5 h-4.5 sm:w-5 sm:w-5"></i>
                </button>
            </div>
        </header>

        <!-- Dukungan Saweria Card -->
        <div id="saweriaCard" class="mb-6 sm:mb-8 p-3.5 sm:p-5 rounded-2xl bg-gradient-to-r from-amber-500/10 via-orange-500/10 to-amber-500/5 dark:from-amber-500/15 dark:via-orange-500/10 dark:to-transparent border border-amber-500/20 dark:border-amber-500/20 flex flex-col md:flex-row items-stretch md:items-center justify-between gap-3 sm:gap-4 shadow-sm relative overflow-hidden backdrop-blur-sm transition-all duration-300">
            <div class="absolute top-0 right-0 w-64 h-64 bg-amber-400/10 dark:bg-amber-500/5 rounded-full blur-[50px] -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
            
            <!-- Dismiss Button -->
            <button type="button" id="btnDismissSaweria" aria-label="Tutup pesan donasi" class="absolute top-2.5 right-2.5 p-1 rounded-lg text-amber-800/50 dark:text-amber-400/50 hover:text-amber-900 dark:hover:text-amber-300 hover:bg-amber-500/10 transition-colors z-20 cursor-pointer" title="Sembunyikan pesan">
                <i data-lucide="x" class="w-3.5 h-3.5"></i>
            </button>

            <div class="relative z-10 text-left flex-1 pr-6 md:pr-0">
                <h3 class="text-xs sm:text-sm font-bold text-amber-800 dark:text-amber-400 flex items-center gap-1.5 sm:gap-2 mb-1">
                    <i data-lucide="heart" class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rose-500 dark:text-rose-400 fill-rose-500/20 dark:fill-rose-400/20 animate-pulse"></i>
                    Aplikasi ini bermanfaat untuk Anda?
                </h3>
                <p class="text-[11px] sm:text-[13px] text-slate-600 dark:text-zinc-400 leading-relaxed max-w-2xl">
                    Dukung pengembangan TulCek agar terus menjadi platform <span class="font-semibold text-slate-700 dark:text-zinc-300">gratis, super cepat,</span> dan <span class="font-semibold text-slate-700 dark:text-zinc-300">100% bebas iklan</span>. Setiap kopi dari Anda adalah energi bagi kami! 🚀
                </p>
            </div>
            
            <a href="https://saweria.co/maaafiqs" target="_blank" rel="noopener noreferrer" class="relative z-10 flex items-center justify-center gap-2 px-4 sm:px-6 py-2.5 bg-gradient-to-r from-[#FFC000] to-[#F2B600] text-amber-950 font-bold text-xs sm:text-sm rounded-xl transition-all shadow-md shadow-amber-500/20 hover:shadow-amber-500/40 hover:-translate-y-0.5 hover:scale-[1.01] active:scale-95 flex-shrink-0 border border-amber-400/50 w-full md:w-auto">
                <i data-lucide="coffee" class="w-4 h-4"></i>
                <span class="tracking-wide">Dukung via Saweria</span>
            </a>
        </div>

        <!-- Main Body -->
        <main class="mb-auto">
            @yield('content')
        </main>

        <!-- Footer Section -->
        <footer class="mt-12 sm:mt-16 pt-8 pb-8 border-t border-slate-200/60 dark:border-zinc-800/60 flex flex-col items-center gap-6">
            
            <!-- Saweria Support Card (Permanent in Footer) -->
            <div class="w-full max-w-xl p-4 sm:p-5 rounded-2xl bg-gradient-to-r from-amber-500/10 via-orange-500/10 to-amber-500/5 dark:from-amber-500/15 dark:via-orange-500/10 dark:to-transparent border border-amber-500/20 dark:border-amber-500/20 flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4 shadow-sm backdrop-blur-sm">
                <div class="text-center sm:text-left">
                    <p class="text-xs sm:text-sm font-bold text-amber-800 dark:text-amber-400 flex items-center justify-center sm:justify-start gap-1.5">
                        <i data-lucide="coffee" class="w-4 h-4 text-amber-600 dark:text-amber-400"></i>
                        Dukung TulCek via Saweria
                    </p>
                    <p class="text-[11px] sm:text-xs text-slate-500 dark:text-zinc-400 mt-0.5">
                        Bantu kami menjaga platform tetap gratis, cepat, dan 100% bebas iklan.
                    </p>
                </div>
                <a href="https://saweria.co/maaafiqs" target="_blank" rel="noopener noreferrer" class="flex items-center justify-center gap-2 px-5 py-2.5 bg-gradient-to-r from-[#FFC000] to-[#F2B600] text-amber-950 font-bold text-xs sm:text-sm rounded-xl transition-all shadow-md shadow-amber-500/20 hover:shadow-amber-500/40 hover:-translate-y-0.5 active:scale-95 flex-shrink-0 border border-amber-400/50 w-full sm:w-auto">
                    <i data-lucide="heart" class="w-3.5 h-3.5 text-rose-600 fill-rose-600"></i>
                    <span>Dukung Saweria</span>
                </a>
            </div>

            <!-- Feedback & Contact Email -->
            <div class="text-center">
                <p class="text-xs text-slate-600 dark:text-zinc-400 flex flex-wrap items-center justify-center gap-1.5">
                    <i data-lucide="message-square" class="w-3.5 h-3.5 text-indigo-500 dark:text-emerald-400 flex-shrink-0"></i>
                    <span>Apabila ada kritik dan saran kirim ke email kami:</span>
                    <a href="mailto:maaafiqsdev@gmail.com" class="font-semibold text-indigo-600 dark:text-emerald-400 hover:text-indigo-700 dark:hover:text-emerald-300 underline underline-offset-4 decoration-indigo-300 dark:decoration-emerald-500/40 transition-colors">
                        maaafiqsdev@gmail.com
                    </a>
                </p>
            </div>

            <!-- Copyright & Brand info -->
            <div class="w-full pt-4 border-t border-slate-200/40 dark:border-zinc-800/40 flex flex-col md:flex-row justify-between items-center gap-3 text-xs text-slate-500 dark:text-zinc-400 text-center md:text-left">
                <p>
                    © {{ date('Y') }} TulCek (Tulis dan Cek). Website ini dikelola oleh <a href="https://maaafiqs.web.id" target="_blank" rel="noopener noreferrer" class="text-indigo-600 dark:text-emerald-400 hover:text-indigo-700 dark:hover:text-emerald-300 font-semibold transition-colors">Maaafiqs Dev</a>.
                </p>
                <div class="flex flex-wrap gap-2 sm:gap-4 opacity-70 justify-center">
                    <span>Toolkit Karir Profesional</span>
                    <span>•</span>
                    <span>Client-Side Processing</span>
                </div>
            </div>
        </footer>

    </div>

    <!-- Global Theme Script -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Lucide Icons globally
            if(typeof lucide !== 'undefined') {
                lucide.createIcons();
            }

            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const navDropdownBtn = document.getElementById('navDropdownBtn');
            const navMenu = document.getElementById('navMenu');
            const navChevron = document.getElementById('navChevron');
            const btnChangelog = document.getElementById('btnChangelog');
            const btnChangelogMenu = document.getElementById('btnChangelogMenu');
            const saweriaCard = document.getElementById('saweriaCard');
            const btnDismissSaweria = document.getElementById('btnDismissSaweria');

            // Saweria Dismiss Logic
            if(saweriaCard && btnDismissSaweria) {
                if(sessionStorage.getItem('saweria_dismissed') === 'true') {
                    saweriaCard.style.display = 'none';
                }
                btnDismissSaweria.addEventListener('click', () => {
                    saweriaCard.style.opacity = '0';
                    saweriaCard.style.transform = 'translateY(-6px)';
                    setTimeout(() => {
                        saweriaCard.style.display = 'none';
                    }, 200);
                    sessionStorage.setItem('saweria_dismissed', 'true');
                });
            }

            // Dropdown Menu Logic with Chevron Animation
            if(navDropdownBtn && navMenu) {
                navDropdownBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const isOpen = !navMenu.classList.contains('hidden');
                    if (isOpen) {
                        navMenu.classList.add('hidden');
                        navMenu.classList.remove('flex');
                        if(navChevron) navChevron.classList.remove('rotate-180');
                    } else {
                        navMenu.classList.remove('hidden');
                        navMenu.classList.add('flex');
                        if(navChevron) navChevron.classList.add('rotate-180');
                    }
                });
                
                document.addEventListener('click', (e) => {
                    if (!navMenu.contains(e.target) && !navDropdownBtn.contains(e.target)) {
                        navMenu.classList.add('hidden');
                        navMenu.classList.remove('flex');
                        if(navChevron) navChevron.classList.remove('rotate-180');
                    }
                });
            }

            // Changelog Logic
            const showChangelog = () => {
                if (navMenu) {
                    navMenu.classList.add('hidden');
                    navMenu.classList.remove('flex');
                    if(navChevron) navChevron.classList.remove('rotate-180');
                }
                Swal.fire({
                    title: 'Tentang & Riwayat Versi',
                    html: `
                        <div class="text-left text-sm space-y-4 mt-2 max-h-[65vh] overflow-y-auto pr-1">
                            <div class="text-center mb-4 text-slate-600 dark:text-zinc-400 text-xs">
                                TulCek (Tulis dan Cek) dikembangkan dengan ❤ untuk membantu Anda dalam penulisan dan urusan karir. <br/>
                                <span class="font-semibold text-slate-700 dark:text-zinc-300 mt-1 block">Dikembangkan oleh Maaafiqs Dev</span>
                            </div>
                            
                            <!-- Versi 1.4 -->
                            <div class="p-4 bg-emerald-50/50 dark:bg-emerald-950/20 rounded-xl border border-emerald-100 dark:border-emerald-800/30">
                                <div class="flex items-center gap-2 mb-2">
                                    <i data-lucide="sparkles" class="w-4 h-4 text-emerald-500"></i>
                                    <span class="font-bold text-emerald-700 dark:text-emerald-400">Versi 1.4 (Saat Ini)</span>
                                    <span class="ml-auto text-xs text-slate-400 dark:text-zinc-500">11 September 2026</span>
                                </div>
                                <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-zinc-400 text-xs">
                                    <li><strong>Logo Resmi Baru & Tema Adaptif</strong>: Implementasi logo TulCek Blue (Light Mode) & TulCek White (Dark Mode) yang beralih otomatis, beserta ikon Favicon tab browser.</li>
                                    <li><strong>Deployment Cloud Serverless di Vercel</strong>: Optimalisasi produksi serverless di Vercel (PHP 8.3 & Laravel), penanganan rute statis gambar, optimasi bundle Vite, dan CSRF exemption untuk API.</li>
                                    <li><strong>Smart Paraphrasing Tool</strong>: Alat parafrase cerdas anti-plagiarisme dengan perbendaharaan sinonim bahasa Indonesia & multi-tier back-translation.</li>
                                    <li><strong>ATS Resume Checker & Job Matcher</strong>: Fitur pencocokan CV dengan Job Description lowongan, visualisasi skor kecocokan (%), dan analisis keyword gap.</li>
                                    <li><strong>Rebranding Identitas TulCek</strong>: Transformasi brand menjadi "TulCek (Tulis dan Cek) — Toolkit Profesional Karir & Teks".</li>
                                </ul>
                            </div>

                            <!-- Versi 1.3 -->
                            <div class="p-4 bg-slate-50 dark:bg-zinc-800/50 rounded-xl border border-slate-100 dark:border-zinc-700/50">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="font-bold text-slate-700 dark:text-zinc-300">Versi 1.3</span>
                                    <span class="ml-auto text-xs text-slate-400 dark:text-zinc-500">6 Agustus 2026</span>
                                </div>
                                <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-zinc-400 text-xs">
                                    <li>Perbaikan ekspor PDF Surat Lamaran: isi tidak lagi kosong atau terpotong ke halaman kedua.</li>
                                    <li>Ganti engine ekspor PDF dari <em>html2canvas</em> ke sistem <em>print popup window</em> berbasis browser — instan & kualitas teks tajam vektor.</li>
                                    <li>Menghilangkan header/footer bawaan browser (tanggal, URL, nomor halaman) pada hasil PDF.</li>
                                    <li>Preview Surat Lamaran kini menampilkan konten penuh tanpa terpotong.</li>
                                </ul>
                            </div>

                            <!-- Versi 1.2 -->
                            <div class="p-4 bg-slate-50 dark:bg-zinc-800/50 rounded-xl border border-slate-100 dark:border-zinc-700/50">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="font-bold text-slate-700 dark:text-zinc-300">Versi 1.2</span>
                                </div>
                                <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-zinc-400 text-xs">
                                    <li>Perbaikan bug macet (freeze) saat upload file Word besar.</li>
                                    <li>Peningkatan performa UI menggunakan sistem Asynchronous.</li>
                                    <li>Perombakan antarmuka donasi (Dukungan Saweria).</li>
                                    <li>Penyembunyian menu navigasi ke dalam *dropdown* untuk UI lebih bersih.</li>
                                    <li>Penonaktifan native spellchecker yang memberatkan browser.</li>
                                </ul>
                            </div>

                            <!-- Versi 1.1 -->
                            <div class="p-4 bg-slate-50 dark:bg-zinc-800/50 rounded-xl border border-slate-100 dark:border-zinc-700/50">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="font-bold text-slate-700 dark:text-zinc-300">Versi 1.1</span>
                                </div>
                                <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-zinc-400 text-xs">
                                    <li>Penambahan alat pembuat CV ATS & ATS Checker.</li>
                                    <li>Integrasi deteksi referensi (Mendeley/Zotero) dari file .docx.</li>
                                    <li>Penyempurnaan warna tema (Dark Mode) yang lebih redup.</li>
                                </ul>
                            </div>

                            <!-- Versi 1.0 -->
                            <div class="p-4 bg-slate-50 dark:bg-zinc-800/50 rounded-xl border border-slate-100 dark:border-zinc-700/50">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="font-bold text-slate-700 dark:text-zinc-300">Versi 1.0</span>
                                </div>
                                <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-zinc-400 text-xs">
                                    <li>Rilis perdana aplikasi TulCek (Tulis dan Cek).</li>
                                    <li>Fitur Analisis Teks (Penghitung Kata, Karakter, Kalimat).</li>
                                    <li>Sistem Pemeriksa Ejaan & Typo offline berbasis JS.</li>
                                    <li>Layout responsif untuk Mobile dan Desktop.</li>
                                </ul>
                            </div>
                        </div>
                    `,
                    width: '36em',
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#6366f1',
                    didOpen: () => {
                        if(typeof lucide !== 'undefined') lucide.createIcons();
                    }
                });
            };

            if(btnChangelog) btnChangelog.addEventListener('click', showChangelog);
            if(btnChangelogMenu) btnChangelogMenu.addEventListener('click', showChangelog);

            function initializeTheme() {
                const isDark = localStorage.getItem('theme') === 'dark' || 
                              (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches);
                
                if (isDark) {
                    document.documentElement.classList.add('dark');
                    if(themeIcon) themeIcon.setAttribute('data-lucide', 'sun');
                } else {
                    document.documentElement.classList.remove('dark');
                    if(themeIcon) themeIcon.setAttribute('data-lucide', 'moon');
                }
                if(typeof lucide !== 'undefined') lucide.createIcons();
            }

            if(themeToggle) {
                themeToggle.addEventListener('click', () => {
                    const isDark = document.documentElement.classList.toggle('dark');
                    localStorage.setItem('theme', isDark ? 'dark' : 'light');
                    themeIcon.setAttribute('data-lucide', isDark ? 'sun' : 'moon');
                    if(typeof lucide !== 'undefined') lucide.createIcons();
                });
            }

            initializeTheme();
        });
    </script>
    @stack('scripts-bottom')
</body>
</html>
