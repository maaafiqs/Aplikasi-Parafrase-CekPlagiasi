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
                            <input type="text" id="cvPhone" class="form-input" placeholder="08xx - xxxx - xxxx">
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
                        <label>Hard Skills (Pisahkan dengan koma/baris)</label>
                        <textarea id="cvHardSkills" class="form-input" rows="2" placeholder="PHP, Laravel, React, SQL, Git"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Soft Skills (Pisahkan dengan koma/baris)</label>
                        <textarea id="cvSoftSkills" class="form-input" rows="2" placeholder="Problem Solving, Public Speaking, Time Management"></textarea>
                    </div>
                </div>
            </form>

        </div>
    </div>
    
    <!-- Right Panel: Preview & Export (7 Cols) -->
    <div class="lg:col-span-7 space-y-6">
        <div class="bg-white/60 dark:bg-zinc-900/60 backdrop-blur-md rounded-3xl p-6 border border-slate-200/60 dark:border-zinc-800/60 shadow-sm relative overflow-hidden flex flex-col h-full">
            
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6 gap-4">
                <h2 class="text-xl font-bold flex items-center gap-2">
                    <i data-lucide="eye" class="w-5 h-5 text-indigo-500 dark:text-emerald-400"></i>
                    Pratinjau CV
                </h2>
                
                <div class="flex flex-wrap items-center gap-3">
                    <div class="flex items-center gap-2 bg-slate-100 dark:bg-zinc-800 p-1.5 rounded-xl border border-slate-200 dark:border-zinc-700">
                        <span class="text-xs font-semibold px-1 text-indigo-600 dark:text-emerald-400">ID</span>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" id="langToggle" class="sr-only peer">
                            <div class="w-9 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-zinc-600 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-zinc-500 peer-checked:bg-indigo-500 dark:peer-checked:bg-emerald-500"></div>
                        </label>
                        <span class="text-xs font-semibold px-1 text-slate-400 peer-checked:text-indigo-600 dark:peer-checked:text-emerald-400">EN</span>
                    </div>
                    
                    <button id="btnTranslate" class="px-3 py-2 rounded-xl bg-indigo-50 text-indigo-600 dark:bg-emerald-500/10 dark:text-emerald-400 font-semibold text-sm hover:bg-indigo-100 dark:hover:bg-emerald-500/20 transition-colors hidden items-center gap-2 border border-indigo-200 dark:border-emerald-500/30">
                        <i data-lucide="languages" class="w-4 h-4"></i>
                        Terjemahkan
                    </button>

                    <button id="btnExportPDF" class="px-4 py-2 rounded-xl bg-slate-900 dark:bg-white text-white dark:text-slate-900 font-semibold text-sm hover:bg-slate-800 dark:hover:bg-slate-100 transition-colors shadow-lg shadow-slate-900/20 flex items-center gap-2">
                        <i data-lucide="download" class="w-4 h-4"></i>
                        Unduh PDF
                    </button>
                </div>
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
        cvHardSkills: document.getElementById('cvHardSkills'),
        cvSoftSkills: document.getElementById('cvSoftSkills')
    };

    let experienceData = [];

    let educationData = [];

    let cvPhotoData = null;

    document.getElementById('cvPhoto').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(evt) {
                const img = new Image();
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    const MAX_WIDTH = 400; // Resize large images for PDF export safety
                    let width = img.width;
                    let height = img.height;
                    
                    if (width > MAX_WIDTH) {
                        height = Math.round((height * MAX_WIDTH) / width);
                        width = MAX_WIDTH;
                    }
                    
                    canvas.width = width;
                    canvas.height = height;
                    const ctx = canvas.getContext('2d');
                    ctx.drawImage(img, 0, 0, width, height);
                    
                    // Convert to lightweight JPEG data URL
                    cvPhotoData = canvas.toDataURL('image/jpeg', 0.85);
                    updatePreview();
                };
                img.src = evt.target.result;
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
                    <span class="text-xs font-bold text-slate-500">Pengalaman #${index + 1}</span>
                    <button type="button" class="text-xs text-red-500 hover:underline" onclick="removeExp(${index})">Hapus</button>
                </div>
                <div class="form-group mb-3">
                    <select class="form-input text-sm py-1.5" onchange="updateExp(${index}, 'type', this.value)">
                        <option value="Kerja" ${exp.type === 'Kerja' ? 'selected' : ''}>Pengalaman Kerja</option>
                        <option value="Magang/Seminar" ${exp.type === 'Magang/Seminar' ? 'selected' : ''}>Pengalaman Magang/Seminar</option>
                        <option value="Umum" ${exp.type === 'Umum' ? 'selected' : ''}>Pengalaman Umum</option>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-3">
                    <div class="form-group mb-0"><input type="text" class="form-input text-sm py-1.5" placeholder="Posisi" value="${exp.title}" oninput="updateExp(${index}, 'title', this.value)"></div>
                    <div class="form-group mb-0"><input type="text" class="form-input text-sm py-1.5" placeholder="Perusahaan/Institusi" value="${exp.company}" oninput="updateExp(${index}, 'company', this.value)"></div>
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
        experienceData.push({ type: 'Kerja', title: '', company: '', location: '', date: '', desc: '' });
        renderExpForms();
    });

    document.getElementById('btnAddEdu').addEventListener('click', () => {
        educationData.push({ degree: '', university: '', location: '', date: '' });
        renderEduForms();
    });


    let isEnglish = false;
    const langToggle = document.getElementById('langToggle');
    const btnTranslate = document.getElementById('btnTranslate');

    langToggle.addEventListener('change', (e) => {
        isEnglish = e.target.checked;
        if(isEnglish) {
            btnTranslate.style.display = 'flex';
        } else {
            btnTranslate.style.display = 'none';
        }
        updatePreview();
    });

    function getHeading(id, en) {
        return isEnglish ? en : id;
    }

    function updatePreview() {
        const name = elements.cvName.value.toUpperCase() || (isEnglish ? 'YOUR NAME' : 'NAMA ANDA');
        const contact = [
            elements.cvLocation.value,
            elements.cvPhone.value,
            elements.cvEmail.value,
            elements.cvLink.value
        ].filter(Boolean).join(' | ');

        let expHtml = '';
        if(experienceData.length > 0) {
            // Group experiences
            const groups = {
                'Kerja': experienceData.filter(e => e.type === 'Kerja'),
                'Magang/Seminar': experienceData.filter(e => e.type === 'Magang/Seminar'),
                'Umum': experienceData.filter(e => e.type === 'Umum')
            };

            const labels = {
                'Kerja': getHeading('PENGALAMAN KERJA', 'WORK EXPERIENCE'),
                'Magang/Seminar': getHeading('PENGALAMAN MAGANG & SEMINAR', 'INTERNSHIP & SEMINAR EXPERIENCE'),
                'Umum': getHeading('PENGALAMAN', 'EXPERIENCE')
            };

            for (const [key, group] of Object.entries(groups)) {
                if (group.length > 0) {
                    expHtml += `<div class="section-title">${labels[key]}</div>`;
                    group.forEach(exp => {
                        const bullets = exp.desc.split('\n').filter(s => s.trim()).map(s => `<li>${s}</li>`).join('');
                        expHtml += `
                            <div style="margin-bottom: 10px;">
                                <div class="item-header">
                                    <span>${(exp.company||'').toUpperCase()}</span>
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
            }
        }

        let eduHtml = '';
        if(educationData.length > 0) {
            eduHtml += `<div class="section-title">${getHeading('PENDIDIKAN', 'EDUCATION')}</div>`;
            educationData.forEach(edu => {
                eduHtml += `
                    <div style="margin-bottom: 10px;">
                        <div class="item-header">
                            <span>${(edu.university||'').toUpperCase()}</span>
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
        if (elements.cvHardSkills.value || elements.cvSoftSkills.value) {
            skillsHtml += `<div class="section-title">${getHeading('KEAHLIAN', 'SKILLS')}</div>`;
            if (elements.cvHardSkills.value) {
                const hsItems = elements.cvHardSkills.value.split(/[,|\n]+/).map(s => s.trim()).filter(Boolean);
                skillsHtml += `
                    <div style="font-weight: bold; margin-bottom: 3px; font-size: 10pt;">Hard Skills</div>
                    <ul style="margin: 0 0 10px 0; padding-left: 20px;">
                        ${hsItems.map(s => `<li>${s}</li>`).join('')}
                    </ul>
                `;
            }
            if (elements.cvSoftSkills.value) {
                const ssItems = elements.cvSoftSkills.value.split(/[,|\n]+/).map(s => s.trim()).filter(Boolean);
                skillsHtml += `
                    <div style="font-weight: bold; margin-bottom: 3px; font-size: 10pt;">Soft Skills</div>
                    <ul style="margin: 0; padding-left: 20px;">
                        ${ssItems.map(s => `<li>${s}</li>`).join('')}
                    </ul>
                `;
            }
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

    async function translateText(text) {
        if(!text) return text;
        try {
            const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const res = await fetch('/api/translate', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token
                },
                body: JSON.stringify({ text: text, lang: 'en' })
            });
            const data = await res.json();
            return data.translatedText || text;
        } catch(e) {
            console.error(e);
            return text;
        }
    }

    btnTranslate.addEventListener('click', async () => {
        Swal.fire({
            title: 'Menerjemahkan...',
            text: 'Harap tunggu, memanggil API',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        if (elements.cvSummary.value) elements.cvSummary.value = await translateText(elements.cvSummary.value);

        for (let i = 0; i < experienceData.length; i++) {
            if (experienceData[i].title) experienceData[i].title = await translateText(experienceData[i].title);
            if (experienceData[i].desc) experienceData[i].desc = await translateText(experienceData[i].desc);
        }

        for (let i = 0; i < educationData.length; i++) {
            if (educationData[i].degree) educationData[i].degree = await translateText(educationData[i].degree);
        }
        
        if (elements.cvHardSkills.value) elements.cvHardSkills.value = await translateText(elements.cvHardSkills.value);
        if (elements.cvSoftSkills.value) elements.cvSoftSkills.value = await translateText(elements.cvSoftSkills.value);

        renderExpForms();
        renderEduForms();
        updatePreview();

        Swal.fire({
            icon: 'success',
            title: 'Selesai!',
            text: 'Isi CV telah diterjemahkan.',
            timer: 2000,
            showConfirmButton: false
        });
    });

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

        // 1. Mock document.styleSheets to bypass html2canvas oklch parse error
        const originalStyleSheets = document.styleSheets;
        const cvStyleSheet = Array.from(document.styleSheets).find(sheet => {
            try {
                const rules = sheet.cssRules || sheet.rules;
                for (let i = 0; i < rules.length; i++) {
                    if (rules[i].selectorText && rules[i].selectorText.includes('.cv-preview')) {
                        return true;
                    }
                }
            } catch (e) {
                // Ignore cross-origin stylesheet errors
            }
            return false;
        });

        try {
            Object.defineProperty(document, 'styleSheets', {
                value: cvStyleSheet ? [cvStyleSheet] : [],
                configurable: true
            });
        } catch (e) {
            console.warn("Could not redefine document.styleSheets", e);
        }

        // 2. Proxy window.getComputedStyle to neutralize oklch values computed from parent inheritance
        const originalGetComputedStyle = window.getComputedStyle;
        window.getComputedStyle = function(el, pseudoEl) {
            const style = originalGetComputedStyle(el, pseudoEl);
            return new Proxy(style, {
                get(target, prop) {
                    if (prop === 'getPropertyValue') {
                        return function(propertyName) {
                            const val = target.getPropertyValue(propertyName);
                            if (typeof val === 'string' && val.includes('oklch')) {
                                if (propertyName.includes('background')) return 'rgb(255, 255, 255)';
                                return 'rgb(0, 0, 0)';
                            }
                            return val;
                        };
                    }
                    const val = target[prop];
                    if (typeof val === 'string' && val.includes('oklch')) {
                        if (prop === 'backgroundColor') return 'rgb(255, 255, 255)';
                        if (prop.toLowerCase().includes('color')) return 'rgb(0, 0, 0)';
                        return 'rgb(0, 0, 0)';
                    }
                    if (typeof val === 'function') {
                        return val.bind(target);
                    }
                    return val;
                }
            });
        };

        const printable = document.getElementById('previewContainer').cloneNode(true);
        printable.style.boxShadow = 'none';
        printable.style.width = '794px'; 
        printable.style.height = '1123px';
        printable.style.padding = '50px 70px';
        printable.style.position = 'absolute';
        printable.style.left = '-9999px';
        document.body.appendChild(printable);

        const opt = {
            margin:       0,
            filename:     'CV_ATS_' + (elements.cvName.value.replace(/ /g, '_') || 'Kerja') + '.pdf',
            image:        { type: 'jpeg', quality: 0.98 },
            html2canvas:  { scale: 2, useCORS: true },
            jsPDF:        { unit: 'in', format: 'a4', orientation: 'portrait' }
        };

        const cleanup = () => {
            // Restore document.styleSheets
            try {
                Object.defineProperty(document, 'styleSheets', {
                    value: originalStyleSheets,
                    configurable: true
                });
            } catch (e) {}
            // Restore getComputedStyle
            window.getComputedStyle = originalGetComputedStyle;
            // Remove cloned element
            if (printable.parentNode) {
                document.body.removeChild(printable);
            }
        };

        html2pdf().set(opt).from(printable).save().then(() => {
            cleanup();
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: 'CV ATS berhasil diunduh.',
                timer: 2000,
                showConfirmButton: false
            });
        }).catch(err => {
            cleanup();
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan saat mengekspor PDF: ' + (err.message || err)
            });
            console.error(err);
        });
    });

});
</script>
@endpush
