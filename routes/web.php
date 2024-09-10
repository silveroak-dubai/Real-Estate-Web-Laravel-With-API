<?php

use App\Http\Controllers\BlogController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;


Auth::routes([
    'register', // 404 Disabled
    'password.confirm', // 404 Disabled
    'password.email', // 404 Disabled
    'password.request', // 404 Disabled
    'password.reset', // 404 Disabled
    'password.update' // 404 Disabled
]);

Route::name('app.')->middleware(['auth','is_active'])->group(function(){
    Route::get('/', [HomeController::class, 'dashboard'])->name('dashboard');

    // User Routes
    Route::resource('users',UserController::class)->except('destroy','update');
    Route::name('users.')->prefix('users')->group(function(){
        Route::post('delete',[UserController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[UserController::class,'bulkDelete'])->name('bulk-delete');
        Route::post('status-change',[UserController::class,'statusChange'])->name('status-change');
    });

    // Profile Routes
    Route::get('profile',[ProfileController::class,'showProfileForm'])->name('profile');
    Route::post('profile/update',[ProfileController::class,'profileUpdate'])->name('profile.update');
    // Password Update Route
    Route::post('password-change',[ProfileController::class,'passwordUpdate'])->name('password.update');

    // Blog Routes
    Route::resource('blogs',BlogController::class)->except('destroy','update');
    Route::name('blogs.')->prefix('blogs')->group(function(){
        Route::post('delete',[BlogController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[BlogController::class,'bulkDelete'])->name('bulk-delete');
        Route::post('status-change',[BlogController::class,'statusChange'])->name('status-change');
    });

});





Route::get('unauthorized',[HomeController::class,'unauthorized']);
