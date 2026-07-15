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
