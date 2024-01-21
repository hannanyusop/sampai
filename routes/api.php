<?php

use App\Http\Controllers\API\V1\AuthController;
use App\Http\Controllers\API\V1\HelperController;
use App\Http\Controllers\API\V1\ParcelController;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('/login', [AuthController::class, 'login']);

Route::group([
    'middleware' => [ 'auth:api'],
], function () {

    Route::get('check', [AuthController::class, 'checkAuth']);
    Route::get('user', [AuthController::class, 'user']);
    Route::post('logout', [AuthController::class, 'logout']);

    Route::get('parcel-counter', [ParcelController::class, 'counter']);
    Route::group([
        'prefix' => 'parcel',
        'as' => 'parcel.',
    ], function () {
        Route::get('/', [ParcelController::class, 'index'])->name('index');
        Route::get('/{parcel}', [ParcelController::class, 'show'])->name('show');

        Route::post('/', [ParcelController::class, 'store'])->name('store');
        Route::put('/{parcel}', [ParcelController::class, 'update'])->name('update');
        Route::delete('/{parcel}', [ParcelController::class, 'destroy'])->name('destroy');
    });

    Route::group([
        'prefix' => 'helper',
        'as' => 'helper.',
    ], function () {
        Route::get('/drop-point', [HelperController::class, 'dropPoint'])->name('drop-point');
    });
});
