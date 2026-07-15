@extends('layouts.app')

@section('title', 'Pembuat Surat Lamaran - PenaHitung')

@push('scripts-top')
    <!-- html2pdf.js for client-side PDF generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        /* A4 aspect ratio and styling for preview */
        .a4-preview {
            width: 100%;
            aspect-ratio: 1 / 1.414;
            background: white;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            padding: 2.5rem;
            color: black;
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            line-height: 1.5;
            overflow: hidden;
            position: relative;
        }
        /* Ensure dark mode doesn't invert the preview paper */
        .dark .a4-preview {
            background: white;
            color: black;
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
                            <input type="text" id="senderPhone" class="form-input" placeholder="0812-3456-7890">
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
                
                <button id="btnExportPDF" class="px-5 py-2.5 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold text-sm hover:bg-slate-800 dark:hover:bg-slate-100 transition-colors shadow-lg shadow-slate-900/20 flex items-center gap-2">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    Unduh PDF
                </button>
            </div>

            <!-- A4 Preview Container -->
            <div class="w-full flex justify-center bg-slate-100 dark:bg-zinc-950/50 rounded-2xl p-4 overflow-x-auto">
                <!-- We set a fixed max-width for the preview to simulate A4, but keep it responsive -->
                <div id="previewContainer" class="a4-preview max-w-[800px] shrink-0" style="min-width: 600px;">
                    
                    <!-- Content injected via JS -->
                    <div id="letterContent"></div>
                    
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
        'mainStrength'
    ];

    const elements = {};
    formInputs.forEach(id => {
        elements[id] = document.getElementById(id);
    });

    const letterContent = document.getElementById('letterContent');
    const btnExportPDF = document.getElementById('btnExportPDF');
    const previewContainer = document.getElementById('previewContainer');

    function updatePreview() {
        const name = elements.senderName.value || '[Nama Anda]';
        const phone = elements.senderPhone.value;
        const email = elements.senderEmail.value;
        const address = elements.senderAddress.value;
        const link = elements.senderLink.value;

        const date = elements.letterDate.value || '[Tanggal]';
        const position = elements.jobPosition.value || '[Posisi]';
        const hr = elements.hrName.value || 'Bapak/Ibu HRD';
        const company = elements.companyName.value || '[Nama Perusahaan]';
        const compAddress = elements.companyAddress.value || '[Alamat Perusahaan]';
        const strength = elements.mainStrength.value || '[Jelaskan pengalaman/kekuatan Anda di sini]';

        // Build contact string
        let contactStr = [];
        if(phone) contactStr.push(phone);
        if(email) contactStr.push(email);
        if(address) contactStr.push(address);
        if(link) contactStr.push(link);

        const html = `
            <div style="text-align: right; margin-bottom: 30px;">
                <p style="margin: 0;">${date}</p>
            </div>

            <div style="margin-bottom: 30px;">
                <p style="margin: 0; font-weight: bold;">Yth. ${hr}</p>
                <p style="margin: 0;">${company}</p>
                <p style="margin: 0;">${compAddress}</p>
            </div>

            <div style="margin-bottom: 20px;">
                <p style="margin: 0;"><strong>Hal: Lamaran Pekerjaan - ${position}</strong></p>
            </div>

            <div style="margin-bottom: 15px;">
                <p style="margin: 0;">Dengan hormat,</p>
            </div>

            <div style="text-align: justify; margin-bottom: 15px;">
                <p style="margin: 0 0 10px 0;">Berdasarkan informasi yang saya peroleh, ${company} saat ini sedang membuka lowongan pekerjaan untuk posisi ${position}. Melalui surat ini, saya bermaksud untuk melamar posisi tersebut.</p>
                
                <p style="margin: 0 0 10px 0;">Nama saya ${name}. ${strength} Saya adalah individu yang cepat belajar, berdedikasi tinggi, dan mampu bekerja baik secara mandiri maupun dalam tim.</p>
                
                <p style="margin: 0 0 10px 0;">Bersama surat ini, saya juga melampirkan Curriculum Vitae (CV) sebagai bahan pertimbangan Bapak/Ibu. Saya sangat berharap dapat diberikan kesempatan wawancara agar saya dapat menjelaskan lebih rinci mengenai potensi dan kualifikasi yang saya miliki.</p>
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

    // Bind inputs to live preview
    formInputs.forEach(id => {
        elements[id].addEventListener('input', updatePreview);
    });

    // Initial render
    updatePreview();

    // PDF Export logic
    btnExportPDF.addEventListener('click', () => {
        Swal.fire({
            title: 'Mengekspor PDF...',
            text: 'Harap tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const opt = {
            margin:       0,
            filename:     'Surat_Lamaran_' + (elements.senderName.value.replace(/ /g, '_') || 'Kerja') + '.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        // Clone the preview to remove padding/shadows for clean export
        const printable = previewContainer.cloneNode(true);
        printable.style.boxShadow = 'none';
        printable.style.width = '794px'; // ~A4 width in px at 96dpi
        printable.style.height = '1123px';
        printable.style.padding = '50px 70px'; // margin for printing
        printable.style.position = 'absolute';
        printable.style.left = '-9999px';
        document.body.appendChild(printable);

        html2pdf().set(opt).from(printable).save().then(() => {
            document.body.removeChild(printable);
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'Surat Lamaran berhasil diunduh.',
                timer: 2000,
                showConfirmButton: false
            });
        }).catch(err => {
            document.body.removeChild(printable);
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat mengekspor PDF.'
            });
            console.error(err);
        });
    });

});
</script>
@endpush
