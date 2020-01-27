<?php

namespace App\Http\ViewComposers;

use Illuminate\View\View;
use Auth;

class SettingsComposer
{
    public function compose(View $view)
    {
        $settings = \App\Models\Setting::first();
        $view->with('settings', $settings);
    }
}
