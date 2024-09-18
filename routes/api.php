<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\FAQController;
use App\Http\Controllers\API\LoginController;
use App\Http\Controllers\API\OurBankController;
use App\Http\Controllers\API\OurPartnerController;
use App\Http\Controllers\API\AchievementController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Login User
Route::post('v1/login',[LoginController::class,'login']);

Route::prefix('v1/auth/')->middleware('auth:sanctum')->group(function(){
    // Our Bank Routes
    Route::prefix('our-banks')->group(function(){
        Route::get('/',[OurBankController::class,'listData']);
        Route::get('/{id}/view',[OurBankController::class,'show']);
    });

    // FAQ Routes
    Route::prefix('faqs')->group(function(){
        Route::get('/',[FAQController::class,'listData']);
        Route::get('/{id}/view',[FAQController::class,'show']);
    });

    // Achievement Routes
    Route::prefix('achievements')->group(function(){
        Route::get('/',[AchievementController::class,'listData']);
        Route::get('/{id}/view',[AchievementController::class,'show']);
    });

    // Our Partner Routes
    Route::prefix('our-partners')->group(function(){
        Route::get('/',[OurPartnerController::class,'listData']);
        Route::get('/{id}/view',[OurPartnerController::class,'show']);
    });

});

