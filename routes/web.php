<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\BlogController;


Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])
        ->name('login');

    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
        ->name('logout');
    Route::resource('applications', ApplicationController::class)
        ->only(['index', 'create', 'store']);
});

Route::middleware('auth')->prefix('blogs')->name('blogs.')->group(function () {
    Route::get('/', [BlogController::class, 'index'])->name('index');
    Route::get('/create', [BlogController::class, 'create'])->name('create');
    Route::post('/', [BlogController::class, 'store'])->name('store');
    Route::get('/search', [BlogController::class, 'search'])->name('search');
    Route::delete('/{id}', [BlogController::class, 'destroy'])->name('destroy');
    Route::get('/{id}/edit', [BlogController::class, 'edit'])->name('edit');
    Route::put('/{id}', [BlogController::class, 'update'])->name('update');
});


Route::get('/', function () {
    return view('welcome');
})->name('dashboard');
Route::get('/api', function () {
    return view('api');
})->name('api');
Route::get('/slideshow', function () {
    return view('slideshow');
})->name('slideshow');
