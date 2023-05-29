<?php

use App\Http\Controllers\Backend\DashboardController;
use App\Http\Controllers\Backend\UnregisteredParcelController;
use App\Models\UnregisteredParcel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Backend\TripController;
use App\Http\Controllers\Backend\OfficeController;
use App\Http\Controllers\Backend\ParcelController;
use App\Http\Controllers\Backend\TripRemarkController;
use App\Http\Controllers\Backend\ReportController;
use App\Http\Controllers\Backend\SettingController;
use App\Http\Controllers\Backend\TripBatchController;
use App\Http\Controllers\Backend\PickupController;

// All route names are prefixed with 'admin.'.
Route::redirect('/', '/admin/dashboard', 301);
Route::get('dashboard', [DashboardController::class, 'index'])
    ->name('dashboard');



Route::resource('tripBatch', TripBatchController::class);

Route::group(['prefix' => 'trip/', 'as' => 'trip.'], function (){

    Route::get('', [TripController::class, 'index'])->name('index');
    Route::get('checklist/{trip}', [TripController::class, 'checklist'])->name('checklist');
    Route::get('search/', [TripController::class, 'search'])->name('search');
    Route::get('assignParcel/{trip}/{parcel}', [TripController::class, 'assignParcel'])->name('assignParcel')->middleware('permission:staff.distributor');


    Route::get('create/', [TripController::class, 'create'])->name('create')->middleware('permission:staff.distributor');
    Route::post('create/', [TripController::class, 'insert'])->name('insert')->middleware('permission:staff.distributor');
    Route::get('edit/{id}', [TripController::class, 'edit'])->name('edit')->middleware('permission:staff.distributor');
    Route::post('edit/{id}', [TripController::class, 'update'])->name('update')->middleware('permission:staff.distributor');

    Route::get('view/{id}', [TripController::class, 'view'])->name('view');
    Route::get('transferCode/{id}', [TripController::class, 'transferCode'])->name('transferCode')->middleware('permission:staff.runner');
    Route::get('addParcel/{id}', [TripController::class, 'addParcel'])->name('addParcel')->middleware('permission:staff.distributor');
    Route::post('insertParcel/{id}', [TripController::class, 'insertParcel'])->name('insertParcel')->middleware('permission:staff.distributor');
    Route::get('deleteParcel/{parcel_id}', [TripController::class, 'deleteParcel'])->name('deleteParcel')->middleware('permission:staff.distributor');

    Route::get('master-list/{id}', [TripController::class, 'masterList'])->name('masterList')->middleware('permission:staff.distributor');

    Route::get('close/{id}', [TripController::class, 'close'])->name('close');
    Route::get('picked/{id}', [TripController::class, 'picked'])->name('picked');

    Route::get('receive/', [TripController::class, 'receive'])->name('receive')->middleware('permission:staff.inhouse');;
    Route::get('scan/', [TripController::class, 'scan'])->name('scan')->middleware('permission:staff.inhouse');;

    Route::post('receive/', [TripController::class, 'receiveSave'])->name('receiveSave')->middleware('permission:staff.inhouse');
    Route::get('receiveQR', [TripController::class, 'receiveSave'])->name('receiveQR')->middleware('permission:staff.inhouse');

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

Route::group(['prefix' => 'unregisteredParcel/', 'as' => 'unregisteredParcel.'], function (){

    Route::get('', [UnregisteredParcelController::class, 'index'])->name('index');
    Route::get('create/', [UnregisteredParcelController::class, 'create'])->name('create');
    Route::get('view/{id}', [UnregisteredParcelController::class, 'view'])->name('view');
    Route::post('store', [UnregisteredParcelController::class, 'store'])->name('store');
    Route::get('edit/{id}', [UnregisteredParcelController::class, 'edit'])->name('edit');
    Route::POST('edit/{id}', [UnregisteredParcelController::class, 'update'])->name('update');
});

Route::group([
    'prefix' => 'pickup/',
    'as' => 'pickup.',
], function (){
    Route::get('search', [PickupController::class, 'search'])->name('search');
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
    Route::get('income', [ReportController::class, 'income'])->name('income')->middleware('permission:staff.distributor');

});

Route::group(['prefix' => 'setting/', 'as' => 'setting.', 'middleware' => 'permission:admin.access.user'], function (){

    Route::get('payment', [SettingController::class, 'payment'])->name('payment');
    Route::post('payment', [SettingController::class, 'paymentSave'])->name('paymentSave');

    Route::get('system', [SettingController::class, 'system'])->name('system');
    Route::post('system', [SettingController::class, 'systemSave'])->name('systemSave');


});
