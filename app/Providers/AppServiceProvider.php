<?php

namespace App\Providers;

use App\Facades\Markdown;
use App\Facades\RobotsFile;
use App\Facades\UrlFetcher;
use App\Facades\UrlHelper;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
