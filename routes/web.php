<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return ['Laravel' => app()->version()];
    return "Livline Coding Test";
});

Route::fallback(function () {
    return "This is coding test.";
});

require __DIR__.'/auth.php';
