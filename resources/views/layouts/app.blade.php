<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TulisRapi — Cek Kata, Paragraf & Dokumen Word')</title>
    
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

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 relative z-10 flex flex-col min-h-screen justify-between">
        
        <!-- Header Section -->
        <header class="relative z-50 flex flex-col md:flex-row justify-between items-center mb-8 border-b border-slate-200/60 dark:border-zinc-800/60 pb-6 gap-4">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-emerald-500 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                    <i data-lucide="sparkles" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                        TulisRapi
                        <button id="btnChangelog" class="text-[10px] font-semibold bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 px-2 py-0.5 rounded-full uppercase tracking-wider hover:bg-emerald-200 dark:hover:bg-emerald-900 transition-all cursor-pointer border-none shadow-sm hover:-translate-y-0.5">v1.2</button>
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Toolkit Profesional Karir & Teks</p>
                </div>
            </a>
            
            <!-- Navbar Menu with Dropdown -->
            <div class="relative ml-auto md:ml-0" id="navDropdownContainer">
                <button id="navDropdownBtn" class="flex items-center gap-2 px-4 py-2.5 rounded-xl text-sm font-semibold bg-white dark:bg-zinc-900 border border-slate-200/60 dark:border-zinc-800/60 text-slate-700 dark:text-zinc-200 hover:bg-slate-50 dark:hover:bg-zinc-800 transition-all shadow-sm">
                    <i data-lucide="layout-grid" class="w-4 h-4 text-indigo-500 dark:text-emerald-400"></i>
                    Menu Alat
                    <i data-lucide="chevron-down" class="w-4 h-4 ml-1 opacity-50"></i>
                </button>
                
                <nav id="navMenu" class="absolute top-full right-0 mt-2 w-56 bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800 rounded-2xl shadow-xl overflow-hidden hidden flex-col z-50 p-2">
                    <a href="{{ url('/') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all {{ request()->is('/') ? 'bg-indigo-50 dark:bg-zinc-800/80 text-indigo-600 dark:text-emerald-400' : 'text-slate-600 hover:bg-slate-50 dark:text-zinc-400 dark:hover:bg-zinc-800/50' }}">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                        Analisis Teks
                    </a>
                    <a href="{{ url('/surat-lamaran') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all {{ request()->is('surat-lamaran') ? 'bg-indigo-50 dark:bg-zinc-800/80 text-indigo-600 dark:text-emerald-400' : 'text-slate-600 hover:bg-slate-50 dark:text-zinc-400 dark:hover:bg-zinc-800/50' }}">
                        <i data-lucide="mail" class="w-4 h-4"></i>
                        Surat Lamaran
                    </a>
                    <a href="{{ url('/parafrase') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all {{ request()->is('parafrase') ? 'bg-indigo-50 dark:bg-zinc-800/80 text-indigo-600 dark:text-emerald-400' : 'text-slate-600 hover:bg-slate-50 dark:text-zinc-400 dark:hover:bg-zinc-800/50' }}">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                        Parafrase
                    </a>
                    <a href="{{ url('/cv-ats') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all {{ request()->is('cv-ats') ? 'bg-indigo-50 dark:bg-zinc-800/80 text-indigo-600 dark:text-emerald-400' : 'text-slate-600 hover:bg-slate-50 dark:text-zinc-400 dark:hover:bg-zinc-800/50' }}">
                        <i data-lucide="briefcase" class="w-4 h-4"></i>
                        CV ATS
                    </a>
                    <a href="{{ url('/ats-checker') }}" class="px-4 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all {{ request()->is('ats-checker') ? 'bg-indigo-50 dark:bg-zinc-800/80 text-indigo-600 dark:text-emerald-400' : 'text-slate-600 hover:bg-slate-50 dark:text-zinc-400 dark:hover:bg-zinc-800/50' }}">
                        <i data-lucide="check-circle" class="w-4 h-4"></i>
                        Cek ATS
                    </a>

                    <!-- Coming Soon Menu -->
                    <div class="px-4 py-2.5 rounded-xl text-xs font-semibold flex items-center justify-between gap-2 transition-all text-slate-400 dark:text-zinc-500 cursor-not-allowed opacity-80 bg-slate-50/50 dark:bg-zinc-900/30" title="Fitur sedang dalam tahap pengembangan">
                        <div class="flex items-center gap-2">
                            <i data-lucide="shield-alert" class="w-4 h-4"></i>
                            Cek Plagiasi
                        </div>
                        <span class="text-[9px] px-1.5 py-0.5 rounded-md bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-400 font-bold uppercase tracking-wider">Segera</span>
                    </div>
                    
                    <div class="h-px bg-slate-200 dark:bg-zinc-800 my-1 mx-2"></div>
                    <button id="btnChangelogMenu" class="w-full text-left px-4 py-2.5 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all text-slate-600 hover:bg-slate-50 dark:text-zinc-400 dark:hover:bg-zinc-800/50">
                        <i data-lucide="info" class="w-4 h-4"></i>
                        Tentang & Versi
                    </button>
                </nav>
            </div>

            <div class="flex items-center gap-4">
                <!-- Theme Toggle Button -->
                <button id="themeToggle" class="p-2.5 rounded-xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-slate-600 dark:text-zinc-400 hover:text-indigo-500 dark:hover:text-emerald-400 hover:border-indigo-200 dark:hover:border-zinc-700 transition-all shadow-sm flex items-center justify-center">
                    <i id="themeIcon" data-lucide="sun" class="w-5 h-5"></i>
                </button>
            </div>
        </header>

        <!-- Global Support / Donation Banner -->
        <div class="mb-8 relative overflow-hidden rounded-2xl bg-gradient-to-r from-amber-50 to-orange-50 dark:from-amber-950/20 dark:to-orange-950/20 border border-amber-200/50 dark:border-amber-800/30 p-5 flex flex-col md:flex-row justify-between items-center gap-5 group shadow-sm transition-all hover:shadow-md">
            <div class="absolute top-0 right-0 w-64 h-64 bg-amber-400/10 dark:bg-amber-500/5 rounded-full blur-[50px] -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
            
            <div class="relative z-10 text-center md:text-left flex-1">
                <h3 class="text-sm font-bold text-amber-800 dark:text-amber-400 flex items-center gap-2 justify-center md:justify-start mb-1">
                    <i data-lucide="heart" class="w-4 h-4 text-rose-500 dark:text-rose-400 fill-rose-500/20 dark:fill-rose-400/20 animate-pulse"></i>
                    Aplikasi ini bermanfaat untuk Anda?
                </h3>
                <p class="text-[13px] text-slate-600 dark:text-zinc-400 leading-relaxed max-w-2xl">
                    Dukung pengembangan TulisRapi agar terus menjadi platform <span class="font-semibold text-slate-700 dark:text-zinc-300">gratis, super cepat,</span> dan <span class="font-semibold text-slate-700 dark:text-zinc-300">100% bebas iklan</span>. Setiap kopi dari Anda adalah energi bagi kami! 🚀
                </p>
            </div>
            
            <a href="https://saweria.co/maaafiqs" target="_blank" rel="noopener noreferrer" class="relative z-10 flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-[#FFC000] to-[#F2B600] text-amber-950 font-bold rounded-xl transition-all shadow-lg shadow-amber-500/20 hover:shadow-amber-500/40 hover:-translate-y-0.5 hover:scale-[1.02] active:scale-95 flex-shrink-0 border border-amber-400/50">
                <i data-lucide="coffee" class="w-4.5 h-4.5"></i>
                <span class="tracking-wide">Dukung via Saweria</span>
            </a>
        </div>

        <!-- Main Body -->
        <main class="mb-auto">
            @yield('content')
        </main>

        <!-- Footer Section -->
        <footer class="mt-16 pt-8 pb-6 border-t border-slate-200/60 dark:border-zinc-800/60 flex flex-col gap-6">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-500 dark:text-zinc-400 pt-2 text-center md:text-left">
                <p>
                    © {{ date('Y') }} TulisRapi. Website ini dikelola oleh <a href="https://maaafiqs.web.id" target="_blank" rel="noopener noreferrer" class="text-indigo-600 dark:text-emerald-400 hover:text-indigo-700 dark:hover:text-emerald-300 font-semibold transition-colors">Maaafiqs Dev</a>.
                </p>
                <div class="flex gap-4 opacity-70 justify-center">
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
            const btnChangelog = document.getElementById('btnChangelog');
            const btnChangelogMenu = document.getElementById('btnChangelogMenu');

            // Dropdown Menu Logic
            if(navDropdownBtn && navMenu) {
                navDropdownBtn.addEventListener('click', (e) => {
                    e.stopPropagation();
                    navMenu.classList.toggle('hidden');
                    navMenu.classList.toggle('flex');
                });
                
                document.addEventListener('click', (e) => {
                    if (!navMenu.contains(e.target) && !navDropdownBtn.contains(e.target)) {
                        navMenu.classList.add('hidden');
                        navMenu.classList.remove('flex');
                    }
                });
            }

            // Changelog Logic
            const showChangelog = () => {
                if (navMenu) {
                    navMenu.classList.add('hidden');
                    navMenu.classList.remove('flex');
                }
                Swal.fire({
                    title: 'Tentang & Riwayat Versi',
                    html: `
                        <div class="text-left text-sm space-y-4 mt-2">
                            <div class="text-center mb-4 text-slate-600 dark:text-zinc-400 text-xs">
                                TulisRapi dikembangkan dengan ❤ untuk membantu Anda dalam penulisan dan urusan karir. <br/>
                                <span class="font-semibold text-slate-700 dark:text-zinc-300 mt-1 block">Dikembangkan oleh Maaafiqs Dev</span>
                            </div>
                            <div class="p-4 bg-emerald-50/50 dark:bg-emerald-950/20 rounded-xl border border-emerald-100 dark:border-emerald-800/30">
                                <div class="flex items-center gap-2 mb-2">
                                    <i data-lucide="sparkles" class="w-4 h-4 text-emerald-500"></i>
                                    <span class="font-bold text-emerald-700 dark:text-emerald-400">Versi 1.3 (Saat Ini)</span>
                                    <span class="ml-auto text-xs text-slate-400 dark:text-zinc-500">6 Agustus 2026</span>
                                </div>
                                <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-zinc-400 text-xs">
                                    <li>Perbaikan ekspor PDF Surat Lamaran: isi tidak lagi kosong atau terpotong ke halaman kedua.</li>
                                    <li>Ganti engine ekspor PDF dari <em>html2canvas</em> (lambat & sering hang) ke sistem <em>print popup window</em> berbasis browser — instan dan kualitas teks vektor.</li>
                                    <li>Menghilangkan header/footer bawaan browser (tanggal, URL, nomor halaman) pada hasil PDF.</li>
                                    <li>Preview Surat Lamaran kini menampilkan konten penuh tanpa terpotong.</li>
                                </ul>
                            </div>
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
                            <div class="p-4 bg-slate-50 dark:bg-zinc-800/50 rounded-xl border border-slate-100 dark:border-zinc-700/50">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="font-bold text-slate-700 dark:text-zinc-300">Versi 1.0</span>
                                </div>
                                <ul class="list-disc pl-5 space-y-1 text-slate-600 dark:text-zinc-400 text-xs">
                                    <li>Rilis perdana aplikasi TulisRapi.</li>
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
