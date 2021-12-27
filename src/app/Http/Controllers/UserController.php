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
    /**
     * Return the profile page.
     *
     * @return Illuminate\View\View
     */
    public function read()
    {
        return view('/profile');
    }

    /**
     * Update a user profile.
     *
     * @return Illuminate\View\View
     */
    public function update()
    {
        request()->validate([
            'name'          => 'required|string',
            // 'password'      => 'nullable', // TODO: Add this functionality
            'bio'           => 'nullable',
        ]);

        $user = User::where('id', '=', Auth::user()->id)->first();
        $user->name = request()->get('name');
        // $user->password = request()->get('password'); // TODO: Add this functionality
        $user->bio = request()->get('bio');
        $user->save();

        session()->flash("message", "Profile updated.");
        return redirect()->back();
    }

    /**
     * Update the user profile picture.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateProfilePic()
    {
        request()->validate([
            'upload_profile_pic' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);
        $id = request()->get('id');

        if (!is_dir(storage_path("app/public/avatars"))) {
            mkdir(storage_path("app/public/avatars"), 0775, true);
        }

        // Upload Avatar (IMAGE INTERVENTION - LARAVEL)
        Image::make(request()->file("upload_profile_pic"))->fit(150, 150)->save(storage_path("app/public/avatars/" . $id . ".png"));

        session()->flash("message", "Avatar updated successfully.");
        return redirect()->back();
    }

    /**
     * Delete a user profile (account).
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete()
    {
        $id = request()->get('id');
        $user = User::find($id)->delete();

        session()->flash("message", "User deleted.");
        return redirect()->back();
    }
}
