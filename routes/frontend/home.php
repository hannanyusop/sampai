<?php

use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\TermsController;

/*
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', function (){

    return view('frontend.index');
})->name('index');

Route::get('/track', [HomeController::class, 'track'])->name('track');
Route::get('terms', [TermsController::class, 'index'])
    ->name('pages.terms');
