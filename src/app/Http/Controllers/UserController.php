<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
            'name' => 'required|string',
            'bio'  => 'nullable',
        ]);

        $user = User::where('id', '=', Auth::user()->id)->first();
        $user->name = request()->get('name');
        $user->bio = request()->get('bio');
        $user->save();

        session()->flash('message', 'Profile updated.');
        return redirect()->back();
    }

    /**
     * Logic to update the user's password.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updatePassword()
    {
        request()->validate([
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::find(auth()->user()->id);

        $user->password = Hash::make(request()->password);
        $user->save();

        session()->flash('message', 'Your password was updated successfully.');
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

        // Upload Avatar (IMAGE INTERVENTION - LARAVEL)
        Image::make(
            request()->file('upload_profile_pic')
        )->fit(150, 150)->save(public_path("storage/images/avatars/$id.png"));

        session()->flash('message', 'Avatar updated successfully.');
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
        User::find($id)->delete();

        session()->flash('message', 'User deleted.');
        return redirect()->back();
    }
}
