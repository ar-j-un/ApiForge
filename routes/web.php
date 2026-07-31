<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\PostController;


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

Route::get('posts/create', [PostController::class, 'create'])->name('posts.create');
Route::post('posts', [PostController::class, 'store'])->name('posts.store');



Route::get('/', function () {
    return view('welcome');
})->name('dashboard');
Route::get('/api', function () {
    return view('api');
})->name('api');
Route::get('/slideshow', function () {
    return view('slideshow');
})->name('slideshow');
