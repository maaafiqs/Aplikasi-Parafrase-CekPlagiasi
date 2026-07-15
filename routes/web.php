<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('tools.word-counter');
});

Route::get('/surat-lamaran', function () {
    return view('tools.cover-letter');
});

Route::get('/cv-ats', function () {
    return view('tools.cv-ats');
});

Route::get('/parafrase', function () {
    return view('tools.paraphrase');
});

Route::get('/ats-checker', function () {
    return view('tools.ats-checker');
});

Route::post('/api/translate', function (\Illuminate\Http\Request $request) {
    $text = $request->input('text');
    $lang = $request->input('lang', 'en'); // target language
    
    if (empty($text)) return response()->json(['translatedText' => '']);
    
    try {
        $response = \Illuminate\Support\Facades\Http::get('https://translate.googleapis.com/translate_a/single', [
            'client' => 'gtx',
            'sl' => $request->input('sl', 'id'),
            'tl' => $lang,
            'dt' => 't',
            'q' => $text
        ]);
        
        if ($response->successful()) {
            $data = $response->json();
            $translatedText = '';
            if (isset($data[0]) && is_array($data[0])) {
                foreach ($data[0] as $segment) {
                    if (isset($segment[0])) {
                        $translatedText .= $segment[0];
                    }
                }
            }
            return response()->json(['translatedText' => $translatedText]);
        }
    } catch (\Exception $e) {
        // Fallback or error
    }
    
    return response()->json(['translatedText' => $text]); // fallback to original
});
