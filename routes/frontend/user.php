<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\User\AccountController;
use App\Http\Controllers\Frontend\User\DashboardController;
use App\Http\Controllers\Frontend\User\ProfileController;
use Tabuna\Breadcrumbs\Trail;
use App\Http\Controllers\Frontend\User\SubscribeController;

Route::group(['as' => 'user.', 'middleware' => ['auth', 'password.expires', config('boilerplate.access.middleware.verified')]], function () {
    Route::get('dashboard', [DashboardController::class, 'index'])
        ->middleware('is_user')
        ->name('dashboard')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.index')
                ->push(__('Dashboard'), route('frontend.user.dashboard'));
        });

    Route::get('account', [AccountController::class, 'index'])
        ->name('account')
        ->breadcrumbs(function (Trail $trail) {
            $trail->parent('frontend.index')
                ->push(__('My Account'), route('frontend.user.account'));
        });

    Route::patch('profile/update', [ProfileController::class, 'update'])->name('profile.update');

    Route::group([
        'prefix' => 'subscribe/',
        'as' => 'subscribe.'
    ],function (){
        Route::get('', [SubscribeController::class, 'index'])->name('index');
        Route::get('view/{id}', [SubscribeController::class, 'view'])->name('view');
        Route::get('create', [SubscribeController::class, 'create'])->name('create');
        Route::post('create', [SubscribeController::class, 'insert'])->name('insert');
        Route::get('edit/{id}', [SubscribeController::class, 'edit'])->name('edit');
        Route::post('edit/{id}', [SubscribeController::class, 'update'])->name('update');
        Route::get('delete/{id}', [SubscribeController::class, 'delete'])->name('delete');

    });
});
