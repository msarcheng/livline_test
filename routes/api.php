<?php

use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function() {

    Route::get('/user', function (Request $request) {
        return $request->user();
    });

    Route::controller(TaskController::class)->group(function() {
        Route::get('/tasks', 'index')->name('tasks');
        Route::get('/tasks/{id}', 'show')->name('show.task');
        Route::post('/tasks', 'store')->name('store.task');
        Route::put('/tasks/{id}', 'update')->name('update.task');
        Route::delete('/tasks/{id}', 'delete')->name('delete.task');
    });
});

Route::fallback(function () {
    return "This is coding test.";
});
