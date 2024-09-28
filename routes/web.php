<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OurBankController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\OurPartnerController;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\Post\CategoryController;
use App\Http\Controllers\Menu\MenuItemController;
use App\Http\Controllers\OurTeam\OurTeamController;
use App\Http\Controllers\OurTeam\TeamLanguageController;
use App\Http\Controllers\OurTeam\TeamSpecializedController;
use App\Http\Controllers\TestimonialController;

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
    Route::resource('posts',PostController::class)->except('destroy','update','show');
    Route::name('posts.')->prefix('posts')->group(function(){
        // Category Routes
        Route::name('categories.')->prefix('categories')->group(function(){
            Route::get('/',[CategoryController::class,'index'])->name('index');
            Route::post('store-or-update',[CategoryController::class,'storeOrUpdate'])->name('store-or-update');
            Route::post('edit',[CategoryController::class,'edit'])->name('edit');
            Route::post('delete',[CategoryController::class,'delete'])->name('delete');
            Route::post('bulk-delete',[CategoryController::class,'bulkDelete'])->name('bulk-delete');
            Route::post('status-change',[CategoryController::class,'statusChange'])->name('status-change');
        });

        Route::post('delete',[PostController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[PostController::class,'bulkDelete'])->name('bulk-delete');
    });

    // Our Banks Routes
    Route::name('our-banks.')->prefix('our-banks')->group(function(){
        Route::get('/',[OurBankController::class,'index'])->name('index');
        Route::post('store-or-update',[OurBankController::class,'storeOrUpdate'])->name('store-or-update');
        Route::post('edit',[OurBankController::class,'edit'])->name('edit');
        Route::post('delete',[OurBankController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[OurBankController::class,'bulkDelete'])->name('bulk-delete');
        Route::post('status-change',[OurBankController::class,'statusChange'])->name('status-change');
    });

    // Faq Routes
    Route::resource('faqs',FAQController::class)->except('destroy','update');
    Route::name('faqs.')->prefix('faqs')->group(function(){
        Route::post('delete',[FAQController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[FAQController::class,'bulkDelete'])->name('bulk-delete');
        Route::post('status-change',[FAQController::class,'statusChange'])->name('status-change');
    });

    // Achievement Routes
    Route::name('achievements.')->prefix('achievements')->group(function(){
        Route::get('/',[AchievementController::class,'index'])->name('index');
        Route::post('store-or-update',[AchievementController::class,'storeOrUpdate'])->name('store-or-update');
        Route::post('edit',[AchievementController::class,'edit'])->name('edit');
        Route::post('delete',[AchievementController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[AchievementController::class,'bulkDelete'])->name('bulk-delete');
        Route::post('status-change',[AchievementController::class,'statusChange'])->name('status-change');
    });

    // Our Partners Routes
    Route::name('our-partners.')->prefix('our-partners')->group(function(){
        Route::get('/',[OurPartnerController::class,'index'])->name('index');
        Route::post('store-or-update',[OurPartnerController::class,'storeOrUpdate'])->name('store-or-update');
        Route::post('edit',[OurPartnerController::class,'edit'])->name('edit');
        Route::post('delete',[OurPartnerController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[OurPartnerController::class,'bulkDelete'])->name('bulk-delete');
        Route::post('status-change',[OurPartnerController::class,'statusChange'])->name('status-change');
    });

    // Team Language Routes
    Route::name('team-languages.')->prefix('team-languages')->group(function(){
        Route::get('/',[TeamLanguageController::class,'index'])->name('index');
        Route::post('store-or-update',[TeamLanguageController::class,'storeOrUpdate'])->name('store-or-update');
        Route::post('edit',[TeamLanguageController::class,'edit'])->name('edit');
        Route::post('delete',[TeamLanguageController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[TeamLanguageController::class,'bulkDelete'])->name('bulk-delete');
        Route::post('status-change',[TeamLanguageController::class,'statusChange'])->name('status-change');
    });

    // Team Specilization Routes
    Route::name('team-specializeds.')->prefix('team-specializeds')->group(function(){
        Route::get('/',[TeamSpecializedController::class,'index'])->name('index');
        Route::post('store-or-update',[TeamSpecializedController::class,'storeOrUpdate'])->name('store-or-update');
        Route::post('edit',[TeamSpecializedController::class,'edit'])->name('edit');
        Route::post('delete',[TeamSpecializedController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[TeamSpecializedController::class,'bulkDelete'])->name('bulk-delete');
        Route::post('status-change',[TeamSpecializedController::class,'statusChange'])->name('status-change');
    });

    // Our Team Routes
    Route::resource('our-teams',OurTeamController::class)->except('destroy','update');
    Route::name('our-teams.')->prefix('our-teams')->group(function(){
        Route::post('delete',[OurTeamController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[OurTeamController::class,'bulkDelete'])->name('bulk-delete');
        Route::post('status-change',[OurTeamController::class,'statusChange'])->name('status-change');
    });

    // Testimonial Routes
    Route::name('testimonials.')->prefix('testimonials')->group(function(){
        Route::get('/',[TestimonialController::class,'index'])->name('index');
        Route::post('store-or-update',[TestimonialController::class,'storeOrUpdate'])->name('store-or-update');
        Route::post('edit',[TestimonialController::class,'edit'])->name('edit');
        Route::post('delete',[TestimonialController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[TestimonialController::class,'bulkDelete'])->name('bulk-delete');
        Route::post('status-change',[TestimonialController::class,'statusChange'])->name('status-change');
    });

    Route::get('manage-menus/{id?}',[MenuController::class,'index'])->name('menu.index');
    Route::post('create-menu',[MenuController::class,'store']);
    Route::get('update-menu',[MenuController::class,'updateMenu']);
    Route::get('delete-menu/{id}',[MenuController::class,'destroy']);

    // Menu Item Routes
    Route::get('add-categories-to-menu',[MenuItemController::class,'addCatToMenu']);
    Route::get('add-post-to-menu',[MenuItemController::class,'addPostToMenu']);
    Route::get('add-custom-link',[MenuItemController::class,'addCustomLink']);
    Route::post('update-menuitem/{id}',[MenuItemController::class,'updateMenuItem']);
    Route::get('delete-menuitem/{id}/{key}/{in?}',[MenuItemController::class,'deleteMenuItem']);








});





Route::get('unauthorized',[HomeController::class,'unauthorized']);
