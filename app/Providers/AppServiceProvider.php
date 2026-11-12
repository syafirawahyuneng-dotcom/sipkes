<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\SiteSetting;

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
        // Share site_logo to all views
        View::composer('*', function ($view) {
            try {
                $siteLogo = SiteSetting::get('site_logo');
            } catch (\Throwable $e) {
                $siteLogo = null;
            }
            $view->with('siteLogo', $siteLogo);
        });
    }
}
