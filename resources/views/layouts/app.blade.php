<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'PenaHitung — Cek Kata, Paragraf & Dokumen Word')</title>
    
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
        <header class="flex flex-col md:flex-row justify-between items-center mb-8 border-b border-slate-200/60 dark:border-zinc-800/60 pb-6 gap-4">
            <a href="{{ url('/') }}" class="flex items-center gap-3 group">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-500 to-emerald-500 flex items-center justify-center shadow-lg shadow-indigo-500/20 group-hover:scale-105 transition-transform">
                    <i data-lucide="sparkles" class="w-5 h-5 text-white"></i>
                </div>
                <div>
                    <h1 class="text-xl font-bold tracking-tight text-slate-900 dark:text-white flex items-center gap-2">
                        PenaHitung
                        <span class="text-[10px] font-semibold bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 px-2 py-0.5 rounded-full uppercase tracking-wider">v2.0</span>
                    </h1>
                    <p class="text-xs text-slate-500 dark:text-zinc-400">Toolkit Profesional Karir & Teks</p>
                </div>
            </a>
            
            <nav class="flex items-center gap-2 bg-white/50 dark:bg-zinc-900/50 p-1.5 rounded-2xl border border-slate-200/60 dark:border-zinc-800/60 backdrop-blur-md">
                <a href="{{ url('/') }}" class="px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all {{ request()->is('/') ? 'bg-indigo-50 dark:bg-zinc-800 text-indigo-600 dark:text-emerald-400 shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    Analisis Teks
                </a>
                <a href="{{ url('/surat-lamaran') }}" class="px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all {{ request()->is('surat-lamaran') ? 'bg-indigo-50 dark:bg-zinc-800 text-indigo-600 dark:text-emerald-400 shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                    <i data-lucide="mail" class="w-4 h-4"></i>
                    Surat Lamaran
                </a>
                <a href="{{ url('/cv-ats') }}" class="px-4 py-2 rounded-xl text-xs font-semibold flex items-center gap-2 transition-all {{ request()->is('cv-ats') ? 'bg-indigo-50 dark:bg-zinc-800 text-indigo-600 dark:text-emerald-400 shadow-sm' : 'text-slate-500 hover:text-slate-700 dark:text-zinc-400 dark:hover:text-zinc-200' }}">
                    <i data-lucide="briefcase" class="w-4 h-4"></i>
                    CV ATS
                </a>
            </nav>

            <div class="flex items-center gap-4">
                <!-- Theme Toggle Button -->
                <button id="themeToggle" class="p-2.5 rounded-xl border border-slate-200 dark:border-zinc-800 bg-white dark:bg-zinc-900 text-slate-600 dark:text-zinc-400 hover:text-indigo-500 dark:hover:text-emerald-400 hover:border-indigo-200 dark:hover:border-zinc-700 transition-all shadow-sm flex items-center justify-center">
                    <i id="themeIcon" data-lucide="sun" class="w-5 h-5"></i>
                </button>
            </div>
        </header>

        <!-- Main Body -->
        <main class="mb-auto">
            @yield('content')
        </main>

        <!-- Footer Section -->
        <footer class="mt-12 pt-6 border-t border-slate-200/60 dark:border-zinc-800/60 flex flex-col md:flex-row justify-between items-center gap-4 text-xs text-slate-400 dark:text-zinc-500">
            <p>© {{ date('Y') }} PenaHitung. Dirancang dengan keindahan & kinerja.</p>
            <div class="flex gap-4">
                <span>Toolkit Karir Profesional</span>
                <span>•</span>
                <span>Client-Side Processing</span>
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
