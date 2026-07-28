<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/api', function () {
    return view('api');
})->name('api');
Route::get('/slideshow', function () {
    return view('slideshow');
})->name('slideshow');
