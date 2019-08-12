<?php

namespace App\Http\ViewComposers;
use Illuminate\View\View;
use Auth;

class SettingsComposer
{
    public function compose(View $view) {
        $settings = \App\Models\Settings::first();
        $view->with('settings', $settings);
    }
}