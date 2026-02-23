<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\FcmTokenController;
use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;

/*
 * Global Routes
 *
 * Routes that are used between both frontend and backend.
 */

// Switch between the included languages
Route::get('lang/{lang}', [LocaleController::class, 'change'])->name('locale.change');


Route::group([
    'middleware' => 'auth'
], function () {

    Route::post('fcm/token', [FcmTokenController::class, 'store'])->name('fcm.token');
    Route::delete('fcm/token', [FcmTokenController::class, 'destroy'])->name('fcm.token.destroy');
    Route::post('fcm/test-notification', [FcmTokenController::class, 'testNotification'])->name('fcm.test-notification');

    Route::group([
        'prefix' => 'account',
        'as' => 'account.'
    ], function () {
        Route::get('update-password', [AccountController::class, 'updatePassword'])->name('update-password');
    });
});

/*
 * Frontend Routes
 */
Route::group(['as' => 'frontend.'], function () {
    includeRouteFiles(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 *
 * These routes can only be accessed by users with type `admin`
 */
Route::group(['prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    includeRouteFiles(__DIR__.'/backend/');
});
