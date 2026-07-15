@extends('layouts.app')

@section('title', 'Editor CV ATS - PenaHitung')

@push('scripts-top')
    <!-- html2pdf.js for client-side PDF generation -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <style>
        /* A4 aspect ratio and ATS CV styling */
        .cv-preview {
            width: 100%;
            aspect-ratio: 1 / 1.414;
            background: white;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            padding: 3rem;
            color: #000;
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 11pt;
            line-height: 1.4;
            overflow: hidden;
            position: relative;
        }
        /* Ensure dark mode doesn't invert the CV paper */
        .dark .cv-preview {
            background: white;
            color: #000;
        }
        
        .cv-preview h1 { font-size: 18pt; font-weight: bold; margin: 0 0 2px 0; text-align: center; text-transform: uppercase; }
        .cv-preview .contact-info { text-align: center; font-size: 9.5pt; margin-bottom: 15px; }
        .cv-preview .section-title { 
            font-size: 11pt; 
            font-weight: bold; 
            text-transform: uppercase; 
            border-bottom: 2px solid #000; 
            margin-top: 15px; 
            margin-bottom: 5px; 
            padding-bottom: 2px;
        }
        .cv-preview .item-header { display: flex; justify-content: space-between; font-weight: bold; }
        .cv-preview .item-sub { display: flex; justify-content: space-between; font-style: italic; margin-bottom: 5px; }
        .cv-preview p { text-align: justify; margin: 0; margin-bottom: 15px; font-size: 10pt; }
        .cv-preview ul { margin: 0 0 10px 0; padding-left: 20px; font-size: 10pt; }
        .cv-preview li { margin-bottom: 3px; }
        .cv-preview span { font-size: 10pt; }
        
        /* Form Styles */
        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
            color: #475569;
        }
        .dark .form-group label { color: #d4d4d8; }
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
        .dark .form-input { background: #27272a; border-color: #3f3f46; color: #f4f4f5; }
        .dark .form-input:focus { border-color: #10b981; box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1); }
        
        .section-card {
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 1rem;
            margin-bottom: 1rem;
            background: #f8fafc;
        }
        .dark .section-card {
            border-color: #3f3f46;
            background: #18181b;
        }
    </style>
@endpush

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
    
    <!-- Left Panel: Form Input (5 Cols) -->
    <div class="lg:col-span-5 space-y-6">
        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl p-6 border border-slate-200/60 dark:border-zinc-800/60 shadow-sm relative overflow-hidden">
            <h2 class="text-xl font-bold mb-6 flex items-center gap-2">
                <i data-lucide="briefcase" class="w-5 h-5 text-indigo-500 dark:text-emerald-400"></i>
                Data CV (ATS Friendly)
            </h2>
            
            <form id="cvForm" class="space-y-6">
                <!-- Personal Info -->
                <div class="space-y-4">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-zinc-200 border-b border-slate-200 dark:border-zinc-700 pb-2">Informasi Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="form-group md:col-span-2">
                            <label>Nama Lengkap</label>
                            <input type="text" id="cvName" class="form-input" placeholder="Budi Santoso">
                        </div>
                        <div class="form-group">
                            <label>Pas Foto (Opsional)</label>
                            <input type="file" id="cvPhoto" class="form-input" accept="image/*" style="padding: 0.55rem 1rem;">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group">
                            <label>No. Telepon / WA</label>
                            <input type="text" id="cvPhone" class="form-input" placeholder="0812-3456-7890">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" id="cvEmail" class="form-input" placeholder="budi@email.com">
                        </div>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group">
                            <label>Kota & Negara</label>
                            <input type="text" id="cvLocation" class="form-input" placeholder="Jakarta, Indonesia">
                        </div>
                        <div class="form-group">
                            <label>LinkedIn / Portfolio</label>
                            <input type="text" id="cvLink" class="form-input" placeholder="linkedin.com/in/budisantoso">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Ringkasan Profil (Summary)</label>
                        <textarea id="cvSummary" class="form-input" rows="3" placeholder="Software Engineer dengan pengalaman 3 tahun..."></textarea>
                    </div>
                </div>

                <!-- Experience -->
                <div class="space-y-4 pt-4">
                    <div class="flex justify-between items-center border-b border-slate-200 dark:border-zinc-700 pb-2">
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-zinc-200">Pengalaman Kerja</h3>
                        <button type="button" id="btnAddExp" class="text-xs text-indigo-600 dark:text-emerald-400 font-semibold hover:underline">+ Tambah</button>
                    </div>
                    <div id="experienceContainer" class="space-y-4">
                        <!-- Dynamic Experience Fields -->
                    </div>
                </div>

                <!-- Education -->
                <div class="space-y-4 pt-4">
                    <div class="flex justify-between items-center border-b border-slate-200 dark:border-zinc-700 pb-2">
                        <h3 class="text-sm font-semibold text-slate-800 dark:text-zinc-200">Pendidikan</h3>
                        <button type="button" id="btnAddEdu" class="text-xs text-indigo-600 dark:text-emerald-400 font-semibold hover:underline">+ Tambah</button>
                    </div>
                    <div id="educationContainer" class="space-y-4">
                        <!-- Dynamic Education Fields -->
                    </div>
                </div>

                <!-- Skills -->
                <div class="space-y-4 pt-4">
                    <h3 class="text-sm font-semibold text-slate-800 dark:text-zinc-200 border-b border-slate-200 dark:border-zinc-700 pb-2">Keahlian (Skills)</h3>
                    <div class="form-group">
                        <label>Daftar Keahlian (Pisahkan dengan koma)</label>
                        <textarea id="cvSkills" class="form-input" rows="2" placeholder="PHP, Laravel, React, SQL, Git"></textarea>
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
                    Pratinjau CV
                </h2>
                
                <button id="btnExportPDF" class="px-5 py-2.5 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold text-sm hover:bg-slate-800 dark:hover:bg-slate-100 transition-colors shadow-lg shadow-slate-900/20 flex items-center gap-2">
                    <i data-lucide="download" class="w-4 h-4"></i>
                    Unduh PDF ATS
                </button>
            </div>

            <!-- A4 Preview Container -->
            <div class="w-full flex justify-center bg-slate-100 dark:bg-zinc-950/50 rounded-2xl p-4 overflow-x-auto">
                <div id="previewContainer" class="cv-preview max-w-[800px] shrink-0" style="min-width: 600px;">
                    <!-- Content injected via JS -->
                    <div id="cvContent"></div>
                </div>
            </div>
            
        </div>
    </div>

</div>
@endsection

@push('scripts-bottom')
<script>
document.addEventListener('DOMContentLoaded', () => {
    
    const elements = {
        cvName: document.getElementById('cvName'),
        cvPhone: document.getElementById('cvPhone'),
        cvEmail: document.getElementById('cvEmail'),
        cvLocation: document.getElementById('cvLocation'),
        cvLink: document.getElementById('cvLink'),
        cvSummary: document.getElementById('cvSummary'),
        cvSkills: document.getElementById('cvSkills')
    };

    let experienceData = [];

    let educationData = [];

    let cvPhotoData = null;

    document.getElementById('cvPhoto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                cvPhotoData = evt.target.result;
                updatePreview();
            };
            reader.readAsDataURL(file);
        } else {
            cvPhotoData = null;
            updatePreview();
        }
    });

    const expContainer = document.getElementById('experienceContainer');
    const eduContainer = document.getElementById('educationContainer');
    const cvContent = document.getElementById('cvContent');
    const btnExportPDF = document.getElementById('btnExportPDF');

    // Bind basic inputs
    Object.values(elements).forEach(el => {
        el.addEventListener('input', updatePreview);
    });

    function renderExpForms() {
        expContainer.innerHTML = '';
        experienceData.forEach((exp, index) => {
            const card = document.createElement('div');
            card.className = 'section-card';
            card.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <span class="text-xs font-bold text-slate-500">Pekerjaan #${index + 1}</span>
                    <button type="button" class="text-xs text-red-500 hover:underline" onclick="removeExp(${index})">Hapus</button>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div class="form-group mb-0"><input type="text" class="form-input text-sm py-1.5" placeholder="Posisi" value="${exp.title}" oninput="updateExp(${index}, 'title', this.value)"></div>
                    <div class="form-group mb-0"><input type="text" class="form-input text-sm py-1.5" placeholder="Perusahaan" value="${exp.company}" oninput="updateExp(${index}, 'company', this.value)"></div>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div class="form-group mb-0"><input type="text" class="form-input text-sm py-1.5" placeholder="Lokasi" value="${exp.location}" oninput="updateExp(${index}, 'location', this.value)"></div>
                    <div class="form-group mb-0"><input type="text" class="form-input text-sm py-1.5" placeholder="Tanggal (e.g. Jan 2020 - Dec 2022)" value="${exp.date}" oninput="updateExp(${index}, 'date', this.value)"></div>
                </div>
                <div class="form-group mb-0">
                    <textarea class="form-input text-sm py-1.5" rows="3" placeholder="Deskripsi (Pisahkan dengan baris baru untuk bullet points)" oninput="updateExp(${index}, 'desc', this.value)">${exp.desc}</textarea>
                </div>
            `;
            expContainer.appendChild(card);
        });
        updatePreview();
    }

    function renderEduForms() {
        eduContainer.innerHTML = '';
        educationData.forEach((edu, index) => {
            const card = document.createElement('div');
            card.className = 'section-card';
            card.innerHTML = `
                <div class="flex justify-between items-center mb-3">
                    <span class="text-xs font-bold text-slate-500">Pendidikan #${index + 1}</span>
                    <button type="button" class="text-xs text-red-500 hover:underline" onclick="removeEdu(${index})">Hapus</button>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div class="form-group mb-0"><input type="text" class="form-input text-sm py-1.5" placeholder="Gelar / Jurusan" value="${edu.degree}" oninput="updateEdu(${index}, 'degree', this.value)"></div>
                    <div class="form-group mb-0"><input type="text" class="form-input text-sm py-1.5" placeholder="Universitas / Sekolah" value="${edu.university}" oninput="updateEdu(${index}, 'university', this.value)"></div>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div class="form-group mb-0"><input type="text" class="form-input text-sm py-1.5" placeholder="Lokasi" value="${edu.location}" oninput="updateEdu(${index}, 'location', this.value)"></div>
                    <div class="form-group mb-0"><input type="text" class="form-input text-sm py-1.5" placeholder="Tahun" value="${edu.date}" oninput="updateEdu(${index}, 'date', this.value)"></div>
                </div>
            `;
            eduContainer.appendChild(card);
        });
        updatePreview();
    }

    // Expose functions globally for inline onclick
    window.updateExp = (idx, field, val) => { experienceData[idx][field] = val; updatePreview(); };
    window.removeExp = (idx) => { experienceData.splice(idx, 1); renderExpForms(); };
    window.updateEdu = (idx, field, val) => { educationData[idx][field] = val; updatePreview(); };
    window.removeEdu = (idx) => { educationData.splice(idx, 1); renderEduForms(); };

    document.getElementById('btnAddExp').addEventListener('click', () => {
        experienceData.push({ title: '', company: '', location: '', date: '', desc: '' });
        renderExpForms();
    });

    document.getElementById('btnAddEdu').addEventListener('click', () => {
        educationData.push({ degree: '', university: '', location: '', date: '' });
        renderEduForms();
    });


    function updatePreview() {
        const name = elements.cvName.value.toUpperCase() || 'NAMA ANDA';
        const contact = [
            elements.cvLocation.value,
            elements.cvPhone.value,
            elements.cvEmail.value,
            elements.cvLink.value
        ].filter(Boolean).join(' | ');

        let expHtml = '';
        if(experienceData.length > 0) {
            expHtml += `<div class="section-title">PENGALAMAN KERJA</div>`;
            experienceData.forEach(exp => {
                const bullets = exp.desc.split('\n').filter(s => s.trim()).map(s => `<li>${s}</li>`).join('');
                expHtml += `
                    <div style="margin-bottom: 10px;">
                        <div class="item-header">
                            <span>${exp.company.toUpperCase()}</span>
                            <span>${exp.location}</span>
                        </div>
                        <div class="item-header" style="margin-bottom: 5px;">
                            <span>${exp.title}</span>
                            <span>${exp.date}</span>
                        </div>
                        ${bullets ? `<ul style="margin: 0; padding-left: 20px;">${bullets}</ul>` : ''}
                    </div>
                `;
            });
        }

        let eduHtml = '';
        if(educationData.length > 0) {
            eduHtml += `<div class="section-title">EDUCATION</div>`;
            educationData.forEach(edu => {
                eduHtml += `
                    <div style="margin-bottom: 10px;">
                        <div class="item-header">
                            <span>${edu.university.toUpperCase()}</span>
                            <span>${edu.location}</span>
                        </div>
                        <div class="item-header" style="margin-bottom: 5px;">
                            <span>${edu.degree}</span>
                            <span>${edu.date}</span>
                        </div>
                    </div>
                `;
            });
        }

        let skillsHtml = '';
        if(elements.cvSkills.value) {
            const skillItems = elements.cvSkills.value.split(/[,|\n]+/).map(s => s.trim()).filter(Boolean);
            const skillBullets = skillItems.map(s => `<li>${s}</li>`).join('');
            skillsHtml = `
                <div class="section-title">KEAHLIAN</div>
                <ul style="margin: 0; padding-left: 20px;">
                    ${skillBullets}
                </ul>
            `;
        }

        let headerHtml = `
            <h1>${name}</h1>
            <div class="contact-info">${contact}</div>
        `;
        if (cvPhotoData) {
            headerHtml = `
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 15px;">
                <div style="flex: 1; margin-right: 15px;">
                    <h1 style="text-align: left; margin-top: 0;">${name}</h1>
                    <div class="contact-info" style="text-align: left; margin-bottom: 0;">${contact}</div>
                </div>
                <div style="width: 100px; height: 125px; flex-shrink: 0;">
                    <img src="${cvPhotoData}" style="width: 100%; height: 100%; object-fit: cover; border: 1px solid #ccc; padding: 2px;" alt="Photo">
                </div>
            </div>
            `;
        }

        const html = `
            ${headerHtml}
            
            ${elements.cvSummary.value ? `
            <p style="text-align: justify; margin-top: 15px; margin-bottom: 15px;">${elements.cvSummary.value}</p>
            ` : ''}
            
            ${expHtml}
            ${eduHtml}
            ${skillsHtml}
        `;

        cvContent.innerHTML = html;
    }

    renderExpForms();
    renderEduForms();

    // PDF Export logic
    btnExportPDF.addEventListener('click', () => {
        Swal.fire({
            title: 'Mengekspor PDF ATS...',
            text: 'Harap tunggu sebentar',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        const opt = {
            margin:       0,
            filename:     'CV_ATS_' + (elements.cvName.value.replace(/ /g, '_') || 'Kerja') + '.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true },
            jsPDF:        { unit: 'pt', format: 'a4', orientation: 'portrait' }
        };

        const printable = document.getElementById('previewContainer').cloneNode(true);
        printable.style.boxShadow = 'none';
        // A4 proportions in pt for jsPDF (595 x 842 pt)
        // Set fixed width so HTML renders correctly before converting to canvas
        printable.style.width = '794px'; 
        printable.style.height = '1123px';
        printable.style.padding = '50px 70px';
        printable.style.position = 'absolute';
        printable.style.left = '-9999px';
        document.body.appendChild(printable);

        html2pdf().set(opt).from(printable).save().then(() => {
            document.body.removeChild(printable);
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'CV ATS berhasil diunduh.',
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
