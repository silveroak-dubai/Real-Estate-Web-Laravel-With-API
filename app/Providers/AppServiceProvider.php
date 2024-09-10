<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Blade::if('permission', function ($permission){
            if(collect(\Illuminate\Support\Facades\Session::get('permission'))->contains($permission)){
                return true;
            }
            return false;
        });
    }
}
