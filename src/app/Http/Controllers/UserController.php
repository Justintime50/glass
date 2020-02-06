<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Validation\Rule;
use App\Models\User;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

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

        /*
        if(!Storage::exists('avatars')) {
            Storage::makeDirectory('avatars');
        }
        */

        $file = $request->file('upload_profile_pic');
        $img = Image::make($file)
            ->resize(320, 240)
            ->save(storage_path(), $file->getClientOriginalName());

        // Upload Profil Pic (IMAGE INTERVENTION - LARAVEL)
        // Image::make($request->file('upload_profile_pic'))->fit(150, 150)->save(storage_path('avatars/'.$id.'.png'));

        session()->flash("message", "Profile picture updated successfully.");
        return redirect()->back();
    }

}
