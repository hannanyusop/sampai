<?php

use App\Http\Controllers\Backend\DashboardController;
use Tabuna\Breadcrumbs\Trail;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\TripController;
use App\Http\Controllers\Backend\OfficeController;
use App\Http\Controllers\Backend\ParcelController;
use App\Http\Controllers\Backend\TripRemarkController;
use App\Http\Controllers\Backend\ReportController;

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


    Route::get('create/', [TripController::class, 'create'])->name('create')->middleware('permission:staff.distributor');
    Route::post('create/', [TripController::class, 'insert'])->name('insert')->middleware('permission:staff.distributor');
    Route::get('edit/{id}', [TripController::class, 'edit'])->name('edit')->middleware('permission:staff.distributor');
    Route::post('edit/{id}', [TripController::class, 'update'])->name('update')->middleware('permission:staff.distributor');

    Route::get('view/{id}', [TripController::class, 'view'])->name('view');
    Route::get('transferCode/{id}', [TripController::class, 'transferCode'])->name('transferCode')->middleware('permission:staff.runner');
    Route::get('addParcel/{id}', [TripController::class, 'addParcel'])->name('addParcel')->middleware('permission:staff.distributor');
    Route::post('insertParcel/{id}', [TripController::class, 'insertParcel'])->name('insertParcel')->middleware('permission:staff.distributor');
    Route::get('deleteParcel/{parcel_id}', [TripController::class, 'deleteParcel'])->name('deleteParcel')->middleware('permission:staff.distributor');

    Route::get('close/{id}', [TripController::class, 'close'])->name('close');
    Route::get('picked/{id}', [TripController::class, 'picked'])->name('picked');

    Route::get('receive/', [TripController::class, 'receive'])->name('receive')->middleware('permission:staff.inhouse');;
    Route::post('receive/', [TripController::class, 'receiveSave'])->name('receiveSave')->middleware('permission:staff.inhouse');
});

Route::group(['prefix' => 'trip-remark/', 'as' => 'trip-remark.'], function (){

    Route::post('create/{id}', [TripRemarkController::class, 'create'])->name('create');
    Route::get('delete/{id}', [TripRemarkController::class, 'delete'])->name('delete');

});

Route::group(['prefix' => 'parcel/', 'as' => 'parcel.'], function (){

    Route::get('', [ParcelController::class, 'index'])->name('index');
    Route::get('search/', [ParcelController::class, 'search'])->name('search');

    Route::get('view', [ParcelController::class, 'view'])->name('view');
    Route::get('scan/', [ParcelController::class, 'scan'])->name('scan')->middleware('permission:staff.inhouse');;
    Route::post('deliver/{tracking_no}', [ParcelController::class, 'deliver'])->name('deliver')->middleware('permission:staff.inhouse');;

});

Route::group(['prefix' => 'office/', 'as' => 'office.'], function (){

    Route::get('', [OfficeController::class, 'index'])->name('index')->middleware('permission:admin.access.user');;
    Route::get('create', [OfficeController::class, 'create'])->name('create')->middleware('permission:admin.access.user');
    Route::post('create', [OfficeController::class, 'insert'])->name('insert')->middleware('permission:admin.access.user');
    Route::get('edit/{id?}', [OfficeController::class, 'edit'])->name('edit')->middleware('permission:staff.manager|admin.access.user');
    Route::post('edit/{id?}', [OfficeController::class, 'update'])->name('update')->middleware('permission:staff.manager|admin.access.user');
    Route::get('delete/{id}', [OfficeController::class, 'delete'])->name('delete')->middleware('permission:admin.access.user');

    Route::get('staff', [OfficeController::class, 'staff'])->name('staff')->middleware('permission:staff.inhouse');

    Route::post('updateManager/{id}', [OfficeController::class, 'updateManager'])->name('updateManager')->middleware('permission:admin.access.user');;
    Route::get('updateManager/{id}', [OfficeController::class, 'updateManagerSave'])->name('updateManagerSave')->middleware('permission:admin.access.user');

});

Route::group(['prefix' => 'report/', 'as' => 'report.'], function (){

    Route::get('monthly', [ReportController::class, 'monthly'])->name('monthly')->middleware('permission:staff.distributor');

});
