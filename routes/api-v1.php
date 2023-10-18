<?php

use App\Http\Controllers\API\v1\AuthController;
use App\Http\Controllers\API\v1\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'middleware' => 'auth:api',
    'namespace' => 'API\v1',
    'prefix' => 'v1',
    'as' => 'api.'
], function (){

    Route::group(['prefix' => 'auth', 'as' => 'auth.'], function (){

        Route::post('login', [AuthController::class, 'login'])->name('login');
        Route::get('user', [AuthController::class, 'user'])->name('user');
    });


    Route::get('/getUserByToken', [UserController::class, 'getUserByToken'])
        ->middleware('auth:api')
        ->name('user');

});
