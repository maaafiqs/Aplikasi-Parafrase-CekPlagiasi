<p align="center">
  <img src="https://raw.githubusercontent.com/lucide-icons/lucide/main/icons/sparkles.svg" width="64" height="64" alt="TulisRapi Logo" />
</p>

<h1 align="center">TulisRapi</h1>

<p align="center">
  <strong>All-in-One Professional Career & Text Analytics Web Toolkit</strong>
</p>

<p align="center">
  A free, ultra-fast, and secure web application designed for comprehensive document analysis, precision word counting, ATS cover letter generation, ATS-friendly CV builder, text paraphrasing, and automated ATS match scoring.
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

## 🌟 Overview

**TulisRapi** is built to bridge the gap between academic writing assistance and career preparation tools. Unlike traditional online services that upload personal documents and resumes to remote servers, **TulisRapi prioritizes client-side browser processing**. Your research papers, theses, cover letters, and sensitive CV details are processed locally without unauthorized data retention.

Crafted with a modern, glassmorphic aesthetic, the application provides an intuitive experience across mobile and desktop devices with seamless **Dark Mode** and **Light Mode** support.

---

## ✨ Key Features

### 1. 📊 Advanced Text Analytics & Word Counter (`/`)
* **Comprehensive Metrics**: Real-time counting of words, characters (with & without spaces), sentences, paragraphs, and lines.
* **Reading & Speaking Time Estimates**: Accurate duration predictions based on standard human reading and speaking rates.
* **Keyword Density Analysis**: Evaluates word frequency and keyword distribution for SEO, academic, and content writing.
* **Document Import (`.docx` & `.txt`)**: In-browser document parsing using Mammoth.js and JSZip—zero files uploaded to the server.
* **Academic Reference Detection**: Automatically detects academic citations and references (e.g., Mendeley, Zotero, APA, IEEE).
* **Indonesian Spelling & Typo Checker**: Built-in typo detection and auto-suggestions.
* **Instant Export**: Copy to clipboard or export processed text directly to `.txt`.

### 2. ✉️ ATS Cover Letter Generator (`/surat-lamaran`)
* **Guided Step-by-Step Form**: Input applicant details, recipient organization, target role, intro, core accomplishments, and closing statements.
* **Multiple Typography Templates**: Choose between Standard, Modern, and Classic layouts tailored for corporate applications.
* **Real-time A4 Paper Preview**: True-to-scale document canvas with interactive live updates.
* **Vector-Quality PDF Export**: High-fidelity browser printing engine delivering sharp vector text without blurry canvas rasterization, blank pages, or unwanted browser URL headers/footers.

### 3. 📄 ATS-Friendly Resume Builder (`/cv-ats`)
* **Optimized for ATS Parsers**: Clean, single-column semantic structure easily parsed by Applicant Tracking Systems.
* **Full Section Support**: Contact information, professional summary, work experience, education, technical & soft skills, projects, and certifications.
* **Print & Export Ready**: Download directly as PDF or print with standard paper dimensions.

### 4. 🔄 Smart Paraphrasing Tool (`/parafrase`)
* **Anti-Plagiarism Rephrasing**: Restructure sentences and enrich vocabulary while preserving the original context.
* **Dual-Pass Bridge**: Leverages an efficient back-translation bridge for natural sentence variation.
* **Real-time Character Counter**: Clean interface with instant text clear and one-click copy.

### 5. 🎯 ATS Resume Checker & Job Matcher (`/ats-checker`)
* **CV vs. Job Description Comparison**: Compare your resume content against employer Job Descriptions (JDs).
* **Match Percentage Score**: Visual progress gauge indicating overall keyword alignment with the job listing.
* **Keyword Gap Analysis**: Highlights matched keywords and identifies missing keywords needed to optimize your application.

---

## 🛠️ Tech Stack

| Layer | Technology |
| --- | --- |
| **Backend Framework** | [Laravel 12.x](https://laravel.com/) (PHP ^8.3) |
| **Frontend Styling** | [Tailwind CSS v4](https://tailwindcss.com/) |
| **Bundler & Build Tool** | [Vite 8.x](https://vitejs.dev/) & Laravel Vite Plugin |
| **Icons** | [Lucide Icons](https://lucide.dev/) |
| **Interactive Modals** | [SweetAlert2](https://sweetalert2.github.io/) |
| **In-Browser Document Parsing** | [Mammoth.js](https://github.com/mwilliamson/mammoth.js) & [JSZip](https://stuk.github.io/jszip/) |
| **Typography** | Google Fonts (*Plus Jakarta Sans* & *JetBrains Mono*) |

---

## 🚀 Local Installation & Setup

Follow these steps to set up and run the project in your local development environment:

### 1. Prerequisites
Ensure the following tools are installed on your machine:
* **PHP >= 8.3** (via Laragon, XAMPP, or native PHP CLI)
* **Composer**
* **Node.js >= 18.x** & **NPM**
* **Git**

### 2. Clone the Repository
```bash
git clone https://github.com/maaafiqs/Aplikasi-Parafrase-CekPlagiasi.git
cd Aplikasi-Parafrase-CekPlagiasi
```

### 3. Install Dependencies
```bash
composer install
npm install
```

### 4. Configure Environment
Duplicate the environment template and generate an application encryption key:
```bash
cp .env.example .env
php artisan key:generate
```

### 5. Launch the Development Server
Run the Vite asset compiler and the Laravel development server:

```bash
# Terminal 1: Compile frontend assets with hot module reloading
npm run dev

# Terminal 2: Run Laravel backend server
php artisan serve
```

Or run everything using Laravel's concurrent runner:
```bash
composer run dev
```

Open your browser and navigate to:
```
http://localhost:8000
```
*(Or `http://app-all-in-one.test` if using Laragon virtual hosts).*

---

## 📁 Project Directory Structure

```plaintext
app-all-in-one/
├── app/
│   └── Http/             # Request handlers & controllers
├── resources/
│   ├── css/              # Tailwind CSS configuration & custom utilities
│   ├── js/               # Application JavaScript entrypoints
│   └── views/
│       ├── layouts/
│       │   └── app.blade.php           # Master layout, navigation, dark mode, changelog
│       └── tools/
│           ├── word-counter.blade.php  # Text analysis & document reader tool
│           ├── cover-letter.blade.php  # ATS cover letter generator
│           ├── cv-ats.blade.php        # ATS-friendly resume creator
│           ├── paraphrase.blade.php    # Smart paraphrase tool
│           └── ats-checker.blade.php   # ATS resume score & job matcher
├── routes/
│   └── web.php           # Web routes & translation bridge endpoint
├── public/               # Static assets & public entrypoint
└── package.json / composer.json
```

---

## 📋 Release Notes & Changelog

* **v1.3 (Current)**:
  * Overhauled Cover Letter PDF export to utilize the browser's native print engine (crisp vector quality, eliminates second-page cutoffs).
  * Removed default browser print artifacts (timestamps, URL footers, page counts).
  * Fully scrollable, unclipped live document preview canvas.
* **v1.2**:
  * Asynchronous processing for large Word (`.docx`) files to prevent UI freezing.
  * Enhanced donation banner integration (Saweria).
  * Collapsible dropdown navigation menu for cleaner interface ergonomics.
* **v1.1**:
  * Introduced ATS Resume Builder & ATS Checker tools.
  * Added Mendeley and Zotero reference pattern recognition.
  * Refined dark mode color palette.
* **v1.0**:
  * Initial public release of TulisRapi (Text analysis, word counter, and spelling diagnostics).

---

## 🤝 Contributing

Contributions, issues, and feature requests are welcome!
1. Fork the project
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a **Pull Request**

---

## ☕ Support the Developer

This project is independently built and maintained to stay 100% free, privacy-centric, and ad-free. If you find TulisRapi useful, consider supporting the developer:

<p align="left">
  <a href="https://saweria.co/maaafiqs" target="_blank">
    <img src="https://img.shields.io/badge/Saweria-Support%20via%20Saweria-F2B600?style=for-the-badge&logo=coffeescript&logoColor=black" alt="Support on Saweria">
  </a>
</p>

---

## 📄 License

This project is licensed under the [MIT License](LICENSE).

Crafted with ❤️ by **[Maaafiqs Dev](https://maaafiqs.web.id)**.
