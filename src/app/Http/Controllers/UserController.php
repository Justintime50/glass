<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Http\Requests;
use Intervention\Image\ImageManagerStatic as Image;

class UserController extends Controller
{
    public function read(Request $request)
    {
        // $profile = User::find(Auth::user());

        return view('/profile');
    }

    public function update(Request $request)
    {
        request()->validate([
            'name'          => 'required|string',
            // 'password'      => 'nullable',
            'bio'           => 'nullable',
        ]);

        $user = User::where('id', '=', Auth::user()->id)->first();
        $user->name = request()->get('name');
        // $user->password = request()->get('password');
        $user->bio = request()->get('bio');
        $user->save();

        session()->flash("message", "Profile updated.");
        return redirect()->back();
    }

    /**
     * LOGIC TO UPDATE THE USER PROFILE PIC
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateProfilePic(Request $request)
    {
        $request->validate([
            'upload_profile_pic' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);
        $id = request()->get('id');

        if (!is_dir(storage_path("app/public/avatars"))) {
            mkdir(storage_path("app/public/avatars"), 0775, true);
        }

        // Upload Avatar (IMAGE INTERVENTION - LARAVEL)
        Image::make($request->file("upload_profile_pic"))->fit(150, 150)->save(storage_path("app/public/avatars/".$id.".png"));

        session()->flash("message", "Avatar updated successfully.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $id = request()->get('id');
        $user = User::find($id)->delete();

        session()->flash("message", "User deleted.");
        return redirect('/');
    }

}
