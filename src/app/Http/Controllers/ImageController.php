<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Intervention\Image\ImageManager;

class ImageController extends Controller
{
    public static $defaultBannerImage = 'pics/banner.jpg';
    public static $postImagesPath = 'storage/images/posts';
    public static $postImagesSubdirectory = 'posts';
    public static $avatarImagesSubdirectory = 'avatars';
    public static $imagesDir = 'images';

    /**
     * Show the image gallery.
     *
     * Images will have a unique ID associated with them which can be referenced to show the images in posts.
     *
     * @param Request $request
     * @return View
     */
    public function showImagesPage(Request $request): View
    {
        $images = Image::where('subdirectory', '=', self::$postImagesSubdirectory)
            ->get();

        return view('images', compact('images'));
    }

    /**
     * Upload an image to local storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function uploadPostImage(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        try {
            $file = $request->file('image');
            $filename = ImageController::sanatizeImageFilename($file);

            ImageManager::gd()
                ->read($file)
                ->save(ImageController::getImagePublicPath(self::$postImagesSubdirectory, $filename));

            $image = new Image();
            $image->subdirectory = self::$postImagesSubdirectory;
            $image->filename = $filename;
            $image->save();

            session()->flash('message', 'Image uploaded successfully.');
        } catch (\Exception $error) {
            session()->flash('error', "Image upload failed: $error");
        }

        return redirect()->back();
    }

    /**
     * Delete an image.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function deletePostImage(Request $request, int $id): RedirectResponse
    {
        try {
            $image = Image::findOrFail($id);
            unlink(ImageController::getImagePublicPath($image->subdirectory, $image->filename));
            $image->delete();
            session()->flash('message', 'Image deleted.');
        } catch (ModelNotFoundException $e) {
            // Don't delete an image that doesn't exist
        }

        return redirect()->back();
    }

    /**
     * Sanatizes an image filename.
     *
     * @param \Illuminate\Http\UploadedFile|\Illuminate\Http\UploadedFile[]|array|null $file
     * @return string
     */
    public static function sanatizeImageFilename($file): string
    {
        $filename = preg_replace('/[^A-Za-z0-9\-\_]/', '', $file->getClientOriginalName());
        $fileExtension = $file->getClientOriginalExtension();
        $newFilename = $filename . '-' . time() . '.' . $fileExtension;

        return $newFilename;
    }

    /**
     * Gets the image asset path for a post.
     *
     * @param ?string $subdirectory
     * @param ?string $imageName
     * @return string|null
     */
    public static function getImageAssetPath(?string $subdirectory, ?string $imageName): string|null
    {
        return isset($subdirectory) && isset($imageName)
            ? asset('storage/' . self::$imagesDir . "/$subdirectory/$imageName")
            : null;
    }

    /**
     * Gets the public image path for a post.
     *
     * @param ?string $subdirectory
     * @param ?string $imageName
     * @return string|null
     */
    public static function getImagePublicPath(?string $subdirectory, ?string $imageName): string|null
    {
        return isset($subdirectory) && isset($imageName)
            ?  public_path('storage/' . self::$imagesDir . "/$subdirectory/$imageName")
            : null;
    }
}
