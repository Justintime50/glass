<?php

namespace App\Providers;

use App\Http\Controllers\ImageController;
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
        $imagesPath = 'storage/' . ImageController::$imagesDir;
        $postsPath = $imagesPath . '/' . ImageController::$postImagesSubdirectory;
        $avatarsPath = $imagesPath . '/' . ImageController::$avatarImagesSubdirectory;
        if (!is_dir(public_path($postsPath))) {
            mkdir(public_path($postsPath), 0775, true);
        }
        if (!is_dir(public_path($avatarsPath))) {
            mkdir(public_path($avatarsPath), 0775, true);
        }

        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }

        Paginator::useBootstrap();
    }
}
