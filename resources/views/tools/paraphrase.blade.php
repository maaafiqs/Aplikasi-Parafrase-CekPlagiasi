@extends('layouts.app')

@section('title', 'Alat Parafrase Teks - PenaHitung')

@section('content')
<div class="space-y-8">
    
    <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl p-6 border border-slate-200/60 dark:border-zinc-800/60 shadow-sm text-center max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold mb-2 flex items-center justify-center gap-2">
            <i data-lucide="refresh-cw" class="w-6 h-6 text-indigo-500 dark:text-emerald-400"></i>
            Alat Parafrase Teks
        </h2>
        <p class="text-slate-500 dark:text-zinc-400 text-sm">Tulis ulang kalimat atau paragraf Anda untuk menghindari plagiarisme dan membuat struktur bahasa yang lebih natural.</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
        
        <!-- Left Panel: Input Text -->
        <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-5 shadow-sm flex flex-col h-full">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-zinc-500">
                    <i data-lucide="file-input" class="w-4 h-4"></i>
                    <span>Teks Asli</span>
                </div>
                <button id="btnClear" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-red-600 dark:text-rose-400 bg-red-50 dark:bg-rose-950/20 hover:bg-red-100 dark:hover:bg-rose-950/40 border border-transparent transition-all">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    Bersihkan
                </button>
            </div>
            
            <textarea id="inputText" class="w-full flex-grow min-h-[300px] p-4 bg-slate-50/50 dark:bg-zinc-950/40 border border-slate-200 dark:border-zinc-800 focus:border-indigo-400 dark:focus:border-emerald-500/50 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-500/5 dark:focus:ring-emerald-500/5 transition-all text-slate-800 dark:text-zinc-100 leading-relaxed text-sm resize-none" placeholder="Masukkan teks bahasa Indonesia yang ingin diparafrasekan di sini..."></textarea>
            
            <div class="mt-4 flex justify-between items-center">
                <span id="charCount" class="text-xs text-slate-400 dark:text-zinc-500 font-medium">0 / 2000 karakter</span>
                <button id="btnParaphrase" class="px-6 py-2.5 rounded-xl bg-indigo-600 dark:bg-emerald-600 text-white font-semibold text-sm hover:bg-indigo-700 dark:hover:bg-emerald-500 transition-colors shadow-lg shadow-indigo-500/20 dark:shadow-emerald-500/20 flex items-center gap-2">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    Parafrase Sekarang
                </button>
            </div>
        </div>

        <!-- Right Panel: Output Text -->
        <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-5 shadow-sm flex flex-col h-full relative">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-indigo-500 dark:text-emerald-400">
                    <i data-lucide="file-output" class="w-4 h-4"></i>
                    <span>Hasil Parafrase</span>
                </div>
                <button id="btnCopy" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 dark:text-zinc-400 bg-slate-50 dark:bg-zinc-800/60 hover:bg-indigo-50 dark:hover:bg-zinc-800 hover:text-indigo-600 dark:hover:text-emerald-400 border border-transparent transition-all">
                    <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                    Salin Teks
                </button>
            </div>
            
            <div class="relative flex-grow flex flex-col">
                <textarea id="outputText" readonly class="w-full flex-grow min-h-[300px] p-4 bg-slate-50/50 dark:bg-zinc-950/40 border border-slate-200 dark:border-zinc-800 rounded-xl focus:outline-none transition-all text-slate-800 dark:text-zinc-100 leading-relaxed text-sm resize-none" placeholder="Hasil parafrase akan muncul di sini..."></textarea>
                
                <!-- Loading Overlay -->
                <div id="loadingOverlay" class="absolute inset-0 bg-white/80 dark:bg-zinc-900/80 backdrop-blur-sm rounded-xl flex flex-col items-center justify-center opacity-0 pointer-events-none transition-opacity duration-300">
                    <div class="w-10 h-10 border-4 border-indigo-200 dark:border-emerald-900 border-t-indigo-600 dark:border-t-emerald-500 rounded-full animate-spin mb-3"></div>
                    <p class="text-sm font-semibold text-slate-700 dark:text-zinc-300">Menganalisis & Memparafrase...</p>
                    <p class="text-xs text-slate-400 mt-1">Menggunakan teknik Back-Translation AI</p>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection

@push('scripts-bottom')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const inputText = document.getElementById('inputText');
    const outputText = document.getElementById('outputText');
    const btnParaphrase = document.getElementById('btnParaphrase');
    const btnClear = document.getElementById('btnClear');
    const btnCopy = document.getElementById('btnCopy');
    const charCount = document.getElementById('charCount');
    const loadingOverlay = document.getElementById('loadingOverlay');
    
    const MAX_CHARS = 2000;

    // Char count update
    inputText.addEventListener('input', () => {
        let text = inputText.value;
        if (text.length > MAX_CHARS) {
            inputText.value = text.substring(0, MAX_CHARS);
            text = inputText.value;
        }
        charCount.textContent = `${text.length} / ${MAX_CHARS} karakter`;
        
        if (text.length >= MAX_CHARS) {
            charCount.classList.add('text-red-500');
            charCount.classList.remove('text-slate-400');
        } else {
            charCount.classList.add('text-slate-400');
            charCount.classList.remove('text-red-500');
        }
    });

    btnClear.addEventListener('click', () => {
        inputText.value = '';
        outputText.value = '';
        charCount.textContent = `0 / ${MAX_CHARS} karakter`;
    });

    btnCopy.addEventListener('click', () => {
        if (!outputText.value.trim()) return;
        navigator.clipboard.writeText(outputText.value).then(() => {
            const originalHTML = btnCopy.innerHTML;
            btnCopy.innerHTML = '<i data-lucide="check" class="w-3.5 h-3.5"></i> Tersalin';
            lucide.createIcons();
            setTimeout(() => {
                btnCopy.innerHTML = originalHTML;
                lucide.createIcons();
            }, 2000);
        });
    });

    btnParaphrase.addEventListener('click', async () => {
        const text = inputText.value.trim();
        if (!text) {
            Swal.fire({
                icon: 'warning',
                title: 'Teks Kosong',
                text: 'Silakan masukkan teks terlebih dahulu.',
                confirmButtonColor: '#6366f1'
            });
            return;
        }

        // Show loading
        loadingOverlay.classList.remove('opacity-0', 'pointer-events-none');
        btnParaphrase.disabled = true;

        try {
            // Step 1: Translate ID to EN
            const res1 = await fetch('/api/translate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ text: text, lang: 'en', sl: 'id' })
            });
            const data1 = await res1.json();
            const englishText = data1.translatedText;
            
            if (!englishText) throw new Error("Gagal menerjemahkan teks.");

            // Step 2: Translate EN back to ID (Back-translation)
            const res2 = await fetch('/api/translate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({ text: englishText, lang: 'id', sl: 'en' })
            });
            const data2 = await res2.json();
            const paraphrasedText = data2.translatedText;
            
            outputText.value = paraphrasedText;
            
        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat memparafrase teks.',
                confirmButtonColor: '#ef4444'
            });
        } finally {
            loadingOverlay.classList.add('opacity-0', 'pointer-events-none');
            btnParaphrase.disabled = false;
        }
    });
});
</script>
@endpush
