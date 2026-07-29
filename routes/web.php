<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ApplicationController;


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



Route::get('/', function () {
    return view('welcome');
})->name('dashboard');
Route::get('/api', function () {
    return view('api');
})->name('api');
Route::get('/slideshow', function () {
    return view('slideshow');
})->name('slideshow');
