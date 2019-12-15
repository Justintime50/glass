<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Settings;
use Auth;

class AdminController extends Controller
{
    public function read()
    {
        $users = User::all();
        $settings = Settings::first();

        return view('/admin', compact('users', 'settings'));
    }

    public function updateSettings(Request $request)
    {
        request()->validate([
            'title'       => 'required|string',
        ]);

        $settings = new Setting();
        $settings->title = request()->get('title');
        $settings->save();

        session()->flash("message", "Settings updated.");
        return redirect()->back();
    }
}
