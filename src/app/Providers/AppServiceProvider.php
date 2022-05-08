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
        $images_path = 'storage/images';
        if (!is_dir(public_path("$images_path/posts"))) {
            mkdir(public_path("$images_path/posts"), 0775, true);
        }
        if (!is_dir(public_path("$images_path/avatars"))) {
            mkdir(public_path("$images_path/avatars"), 0775, true);
        }

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();
    }
}
