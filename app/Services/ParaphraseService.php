<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class ParaphraseService
{
    public static array $synonyms = [
        // Frasa Penghubung & Transisi (Multi-kata lebih awal)
        'oleh karena itu' => ['dengan demikian', 'maka dari itu', 'sehubungan dengan hal tersebut'],
        'dengan demikian' => ['oleh karena itu', 'maka dari itu', 'atas dasar tersebut'],
        'selain itu' => ['di samping itu', 'lebih lanjut', 'lebih jauh lagi'],
        'di samping itu' => ['selain itu', 'lebih lanjut'],
        'pada dasarnya' => ['secara fundamental', 'pada hakikatnya', 'pada prinsipnya'],
        'sehubungan dengan' => ['berkenaan dengan', 'terkait dengan', 'mengenai'],
        'berdasarkan hal tersebut' => ['merujuk pada hal itu', 'mengacu pada hal tersebut'],
        'akan tetapi' => ['namun', 'tetapi', 'kendati demikian'],
        'meskipun demikian' => ['walaupun demikian', 'kendati demikian', 'namun demikian'],
        'sampai saat ini' => ['hingga kini', 'sejauh ini'],
        'saat ini' => ['sekarang', 'dewasa ini', 'pada masa kini'],
        'pada umumnya' => ['secara umum', 'lazimnya', 'kebanyakan'],
        'seperti halnya' => ['sebagaimana', 'serupa dengan', 'layaknya'],
        'dalam rangka' => ['untuk', 'guna', 'demi'],
        'terdiri dari' => ['mencakup', 'meliputi', 'memuat'],
        'bertujuan untuk' => ['bermaksud untuk', 'ditujukan guna', 'berorientasi pada'],

        // Kata Sambung & Partikel
        'namun' => ['tetapi', 'akan tetapi', 'hanya saja'],
        'tetapi' => ['namun', 'akan tetapi'],
        'karena' => ['sebab', 'dikarenakan', 'lantaran'],
        'sebab' => ['karena', 'dikarenakan'],
        'dikarenakan' => ['karena', 'disebabkan oleh'],
        'sehingga' => ['alhasil', 'sampai-sampai', 'hingga'],
        'agar' => ['supaya', 'guna', 'dalam rangka'],
        'supaya' => ['agar', 'demi'],
        'untuk' => ['guna', 'demi', 'dalam rangka'],
        'guna' => ['untuk', 'demi'],
        'sedangkan' => ['sementara', 'adapun'],
        'sementara' => ['sedangkan', 'adapun'],
        'kemudian' => ['lalu', 'selanjutnya', 'setelah itu'],
        'lalu' => ['kemudian', 'lantas', 'setelahnya'],
        'jika' => ['apabila', 'bilamana', 'sekiranya'],
        'apabila' => ['jika', 'bila', 'kala'],
        'walaupun' => ['meskipun', 'kendatipun', 'biarpun'],
        'meskipun' => ['walaupun', 'kendati'],

        // Kata Kerja (Verba)
        'adalah' => ['merupakan', 'yakni', 'ialah'],
        'merupakan' => ['adalah', 'yakni', 'ialah'],
        'menggunakan' => ['memakai', 'memanfaatkan', 'menerapkan'],
        'memakai' => ['menggunakan', 'memanfaatkan'],
        'memanfaatkan' => ['menggunakan', 'mengoptimalkan', 'mendayagunakan'],
        'membantu' => ['menolong', 'mendukung', 'mempermudah'],
        'menolong' => ['membantu', 'mendukung'],
        'mendukung' => ['menopang', 'membantu', 'menyokong'],
        'menunjukkan' => ['memperlihatkan', 'mengindikasikan', 'menandakan'],
        'memperlihatkan' => ['menunjukkan', 'menampilkan', 'memaparkan'],
        'membuat' => ['menciptakan', 'menghasilkan', 'merancang'],
        'menciptakan' => ['menghasilkan', 'membuat', 'melahirkan'],
        'menghasilkan' => ['menciptakan', 'memperoleh', 'membuahkan'],
        'melakukan' => ['menjalankan', 'menerapkan', 'mengadakan'],
        'menjalankan' => ['melakukan', 'mempraktikkan', 'mengoperasikan'],
        'menerapkan' => ['mengaplikasikan', 'mempraktikkan', 'mengimplementasikan'],
        'memperoleh' => ['mendapatkan', 'meraih', 'mengantongi'],
        'mendapatkan' => ['memperoleh', 'meraih', 'menerima'],
        'memberikan' => ['menyediakan', 'memberi', 'menyuguhkan'],
        'menyediakan' => ['memberikan', 'menyiapkan', 'memfasilitasi'],
        'mempelajari' => ['mendalami', 'mengkaji', 'memahami'],
        'mengkaji' => ['meneliti', 'menelaah', 'menganalisis'],
        'meneliti' => ['mengkaji', 'meriset', 'menganalisis'],
        'menjelaskan' => ['menerangkan', 'memaparkan', 'menguraikan'],
        'memaparkan' => ['menjelaskan', 'menguraikan', 'menyajikan'],
        'menguraikan' => ['menjelaskan', 'memaparkan', 'menjabarkan'],
        'meningkatkan' => ['mendongkrak', 'mengoptimalkan', 'memaksimalkan'],
        'mengembangkan' => ['menumbuhkan', 'membangun', 'memajukan'],
        'membutuhkan' => ['memerlukan', 'menghendaki'],
        'memerlukan' => ['membutuhkan', 'menuntut'],
        'menyelesaikan' => ['merampungkan', 'menuntaskan', 'mengatasi'],
        'mengatasi' => ['menyelesaikan', 'menanggulangi'],
        'berharap' => ['menginginkan', 'berkeinginan', 'mengharapkan'],
        'menemukan' => ['mendapati', 'menjumpai', 'mengidentifikasi'],
        'mengetahui' => ['memahami', 'menyadari', 'mengenali'],
        'mengatakan' => ['menyatakan', 'mengungkapkan', 'menuturkan'],
        'menyatakan' => ['mengatakan', 'menegaskan', 'menyampaikan'],
        'mengamati' => ['memperhatikan', 'meninjau', 'melihat'],
        'membuktikan' => ['memperjelas', 'memastikan', 'memperkuat'],

        // Kata Sifat (Adjektiva) & Keterangan
        'sangat' => ['amat', 'sungguh', 'teramat'],
        'amat' => ['sangat', 'sungguh'],
        'penting' => ['krusial', 'utama', 'esensial'],
        'krusial' => ['sangat penting', 'utama'],
        'utama' => ['pokok', 'primer', 'terpenting'],
        'banyak' => ['sejumlah', 'berbagai', 'beragam'],
        'berbagai' => ['ragam', 'beraneka', 'sejumlah'],
        'besar' => ['signifikan', 'luas', 'tinggi'],
        'signifikan' => ['berarti', 'cukup besar', 'nyata'],
        'kecil' => ['minim', 'terbatas', 'sedikit'],
        'sedikit' => ['minim', 'terbatas'],
        'sulit' => ['sukar', 'rumit', 'kompleks'],
        'mudah' => ['gampang', 'sederhana', 'ringan'],
        'sering' => ['kerap', 'acap kali', 'seringkali'],
        'selalu' => ['senantiasa', 'terus-menerus'],
        'cepat' => ['pesat', 'lekas', 'singkat'],
        'jelas' => ['gamblang', 'nyata', 'terang'],
        'tepat' => ['akurat', 'sesuai', 'pas'],
        'baik' => ['bagus', 'positif', 'optimal'],
        'buruk' => ['jelek', 'negatif', 'kurang baik'],

        // Kata Benda (Nomina)
        'metode' => ['cara', 'teknik', 'pendekatan'],
        'cara' => ['metode', 'langkah', 'teknik'],
        'teknik' => ['metode', 'pendekatan'],
        'tujuan' => ['sasaran', 'maksud', 'target'],
        'sasaran' => ['tujuan', 'target', 'arah'],
        'masalah' => ['kendala', 'persoalan', 'hambatan'],
        'kendala' => ['hambatan', 'masalah', 'rintangan'],
        'hambatan' => ['kendala', 'rintangan'],
        'kemampuan' => ['kapabilitas', 'keahlian', 'potensi'],
        'keahlian' => ['kompetensi', 'kemampuan', 'keterampilan'],
        'keterampilan' => ['keahlian', 'kemampuan'],
        'pekerjaan' => ['profesi', 'tugas', 'karier'],
        'pengalaman' => ['rekam jejak', 'jam terbang'],
        'hasil' => ['capaian', 'output', 'perolehan'],
        'dampak' => ['pengaruh', 'efek', 'konsekuensi'],
        'faktor' => ['unsur', 'elemen', 'aspek'],
        'informasi' => ['keterangan', 'data', 'penjelasan'],
    ];

    public static function applySynonyms(string $text, float $intensity = 0.85): string
    {
        $synonyms = self::$synonyms;
        // Urutkan key dari yang terpanjang (frasa multi-kata dulu)
        uksort($synonyms, function ($a, $b) {
            return strlen($b) - strlen($a);
        });

        $result = $text;
        foreach ($synonyms as $word => $replacements) {
            if ((mt_rand(1, 100) / 100) > $intensity) {
                continue;
            }

            $pattern = '/\b' . preg_quote($word, '/') . '\b/iu';
            $result = preg_replace_callback($pattern, function ($matches) use ($replacements) {
                $replacement = $replacements[array_rand($replacements)];
                // Pertahankan kapitalisasi awal kata
                if (ctype_upper($matches[0][0])) {
                    return mb_convert_case($replacement, MB_CASE_TITLE, "UTF-8");
                }
                return $replacement;
            }, $result);
        }

        return $result;
    }

    public static function translateChunk(string $text, string $sl, string $tl): ?string
    {
        // 1. MyMemory Translated API
        try {
            $res = Http::timeout(4)->get('https://api.mymemory.translated.net/get', [
                'q' => $text,
                'langpair' => "{$sl}|{$tl}"
            ]);
            if ($res->successful()) {
                $data = $res->json();
                if (!empty($data['responseData']['translatedText']) && ($data['responseStatus'] == 200 || $data['responseStatus'] == '200')) {
                    $out = html_entity_decode($data['responseData']['translatedText'], ENT_QUOTES | ENT_HTML5, 'UTF-8');
                    if (!str_contains($out, 'MYMEMORY WARNING') && !str_contains($out, 'QUERY LENGTH LIMIT')) {
                        return trim($out);
                    }
                }
            }
        } catch (\Throwable $e) {
        }

        // 2. Fallback Google Translate with modern browser User-Agent
        try {
            $res = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/124.0.0.0 Safari/537.36'
            ])->timeout(4)->get('https://translate.googleapis.com/translate_a/single', [
                'client' => 'gtx',
                'sl' => $sl,
                'tl' => $tl,
                'dt' => 't',
                'q' => $text
            ]);
            if ($res->successful()) {
                $data = $res->json();
                $out = '';
                if (isset($data[0]) && is_array($data[0])) {
                    foreach ($data[0] as $seg) {
                        if (isset($seg[0])) {
                            $out .= $seg[0];
                        }
                    }
                }
                if (!empty($out)) {
                    return trim($out);
                }
            }
        } catch (\Throwable $e) {
        }

        return null;
    }

    public static function backTranslate(string $text, string $pivotLang = 'en'): string
    {
        // Pisahkan berdasarkan kalimat agar aman dari batas panjang teks
        $sentences = preg_split('/(?<=[.?!])\s+/u', $text, -1, PREG_SPLIT_NO_EMPTY);
        if (empty($sentences)) {
            return $text;
        }

        $results = [];
        foreach ($sentences as $sentence) {
            $sentence = trim($sentence);
            if (empty($sentence)) {
                continue;
            }

            $toPivot = self::translateChunk($sentence, 'id', $pivotLang);
            if ($toPivot) {
                $back = self::translateChunk($toPivot, $pivotLang, 'id');
                if ($back && trim($back) !== '') {
                    $results[] = $back;
                    continue;
                }
            }
            // Fallback per kalimat jika translasi gagal
            $results[] = self::applySynonyms($sentence, 1.0);
        }

        return implode(' ', $results);
    }

    public static function paraphrase(string $text, string $mode = 'standard'): array
    {
        $text = trim($text);
        if (empty($text)) {
            return ['paraphrased' => '', 'similarity' => 100, 'originality' => 0];
        }

        $output = '';

        if ($mode === 'creative') {
            // Mode Alih Bahasa Silang
            $output = self::backTranslate($text, 'en');
            // Jika hasil masih sama persis, perkaya dengan sinonim
            if (trim($output) === $text || empty($output)) {
                $output = self::applySynonyms($text, 1.0);
            }
        } elseif ($mode === 'maximum') {
            // Mode Kombinasi (Alih Bahasa + Pengayaan Sinonim)
            $output = self::backTranslate($text, 'en');
            $output = self::applySynonyms($output, 0.85);
        } else {
            // Mode Standar (Sinonim Cerdas & Kosakata)
            $output = self::applySynonyms($text, 1.0);
            // Cek apakah ada perubahan cukup signifikan
            similar_text($text, $output, $sim);
            if ($sim > 92) {
                $translated = self::backTranslate($text, 'en');
                if ($translated && $translated !== $text) {
                    $output = $translated;
                }
            }
        }

        // Jaminan keamanan: Hasil tidak boleh persis sama dengan input aslinya
        if (trim($output) === $text) {
            $output = self::applySynonyms($text, 1.0);
        }

        // Hitung persentase kemiripan & orisinalitas
        similar_text($text, $output, $similarity);
        $simRounded = round($similarity, 1);
        $originality = round(max(0, 100 - $simRounded), 1);

        return [
            'paraphrased' => $output,
            'similarity' => $simRounded,
            'originality' => $originality
        ];
    }
}
