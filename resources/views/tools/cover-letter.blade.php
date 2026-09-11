@extends('layouts.app')

@section('title', 'Pembuat Surat Lamaran - PenaHitung')

@push('scripts-top')
    <style id="cover-letter-styles">
        /* Preview paper (scrollable, not clipped) */
        .a4-preview {
            width: 794px;
            min-height: 1123px;
            background: white;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            padding: 60px 70px;
            color: black;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            line-height: 1.6;
            box-sizing: border-box;
        }
        /* Ensure dark mode doesn't invert the preview paper */
        .dark .a4-preview {
            background: white;
            color: black;
        }

        /* Template Styles */
        .template-standard { font-family: 'Times New Roman', Times, serif; }
        
        .template-modern { 
            font-family: 'Arial', sans-serif; 
            color: #111827;
        }
        .template-modern .letter-header h1 {
            color: #2563eb;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 4px;
            margin-bottom: 16px;
        }
        
        .template-klasik {
            font-family: 'Georgia', serif;
            color: #27272a;
        }
        .template-klasik .letter-header {
            text-align: center;
            border-bottom: 1px solid #000;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .template-klasik .letter-header h1 {
            font-size: 1.5rem;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        
        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #475569;
        }
        .dark .form-group label {
            color: #d4d4d8;
        }
        .form-input {
            width: 100%;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            border: 1px solid #e2e8f0;
            background: white;
            color: #1e293b;
            transition: all 0.2s;
        }
        .form-input:focus {
            outline: none;
            border-color: #6366f1;
            box-shadow: 0 0 0 4px rgba(99, 102, 241, 0.1);
        }
        .dark .form-input {
            background: #27272a;
            border-color: #3f3f46;
            color: #f4f4f5;
        }
        .dark .form-input:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }
    </style>
@endpush

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Left Panel: Form Input (5 Cols) -->
    <div class="lg:col-span-5 space-y-6">
        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl p-6 border border-slate-200/60 dark:border-zinc-800/60 shadow-sm relative overflow-hidden">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                <i data-lucide="edit-3" class="w-5 h-5 text-indigo-500 dark:text-emerald-400"></i>
                Data Surat
            </h2>
            
            <form id="coverLetterForm" class="space-y-6">
                <!-- Data Pelamar -->
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-zinc-200 border-b border-slate-200 dark:border-zinc-700 pb-2">Informasi Pelamar</h3>
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" id="senderName" class="form-input" placeholder="Budi Santoso">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group">
                            <label>No. Telepon / WA</label>
                            <input type="text" id="senderPhone" class="form-input" placeholder="08xx - xxxx - xxxx">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="senderEmail" class="form-input" placeholder="budi@email.com">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat Domisili</label>
                        <input type="text" id="senderAddress" class="form-input" placeholder="Jakarta Selatan">
                    </div>
                    <div class="form-group">
                        <label>LinkedIn / Portfolio (Opsional)</label>
                        <input type="text" id="senderLink" class="form-input" placeholder="linkedin.com/in/budisantoso">
                    </div>
                </div>

                <!-- Data Perusahaan -->
                <div class="space-y-4 pt-4">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-zinc-200 border-b border-slate-200 dark:border-zinc-700 pb-2">Tujuan Surat</h3>
                    <div class="form-group">
                        <label>Tanggal Surat</label>
                        <input type="text" id="letterDate" class="form-input" placeholder="Jakarta, 15 Juli 2026">
                    </div>
                    <div class="form-group">
                        <label>Posisi yang Dilamar</label>
                        <input type="text" id="jobPosition" class="form-input" placeholder="Software Engineer">
                    </div>
                    <div class="form-group">
                        <label>Nama HRD (Opsional)</label>
                        <input type="text" id="hrName" class="form-input" placeholder="Bapak/Ibu HRD Manager">
                    </div>
                    <div class="form-group">
                        <label>Nama Perusahaan</label>
                        <input type="text" id="companyName" class="form-input" placeholder="PT Teknologi Nusantara">
                    </div>
                    <div class="form-group">
                        <label>Alamat Perusahaan (Singkat)</label>
                        <input type="text" id="companyAddress" class="form-input" placeholder="Jakarta, Indonesia">
                    </div>
                </div>

                <!-- Isi Surat -->
                <div class="space-y-4 pt-4">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-zinc-200 border-b border-slate-200 dark:border-zinc-700 pb-2">Isi Kustom</h3>
                    <div class="form-group">
                        <label>Kekuatan / Pengalaman Utama (1-2 kalimat)</label>
                        <textarea id="mainStrength" class="form-input" rows="3" placeholder="Saya memiliki pengalaman 3 tahun di bidang pengembangan web..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Daftar Lampiran (pisahkan dengan koma atau baris baru)</label>
                        <textarea id="attachmentsList" class="form-input" rows="2" placeholder="Curriculum Vitae (CV), Fotokopi KTP, Pas Foto 4x6"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Format Penulisan Lampiran</label>
                        <select id="attachmentFormat" class="form-input">
                            <option value="list">Daftar Berurut (Angka 1, 2, 3)</option>
                            <option value="paragraph">Teks Sebaris (Paragraf)</option>
                        </select>
                    </div>
                </div>
            </form>

        </div>
    </div>
    
    <!-- Right Panel: Preview & Export (7 Cols) -->
    <div class="lg:col-span-7 space-y-6">
        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl p-6 border border-slate-200/60 dark:border-zinc-800/60 shadow-sm relative overflow-hidden flex flex-col h-full">
            
            <div class="flex justify-between items-center mb-6">
                <h2 class="text-xl font-bold flex items-center gap-2">
                    <i data-lucide="eye" class="w-5 h-5 text-indigo-500 dark:text-emerald-400"></i>
                    Pratinjau
                </h2>
                <div class="flex flex-wrap items-center gap-2">
                    <select id="templateSelector" class="px-3 py-2 rounded-xl text-xs font-semibold bg-white dark:bg-zinc-800 border border-slate-200 dark:border-zinc-700 text-slate-700 dark:text-zinc-300 focus:outline-none focus:ring-2 focus:ring-indigo-500/20 cursor-pointer">
                        <option value="template-standard">Standar (Times New Roman)</option>
                        <option value="template-modern">Modern (Arial + Aksen Biru)</option>
                        <option value="template-klasik">Klasik (Georgia Header Tengah)</option>
                    </select>
                    <button id="btnReset" class="px-4 py-2.5 rounded-xl bg-red-100 text-red-600 dark:bg-red-900/30 dark:text-red-400 font-semibold text-sm hover:bg-red-200 dark:hover:bg-red-900/50 transition-colors flex items-center gap-2">
                        <i data-lucide="refresh-cw" class="w-4 h-4"></i>
                        Reset
                    </button>
                    <button id="btnExportPDF" class="px-5 py-2.5 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold text-sm hover:bg-slate-800 dark:hover:bg-slate-100 transition-colors shadow-lg shadow-slate-900/20 flex items-center gap-2">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        Unduh PDF
                    </button>
                </div>
            </div>

            <!-- A4 Preview Container -->
            <div class="w-full flex justify-center bg-slate-100 dark:bg-zinc-950/50 rounded-2xl p-4 overflow-x-auto">
                <div style="width: 596px; flex-shrink: 0;">
                    <div id="previewContainer" class="a4-preview template-standard" style="transform-origin: top left; transform: scale(0.75); margin-bottom: -282px;">
                        <!-- Content injected via JS -->
                        <div id="letterContent"></div>
                    </div>
                </div>
            </div>

            
        </div>
    </div>

</div>
@endsection

@push('scripts-bottom')
<script>
document.addEventListener('DOMContentLoaded', () => {
    
    const formInputs = [
        'senderName', 'senderPhone', 'senderEmail', 'senderAddress', 'senderLink',
        'letterDate', 'jobPosition', 'hrName', 'companyName', 'companyAddress',
        'mainStrength', 'attachmentsList', 'attachmentFormat'
    ];

    const elements = {};
    const templateSelector = document.getElementById('templateSelector');

    // Event listener for template change
    templateSelector.addEventListener('change', () => {
        // Remove old template classes
        previewContainer.classList.remove('template-standard', 'template-modern', 'template-klasik');
        // Add new template class
        previewContainer.classList.add(templateSelector.value);
        // Re-render
        updatePreview();
    });

    // Event listeners
    formInputs.forEach(id => {
        elements[id] = document.getElementById(id);
    });

    const letterContent = document.getElementById('letterContent');
    const btnExportPDF = document.getElementById('btnExportPDF');
    const btnReset = document.getElementById('btnReset');
    const previewContainer = document.getElementById('previewContainer');

    function saveToStorage() {
        const data = {};
        for (const key in elements) {
            data[key] = elements[key].value;
        }
        localStorage.setItem('coverLetterData', JSON.stringify(data));
    }

    function loadFromStorage() {
        const stored = localStorage.getItem('coverLetterData');
        if (stored) {
            try {
                const data = JSON.parse(stored);
                for (const key in elements) {
                    if (data[key] !== undefined) {
                        elements[key].value = data[key];
                    }
                }
            } catch (e) {}
        }
    }

    // Load saved data on init
    loadFromStorage();

    // Initial render is now called explicitly here after data load
    updatePreview();

    // Listen to inputs
    for (const key in elements) {
        elements[key].addEventListener('input', () => {
            saveToStorage();
            updatePreview();
        });
    }

    // Reset button logic
    btnReset.addEventListener('click', () => {
        Swal.fire({
            title: 'Reset Form?',
            text: 'Semua isian akan dihapus.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Reset',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                for (const key in elements) {
                    elements[key].value = '';
                }
                localStorage.removeItem('coverLetterData');
                updatePreview();
            }
        });
    });

    function updatePreview() {
        const vals = {};
        for (const key in elements) {
            vals[key] = elements[key].value;
        }

        const name = vals.senderName || '[Nama Anda]';
        const phone = vals.senderPhone;
        const email = vals.senderEmail;
        const address = vals.senderAddress;
        const link = vals.senderLink;

        let contactStr = [];
        if(phone) contactStr.push(phone);
        if(email) contactStr.push(email);
        if(address) contactStr.push(address);
        if(link) contactStr.push(link);

        const date = vals.letterDate || '[Tanggal]';
        const position = vals.jobPosition || '[Posisi]';
        const hr = vals.hrName || 'Bapak/Ibu HRD';
        const company = vals.companyName || '[Nama Perusahaan]';
        const compAddress = vals.companyAddress || '[Alamat Perusahaan]';
        const strength = vals.mainStrength || '[Jelaskan pengalaman/kekuatan Anda di sini]';
        
        const attachmentStr = vals.attachmentsList || '';
        const attachmentFmt = vals.attachmentFormat || 'list';
        
        let attachmentHtml = '';
        if (attachmentStr.trim() !== '') {
            const items = attachmentStr.split(/[\n,]+/).map(i => i.trim()).filter(i => i.length > 0);
            if (items.length > 0) {
                if (attachmentFmt === 'list') {
                    attachmentHtml = `
                        <p style="margin: 0 0 10px 0;">Sebagai bahan pertimbangan Bapak/Ibu, bersama surat ini turut saya lampirkan:</p>
                        <ol style="margin: 0 0 10px 0; padding-left: 20px; list-style-type: decimal; margin-left: 15px;">
                            ${items.map(i => `<li style="margin-bottom: 3px; padding-left: 5px;">${i}</li>`).join('')}
                        </ol>
                        <p style="margin: 0 0 10px 0;">Saya sangat berharap dapat diberikan kesempatan wawancara agar saya dapat menjelaskan lebih rinci mengenai potensi dan kualifikasi yang saya miliki.</p>
                    `;
                } else {
                    let formattedItems = '';
                    if (items.length === 1) {
                        formattedItems = items[0];
                    } else if (items.length === 2) {
                        formattedItems = items.join(' dan ');
                    } else {
                        const lastItem = items.pop();
                        formattedItems = items.join(', ') + ', dan ' + lastItem;
                    }
                    attachmentHtml = `
                        <p style="margin: 0 0 10px 0;">Sebagai bahan pertimbangan Bapak/Ibu, bersama surat ini turut saya lampirkan ${formattedItems}. Saya sangat berharap dapat diberikan kesempatan wawancara agar saya dapat menjelaskan lebih rinci mengenai potensi dan kualifikasi yang saya miliki.</p>
                    `;
                }
            } else {
                attachmentHtml = `<p style="margin: 0 0 10px 0;">Bersama surat ini, saya juga melampirkan Curriculum Vitae (CV) sebagai bahan pertimbangan Bapak/Ibu. Saya sangat berharap dapat diberikan kesempatan wawancara agar saya dapat menjelaskan lebih rinci mengenai potensi dan kualifikasi yang saya miliki.</p>`;
            }
        } else {
            attachmentHtml = `<p style="margin: 0 0 10px 0;">Bersama surat ini, saya juga melampirkan Curriculum Vitae (CV) sebagai bahan pertimbangan Bapak/Ibu. Saya sangat berharap dapat diberikan kesempatan wawancara agar saya dapat menjelaskan lebih rinci mengenai potensi dan kualifikasi yang saya miliki.</p>`;
        }
        
        let headerHtml = '';
        const selectedTemplate = document.getElementById('templateSelector').value;
        
        if (selectedTemplate === 'template-klasik') {
            headerHtml = `
                <div class="letter-header">
                    <h1 style="margin:0; font-weight:bold;">${vals.senderName || 'Nama Lengkap'}</h1>
                    <p style="margin:5px 0 0 0; font-size:12px;">${vals.senderAddress || 'Alamat Domisili'}</p>
                    <p style="margin:0; font-size:12px;">${vals.senderPhone || 'No. Telp'} | ${vals.senderEmail || 'Email'} ${vals.senderLink ? '| ' + vals.senderLink : ''}</p>
                </div>
            `;
        } else if (selectedTemplate === 'template-modern') {
            headerHtml = `
                <div class="letter-header">
                    <h1 style="margin:0; font-size:24px; font-weight:bold;">${vals.senderName || 'Nama Lengkap'}</h1>
                    <p style="margin:5px 0 0 0;">${vals.senderAddress || 'Alamat Domisili'}</p>
                    <p style="margin:0;">${vals.senderPhone || 'No. Telp'} | ${vals.senderEmail || 'Email'} ${vals.senderLink ? '| ' + vals.senderLink : ''}</p>
                </div>
            `;
        } else {
            // Standard
            headerHtml = `
                <div class="mb-6">
                    <p style="margin:0; font-weight:bold;">${vals.senderName || 'Nama Lengkap'}</p>
                    <p style="margin:0;">${vals.senderAddress || 'Alamat Domisili'}</p>
                    <p style="margin:0;">${vals.senderPhone || 'No. Telp'} | ${vals.senderEmail || 'Email'} ${vals.senderLink ? '| ' + vals.senderLink : ''}</p>
                </div>
            `;
        }

        const html = `
            ${headerHtml}
            <div style="text-align: right; margin-bottom: 30px;">
                <p style="margin: 0;">${date}</p>
            </div>

            <div style="margin-bottom: 30px;">
                <p style="margin: 0; font-weight: bold;">Yth. ${hr}</p>
                <p style="margin: 0;">${company}</p>
                <p style="margin: 0;">${compAddress}</p>
            </div>

            <div class="mb-6" style="${selectedTemplate === 'template-klasik' ? 'text-align: left;' : ''} margin-bottom: 20px;">
                <p style="margin: 0;"><strong>Hal: Lamaran Pekerjaan - ${position}</strong></p>
            </div>

            <div style="margin-bottom: 15px;">
                <p style="margin: 0;">Dengan hormat,</p>
            </div>

            <div style="text-align: justify; margin-bottom: 15px;">
                <p style="margin: 0 0 10px 0;">Berdasarkan informasi yang saya peroleh, ${company} saat ini sedang membuka lowongan pekerjaan untuk posisi ${position}. Melalui surat ini, saya bermaksud untuk melamar posisi tersebut.</p>
                
                <p style="margin: 0 0 10px 0;">Nama saya ${name}. ${strength} Saya adalah individu yang cepat belajar, berdedikasi tinggi, dan mampu bekerja baik secara mandiri maupun dalam tim.</p>
                
                ${attachmentHtml}
            </div>

            <div style="margin-bottom: 40px;">
                <p style="margin: 0;">Atas perhatian dan waktu yang diberikan, saya ucapkan terima kasih.</p>
            </div>

            <div>
                <p style="margin: 0 0 50px 0;">Hormat saya,</p>
                <p style="margin: 0; font-weight: bold;">${name}</p>
                <p style="margin: 0; font-size: 12px; color: #555;">${contactStr.join(' | ')}</p>
            </div>
        `;

        letterContent.innerHTML = html;
    }

    // Event listeners are bound at the top of the script

    // PDF Export — opens a clean popup window with only the letter content and prints it
    btnExportPDF.addEventListener('click', () => {
        const currentTemplate = templateSelector.value;

        // Pick the right font family for the selected template
        const fontFamily = currentTemplate === 'template-modern' ? "'Arial', Helvetica, sans-serif"
                         : currentTemplate === 'template-klasik' ? "'Georgia', 'Times New Roman', serif"
                         : "'Times New Roman', Times, serif";

        // Extra CSS needed for modern/klasik templates
        const templateExtraCSS = currentTemplate === 'template-modern' ? `
            .letter-header h1 { color: #2563eb; border-bottom: 2px solid #2563eb; padding-bottom: 4px; margin-bottom: 16px; }
        ` : currentTemplate === 'template-klasik' ? `
            .letter-header { text-align: center; border-bottom: 1px solid #000; margin-bottom: 20px; padding-bottom: 10px; }
            .letter-header h1 { font-size: 18pt; text-transform: uppercase; letter-spacing: 2px; }
        ` : '';

        // Build the full HTML for the print window
        const printHTML = `<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Lamaran</title>
    <style>
        @page { size: A4 portrait; margin: 0; }
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            padding: 15mm 18mm;
            font-family: ${fontFamily};
            font-size: 12pt;
            line-height: 1.5;
            color: #000;
            background: #fff;
        }
        p  { margin: 0; }
        ol { padding-left: 20px; margin: 0 0 10px 0; list-style-type: decimal; }
        li { margin-bottom: 3px; }
        strong { font-weight: bold; }
        ${templateExtraCSS}
    </style>
</head>
<body>
    ${letterContent.innerHTML}
</body>
</html>`;

        // Open a small popup, write the HTML, then print and close
        const pw = window.open('', '_blank', 'width=900,height=700,scrollbars=yes');
        if (!pw) {
            Swal.fire({
                icon: 'warning',
                title: 'Popup Diblokir',
                text: 'Mohon izinkan popup dari situs ini di browser Anda, lalu coba lagi.',
            });
            return;
        }
        pw.document.open();
        pw.document.write(printHTML);
        pw.document.close();

        // Wait for fonts/layout to settle, then trigger print
        pw.onload = () => {
            setTimeout(() => {
                pw.focus();
                pw.print();
                // pw.close() — let user close; some browsers need the window open to save PDF
            }, 300);
        };

        // Fallback if onload already fired
        setTimeout(() => {
            try { pw.focus(); pw.print(); } catch(e) {}
        }, 800);
    });

});
</script>
@endpush
