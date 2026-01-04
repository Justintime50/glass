<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer('*', 'App\Http\ViewComposers\SettingsComposer');
    }
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
