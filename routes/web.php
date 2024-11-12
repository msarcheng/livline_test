<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    // return ['Laravel' => app()->version()];
    return "Livline Coding Test";
});

require __DIR__.'/auth.php';
