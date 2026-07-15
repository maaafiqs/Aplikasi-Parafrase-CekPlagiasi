@extends('layouts.app')

@section('title', 'PenaHitung — Cek Kata, Paragraf & Dokumen Word')

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
            
            <!-- Left Panel: Document Upload & Text Input (8 Cols) -->
            <div class="lg:col-span-8 space-y-6">
                
                <!-- Uploader & File Dropzone -->
                <div id="dropzone" class="border-2 border-dashed border-slate-200 dark:border-zinc-800 hover:border-indigo-400 dark:hover:border-emerald-500/50 bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-2xl p-8 text-center cursor-pointer transition-all duration-300 shadow-sm relative overflow-hidden group">
                    <input type="file" id="fileInput" accept=".docx,.txt" class="hidden" />
                    
                    <div class="flex flex-col items-center gap-3 relative z-10">
                        <div class="w-14 h-14 rounded-2xl bg-indigo-50 dark:bg-zinc-800 text-indigo-600 dark:text-emerald-400 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                            <i data-lucide="cloud-upload" class="w-8 h-8"></i>
                        </div>
                        <div>
                            <p class="text-sm font-semibold text-slate-800 dark:text-zinc-100">
                                Seret & Lepaskan berkas di sini atau <span class="text-indigo-600 dark:text-emerald-400 underline decoration-2 underline-offset-2">Pilih Berkas</span>
                            </p>
                            <p class="text-xs text-slate-400 dark:text-zinc-500 mt-1">
                                Mendukung format dokumen Word (<span class="font-medium text-slate-500 dark:text-zinc-400">.docx</span>) atau Teks Biasa (<span class="font-medium text-slate-500 dark:text-zinc-400">.txt</span>)
                            </p>
                        </div>
                    </div>
                    
                    <!-- Progress Bar (Visible during parse) -->
                    <div id="uploadProgress" class="absolute bottom-0 left-0 w-0 h-1 bg-gradient-to-r from-indigo-500 to-emerald-500 transition-all duration-300"></div>
                </div>

                <!-- Text Area Editor -->
                <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-5 shadow-sm space-y-4">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-zinc-500">
                            <i data-lucide="file-text" class="w-4 h-4"></i>
                            <span>Editor Teks</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <!-- Quick action buttons -->
                            <button id="btnCopy" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 dark:text-zinc-400 bg-slate-50 dark:bg-zinc-800/60 hover:bg-indigo-50 dark:hover:bg-zinc-800 hover:text-indigo-600 dark:hover:text-emerald-400 border border-transparent transition-all">
                                <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                                Salin
                            </button>
                            <button id="btnDownload" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 dark:text-zinc-400 bg-slate-50 dark:bg-zinc-800/60 hover:bg-indigo-50 dark:hover:bg-zinc-800 hover:text-indigo-600 dark:hover:text-emerald-400 border border-transparent transition-all">
                                <i data-lucide="download" class="w-3.5 h-3.5"></i>
                                Ekspor (.txt)
                            </button>
                            <button id="btnClear" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-red-600 dark:text-rose-400 bg-red-50 dark:bg-rose-950/20 hover:bg-red-100 dark:hover:bg-rose-950/40 border border-transparent transition-all">
                                <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                                Bersihkan
                            </button>
                        </div>
                    </div>
                    
                    <div class="relative">
                        <textarea id="textEditor" class="w-full min-h-[300px] p-4 bg-slate-50/50 dark:bg-zinc-950/40 border border-slate-200 dark:border-zinc-800 focus:border-indigo-400 dark:focus:border-emerald-500/50 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-500/5 dark:focus:ring-emerald-500/5 transition-all text-slate-800 dark:text-zinc-100 leading-relaxed text-sm resize-y" placeholder="Mulai mengetik di sini, atau upload dokumen Word Anda di atas..."></textarea>
                    </div>
                </div>

                <!-- Core Stats Cards -->
                <div class="grid grid-cols-2 md:grid-cols-5 gap-4">
                    <div class="bg-white dark:bg-zinc-900 border border-slate-100 dark:border-zinc-800/50 p-4 rounded-xl shadow-sm text-center hover:translate-y-[-2px] transition-transform duration-200">
                        <p class="text-xs font-medium text-slate-400 dark:text-zinc-500 uppercase tracking-wider mb-1">Kata</p>
                        <p id="statWords" class="text-2xl font-extrabold text-slate-800 dark:text-white">0</p>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 border border-slate-100 dark:border-zinc-800/50 p-4 rounded-xl shadow-sm text-center hover:translate-y-[-2px] transition-transform duration-200">
                        <p class="text-xs font-medium text-slate-400 dark:text-zinc-500 uppercase tracking-wider mb-1">Karakter</p>
                        <p id="statChars" class="text-2xl font-extrabold text-slate-800 dark:text-white">0</p>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 border border-slate-100 dark:border-zinc-800/50 p-4 rounded-xl shadow-sm text-center hover:translate-y-[-2px] transition-transform duration-200">
                        <p class="text-xs font-medium text-slate-400 dark:text-zinc-500 uppercase tracking-wider mb-1">Tanpa Spasi</p>
                        <p id="statCharsNoSp" class="text-2xl font-extrabold text-slate-800 dark:text-white">0</p>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 border border-slate-100 dark:border-zinc-800/50 p-4 rounded-xl shadow-sm text-center hover:translate-y-[-2px] transition-transform duration-200">
                        <p class="text-xs font-medium text-slate-400 dark:text-zinc-500 uppercase tracking-wider mb-1">Paragraf</p>
                        <p id="statParagraphs" class="text-2xl font-extrabold text-slate-800 dark:text-white">0</p>
                    </div>
                    <div class="bg-white dark:bg-zinc-900 border border-slate-100 dark:border-zinc-800/50 p-4 rounded-xl shadow-sm text-center hover:translate-y-[-2px] transition-transform duration-200 col-span-2 md:col-span-1">
                        <p class="text-xs font-medium text-slate-400 dark:text-zinc-500 uppercase tracking-wider mb-1">Kalimat</p>
                        <p id="statSentences" class="text-2xl font-extrabold text-slate-800 dark:text-white">0</p>
                    </div>
                </div>

            </div>

            <!-- Right Panel: Analytics & Sidebar (4 Cols) -->
            <div class="lg:col-span-4 space-y-6">
                
                <!-- Reference Manager Detector Card -->
                <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <i data-lucide="bookmark-check" class="w-4 h-4 text-indigo-500 dark:text-emerald-400"></i>
                        Sumber Referensi / Sitasi
                    </h2>
                    
                    <div id="refDetectorContent" class="flex flex-col gap-3">
                        <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-zinc-950/40 border border-slate-100 dark:border-zinc-800/40">
                            <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-zinc-800 text-slate-500 flex items-center justify-center">
                                <i data-lucide="help-circle" class="w-4.5 h-4.5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-slate-700 dark:text-zinc-300">Belum Ada Dokumen</p>
                                <p class="text-[11px] text-slate-400 dark:text-zinc-500 mt-0.5">Unggah dokumen Word untuk mendeteksi tipe referensi.</p>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Spell Checker Card -->
                <div id="spellCheckCard" class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-sm">
                    <div class="flex justify-between items-center mb-4">
                        <h2 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider flex items-center gap-2">
                            <i data-lucide="check-square" class="w-4 h-4 text-indigo-500 dark:text-emerald-400"></i>
                            Pemeriksa Ejaan & Typo
                        </h2>
                        <span id="spellCheckStatus" class="text-[10px] font-semibold px-2.5 py-0.5 rounded-full bg-slate-100 dark:bg-zinc-800 text-slate-500 dark:text-zinc-400">Menyiapkan...</span>
                    </div>
                    
                    <div id="spellCheckContent" class="space-y-3 max-h-[220px] overflow-y-auto overscroll-contain pr-1" style="overscroll-behavior: contain;">
                        <div class="text-center py-6 text-slate-400 dark:text-zinc-500 text-xs">
                            <i data-lucide="alert-triangle" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                            Tulis atau unggah dokumen untuk menganalisis kesalahan ejaan.
                        </div>
                    </div>
                </div>
                
                <!-- Time Estimates Card -->
                <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <i data-lucide="hourglass" class="w-4 h-4 text-indigo-500 dark:text-emerald-400"></i>
                        Estimasi Waktu
                    </h2>
                    
                    <div class="space-y-4">
                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-zinc-950/40 border border-slate-100 dark:border-zinc-800/40">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-indigo-100 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center">
                                    <i data-lucide="book-open" class="w-4.5 h-4.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-slate-400 dark:text-zinc-500">Membaca</p>
                                    <p class="text-xs text-slate-400 dark:text-zinc-500">(~200 kata/menit)</p>
                                </div>
                            </div>
                            <span id="timeRead" class="text-sm font-bold text-slate-700 dark:text-zinc-200">0 dtk</span>
                        </div>

                        <div class="flex items-center justify-between p-3 rounded-xl bg-slate-50 dark:bg-zinc-950/40 border border-slate-100 dark:border-zinc-800/40">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center">
                                    <i data-lucide="mic" class="w-4.5 h-4.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-medium text-slate-400 dark:text-zinc-500">Berbicara</p>
                                    <p class="text-xs text-slate-400 dark:text-zinc-500">(~130 kata/menit)</p>
                                </div>
                            </div>
                            <span id="timeSpeak" class="text-sm font-bold text-slate-700 dark:text-zinc-200">0 dtk</span>
                        </div>
                    </div>
                </div>

                <!-- Readability Score Card -->
                <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <i data-lucide="activity" class="w-4 h-4 text-indigo-500 dark:text-emerald-400"></i>
                        Skor Keterbacaan
                    </h2>
                    
                    <div class="flex items-center gap-4">
                        <div class="relative w-16 h-16 flex items-center justify-center shrink-0">
                            <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                                <path class="text-slate-100 dark:text-zinc-800" stroke-dasharray="100, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3"></path>
                                <path id="readabilityCircle" class="text-slate-300 dark:text-zinc-600 transition-all duration-1000 ease-out" stroke-dasharray="0, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3"></path>
                            </svg>
                            <div class="absolute inset-0 flex items-center justify-center">
                                <span id="readabilityScoreText" class="text-lg font-black text-slate-800 dark:text-white">0</span>
                            </div>
                        </div>
                        <div>
                            <p id="readabilityLevel" class="text-sm font-bold text-slate-700 dark:text-zinc-200">Belum ada teks</p>
                            <p id="readabilityDesc" class="text-[11px] text-slate-500 dark:text-zinc-400 mt-1">Ketik kalimat untuk mengukur tingkat kesulitan membaca (Flesch Score).</p>
                        </div>
                    </div>
                </div>

                <!-- Keyword Density Card -->
                <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <i data-lucide="bar-chart-2" class="w-4 h-4 text-indigo-500 dark:text-emerald-400"></i>
                        Kepadatan Kata Kunci
                    </h2>
                    
                    <div id="densityList" class="space-y-3">
                        <div class="text-center py-6 text-slate-400 dark:text-zinc-500 text-xs">
                            <i data-lucide="text" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                            Tulis atau upload sesuatu untuk melihat kata kunci terpopuler
                        </div>
                    </div>
                </div>

                <!-- Characters Profile Chart -->
                <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-sm">
                    <h2 class="text-sm font-bold text-slate-800 dark:text-white uppercase tracking-wider mb-4 flex items-center gap-2">
                        <i data-lucide="pie-chart" class="w-4 h-4 text-indigo-500 dark:text-emerald-400"></i>
                        Profil Karakter
                    </h2>
                    
                    <div class="space-y-4">
                        <!-- Vowels -->
                        <div>
                            <div class="flex justify-between text-xs font-medium mb-1">
                                <span class="text-slate-500 dark:text-zinc-400">Huruf Vokal (A, I, U, E, O)</span>
                                <span id="vowelPercent" class="text-slate-800 dark:text-zinc-200">0%</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-zinc-800 h-2 rounded-full overflow-hidden">
                                <div id="vowelBar" class="bg-indigo-500 h-full rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- Consonants -->
                        <div>
                            <div class="flex justify-between text-xs font-medium mb-1">
                                <span class="text-slate-500 dark:text-zinc-400">Huruf Konsonan</span>
                                <span id="consonantPercent" class="text-slate-800 dark:text-zinc-200">0%</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-zinc-800 h-2 rounded-full overflow-hidden">
                                <div id="consonantBar" class="bg-emerald-500 h-full rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                        </div>

                        <!-- Numbers / Digits -->
                        <div>
                            <div class="flex justify-between text-xs font-medium mb-1">
                                <span class="text-slate-500 dark:text-zinc-400">Angka</span>
                                <span id="digitPercent" class="text-slate-800 dark:text-zinc-200">0%</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-zinc-800 h-2 rounded-full overflow-hidden">
                                <div id="digitBar" class="bg-amber-500 h-full rounded-full transition-all duration-300" style="width: 0%"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

</div>
@endsection

@push('scripts-bottom')
    <!-- Script Section for Logic -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Initialize Lucide Icons
            lucide.createIcons();

            // Dom Elements
            const themeToggle = document.getElementById('themeToggle');
            const themeIcon = document.getElementById('themeIcon');
            const dropzone = document.getElementById('dropzone');
            const fileInput = document.getElementById('fileInput');
            const textEditor = document.getElementById('textEditor');
            const uploadProgress = document.getElementById('uploadProgress');
            const spellCheckContent = document.getElementById('spellCheckContent');

            // Counter Elements
            const statWords = document.getElementById('statWords');
            const statChars = document.getElementById('statChars');
            const statCharsNoSp = document.getElementById('statCharsNoSp');
            const statParagraphs = document.getElementById('statParagraphs');
            const statSentences = document.getElementById('statSentences');

            // Analysis Elements
            const timeRead = document.getElementById('timeRead');
            const timeSpeak = document.getElementById('timeSpeak');
            const densityList = document.getElementById('densityList');
            const vowelPercent = document.getElementById('vowelPercent');
            const vowelBar = document.getElementById('vowelBar');
            const consonantPercent = document.getElementById('consonantPercent');
            const consonantBar = document.getElementById('consonantBar');
            const digitPercent = document.getElementById('digitPercent');
            const digitBar = document.getElementById('digitBar');

            // Buttons
            const btnCopy = document.getElementById('btnCopy');
            const btnDownload = document.getElementById('btnDownload');
            const btnClear = document.getElementById('btnClear');

            // Stopwords for Indonesian & English to perform density search
            const indonesianStopwords = new Set([
                'yang', 'dan', 'di', 'ke', 'dari', 'untuk', 'dengan', 'ini', 'itu', 'atau', 'juga', 'adalah', 
                'bahwa', 'pada', 'sebagai', 'oleh', 'saya', 'kami', 'mereka', 'ia', 'dia', 'anda', 'kamu', 
                'sebuah', 'ada', 'yaitu', 'ialah', 'telah', 'sudah', 'akan', 'bisa', 'dapat', 'tidak', 'tak', 
                'belum', 'hanya', 'saja', 'sangat', 'lebih', 'banyak', 'tersebut', 'secara', 'dalam', 
                'karena', 'sehingga', 'jika', 'kalau', 'tentang', 'seperti', 'melalui', 'maka', 'terhadap',
                'kami', 'kita', 'buat', 'adapun', 'bagaimana', 'apa', 'mengapa', 'siapa', 'kapan', 'dimana'
            ]);

            const englishStopwords = new Set([
                'the', 'a', 'an', 'and', 'or', 'but', 'if', 'because', 'as', 'until', 'while', 'of', 'at', 
                'by', 'for', 'with', 'about', 'against', 'between', 'into', 'through', 'during', 'before', 
                'after', 'above', 'below', 'to', 'from', 'up', 'down', 'in', 'out', 'on', 'off', 'over', 
                'under', 'again', 'further', 'then', 'once', 'here', 'there', 'when', 'where', 'why', 
                'how', 'all', 'any', 'both', 'each', 'few', 'more', 'most', 'other', 'some', 'such', 
                'no', 'nor', 'not', 'only', 'own', 'same', 'so', 'than', 'too', 'very', 'can', 'will', 
                'just', 'should', 'now', 'i', 'you', 'he', 'she', 'it', 'we', 'they', 'them', 'their', 
                'his', 'her', 'us', 'our'
            ]);



            // Uploader Drag and Drop Events
            dropzone.addEventListener('click', () => fileInput.click());
            
            ['dragenter', 'dragover'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    dropzone.classList.add('border-indigo-500', 'dark:border-emerald-400', 'bg-indigo-50/20', 'dark:bg-emerald-950/20');
                }, false);
            });

            ['dragleave', 'drop'].forEach(eventName => {
                dropzone.addEventListener(eventName, (e) => {
                    e.preventDefault();
                    dropzone.classList.remove('border-indigo-500', 'dark:border-emerald-400', 'bg-indigo-50/20', 'dark:bg-emerald-950/20');
                }, false);
            });

            dropzone.addEventListener('drop', (e) => {
                const dt = e.dataTransfer;
                const files = dt.files;
                if (files.length > 0) {
                    handleFile(files[0]);
                }
            });

            fileInput.addEventListener('change', (e) => {
                if (e.target.files.length > 0) {
                    handleFile(e.target.files[0]);
                }
            });

            // Prevent main page scroll chaining when scrolling on the spell check card
            const spellCheckCard = document.getElementById('spellCheckCard');
            spellCheckCard.addEventListener('wheel', (e) => {
                spellCheckContent.scrollTop += e.deltaY;
                e.preventDefault();
            }, { passive: false });

            // Handle file loading and parsing
            function handleFile(file) {
                const extension = file.name.split('.').pop().toLowerCase();
                
                if (extension !== 'docx' && extension !== 'txt') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Format Tidak Didukung',
                        text: 'Silakan upload file berformat .docx (Word) atau .txt saja.',
                        confirmButtonColor: '#6366f1',
                    });
                    return;
                }

                // Show progress mock
                uploadProgress.style.width = '0%';
                let progress = 0;
                const progressInterval = setInterval(() => {
                    progress += 15;
                    if (progress > 80) clearInterval(progressInterval);
                    uploadProgress.style.width = `${progress}%`;
                }, 100);

                const reader = new FileReader();

                reader.onload = function(event) {
                    clearInterval(progressInterval);
                    uploadProgress.style.width = '100%';
                    
                    if (extension === 'docx') {
                        // Process docx using mammoth.js
                        const arrayBuffer = event.target.result;
                        
                        // Concurrent reference detection using JSZip
                        detectReferenceManager(arrayBuffer);

                        mammoth.extractRawText({ arrayBuffer: arrayBuffer })
                            .then(function(result) {
                                textEditor.value = result.value;
                                analyzeText(result.value);
                                
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Selesai!',
                                    text: `Teks dari dokumen "${file.name}" berhasil diimpor.`,
                                    timer: 2000,
                                    showConfirmButton: false,
                                });

                                setTimeout(() => {
                                    uploadProgress.style.width = '0%';
                                }, 800);
                            })
                            .catch(function(err) {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal Membaca Dokumen',
                                    text: 'Terjadi kesalahan saat mengekstrak teks dokumen Word Anda.',
                                    confirmButtonColor: '#ef4444',
                                });
                                uploadProgress.style.width = '0%';
                            });
                    } else if (extension === 'txt') {
                        // Direct read for txt
                        const text = event.target.result;
                        textEditor.value = text;
                        analyzeText(text);

                        // Set references detector warning for plain text file
                        document.getElementById('refDetectorContent').innerHTML = `
                            <div class="flex items-start gap-3 p-3 rounded-xl bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 border border-amber-200/50 dark:border-amber-800/20">
                                <div class="w-8 h-8 rounded-lg bg-amber-100 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center shrink-0 mt-0.5">
                                    <i data-lucide="alert-circle" class="w-4.5 h-4.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold">Kutipan Manual (Teks Biasa)</p>
                                    <p class="text-[11px] opacity-80 mt-0.5">Format berkas .txt tidak mendukung metadata referensi otomatis.</p>
                                </div>
                            </div>
                        `;
                        lucide.createIcons();
                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Selesai!',
                            text: `Teks dari berkas "${file.name}" berhasil diimpor.`,
                            timer: 2000,
                            showConfirmButton: false,
                        });

                        setTimeout(() => {
                            uploadProgress.style.width = '0%';
                        }, 800);
                    }
                };

                if (extension === 'docx') {
                    reader.readAsArrayBuffer(file);
                } else {
                    reader.readAsText(file);
                }
            }

            // Reference Manager XML Metadata Detector
            function detectReferenceManager(arrayBuffer) {
                const refContent = document.getElementById('refDetectorContent');
                refContent.innerHTML = `
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-zinc-950/40 border border-slate-100 dark:border-zinc-800/40 animate-pulse">
                        <div class="w-8 h-8 rounded-lg bg-indigo-50 dark:bg-zinc-800 text-indigo-500 flex items-center justify-center">
                            <i data-lucide="loader-2" class="w-4.5 h-4.5 animate-spin"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-700 dark:text-zinc-300">Mendeteksi...</p>
                            <p class="text-[11px] text-slate-400 dark:text-zinc-500 mt-0.5">Memindai metadata berkas XML...</p>
                        </div>
                    </div>
                `;
                lucide.createIcons();

                JSZip.loadAsync(arrayBuffer)
                    .then(function(zip) {
                        const documentXml = zip.file("word/document.xml");
                        const footnotesXml = zip.file("word/footnotes.xml");
                        const endnotesXml = zip.file("word/endnotes.xml");
                        
                        let combinedXmlPromise = Promise.resolve("");

                        if (documentXml) {
                            combinedXmlPromise = documentXml.async("text");
                        }

                        return combinedXmlPromise.then(function(docText) {
                            const promises = [];
                            if (footnotesXml) promises.push(footnotesXml.async("text"));
                            if (endnotesXml) promises.push(endnotesXml.async("text"));

                            return Promise.all(promises).then(function(extraTexts) {
                                return docText + " " + extraTexts.join(" ");
                            });
                        });
                    })
                    .then(function(fullXmlText) {
                        const lowerXml = fullXmlText.toLowerCase();
                        
                        // Detect signatures
                        const hasZotero = lowerXml.includes("zotero_item") || 
                                           lowerXml.includes("zotero_csl_citation") || 
                                           lowerXml.includes("zotero_bibl") || 
                                           lowerXml.includes("zotero_bref");
                                           
                        const hasMendeley = lowerXml.includes("mendeley citation") || 
                                            lowerXml.includes("mendeley bibliography") || 
                                            lowerXml.includes("mendeleycite") ||
                                            lowerXml.includes("mendeley.com");

                        let title = "Kutipan Manual (Ketik Tangan)";
                        let desc = "Tidak ditemukan metadata Zotero atau Mendeley. Referensi diketik manual.";
                        let icon = "alert-circle";
                        let colorClasses = "bg-amber-50 dark:bg-amber-950/20 text-amber-600 dark:text-amber-400 border-amber-200/50 dark:border-amber-800/20";
                        let iconColor = "bg-amber-100 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400";

                        if (hasZotero && hasMendeley) {
                            title = "Campuran (Zotero & Mendeley)";
                            desc = "Terdeteksi metadata kutipan dari Zotero dan Mendeley secara bersamaan.";
                            icon = "git-merge";
                            colorClasses = "bg-purple-50 dark:bg-purple-950/20 text-purple-600 dark:text-purple-400 border-purple-200/50 dark:border-purple-800/20";
                            iconColor = "bg-purple-100 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400";
                        } else if (hasZotero) {
                            title = "Zotero (Otomatis)";
                            desc = "Dokumen menggunakan pengelola referensi Zotero secara otomatis.";
                            icon = "check-circle-2";
                            colorClasses = "bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 border-emerald-200/50 dark:border-emerald-800/20";
                            iconColor = "bg-emerald-100 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400";
                        } else if (hasMendeley) {
                            title = "Mendeley (Otomatis)";
                            desc = "Dokumen menggunakan pengelola referensi Mendeley secara otomatis.";
                            icon = "check-circle-2";
                            colorClasses = "bg-indigo-50 dark:bg-indigo-950/20 text-indigo-600 dark:text-indigo-400 border-indigo-200/50 dark:border-indigo-800/20";
                            iconColor = "bg-indigo-100 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400";
                        }

                        refContent.innerHTML = `
                            <div class="flex items-start gap-3 p-3 rounded-xl border ${colorClasses}">
                                <div class="w-8 h-8 rounded-lg ${iconColor} flex items-center justify-center shrink-0 mt-0.5">
                                    <i data-lucide="${icon}" class="w-4.5 h-4.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold">${title}</p>
                                    <p class="text-[11px] opacity-80 mt-0.5">${desc}</p>
                                </div>
                            </div>
                        `;
                        lucide.createIcons();
                    })
                    .catch(function(err) {
                        console.error(err);
                        refContent.innerHTML = `
                            <div class="flex items-start gap-3 p-3 rounded-xl bg-red-50 dark:bg-red-950/20 text-red-600 dark:text-red-400 border border-red-200/50 dark:border-red-800/20">
                                <div class="w-8 h-8 rounded-lg bg-red-100 dark:bg-red-950/50 text-red-600 dark:text-red-400 flex items-center justify-center shrink-0 mt-0.5">
                                    <i data-lucide="x-circle" class="w-4.5 h-4.5"></i>
                                </div>
                                <div>
                                    <p class="text-xs font-semibold">Gagal Membaca Metadata</p>
                                    <p class="text-[11px] opacity-80 mt-0.5">Terjadi kesalahan saat mengekstrak XML berkas.</p>
                                </div>
                            </div>
                        `;
                        lucide.createIcons();
                    });
            }

            // Real-time editor input hook
            textEditor.addEventListener('input', () => {
                analyzeText(textEditor.value);
            });

            // Perform analytical calculations (Optimized to match MS Word rules)
            function analyzeText(text) {
                if (!text || text.trim() === '') {
                    resetStats();
                    return;
                }

                // 1. Character count (excluding newlines to match MS Word)
                const charCount = text.replace(/[\r\n]/g, '').length;
                
                // 2. Character count without spaces (excluding all whitespaces and newlines)
                const charCountNoSpaces = text.replace(/[\s\r\n]/g, '').length;
                
                // 3. Word count using Word-matching Regex
                // Matches numbers with decimal/thousands separators or standard words (with optional hyphens/apostrophes)
                // This correctly splits "dan/atau" into 2 words, ignores floating symbols like "—", and counts "anak-anak" as 1.
                const wordsArray = text.match(/(\d+(?:[.,]\d+)+|[\p{L}\p{N}]+(?:[-'’][\p{L}\p{N}]+)*)/gu) || [];
                const wordCount = wordsArray.length;

                // 4. Paragraph count
                const paragraphsArray = text.split(/\n+/).filter(para => para.trim().length > 0);
                const paragraphCount = paragraphsArray.length;

                // 5. Sentence count
                const sentencesArray = text.split(/[.!?]+/).filter(sentence => sentence.trim().length > 0);
                const sentenceCount = sentencesArray.length;

                // Set primary counters
                statWords.textContent = formatNumber(wordCount);
                statChars.textContent = formatNumber(charCount);
                statCharsNoSp.textContent = formatNumber(charCountNoSpaces);
                statParagraphs.textContent = formatNumber(paragraphCount);
                statSentences.textContent = formatNumber(sentenceCount);

                // 6. Time Estimates
                const readTimeSec = Math.round((wordCount / 200) * 60);
                timeRead.textContent = formatTime(readTimeSec);

                const speakTimeSec = Math.round((wordCount / 130) * 60);
                timeSpeak.textContent = formatTime(speakTimeSec);

                // 6.5 Readability Score
                analyzeReadability(text, wordCount, sentenceCount);

                // 7. Character profile
                analyzeCharacterProfile(text);

                // 8. Keyword Density
                analyzeKeywordDensity(wordsArray);

                // 9. Spell & Typo Checker
                checkSpellingAndTypos(wordsArray);
            }

            function resetStats() {
                statWords.textContent = '0';
                statChars.textContent = '0';
                statCharsNoSp.textContent = '0';
                statParagraphs.textContent = '0';
                statSentences.textContent = '0';
                timeRead.textContent = '0 dtk';
                timeSpeak.textContent = '0 dtk';
                
                const readLevel = document.getElementById('readabilityLevel');
                const readDesc = document.getElementById('readabilityDesc');
                const readScore = document.getElementById('readabilityScoreText');
                const readCircle = document.getElementById('readabilityCircle');
                readLevel.textContent = 'Belum ada teks';
                readDesc.textContent = 'Ketik kalimat untuk mengukur tingkat kesulitan membaca (Flesch Score).';
                readScore.textContent = '0';
                readCircle.setAttribute('stroke-dasharray', '0, 100');
                readCircle.setAttribute('class', 'text-slate-300 dark:text-zinc-600 transition-all duration-1000 ease-out');
                
                vowelPercent.textContent = '0%';
                vowelBar.style.width = '0%';
                consonantPercent.textContent = '0%';
                consonantBar.style.width = '0%';
                digitPercent.textContent = '0%';
                digitBar.style.width = '0%';

                densityList.innerHTML = `
                    <div class="text-center py-6 text-slate-400 dark:text-zinc-500 text-xs">
                        <i data-lucide="text" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                        Tulis atau upload sesuatu untuk melihat kata kunci terpopuler
                    </div>
                `;

                document.getElementById('refDetectorContent').innerHTML = `
                    <div class="flex items-center gap-3 p-3 rounded-xl bg-slate-50 dark:bg-zinc-950/40 border border-slate-100 dark:border-zinc-800/40">
                        <div class="w-8 h-8 rounded-lg bg-slate-100 dark:bg-zinc-800 text-slate-500 flex items-center justify-center">
                            <i data-lucide="help-circle" class="w-4.5 h-4.5"></i>
                        </div>
                        <div>
                            <p class="text-xs font-semibold text-slate-700 dark:text-zinc-300">Belum Ada Dokumen</p>
                            <p class="text-[11px] text-slate-400 dark:text-zinc-500 mt-0.5">Unggah dokumen Word untuk mendeteksi tipe referensi.</p>
                        </div>
                    </div>
                `;

                document.getElementById('spellCheckContent').innerHTML = `
                    <div class="text-center py-6 text-slate-400 dark:text-zinc-500 text-xs">
                        <i data-lucide="alert-triangle" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                        Tulis atau unggah dokumen untuk menganalisis kesalahan ejaan.
                    </div>
                `;

                lucide.createIcons();
            }

            function analyzeReadability(text, words, sentences) {
                const readLevel = document.getElementById('readabilityLevel');
                const readDesc = document.getElementById('readabilityDesc');
                const readScoreText = document.getElementById('readabilityScoreText');
                const readCircle = document.getElementById('readabilityCircle');

                if (words === 0 || sentences === 0) {
                    return;
                }

                // Estimate syllables by counting vowel groups
                const syllables = text.toLowerCase().match(/[aiueo]+/g);
                const syllableCount = syllables ? syllables.length : 0;

                // Flesch Reading Ease formula
                let score = 206.835 - 1.015 * (words / sentences) - 84.6 * (syllableCount / words);
                score = Math.max(0, Math.min(100, Math.round(score)));

                readScoreText.textContent = score;
                readCircle.setAttribute('stroke-dasharray', `${score}, 100`);

                if (score >= 80) {
                    readCircle.setAttribute('class', 'text-emerald-500 transition-all duration-1000 ease-out');
                    readLevel.textContent = 'Sangat Mudah';
                    readLevel.className = 'text-sm font-bold text-emerald-600 dark:text-emerald-400';
                    readDesc.textContent = 'Mudah dipahami oleh rata-rata orang / siswa.';
                } else if (score >= 60) {
                    readCircle.setAttribute('class', 'text-indigo-500 transition-all duration-1000 ease-out');
                    readLevel.textContent = 'Standar';
                    readLevel.className = 'text-sm font-bold text-indigo-600 dark:text-indigo-400';
                    readDesc.textContent = 'Mudah dibaca oleh kebanyakan orang dewasa.';
                } else if (score >= 30) {
                    readCircle.setAttribute('class', 'text-amber-500 transition-all duration-1000 ease-out');
                    readLevel.textContent = 'Cukup Sulit';
                    readLevel.className = 'text-sm font-bold text-amber-600 dark:text-amber-400';
                    readDesc.textContent = 'Kalimat agak kompleks, butuh konsentrasi.';
                } else {
                    readCircle.setAttribute('class', 'text-rose-500 transition-all duration-1000 ease-out');
                    readLevel.textContent = 'Sangat Sulit';
                    readLevel.className = 'text-sm font-bold text-rose-600 dark:text-rose-400';
                    readDesc.textContent = 'Sulit dipahami. Cocok untuk jurnal akademis.';
                }
            }

            function formatNumber(num) {
                return new Intl.NumberFormat('id-ID').format(num);
            }

            function formatTime(seconds) {
                if (seconds < 60) {
                    return `${seconds} dtk`;
                } else {
                    const min = Math.floor(seconds / 60);
                    const sec = seconds % 60;
                    return sec > 0 ? `${min} mnt ${sec} dtk` : `${min} mnt`;
                }
            }

            function analyzeCharacterProfile(text) {
                const totalChars = text.replace(/[\r\n]/g, '').length;
                if (totalChars === 0) return;

                const clean = text.toLowerCase();
                
                const vowels = (clean.match(/[aeiou]/g) || []).length;
                const digits = (clean.match(/[0-9]/g) || []).length;
                
                // Consonants are letters that are not vowels
                const letters = (clean.match(/[a-z]/g) || []).length;
                const consonants = letters - vowels;

                const vPercent = Math.round((vowels / totalChars) * 100) || 0;
                const cPercent = Math.round((consonants / totalChars) * 100) || 0;
                const dPercent = Math.round((digits / totalChars) * 100) || 0;

                vowelPercent.textContent = `${vPercent}%`;
                vowelBar.style.width = `${vPercent}%`;

                consonantPercent.textContent = `${cPercent}%`;
                consonantBar.style.width = `${cPercent}%`;

                digitPercent.textContent = `${dPercent}%`;
                digitBar.style.width = `${dPercent}%`;
            }

            function analyzeKeywordDensity(wordsArray) {
                const frequencies = {};
                let validWordsCount = 0;

                wordsArray.forEach(rawWord => {
                    // Lowercase and remove symbols
                    const cleanWord = rawWord.toLowerCase().replace(/[^a-z0-9\-]/g, '');
                    
                    if (cleanWord.length > 2 && 
                        !indonesianStopwords.has(cleanWord) && 
                        !englishStopwords.has(cleanWord) &&
                        !/^\d+$/.test(cleanWord)) { // Skip purely numerical tokens
                        frequencies[cleanWord] = (frequencies[cleanWord] || 0) + 1;
                        validWordsCount++;
                    }
                });

                // Sort frequencies descending
                const sortedKeywords = Object.entries(frequencies)
                    .sort((a, b) => b[1] - a[1])
                    .slice(0, 5); // top 5 keywords

                if (sortedKeywords.length === 0) {
                    densityList.innerHTML = `
                        <div class="text-center py-6 text-slate-400 dark:text-zinc-500 text-xs">
                            <i data-lucide="text" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                            Tulis kata kunci yang lebih panjang untuk dianalisis
                        </div>
                    `;
                    lucide.createIcons();
                    return;
                }

                const maxFreq = sortedKeywords[0][1];

                let html = '';
                sortedKeywords.forEach(([word, freq]) => {
                    const widthPercent = Math.round((freq / maxFreq) * 100);
                    const absolutePercent = Math.round((freq / wordsArray.length) * 100 * 10) / 10;
                    html += `
                        <div>
                            <div class="flex justify-between text-xs font-semibold mb-1">
                                <span class="text-slate-700 dark:text-zinc-300 font-medium">${word}</span>
                                <span class="text-slate-500 dark:text-zinc-400 font-normal">${freq} kali (${absolutePercent}%)</span>
                            </div>
                            <div class="w-full bg-slate-100 dark:bg-zinc-800 h-1.5 rounded-full overflow-hidden">
                                <div class="bg-indigo-500 dark:bg-emerald-400 h-full rounded-full transition-all duration-300" style="width: ${widthPercent}%"></div>
                            </div>
                        </div>
                    `;
                });

                densityList.innerHTML = html;
            }

            // Spellchecker state and logic
            let indonesianDictionary = new Set();
            let englishDictionary = new Set();
            let isDictionaryLoaded = false;
            let isEnglishDictionaryLoaded = false;

            const commonTypos = {
                'yg': 'yang', 'dgn': 'dengan', 'utk': 'untuk', 'karna': 'karena',
                'aja': 'saja', 'aj': 'saja', 'bgt': 'sangat', 'praktek': 'praktik',
                'resiko': 'risiko', 'analisa': 'analisis', 'ijin': 'izin',
                'obyek': 'objek', 'subyek': 'subjek', 'katagori': 'kategori',
                'jadual': 'jadwal', 'sekedar': 'sekadar', 'kwalitas': 'kualitas',
                'aktifitas': 'aktivitas', 'efektip': 'efektif', 'amphibi': 'amfibi',
                'asik': 'asyik', 'fikir': 'pikir', 'himbauan': 'imbauan',
                'khatir': 'khawatir', 'nasehat': 'nasihat', 'negri': 'negeri'
            };

            const commonEnglishWords = new Set([
                'the', 'and', 'to', 'of', 'a', 'is', 'in', 'that', 'it', 'for', 'was', 'as', 'with', 'be', 'by', 'at', 'an', 'this',
                'from', 'are', 'not', 'or', 'have', 'on', 'your', 'with', 'data', 'system', 'program', 'user', 'file', 'application',
                'code', 'page', 'content', 'word', 'character', 'paragraph', 'sentence', 'read', 'speak', 'time', 'key', 'name',
                'hello', 'world', 'about', 'above', 'after', 'again', 'against', 'all', 'am', 'an', 'and', 'any', 'are', 'arent',
                'as', 'at', 'be', 'because', 'been', 'before', 'being', 'below', 'between', 'both', 'but', 'by', 'cant', 'cannot',
                'co', 'con', 'could', 'couldnt', 'did', 'didnt', 'do', 'does', 'doesnt', 'doing', 'dont', 'down', 'during', 'each',
                'few', 'for', 'from', 'further', 'had', 'hadnt', 'has', 'hasnt', 'have', 'havent', 'having', 'he', 'hed', 'hell',
                'hes', 'her', 'here', 'heres', 'hers', 'herself', 'him', 'himself', 'his', 'how', 'hows', 'i', 'id', 'ill', 'im',
                'ive', 'if', 'in', 'into', 'is', 'isnt', 'it', 'its', 'itself', 'lets', 'me', 'more', 'most', 'mustnt', 'my', 'myself',
                'no', 'nor', 'not', 'of', 'off', 'on', 'once', 'only', 'or', 'other', 'ought', 'our', 'ours', 'ourselves', 'out',
                'over', 'own', 'same', 'shant', 'she', 'shed', 'shell', 'shes', 'should', 'shouldnt', 'so', 'some', 'such', 'than',
                'that', 'thats', 'the', 'their', 'theirs', 'them', 'themselves', 'then', 'there', 'theres', 'these', 'they',
                'theyd', 'theyll', 'theyre', 'theyve', 'this', 'those', 'through', 'to', 'too', 'under', 'until', 'up', 'very',
                'was', 'wasnt', 'we', 'wed', 'well', 'were', 'weve', 'werent', 'what', 'whats', 'when', 'whens', 'where', 'wheres',
                'which', 'while', 'who', 'whos', 'whom', 'why', 'whys', 'with', 'wont', 'would', 'wouldnt', 'you', 'youd', 'youll',
                'youre', 'youve', 'your', 'yours', 'yourself', 'yourselves'
            ]);

            const fallbackWords = [
                'yang', 'dan', 'di', 'ke', 'dari', 'untuk', 'dengan', 'ini', 'itu', 'atau', 'juga', 'adalah', 'bahwa', 'pada',
                'sebagai', 'oleh', 'saya', 'kami', 'mereka', 'ia', 'dia', 'anda', 'kamu', 'sebuah', 'ada', 'yaitu', 'ialah',
                'telah', 'sudah', 'akan', 'bisa', 'dapat', 'tidak', 'tak', 'belum', 'hanya', 'saja', 'sangat', 'lebih', 'banyak',
                'tersebut', 'secara', 'dalam', 'karena', 'sehingga', 'jika', 'kalau', 'tentang', 'seperti', 'melalui', 'maka',
                'terhadap', 'kita', 'buat', 'adapun', 'bagaimana', 'apa', 'mengapa', 'siapa', 'kapan', 'dimana', 'orang', 'kerja',
                'satu', 'dua', 'tiga', 'empat', 'lima', 'banyak', 'beberapa', 'semua', 'setiap', 'lain', 'baru', 'lama', 'baik',
                'buruk', 'besar', 'kecil', 'hari', 'bulan', 'tahun', 'waktu', 'negara', 'pemerintah', 'masyarakat', 'anak',
                'ibu', 'ayah', 'keluarga', 'sekolah', 'guru', 'siswa', 'mahasiswa', 'dosen', 'tugas', 'kuliah', 'belajar',
                'tulis', 'baca', 'hitung', 'kata', 'kalimat', 'paragraf', 'buku', 'dokumen', 'berkas', 'sistem', 'aplikasi',
                'data', 'informasi', 'komputer', 'internet', 'web', 'halaman', 'waktu', 'jam', 'menit', 'detik', 'analisis',
                'praktik', 'risiko', 'izin', 'objek', 'subjek', 'kategori', 'jadwal', 'aktivitas', 'efektif', 'kualitas'
            ];

            fallbackWords.forEach(w => indonesianDictionary.add(w));
            commonEnglishWords.forEach(w => englishDictionary.add(w));

            function updateStatusText() {
                const statusSpan = document.getElementById('spellCheckStatus');
                const idCount = indonesianDictionary.size;
                const enCount = englishDictionary.size;
                statusSpan.textContent = `Kamus (ID: ${idCount.toLocaleString('id-ID')} | EN: ${enCount.toLocaleString('id-ID')})`;
            }

            function loadDictionary() {
                const statusSpan = document.getElementById('spellCheckStatus');
                statusSpan.textContent = 'Memuat Kamus...';
                
                const cachedDict = localStorage.getItem('id_wordlist');
                if (cachedDict) {
                    try {
                        const words = JSON.parse(cachedDict);
                        words.forEach(w => indonesianDictionary.add(w.toLowerCase()));
                        isDictionaryLoaded = true;
                    } catch (e) {
                        console.error("Gagal parse cache kamus ID:", e);
                    }
                }

                const cachedEnDict = localStorage.getItem('en_wordlist');
                if (cachedEnDict) {
                    try {
                        const words = JSON.parse(cachedEnDict);
                        words.forEach(w => englishDictionary.add(w.toLowerCase()));
                        isEnglishDictionaryLoaded = true;
                    } catch (e) {
                        console.error("Gagal parse cache kamus EN:", e);
                    }
                }

                updateStatusText();

                let p1 = Promise.resolve();
                if (!isDictionaryLoaded) {
                    p1 = fetch('https://raw.githubusercontent.com/agulagul/Indonesia-words/master/kata.txt')
                        .then(response => {
                            if (!response.ok) throw new Error("HTTP error " + response.status);
                            return response.text();
                        })
                        .then(text => {
                            const words = text.split(/\r?\n/).map(w => w.trim().toLowerCase()).filter(w => w.length > 1);
                            words.forEach(w => indonesianDictionary.add(w));
                            isDictionaryLoaded = true;
                            try {
                                localStorage.setItem('id_wordlist', JSON.stringify(Array.from(indonesianDictionary)));
                            } catch (e) {
                                console.warn("Storage penuh, tidak dapat menyimpan cache kamus ID.");
                            }
                        });
                }

                let p2 = Promise.resolve();
                if (!isEnglishDictionaryLoaded) {
                    p2 = fetch('https://raw.githubusercontent.com/first20hours/google-10000-english/master/google-10000-english-no-swears.txt')
                        .then(response => {
                            if (!response.ok) throw new Error("HTTP error " + response.status);
                            return response.text();
                        })
                        .then(text => {
                            const words = text.split(/\r?\n/).map(w => w.trim().toLowerCase()).filter(w => w.length > 1);
                            words.forEach(w => englishDictionary.add(w));
                            isEnglishDictionaryLoaded = true;
                            try {
                                localStorage.setItem('en_wordlist', JSON.stringify(Array.from(englishDictionary)));
                            } catch (e) {
                                console.warn("Storage penuh, tidak dapat menyimpan cache kamus EN.");
                            }
                        });
                }

                Promise.all([p1, p2])
                    .then(() => {
                        updateStatusText();
                        if (textEditor.value.trim() !== '') {
                            analyzeText(textEditor.value);
                        }
                    })
                    .catch(err => {
                        console.error("Gagal mengunduh kamus lengkap:", err);
                        updateStatusText();
                    });
            }

            function stemIndonesian(word) {
                let stemmed = word;
                
                // Check if already in dictionary (no stemming needed)
                if (indonesianDictionary.has(stemmed)) return stemmed;

                // 1. Remove inflectional suffixes (-lah, -kah, -tah, -pun, -ku, -mu, -nya)
                if (stemmed.endsWith('lah') || stemmed.endsWith('kah') || stemmed.endsWith('tah') || stemmed.endsWith('pun')) {
                    stemmed = stemmed.slice(0, -3);
                }
                if (indonesianDictionary.has(stemmed)) return stemmed;

                if (stemmed.endsWith('ku') || stemmed.endsWith('mu')) {
                    stemmed = stemmed.slice(0, -2);
                }
                if (indonesianDictionary.has(stemmed)) return stemmed;

                if (stemmed.endsWith('nya')) {
                    stemmed = stemmed.slice(0, -3);
                }
                if (indonesianDictionary.has(stemmed)) return stemmed;
                
                // 2. Remove derivational suffixes (-kan, -an, -i)
                if (stemmed.endsWith('kan')) {
                    const temp = stemmed.slice(0, -3);
                    if (indonesianDictionary.has(temp)) return temp;
                    stemmed = temp;
                } else if (stemmed.endsWith('an')) {
                    const temp = stemmed.slice(0, -2);
                    if (indonesianDictionary.has(temp)) return temp;
                    stemmed = temp;
                } else if (stemmed.endsWith('i') && !stemmed.endsWith('si') && !stemmed.endsWith('ti')) {
                    const temp = stemmed.slice(0, -1);
                    if (indonesianDictionary.has(temp)) return temp;
                    stemmed = temp;
                }

                // 3. Remove prefixes (me-, pe-, di-, ter-, ke-, se-, ber-, per-)
                if (stemmed.startsWith('peng') || stemmed.startsWith('meny') || stemmed.startsWith('meng') || stemmed.startsWith('men') || stemmed.startsWith('mem') || stemmed.startsWith('me') || stemmed.startsWith('pe')) {
                    if (stemmed.startsWith('peng')) {
                        const rest = stemmed.slice(4);
                        if (indonesianDictionary.has(rest)) return rest;
                        if (indonesianDictionary.has('k' + rest)) return 'k' + rest;
                    }
                    if (stemmed.startsWith('pem')) {
                        const rest = stemmed.slice(3);
                        if (indonesianDictionary.has(rest)) return rest;
                        if (indonesianDictionary.has('p' + rest)) return 'p' + rest;
                    }
                    if (stemmed.startsWith('peny')) {
                        const rest = stemmed.slice(4);
                        if (indonesianDictionary.has('s' + rest)) return 's' + rest;
                    }
                    if (stemmed.startsWith('pen')) {
                        const rest = stemmed.slice(3);
                        if (indonesianDictionary.has(rest)) return rest;
                        if (indonesianDictionary.has('t' + rest)) return 't' + rest;
                    }
                    
                    const restMe = stemmed.slice(2);
                    if (indonesianDictionary.has(restMe)) return restMe;
                }

                if (stemmed.startsWith('ber') || stemmed.startsWith('per')) {
                    const rest = stemmed.slice(3);
                    if (indonesianDictionary.has(rest)) return rest;
                    if (stemmed.startsWith('be')) {
                        const restBe = stemmed.slice(2);
                        if (indonesianDictionary.has(restBe)) return restBe;
                    }
                }

                if (stemmed.startsWith('di') || stemmed.startsWith('ke') || stemmed.startsWith('se') || stemmed.startsWith('ter')) {
                    const rest = stemmed.startsWith('ter') ? stemmed.slice(3) : stemmed.slice(2);
                    if (indonesianDictionary.has(rest)) return rest;
                }

                return stemmed;
            }

            function checkSpellingAndTypos(wordsArray) {
                const spellContent = document.getElementById('spellCheckContent');
                
                if (wordsArray.length === 0) {
                    spellContent.innerHTML = `
                        <div class="text-center py-6 text-slate-400 dark:text-zinc-500 text-xs">
                            <i data-lucide="alert-triangle" class="w-8 h-8 mx-auto mb-2 opacity-50"></i>
                            Tulis atau unggah dokumen untuk menganalisis kesalahan ejaan.
                        </div>
                    `;
                    lucide.createIcons();
                    return;
                }

                const flaggedItems = {};
                let totalTypos = 0;
                let totalForeign = 0;
                let totalUnknown = 0;

                wordsArray.forEach(word => {
                    const cleanWord = word.toLowerCase().replace(/[^a-z0-9\-]/g, '');
                    
                    if (cleanWord.length <= 2) return; 
                    if (/^\d+$/.test(cleanWord)) return; 
                    
                    const isCapitalized = /^[A-Z]/.test(word);
                    if (isCapitalized) return;

                    const isKnownIndo = indonesianDictionary.has(cleanWord) || indonesianDictionary.has(stemIndonesian(cleanWord));
                    if (isKnownIndo) return;

                    let type = 'unknown';
                    if (commonTypos[cleanWord]) {
                        type = 'typo';
                    } else if (englishDictionary.has(cleanWord)) {
                        type = 'foreign';
                    } else {
                        type = 'unknown';
                    }

                    if (!flaggedItems[cleanWord]) {
                        flaggedItems[cleanWord] = { count: 0, type: type };
                    }
                    flaggedItems[cleanWord].count++;
                    
                    if (type === 'typo') totalTypos++;
                    else if (type === 'foreign') totalForeign++;
                    else totalUnknown++;
                });

                const sortedItems = Object.entries(flaggedItems)
                    .sort((a, b) => b[1].count - a[1].count);

                const totalIssues = totalTypos + totalForeign + totalUnknown;

                if (totalIssues === 0) {
                    spellContent.innerHTML = `
                        <div class="flex items-start gap-3 p-3 rounded-xl bg-emerald-50 dark:bg-emerald-950/20 text-emerald-600 dark:text-emerald-400 border border-emerald-200/50 dark:border-emerald-800/20">
                            <div class="w-8 h-8 rounded-lg bg-emerald-100 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center shrink-0 mt-0.5">
                                <i data-lucide="check" class="w-4.5 h-4.5"></i>
                            </div>
                            <div>
                                <p class="text-xs font-semibold">Semua Ejaan Sempurna!</p>
                                <p class="text-[11px] opacity-80 mt-0.5">Tidak ditemukan kata typo atau tidak baku di dalam dokumen.</p>
                            </div>
                        </div>
                    `;
                    lucide.createIcons();
                    return;
                }

                let html = `
                    <div class="p-3 rounded-xl bg-slate-50 dark:bg-zinc-950/40 text-slate-700 dark:text-zinc-300 border border-slate-200/60 dark:border-zinc-800/60 mb-3 space-y-1">
                        <p class="text-xs font-semibold flex items-center gap-1.5">
                            <i data-lucide="info" class="w-3.5 h-3.5 text-indigo-500"></i>
                            Hasil Analisis Ejaan:
                        </p>
                        <div class="flex flex-wrap gap-2 mt-1 text-[10px]">
                            <span class="flex items-center gap-1 text-rose-600 dark:text-rose-400 bg-rose-50 dark:bg-rose-950/20 px-2 py-0.5 rounded font-medium border border-rose-100 dark:border-rose-950/40">
                                <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                ${totalTypos} Typo
                            </span>
                            <span class="flex items-center gap-1 text-amber-600 dark:text-amber-400 bg-amber-50 dark:bg-amber-950/20 px-2 py-0.5 rounded font-medium border border-amber-100 dark:border-amber-950/40">
                                <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                ${totalUnknown} Tidak Baku
                            </span>
                            <span class="flex items-center gap-1 text-indigo-600 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-950/20 px-2 py-0.5 rounded font-medium border border-indigo-100 dark:border-indigo-950/40">
                                <span class="w-1.5 h-1.5 rounded-full bg-indigo-500"></span>
                                ${totalForeign} Kata Asing
                            </span>
                        </div>
                    </div>
                    <div class="space-y-2">
                `;

                sortedItems.forEach(([word, info]) => {
                    const count = info.count;
                    const type = info.type;
                    
                    let badge = '';
                    let desc = '';
                    let borderClass = 'border-slate-200/60 dark:border-zinc-800/40';
                    let bgClass = 'bg-slate-50 dark:bg-zinc-900/60';
                    let bgHoverClass = 'hover:bg-slate-100/80 dark:hover:bg-zinc-900/90';
                    let wordColorClass = 'text-slate-800 dark:text-zinc-100';
                    
                    if (type === 'typo') {
                        const correction = commonTypos[word];
                        badge = `<span class="px-2 py-0.5 text-[10px] font-semibold tracking-wide rounded bg-rose-50 border border-rose-200/40 text-rose-600 dark:bg-rose-950/40 dark:border-rose-900/30 dark:text-rose-400 uppercase scale-95 origin-left">Typo</span>`;
                        desc = `Saran: <span class="font-bold text-rose-600 dark:text-rose-400">"${correction}"</span>`;
                        borderClass = 'border-rose-200/50 dark:border-rose-900/40';
                        bgClass = 'bg-rose-50 dark:bg-rose-950/20';
                        bgHoverClass = 'hover:bg-rose-100/70 dark:hover:bg-rose-950/30';
                    } else if (type === 'foreign') {
                        badge = `<span class="px-2 py-0.5 text-[10px] font-semibold tracking-wide rounded bg-indigo-50 border border-indigo-200/40 text-indigo-600 dark:bg-indigo-950/40 dark:border-indigo-900/30 dark:text-indigo-400 uppercase scale-95 origin-left">Kata Asing</span>`;
                        desc = `<span class="text-slate-400 dark:text-zinc-500 font-medium">Bahasa Inggris baku</span>`;
                        borderClass = 'border-indigo-200/50 dark:border-indigo-900/40';
                        bgClass = 'bg-indigo-50 dark:bg-indigo-950/20';
                        bgHoverClass = 'hover:bg-indigo-100/70 dark:hover:bg-indigo-950/30';
                    } else {
                        badge = `<span class="px-2 py-0.5 text-[10px] font-semibold tracking-wide rounded bg-amber-50 border border-amber-200/40 text-amber-600 dark:bg-amber-950/40 dark:border-amber-900/30 dark:text-amber-400 uppercase scale-95 origin-left">Tidak Baku</span>`;
                        desc = `<span class="text-slate-400 dark:text-zinc-500 font-medium">Bukan kata baku KBBI</span>`;
                        borderClass = 'border-amber-200/50 dark:border-amber-900/40';
                        bgClass = 'bg-amber-50 dark:bg-amber-950/20';
                        bgHoverClass = 'hover:bg-amber-100/70 dark:hover:bg-amber-950/30';
                    }
                    
                    html += `
                        <div class="flex justify-between items-center p-3 rounded-xl ${bgClass} border ${borderClass} ${bgHoverClass} transition-all duration-200 shadow-sm">
                            <div class="min-w-0 flex-1">
                                <div class="flex items-center gap-2 mb-0.5">
                                    <p class="text-sm font-semibold ${wordColorClass} truncate font-mono">${word}</p>
                                    ${badge}
                                </div>
                                <p class="text-xs text-slate-500 dark:text-zinc-400 mt-0.5">${desc}</p>
                            </div>
                            <span class="text-xs font-bold px-2.5 py-1 rounded-lg bg-slate-200/60 dark:bg-zinc-800 text-slate-700 dark:text-zinc-300 ml-2 shrink-0">
                                ${count}x
                            </span>
                        </div>
                    `;
                });

                html += `</div>`;
                spellContent.innerHTML = html;
                lucide.createIcons();
            }

            // Quick Actions Actions
            btnCopy.addEventListener('click', () => {
                const text = textEditor.value;
                if (!text || text.trim() === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Tidak Ada Teks',
                        text: 'Tulis atau impor teks terlebih dahulu untuk menyalin.',
                        confirmButtonColor: '#6366f1',
                    });
                    return;
                }
                
                navigator.clipboard.writeText(text).then(() => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Tersalin!',
                        text: 'Teks disalin ke papan klip Anda.',
                        timer: 1500,
                        showConfirmButton: false,
                    });
                }).catch(() => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal Menyalin',
                        text: 'Sistem menolak izin menyalin secara otomatis.',
                        confirmButtonColor: '#ef4444',
                    });
                });
            });

            btnDownload.addEventListener('click', () => {
                const text = textEditor.value;
                if (!text || text.trim() === '') {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Teks Kosong',
                        text: 'Tulis atau impor teks terlebih dahulu untuk diekspor.',
                        confirmButtonColor: '#6366f1',
                    });
                    return;
                }

                const blob = new Blob([text], { type: 'text/plain;charset=utf-8' });
                const url = URL.createObjectURL(blob);
                const a = document.createElement('a');
                a.href = url;
                a.download = 'penahitung-export.txt';
                document.body.appendChild(a);
                a.click();
                document.body.removeChild(a);
                URL.revokeObjectURL(url);

                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil Mengekspor!',
                    text: 'Teks diunduh sebagai penahitung-export.txt.',
                    timer: 1500,
                    showConfirmButton: false,
                });
            });

            btnClear.addEventListener('click', () => {
                if (!textEditor.value || textEditor.value.trim() === '') return;
                
                Swal.fire({
                    title: 'Bersihkan Editor?',
                    text: "Semua teks saat ini di editor akan dihapus secara permanen.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#ef4444',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        textEditor.value = '';
                        resetStats();
                    }
                });
            });

            loadDictionary();
        });
    </script>
@endpush
