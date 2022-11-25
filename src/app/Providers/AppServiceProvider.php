<?php

namespace App\Providers;

use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Setup directories as needed
        $imagesPath = 'storage/images';
        if (!is_dir(public_path("$imagesPath/posts"))) {
            mkdir(public_path("$imagesPath/posts"), 0775, true);
        }
        if (!is_dir(public_path("$imagesPath/avatars"))) {
            mkdir(public_path("$imagesPath/avatars"), 0775, true);
        }

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();
    }
}
