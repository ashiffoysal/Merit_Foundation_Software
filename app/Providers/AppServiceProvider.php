<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\CompanyInformation;
use App\Models\Seo;
use App\Models\Social;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // SHARING COMPANY INFORMATION DATA TO ALL VIEWS
        view()->composer('*', function ($view) {
            $companyInfo = CompanyInformation::first();
            $view->with('companyInfo', $companyInfo);
        });

        // SHARING SOCIAL MEDIA DATA TO ALL VIEWS

        view()->composer('*', function ($view) {
            $social = Social::first();
            $view->with('social', $social);
        });
        // SHARING SEO DATA TO ALL VIEWS
        view()->composer('*', function ($view) {
            $seoData = Seo::first();
            $view->with('seoData', $seoData);
           });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
