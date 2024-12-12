<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Intervention\Image\ImageManager;

class UserController extends Controller
{
    /**
     * Return the profile page.
     *
     * @return View
     */
    public function showProfile(): View
    {
        return view('profile');
    }

    /**
     * Update a user profile.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string',
            'bio'  => 'nullable',
        ]);

        $user = User::where('id', '=', Auth::user()->id)->first();
        $user->name = $request->input('name');
        $user->bio = $request->input('bio');
        $user->save();

        session()->flash('message', 'Profile updated.');
        return redirect()->back();
    }

    /**
     * Logic to update the user's password.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'password' => 'required|string|confirmed|min:8',
        ]);

        $user = User::find(auth()->user()->id);

        $user->password = Hash::make($request->input('password'));
        $user->save();

        session()->flash('message', 'Your password was updated successfully.');
        return redirect()->back();
    }

    /**
     * Update the user profile picture.
     *
     * 1. Store the image on disk
     * 2. Make an entry of the image filename in the images table
     * 3. Associate the new image to the user
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateProfilePic(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        try {
            $file = $request->file('image');
            $filename = ImageController::sanatizeImageFilename($file);
            $subdirectory = ImageController::$avatarImagesSubdirectory;
            $temporaryPath = sys_get_temp_dir() . '/' . $filename;
            ImageManager::gd()
                ->read($file)
                ->resize(150, 150)
                ->save($temporaryPath);

            if (config('filesystems.default') === 's3') {
                $s3Path = ImageController::$imagesDir . "/$subdirectory/$filename";
                $success = Storage::disk('s3')->put($s3Path, file_get_contents($temporaryPath));
                unlink($temporaryPath);
                if (!$success) {
                    throw new \Exception();
                }
            } else {
                $localPath = ImageController::getImagePublicPath($subdirectory, $filename);
                rename($temporaryPath, $localPath);
            }

            $image = new Image();
            $image->subdirectory = ImageController::$avatarImagesSubdirectory;
            $image->filename = $filename;
            $image->save();

            $user = User::find(Auth::user()->id);
            $user->image_id = $image->id;
            $user->save();

            session()->flash('message', 'Avatar updated successfully.');
        } catch (\Exception $error) {
            session()->flash('error', 'Avatar upload failed, please try again.');
        }

        return redirect()->back();
    }

    /**
     * Delete a user profile (account).
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(Request $request, int $id): RedirectResponse
    {
        $user = User::find($id);
        try {
            $image = Image::findOrFail($user->image_id);
            if (config('filesystems.default') === 's3') {
                $s3Path = ImageController::$imagesDir . "/$image->subdirectory/$image->filename";
                $success = Storage::disk('s3')->delete($s3Path);
                if (!$success) {
                    throw new \Exception();
                }
            } else {
                $localPath = ImageController::getImagePublicPath($image->subdirectory, $image->filename);
                unlink($localPath);
            }
            $image->delete();
        } catch (ModelNotFoundException $e) {
            // Don't delete an image that doesn't exist
        }
        $user->delete();

        session()->flash('message', 'User deleted.');
        return redirect()->back();
    }
}
