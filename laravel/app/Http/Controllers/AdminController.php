<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class AdminController extends Controller
{
    public function read()
    {
        $users = User::all();

        return view('/admin', compact('users'));
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
