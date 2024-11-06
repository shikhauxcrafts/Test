<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DataController;


use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('Test', function() {
 return Inertia::render('Test');
});
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
});

Route::get('get-title/{id}', [DataController::class, 'get_title'])->name('get.title');
Route::post('store-subtitle', [DataController::class, 'store_subtitle'])->name('store.subtitle');
Route::get('get-subitle', [DataController::class, 'get_subtitles'])->name('get.subtitle');


