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
        $this->app->alias(Markdown::class, 'Markdown');
        $this->app->alias(RobotsFile::class, 'RobotsFile');
        $this->app->alias(UrlFetcher::class, 'UrlFetcher');
//        $this->app->alias(UrlHelper::class, 'UrlHelper');
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
