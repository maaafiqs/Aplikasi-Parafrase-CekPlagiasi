@extends('layouts.app')

@section('title', 'Alat Parafrase Teks — TulCek (Tulis dan Cek)')

@section('content')
<div class="space-y-8">
    
    @push('styles')
    <style>
        .btn-parafrase-custom {
            background-color: #4f46e5 !important; /* indigo-600 */
            color: #ffffff !important;
        }
        .btn-parafrase-custom:hover {
            background-color: #4338ca !important; /* indigo-700 */
        }
        .dark .btn-parafrase-custom {
            background-color: #059669 !important; /* emerald-600 */
        }
        .dark .btn-parafrase-custom:hover {
            background-color: #047857 !important; /* emerald-700 */
        }
        .mode-pill.active {
            background-color: #4f46e5;
            color: #ffffff;
            border-color: #4f46e5;
        }
        .dark .mode-pill.active {
            background-color: #059669;
            color: #ffffff;
            border-color: #059669;
        }
    </style>
    @endpush
    
    <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl p-6 border border-slate-200/60 dark:border-zinc-800/60 shadow-sm text-center max-w-3xl mx-auto">
        <h2 class="text-2xl font-bold mb-2 flex items-center justify-center gap-2">
            <i data-lucide="refresh-cw" class="w-6 h-6 text-indigo-500 dark:text-emerald-400"></i>
            Alat Parafrase Teks
        </h2>
        <p class="text-slate-500 dark:text-zinc-400 text-sm">Tulis ulang kalimat atau paragraf Anda untuk menghindari plagiarisme dan membuat struktur bahasa yang lebih natural.</p>
        
        <!-- Paraphrase Mode Selector -->
        <div class="mt-4 inline-flex p-1 bg-slate-100 dark:bg-zinc-800/80 rounded-2xl border border-slate-200/80 dark:border-zinc-700/60 gap-1 text-xs font-semibold">
            <button type="button" data-mode="standard" class="mode-pill active px-3.5 py-1.5 rounded-xl border border-transparent transition-all flex items-center gap-1.5 text-slate-600 dark:text-zinc-300">
                <i data-lucide="sparkles" class="w-3.5 h-3.5"></i>
                Standar (Sinonim)
            </button>
            <button type="button" data-mode="creative" class="mode-pill px-3.5 py-1.5 rounded-xl border border-transparent transition-all flex items-center gap-1.5 text-slate-600 dark:text-zinc-300">
                <i data-lucide="shuffle" class="w-3.5 h-3.5"></i>
                Kreatif (Alih Bahasa)
            </button>
            <button type="button" data-mode="maximum" class="mode-pill px-3.5 py-1.5 rounded-xl border border-transparent transition-all flex items-center gap-1.5 text-slate-600 dark:text-zinc-300">
                <i data-lucide="zap" class="w-3.5 h-3.5"></i>
                Maksimal (Kombinasi)
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 items-stretch">
        
        <!-- Left Panel: Input Text -->
        <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-5 shadow-sm flex flex-col h-full">
            <div class="flex justify-between items-center mb-4">
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-slate-400 dark:text-zinc-500">
                    <i data-lucide="file-input" class="w-4 h-4"></i>
                    <span>Teks Asli</span>
                </div>
                <button id="btnClear" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-red-600 dark:text-rose-400 bg-red-50 dark:bg-rose-950/20 hover:bg-red-100 dark:hover:bg-rose-950/40 border border-transparent transition-all cursor-pointer">
                    <i data-lucide="trash-2" class="w-3.5 h-3.5"></i>
                    Bersihkan
                </button>
            </div>
            
            <textarea id="inputText" class="w-full flex-grow min-h-[300px] p-4 bg-slate-50/50 dark:bg-zinc-950/40 border border-slate-200 dark:border-zinc-800 focus:border-indigo-400 dark:focus:border-emerald-500/50 rounded-xl focus:outline-none focus:ring-4 focus:ring-indigo-500/5 dark:focus:ring-emerald-500/5 transition-all text-slate-800 dark:text-zinc-100 leading-relaxed text-sm resize-none" placeholder="Masukkan teks bahasa Indonesia yang ingin diparafrasekan di sini..."></textarea>
            
            <div class="mt-4 flex flex-wrap gap-2 justify-between items-center border-t border-slate-100 dark:border-zinc-800/60 pt-4">
                <span id="charCount" class="text-xs text-slate-400 dark:text-zinc-500 font-medium">0 / 2000 karakter</span>
                <button id="btnParaphrase" class="btn-parafrase-custom px-6 py-2.5 rounded-xl font-semibold text-sm transition-all shadow-sm flex items-center justify-center gap-2 cursor-pointer">
                    <i data-lucide="sparkles" class="w-4 h-4"></i>
                    Parafrase Teks
                </button>
            </div>
        </div>

        <!-- Right Panel: Output Text -->
        <div class="bg-white dark:bg-zinc-900 border border-slate-200 dark:border-zinc-800/80 rounded-2xl p-5 shadow-sm flex flex-col h-full relative">
            <div class="flex flex-wrap gap-2 justify-between items-center mb-4">
                <div class="flex items-center gap-2 text-xs font-semibold uppercase tracking-wider text-indigo-500 dark:text-emerald-400">
                    <i data-lucide="file-output" class="w-4 h-4"></i>
                    <span>Hasil Parafrase</span>
                </div>
                <div class="flex items-center gap-2">
                    <span id="statsBadge" class="hidden px-2.5 py-1 rounded-lg text-xs font-bold bg-indigo-50 dark:bg-emerald-950/40 text-indigo-600 dark:text-emerald-400 border border-indigo-100 dark:border-emerald-800/40">
                        0% Berubah
                    </span>
                    <button id="btnCopy" class="flex items-center gap-1.5 px-3 py-1.5 rounded-lg text-xs font-medium text-slate-600 dark:text-zinc-400 bg-slate-50 dark:bg-zinc-800/60 hover:bg-indigo-50 dark:hover:bg-zinc-800 hover:text-indigo-600 dark:hover:text-emerald-400 border border-transparent transition-all cursor-pointer">
                        <i data-lucide="copy" class="w-3.5 h-3.5"></i>
                        Salin Teks
                    </button>
                </div>
            </div>
            
            <div class="relative flex-grow flex flex-col">
                <textarea id="outputText" readonly class="w-full flex-grow min-h-[300px] p-4 bg-slate-50/50 dark:bg-zinc-950/40 border border-slate-200 dark:border-zinc-800 rounded-xl focus:outline-none transition-all text-slate-800 dark:text-zinc-100 leading-relaxed text-sm resize-none" placeholder="Hasil parafrase akan muncul di sini..."></textarea>
            </div>

            <div class="mt-4 flex justify-between items-center border-t border-slate-100 dark:border-zinc-800/60 pt-4">
                <span id="outputCharCount" class="text-xs text-slate-400 dark:text-zinc-500 font-medium">0 kata • 0 karakter</span>
                <span id="modeBadge" class="text-[11px] text-slate-400 dark:text-zinc-500">Mode: Standar</span>
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
    const outputCharCount = document.getElementById('outputCharCount');
    const statsBadge = document.getElementById('statsBadge');
    const modeBadge = document.getElementById('modeBadge');
    const modePills = document.querySelectorAll('.mode-pill');
    
    let currentMode = 'standard';
    const MAX_CHARS = 2000;

    // Mode Selector
    modePills.forEach(pill => {
        pill.addEventListener('click', () => {
            modePills.forEach(p => p.classList.remove('active'));
            pill.classList.add('active');
            currentMode = pill.getAttribute('data-mode');
            const modeNames = {
                'standard': 'Standar',
                'creative': 'Kreatif',
                'maximum': 'Maksimal'
            };
            modeBadge.textContent = `Mode: ${modeNames[currentMode] || currentMode}`;
        });
    });

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
        outputCharCount.textContent = `0 kata • 0 karakter`;
        statsBadge.classList.add('hidden');
    });

    btnCopy.addEventListener('click', () => {
        if (!outputText.value.trim()) return;
        navigator.clipboard.writeText(outputText.value).then(() => {
            const originalHTML = btnCopy.innerHTML;
            btnCopy.innerHTML = '<i data-lucide="check" class="w-3.5 h-3.5"></i> Tersalin';
            if (typeof lucide !== 'undefined') lucide.createIcons();
            setTimeout(() => {
                btnCopy.innerHTML = originalHTML;
                if (typeof lucide !== 'undefined') lucide.createIcons();
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

        const originalBtnHTML = btnParaphrase.innerHTML;
        outputText.value = 'Sedang memproses parafrase, mohon tunggu sebentar...';
        btnParaphrase.disabled = true;
        btnParaphrase.innerHTML = '<i data-lucide="loader-2" class="w-4 h-4 animate-spin"></i> Memproses...';
        if (typeof lucide !== 'undefined') lucide.createIcons();

        try {
            const csrfToken = document.querySelector('meta[name="csrf-token"]')?.content || '';
            let res = await fetch('/api/paraphrase', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrfToken
                },
                body: JSON.stringify({ 
                    text: text, 
                    mode: currentMode 
                })
            });

            if (!res.ok) {
                // Fallback in case Vercel rewrites or strips /api
                res = await fetch('/paraphrase-process', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({ 
                        text: text, 
                        mode: currentMode 
                    })
                });
            }

            if (!res.ok) {
                throw new Error(`HTTP error! status: ${res.status}`);
            }

            const data = await res.json();
            const paraphrased = data.paraphrasedText || '';
            
            outputText.value = paraphrased;

            // Update stats
            const words = paraphrased.trim() ? paraphrased.trim().split(/\s+/).length : 0;
            outputCharCount.textContent = `${words} kata • ${paraphrased.length} karakter`;

            if (data.originality !== undefined) {
                statsBadge.textContent = `${data.originality}% Berubah`;
                statsBadge.classList.remove('hidden');
            }

        } catch (error) {
            console.error(error);
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat memproses parafrase. Silakan coba lagi.',
                confirmButtonColor: '#ef4444'
            });
            outputText.value = '';
        } finally {
            btnParaphrase.disabled = false;
            btnParaphrase.innerHTML = originalBtnHTML;
            if (typeof lucide !== 'undefined') lucide.createIcons();
        }
    });
});
</script>
@endpush
