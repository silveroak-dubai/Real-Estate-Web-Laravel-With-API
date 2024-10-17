<?php

use App\Http\Controllers\AchievementController;
use App\Http\Controllers\FAQController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\Menu\MenuController;
use App\Http\Controllers\Menu\MenuItemController;
use App\Http\Controllers\OurBankController;
use App\Http\Controllers\OurPartnerController;
use App\Http\Controllers\OurTeam\DepartmentController;
use App\Http\Controllers\OurTeam\OurTeamController;
use App\Http\Controllers\OurTeam\TeamLanguageController;
use App\Http\Controllers\OurTeam\TeamSpecializedController;
use App\Http\Controllers\Post\CategoryController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TestimonialController;
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

    // Department Routes
    Route::name('departments.')->prefix('departments')->group(function(){
        Route::get('/',[DepartmentController::class,'index'])->name('index');
        Route::post('store-or-update',[DepartmentController::class,'storeOrUpdate'])->name('store-or-update');
        Route::post('edit',[DepartmentController::class,'edit'])->name('edit');
        Route::post('delete',[DepartmentController::class,'delete'])->name('delete');
        Route::post('bulk-delete',[DepartmentController::class,'bulkDelete'])->name('bulk-delete');
        Route::post('status-change',[DepartmentController::class,'statusChange'])->name('status-change');
        Route::get('ordering/{id}',[DepartmentController::class,'deptOrderForm'])->name('ordering.index');
        Route::post('ordering/store',[DepartmentController::class,'deptOrder'])->name('ordering');
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


    // Menu Routes
    Route::name('menus.')->prefix('menus/')->group(function(){
        Route::get('/',[MenuController::class,'index'])->name('index');

        Route::get('manage/{id?}',[MenuController::class,'create'])->name('create');

        Route::post('store',[MenuController::class,'store'])->name('store');
        Route::get('update-menu',[MenuController::class,'updateMenu'])->name('update-with.items');
        Route::post('delete',[MenuController::class,'delete'])->name('delete');

        Route::get('add-categories-to-menu', [MenuController::class, 'addCatToMenu'])->name('add.categories');
        Route::get('add-post-to-menu', [MenuController::class, 'addPostToMenu'])->name('add.posts');
        Route::get('add-custom-link', [MenuController::class, 'addCustomLink'])->name('add.customs');


        Route::post('update-menuitem/{id}',[MenuController::class,'updateMenuItem']);
        Route::get('delete-menuitem/{id}/{key}/{in?}',[MenuController::class,'deleteMenuItem']);

    });




    // Slug Generate Route
    Route::post('slug/generate',[MapController::class, 'generateSlug'])->name('slug.generate');


});





Route::get('unauthorized',[HomeController::class,'unauthorized']);
