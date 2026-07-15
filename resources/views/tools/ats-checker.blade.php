@extends('layouts.app')

@section('title', 'Cek Skor ATS & Job Matcher - PenaHitung')

@section('content')
<div class="space-y-8">
    
    <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl p-6 border border-slate-200/60 dark:border-zinc-800/60 shadow-sm text-center max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold mb-2 flex items-center justify-center gap-2">
            <i data-lucide="check-circle" class="w-6 h-6 text-indigo-500 dark:text-emerald-400"></i>
            Cek Skor ATS & Kecocokan Lowongan
        </h2>
        <p class="text-slate-500 dark:text-zinc-400 text-sm">Bandingkan isi CV Anda dengan deskripsi lowongan kerja untuk melihat skor kecocokan kata kunci (keywords) yang digunakan sistem ATS perusahaan.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
        
        <!-- Left Panel: Job Description -->
        <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-5 shadow-sm flex flex-col h-full">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-zinc-500">
                    <i data-lucide="briefcase" class="w-4 h-4"></i>
                    <span>Deskripsi Lowongan Kerja (JD)</span>
                </div>
            </div>
            
            <textarea id="jdText" class="w-full flex-grow min-h-[250px] p-4 bg-slate-50/50 dark:bg-zinc-950/40 border border-slate-200 dark:border-zinc-800 focus:border-indigo-400 dark:focus:border-emerald-500/50 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-500/5 dark:focus:ring-emerald-500/5 transition-all text-slate-800 dark:text-zinc-100 leading-relaxed text-sm resize-none" placeholder="Tempel persyaratan atau deskripsi lowongan pekerjaan (Job Description) di sini..."></textarea>
        </div>

        <!-- Right Panel: Resume / CV -->
        <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-5 shadow-sm flex flex-col h-full">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-zinc-500">
                    <i data-lucide="file-text" class="w-4 h-4"></i>
                    <span>Isi Teks CV Anda</span>
                </div>
            </div>
            
            <textarea id="cvText" class="w-full flex-grow min-h-[250px] p-4 bg-slate-50/50 dark:bg-zinc-950/40 border border-slate-200 dark:border-zinc-800 focus:border-indigo-400 dark:focus:border-emerald-500/50 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-500/5 dark:focus:ring-emerald-500/5 transition-all text-slate-800 dark:text-zinc-100 leading-relaxed text-sm resize-none" placeholder="Tempel seluruh isi teks dari CV / Resume Anda di sini..."></textarea>
        </div>
    </div>

    <!-- Center Action Button -->
    <div class="flex justify-center">
        <button id="btnAnalyze" class="px-8 py-3.5 rounded-2xl bg-indigo-600 dark:bg-emerald-600 text-white font-bold text-base hover:bg-indigo-700 dark:hover:bg-emerald-500 transition-all shadow-lg shadow-indigo-500/30 dark:shadow-emerald-500/30 flex items-center gap-2 hover:scale-105 active:scale-95">
            <i data-lucide="scan-line" class="w-5 h-5"></i>
            Analisis Kecocokan Sekarang
        </button>
    </div>

    <!-- Results Section (Hidden by default) -->
    <div id="resultsSection" class="hidden grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Score Card -->
        <div class="lg:col-span-1 bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-sm flex flex-col items-center justify-center text-center">
            <h3 class="text-sm font-semibold text-slate-500 dark:text-zinc-400 mb-6 uppercase tracking-widest">Skor ATS Anda</h3>
            
            <!-- Radial Progress (Custom CSS) -->
            <div class="relative w-40 h-40 flex items-center justify-center mb-4">
                <svg class="w-full h-full transform -rotate-90" viewBox="0 0 36 36">
                    <path class="text-slate-100 dark:text-zinc-800" stroke-dasharray="100, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3"></path>
                    <path id="scoreCircle" class="text-indigo-500 dark:text-emerald-500 transition-all duration-1000 ease-out" stroke-dasharray="0, 100" d="M18 2.0845 a 15.9155 15.9155 0 0 1 0 31.831 a 15.9155 15.9155 0 0 1 0 -31.831" fill="none" stroke="currentColor" stroke-width="3"></path>
                </svg>
                <div class="absolute inset-0 flex flex-col items-center justify-center">
                    <span id="scoreText" class="text-4xl font-black text-slate-800 dark:text-white">0%</span>
                </div>
            </div>
            
            <p id="scoreMessage" class="text-sm font-medium text-slate-600 dark:text-zinc-300">Menunggu analisis...</p>
        </div>

        <!-- Keyword Details -->
        <div class="lg:col-span-2 bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-6 shadow-sm">
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 h-full">
                
                <!-- Found Keywords -->
                <div class="flex flex-col h-full">
                    <h3 class="text-sm font-bold flex items-center gap-2 text-emerald-600 dark:text-emerald-400 mb-4 border-b border-slate-100 dark:border-zinc-800 pb-2">
                        <i data-lucide="check-circle-2" class="w-4 h-4"></i>
                        Kata Kunci Ditemukan (<span id="foundCount">0</span>)
                    </h3>
                    <div id="foundList" class="flex flex-wrap gap-2 content-start flex-grow max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                        <p class="text-xs text-slate-400 italic">Belum ada data.</p>
                    </div>
                </div>

                <!-- Missing Keywords -->
                <div class="flex flex-col h-full">
                    <h3 class="text-sm font-bold flex items-center gap-2 text-rose-600 dark:text-rose-400 mb-4 border-b border-slate-100 dark:border-zinc-800 pb-2">
                        <i data-lucide="x-circle" class="w-4 h-4"></i>
                        Kata Kunci Hilang (<span id="missingCount">0</span>)
                    </h3>
                    <div id="missingList" class="flex flex-wrap gap-2 content-start flex-grow max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                        <p class="text-xs text-slate-400 italic">Belum ada data.</p>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-3 pt-3 border-t border-slate-100 dark:border-zinc-800">*Tambahkan kata-kata di atas ke dalam CV Anda untuk meningkatkan skor ATS secara signifikan.</p>
                </div>
            </div>
            
        </div>

    </div>
</div>
@endsection

@push('scripts-bottom')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const jdText = document.getElementById('jdText');
    const cvText = document.getElementById('cvText');
    const btnAnalyze = document.getElementById('btnAnalyze');
    const resultsSection = document.getElementById('resultsSection');
    const scoreCircle = document.getElementById('scoreCircle');
    const scoreText = document.getElementById('scoreText');
    const scoreMessage = document.getElementById('scoreMessage');
    const foundList = document.getElementById('foundList');
    const missingList = document.getElementById('missingList');
    const foundCount = document.getElementById('foundCount');
    const missingCount = document.getElementById('missingCount');

    // Indonesian & English Stopwords
    const stopWords = new Set([
        // ID
        'yang','di','ke','dari','pada','dalam','untuk','dan','atau','dengan','ini','itu',
        'juga','sebagai','akan','dapat','bisa','telah','oleh','kami','kita','mereka','saya',
        'anda','dia','adalah','merupakan','sebuah','suatu','seperti','bagi','tentang','atas',
        'saat','setelah','sebelum','namun','tetapi','jika','kalau','agar','supaya','karena',
        'sebab','sehingga','maka','sangat','lebih','paling','hanya','saja','lagi','sudah',
        'belum','masih','sedang','akan','ingin','harus','perlu','mungkin','banyak','beberapa',
        'semua','seluruh','setiap','suatu','sesuatu','ada','tidak','bukan','jangan','ya','tidak',
        'tahun','bulan','hari','pengalaman','kerja','kemampuan','mampu','diperlukan','dicari',
        // EN
        'the','and','to','of','a','in','for','is','on','that','by','this','with','i','you',
        'it','not','or','be','are','from','at','as','your','all','have','new','more','an',
        'was','we','will','home','can','us','about','if','page','my','has','search','free',
        'but','our','one','other','do','no','information','time','they','site','he','up',
        'may','what','which','their','news','out','use','any','there','see','only','so',
        'his','when','contact','here','business','who','web','also','now','help','get',
        'pm','view','online','c','e','been','would','how','were','me','s','services','some',
        'these','click','its','like','service','x','than','find','price','date','back','top',
        'people','had','list','name','just','over','state','year','day','into','email','two',
        'health','n','world','re','next','used','go','b','work','last','most','products',
        'music','buy','data','make','them','should','product','system','post','her','city',
        't','add','policy','number','such','please','available','copyright','support','message',
        'after','best','software','then','jan','good','video','well','d','where','info','rights',
        'public','books','high','school','through','m','each','links','she','review','years',
        'order','very','privacy','book','items','company','r','read','group','sex','need','many',
        'user','said','de','does','set','under','general','research','university','january',
        'mail','full','map','reviews','program','life','experience','skills','required','looking',
        'knowledge','ability','strong','working','understanding','years'
    ]);

    function extractKeywords(text) {
        if (!text) return [];
        // Clean text: lower case, remove non-alphanumeric except spaces
        let cleanText = text.toLowerCase().replace(/[^a-z0-9\s]/g, ' ');
        let words = cleanText.split(/\s+/).filter(w => w.length > 2 && !stopWords.has(w));
        
        // Count frequencies
        let freqMap = {};
        words.forEach(w => {
            freqMap[w] = (freqMap[w] || 0) + 1;
        });
        
        // Sort by frequency
        let sortedWords = Object.keys(freqMap).sort((a, b) => freqMap[b] - freqMap[a]);
        
        // Return top N keywords (max 30)
        return sortedWords.slice(0, 30);
    }

    btnAnalyze.addEventListener('click', () => {
        const jd = jdText.value.trim();
        const cv = cvText.value.trim();

        if (!jd || !cv) {
            Swal.fire({
                icon: 'warning',
                title: 'Data Tidak Lengkap',
                text: 'Pastikan Anda telah mengisi Job Description dan isi CV.',
                confirmButtonColor: '#6366f1'
            });
            return;
        }

        // Processing
        btnAnalyze.innerHTML = '<i data-lucide="loader" class="w-5 h-5 animate-spin"></i> Menganalisis...';
        btnAnalyze.disabled = true;
        lucide.createIcons();

        setTimeout(() => {
            const jdKeywords = extractKeywords(jd);
            const cvTextLower = cv.toLowerCase();
            
            const found = [];
            const missing = [];

            jdKeywords.forEach(kw => {
                // Word boundary check
                const regex = new RegExp('\\b' + kw + '\\b', 'i');
                if (regex.test(cvTextLower)) {
                    found.push(kw);
                } else {
                    missing.push(kw);
                }
            });

            // Calculate Score
            let score = 0;
            if (jdKeywords.length > 0) {
                score = Math.round((found.length / jdKeywords.length) * 100);
            }

            // Update UI
            resultsSection.classList.remove('hidden');
            resultsSection.classList.add('grid');
            
            scoreText.textContent = `${score}%`;
            scoreCircle.setAttribute('stroke-dasharray', `${score}, 100`);
            
            if (score >= 80) {
                scoreCircle.setAttribute('class', 'text-emerald-500 transition-all duration-1000 ease-out');
                scoreMessage.textContent = 'Luar Biasa! CV Anda sangat cocok.';
                scoreMessage.className = 'text-sm font-medium text-emerald-600 dark:text-emerald-400 mt-2';
            } else if (score >= 50) {
                scoreCircle.setAttribute('class', 'text-amber-500 transition-all duration-1000 ease-out');
                scoreMessage.textContent = 'Cukup Baik. Tambahkan kata kunci yang hilang.';
                scoreMessage.className = 'text-sm font-medium text-amber-600 dark:text-amber-400 mt-2';
            } else {
                scoreCircle.setAttribute('class', 'text-rose-500 transition-all duration-1000 ease-out');
                scoreMessage.textContent = 'Perlu Perbaikan. CV belum memenuhi kriteria.';
                scoreMessage.className = 'text-sm font-medium text-rose-600 dark:text-rose-400 mt-2';
            }

            foundCount.textContent = found.length;
            missingCount.textContent = missing.length;

            // Render tags
            foundList.innerHTML = found.length > 0 
                ? found.map(w => `<span class="px-2.5 py-1 bg-emerald-50 dark:bg-emerald-950/30 border border-emerald-200 dark:border-emerald-800 text-emerald-700 dark:text-emerald-400 rounded-lg text-xs font-semibold">${w}</span>`).join('')
                : '<p class="text-xs text-slate-400 italic">Tidak ada kecocokan.</p>';

            missingList.innerHTML = missing.length > 0
                ? missing.map(w => `<span class="px-2.5 py-1 bg-rose-50 dark:bg-rose-950/30 border border-rose-200 dark:border-rose-800 text-rose-700 dark:text-rose-400 rounded-lg text-xs font-semibold">${w}</span>`).join('')
                : '<p class="text-xs text-slate-400 italic">Semua kata kunci utama sudah ada di CV!</p>';

            // Reset button
            btnAnalyze.innerHTML = '<i data-lucide="scan-line" class="w-5 h-5"></i> Analisis Kecocokan Sekarang';
            btnAnalyze.disabled = false;
            lucide.createIcons();

            // Scroll to results
            resultsSection.scrollIntoView({ behavior: 'smooth', block: 'start' });
            
        }, 800); // Fake delay for UX
    });
});
</script>
@endpush
