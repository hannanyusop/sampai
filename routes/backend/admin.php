<?php

use App\Http\Controllers\Backend\DashboardController;
use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\TripController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->breadcrumbs(function (Trail $trail) {
        $trail->push(__('Home'), route('admin.dashboard'));
    });



Route::group(['prefix' => 'trip/', 'as' => 'trip.'], function (){

    Route::get('', [TripController::class, 'index'])->name('index');
    Route::get('search/', [TripController::class, 'search'])->name('search');


    Route::get('create/', [TripController::class, 'create'])->name('create');
    Route::post('create/', [TripController::class, 'insert'])->name('insert');
    Route::get('edit/{id}', [TripController::class, 'edit'])->name('edit');
    Route::post('edit/{id}', [TripController::class, 'update'])->name('update');

    Route::get('view/{id}', [TripController::class, 'view'])->name('view');
    Route::get('transferCode/{id}', [TripController::class, 'transferCode'])->name('transferCode');
    Route::get('addParcel/{id}', [TripController::class, 'addParcel'])->name('addParcel');
    Route::post('insertParcel/{id}', [TripController::class, 'insertParcel'])->name('insertParcel');
    Route::get('deleteParcel/{parcel_id}', [TripController::class, 'deleteParcel'])->name('deleteParcel');

    Route::get('close/{id}', [TripController::class, 'close'])->name('close');
    Route::get('picked/{id}', [TripController::class, 'picked'])->name('picked');

    Route::get('receive/', [TripController::class, 'receive'])->name('receive');
    Route::post('receive/', [TripController::class, 'receiveSave'])->name('receiveSave');
});
