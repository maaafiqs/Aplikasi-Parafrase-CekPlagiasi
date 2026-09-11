<p align="center">
  <img src="https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/sparkles.svg" width="64" height="64" alt="TulisRapi Logo" />
</p>

<h1 align="center">TulisRapi</h1>

<p align="center">
  <strong>Toolkit Profesional Karir & Analisis Teks All-in-One Berbasis Web</strong>
</p>

<p align="center">
  Platform gratis, cepat, dan aman untuk analisis dokumen, penghitung kata presisi, pembuatan surat lamaran kerja, pembuat CV ATS, alat parafrase, serta pengecekan kesesuaian sistem ATS (Applicant Tracking System).
</p>

<p align="center">
  <a href="https://github.com/maaafiqs/Aplikasi-Parafrase-CekPlagiasi/stargazers"><img src="https://img.shields.io/github/stars/maaafiqs/Aplikasi-Parafrase-CekPlagiasi?style=for-the-badge&logo=github&color=6366f1" alt="GitHub Stars"></a>
  <a href="https://github.com/maaafiqs/Aplikasi-Parafrase-CekPlagiasi/network/members"><img src="https://img.shields.io/github/forks/maaafiqs/Aplikasi-Parafrase-CekPlagiasi?style=for-the-badge&logo=github&color=10b981" alt="GitHub Forks"></a>
  <a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel"></a>
  <a href="https://php.net"><img src="https://img.shields.io/badge/PHP-%5E8.3-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP"></a>
  <a href="https://tailwindcss.com"><img src="https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS"></a>
  <a href="https://opensource.org/licenses/MIT"><img src="https://img.shields.io/badge/License-MIT-amber?style=for-the-badge" alt="License"></a>
</p>

---

## 🌟 Tentang Proyek

**TulisRapi** lahir dari kebutuhan akan alat penulisan dan persiapan karir yang terintegrasi, praktis, serta menjamin privasi pengguna. Berbeda dari kebanyakan layanan online yang mengunggah berkas pengguna ke server pihak ketiga, **TulisRapi mengutamakan pemrosesan lokal di sisi peramban (*client-side processing*)**. Dokumen, esai, tugas akhir, maupun resume pribadi Anda tidak disimpan atau disalahgunakan.

Aplikasi ini dirancang dengan antarmuka modern, interaktif, responsif untuk perangkat mobile maupun desktop, serta mendukung tampilan tema Gelap (*Dark Mode*) dan Terang (*Light Mode*).

---

## ✨ Fitur-Fitur Utama

### 1. 📊 Analisis Teks & Penghitung Kata (`/`)
* **Metrik Komprehensif**: Menghitung jumlah kata, karakter (dengan & tanpa spasi), kalimat, paragraf, serta baris secara instan (*real-time*).
* **Estimasi Waktu**: Prediksi estimasi durasi membaca (*reading time*) dan durasi berbicara (*speaking time*).
* **Analisis Kata Kunci**: Distribusi frekuensi kata, kepadatan kata kunci (*keyword density*), serta pembobotan kata untuk keperluan SEO atau akademis.
* **Import File Dokumen**: Dukungan unggah berkas Microsoft Word (`.docx`) dan teks polos (`.txt`) langsung diolah oleh browser via Mammoth.js & JSZip.
* **Deteksi Referensi Akademik**: Mendeteksi pola sitasi/daftar pustaka (seperti format Mendeley, Zotero, APA, IEEE).
* **Pemeriksa Typo/Ejaan**: Deteksi ejaan kata baku bahasa Indonesia.
* **Ekspor Cepat**: Salin ke clipboard atau unduh hasil teks dalam format `.txt`.

### 2. ✉️ Pembuat Surat Lamaran Kerja ATS (`/surat-lamaran`)
* **Formulir Terstruktur**: Memandu penulisan data diri, instansi tujuan, posisi yang dilamar, paragraf pembuka, kompetensi, dan penutup.
* **Pilihan Template**: Pilihan tata letak elegan (Standar, Modern, Klasik) dengan tipografi formal.
* **Pratinjau Nyata A4 (*Live Preview*)**: Tampilan kertas dokumen ukuran A4 yang responsif dan proporsional.
* **Ekspor Cetak PDF Instan**: Menggunakan browser print engine berbasis vektor yang menghasilkan teks tajam, tidak pecah, tanpa terpotong ke halaman berikutnya, dan bersih dari footer/URL browser.

### 3. 📄 Pembuat CV ATS-Friendly (`/cv-ats`)
* **Standar Applicant Tracking System**: Format sederhana, bersih, dan mudah dibaca oleh parser mesin rekrutmen perusahaan.
* **Bagian Komplit**: Profil ringkas, riwayat kerja/pengalaman, pendidikan, keahlian teknis (*hard skills* & *soft skills*), proyek, serta sertifikasi.
* **Pratinjau Langsung**: Tampilan hasil siap cetak atau simpan ke format PDF kapan saja.

### 4. 🔄 Alat Parafrase Teks (`/parafrase`)
* **Menghindari Plagiarisme**: Membantu memvariasikan kalimat dan kosakata untuk menyegarkan karya tulis atau artikel ilmiah.
* **Pemrosesan Cerdas**: Terhubung dengan micro-endpoint penerjemah silang internal yang cepat dan efisien.
* **Penghitung Batas Karakter & Salin Cepat**: Memudahkan pengolahan teks bertahap.

### 5. 🎯 ATS Checker & Job Matcher (`/ats-checker`)
* **Komparasi CV vs Deskripsi Lowongan**: Tempelkan isi Job Description (JD) dan teks CV Anda untuk menganalisis kecocokannya.
* **Skor Persentase Kecocokan**: Menampilkan indikator visual seberapa besar relevansi kualifikasi CV Anda terhadap kriteria posisi kerja.
* **Deteksi Kata Kunci**: Mengidentifikasi kata kunci yang sudah terpenuhi (*Matched Keywords*) dan kata kunci penting yang belum tercantum (*Missing Keywords*).

---

## 🛠️ Tumpukan Teknologi (Tech Stack)

| Bagian | Teknologi |
| --- | --- |
| **Backend Framework** | [Laravel 12.x](https://laravel.com/) (PHP ^8.3) |
| **Frontend Styling** | [Tailwind CSS v4](https://tailwindcss.com/) |
| **Build Tool** | [Vite 8.x](https://vitejs.dev/) & Laravel Vite Plugin |
| **Ikon UI** | [Lucide Icons](https://lucide.dev/) |
| **Interaksi & Notifikasi** | [SweetAlert2](https://sweetalert2.github.io/) |
| **Parsing Dokumen Klien** | [Mammoth.js](https://github.com/mwilliamson/mammoth.js) & [JSZip](https://stuk.github.io/jszip/) |
| **Tipografi** | Google Fonts (*Plus Jakarta Sans* & *JetBrains Mono*) |

---

## 🚀 Panduan Instalasi Lokal

Ikuti langkah-langkah berikut untuk menjalankan proyek ini di lingkungan lokal Anda:

### 1. Prasyarat Sistem
Pastikan telah menginstal:
* **PHP >= 8.3** (disarankan via Laragon, XAMPP, atau PHP CLI native)
* **Composer**
* **Node.js >= 18.x** dan **NPM**
* **Git**

### 2. Kloning Repositori
```bash
git clone https://github.com/maaafiqs/Aplikasi-Parafrase-CekPlagiasi.git
cd Aplikasi-Parafrase-CekPlagiasi
```

### 3. Instal Dependensi Composer & Node
```bash
composer install
npm install
```

### 4. Konfigurasi Lingkungan (`.env`)
Salin file `.env.example` menjadi `.env` lalu generate application key:
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Jalankan Server Pengembangan
Jalankan frontend compiler dan server Laravel secara bersamaan:

```bash
# Terminal 1: Kompilasi aset Vite
npm run dev

# Terminal 2: Server Laravel
php artisan serve
```

Atau cukup gunakan skrip bawaan Laravel:
```bash
composer run dev
```

Buka peramban Anda dan akses:
```
http://localhost:8000
```
*(Atau `http://app-all-in-one.test` jika menggunakan Laragon virtual host).*

---

## 📁 Struktur Direktori Utama

```plaintext
app-all-in-one/
├── app/
│   └── Http/             # Pengendali & Request logic
├── resources/
│   ├── css/              # Konfigurasi Tailwind CSS
│   ├── js/               # JavaScript aplikasi
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php           # Master layout, navbar, changelog modal, dark mode
│       └── tools/
│           ├── word-counter.blade.php  # Alat Analisis Teks & Dokumen
│           ├── cover-letter.blade.php  # Alat Pembuat Surat Lamaran
│           ├── cv-ats.blade.php        # Alat Pembuat CV Format ATS
│           ├── paraphrase.blade.php    # Alat Parafrase Teks
│           └── ats-checker.blade.php   # Scanner & Evaluator Skor ATS
├── routes/
│   └── web.php           # Definisi rute halaman & API bridge
├── public/               # File publik & aset statis
└── package.json / composer.json
```

---

## 📋 Catatan Rilis & Versi

* **v1.3 (Terbaru)**:
  * Pembaruan engine ekspor PDF Surat Lamaran ke native popup printing (kualitas vektor, anti-pecah, tidak terpotong halaman).
  * Pembersihan header/footer otomatis dari browser pada dokumen cetak.
  * Preview responsif ukuran penuh tanpa terpotong (*scroll-friendly*).
* **v1.2**:
  * Optimasi penguraian berkas Word besar secara asinkron (mencegah freeze/hang pada browser).
  * Pembaruan widget donasi Saweria.
  * Menu navigasi yang lebih ringkas dan teratur via dropdown menu.
* **v1.1**:
  * Peluncuran fitur Pembuat CV ATS & ATS Checker.
  * Deteksi referensi sitasi Mendeley / Zotero.
  * Penyempurnaan palet warna Dark Mode.
* **v1.0**:
  * Rilis perdana TulisRapi (Penghitung Kata, Karakter, Analisis Teks & Typo Checker).

---

## 🤝 Kontribusi

Kontribusi selalu disambut dengan baik! Jika Anda menemukan bug, memiliki ide fitur baru, atau ingin melakukan perbaikan tampilan:
1. Fork repositori ini
2. Buat branch fitur baru (`git checkout -b fitur/FiturKeren`)
3. Commit perubahan Anda (`git commit -m 'Menambahkan fitur keren'`)
4. Push ke branch Anda (`git push origin fitur/FiturKeren`)
5. Ajukan **Pull Request**

---

## ☕ Dukung Pengembang

Aplikasi ini dikembangkan dan dipelihara secara independen agar tetap dapat diakses gratis oleh semua kalangan tanpa gangguan iklan. Jika alat ini bermanfaat bagi Anda, dukung pengembang dengan traktiran kopi:

<p align="left">
  <a href="https://saweria.co/maaafiqs" target="_blank">
    <img src="https://img.shields.io/badge/Saweria-Dukung%20via%20Saweria-F2B600?style=for-the-badge&logo=coffeescript&logoColor=black" alt="Dukung di Saweria">
  </a>
</p>

---

## 📄 Lisensi

Proyek ini dilisensikan di bawah lisensi [MIT License](LICENSE).

Dibuat dengan ❤️ oleh **[Maaafiqs Dev](https://maaafiqs.web.id)**.
