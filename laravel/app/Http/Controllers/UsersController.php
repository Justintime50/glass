<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    public function read(Request $request) 
    {
        // $profile = User::find(Auth::user());

        return view('/profile');
    }

    public function update(Request $request) 
    {
        request()->validate([
            // 'name'          => 'required|string',
            // 'password'      => 'nullable',
            'bio'           => 'nullable',
        ]);

        $user = User::where('id', '=', Auth::user()->id)->first();
        // $user->name = request()->get('name');
        // $user->password = request()->get('password');
        $user->bio = request()->get('bio');
        $user->save();

        session()->flash("message", "Profile updated.");
        return redirect()->back();
    }
}
