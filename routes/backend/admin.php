<?php

use App\Http\Controllers\Backend\DashboardController;
use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\TripController;
use App\Http\Controllers\Backend\OfficeController;
use App\Http\Controllers\Backend\ParcelController;
use App\Http\Controllers\Backend\TripRemarkController;

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

Route::group(['prefix' => 'trip-remark/', 'as' => 'trip-remark.'], function (){

    Route::post('create/{id}', [TripRemarkController::class, 'create'])->name('create');
    Route::get('delete/{id}', [TripRemarkController::class, 'delete'])->name('delete');

});

Route::group(['prefix' => 'parcel/', 'as' => 'parcel.'], function (){

    Route::get('', [ParcelController::class, 'index'])->name('index');
    Route::get('search/', [ParcelController::class, 'search'])->name('search');

    Route::get('view', [ParcelController::class, 'view'])->name('view');
    Route::get('scan/', [ParcelController::class, 'scan'])->name('scan');
    Route::post('deliver/{tracking_no}', [ParcelController::class, 'deliver'])->name('deliver');

});

Route::group(['prefix' => 'office/', 'as' => 'office.'], function (){

    Route::get('', [OfficeController::class, 'index'])->name('index');
    Route::get('create', [OfficeController::class, 'create'])->name('create');
    Route::post('create', [OfficeController::class, 'insert'])->name('insert');
    Route::get('edit/{id}', [OfficeController::class, 'edit'])->name('edit');
    Route::post('edit/{id}', [OfficeController::class, 'update'])->name('update');
    Route::get('delete/{id}', [OfficeController::class, 'delete'])->name('delete');

    Route::post('updateManager/{id}', [OfficeController::class, 'updateManager'])->name('updateManager');
    Route::get('updateManager/{id}', [OfficeController::class, 'updateManagerSave'])->name('updateManagerSave');

});
