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

$paraphraseHandler = function (\Illuminate\Http\Request $request) {
    $text = $request->input('text', '');
    $mode = $request->input('mode', 'standard');

    if (empty(trim($text))) {
        return response()->json([
            'paraphrasedText' => '',
            'similarity' => 100,
            'originality' => 0
        ]);
    }

    $result = \App\Services\ParaphraseService::paraphrase($text, $mode);

    return response()->json([
        'paraphrasedText' => $result['paraphrased'],
        'similarity' => $result['similarity'],
        'originality' => $result['originality']
    ]);
};

Route::post('/api/paraphrase', $paraphraseHandler);
Route::post('/paraphrase-process', $paraphraseHandler);
Route::post('/paraphrase', $paraphraseHandler);

$translateHandler = function (\Illuminate\Http\Request $request) {
    $text = $request->input('text');
    $lang = $request->input('lang', 'en');
    $sl = $request->input('sl', 'id');
    
    if (empty($text)) return response()->json(['translatedText' => '']);
    
    $translated = \App\Services\ParaphraseService::translateChunk($text, $sl, $lang);
    if ($translated) {
        return response()->json(['translatedText' => $translated]);
    }
    
    return response()->json(['translatedText' => $text]);
};

Route::post('/api/translate', $translateHandler);
Route::post('/translate', $translateHandler);
