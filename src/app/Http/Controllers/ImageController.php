<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;

class ImageController extends Controller
{
    public static $defaultBannerImage = 'pics/banner.jpg';
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
            ->orderByDesc('created_at')
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
            $filename = self::sanatizeImageFilename($file);
            $subdirectory = self::$postImagesSubdirectory;
            $temporaryPath = sys_get_temp_dir() . '/' . $filename;
            ImageManager::gd()->read($file)->save($temporaryPath);

            if (config('filesystems.default') === 's3') {
                $s3Path = self::$imagesDir . "/$subdirectory/$filename";
                if (config('filesystems.disks.s3.path_prefix') !== null) {
                    $s3Path = config('filesystems.disks.s3.path_prefix') . '/' . $s3Path;
                }
                Storage::disk('s3')->put($s3Path, file_get_contents($temporaryPath));
                unlink($temporaryPath);
            } else {
                $localPath = self::getImagePublicPath($subdirectory, $filename);
                rename($temporaryPath, $localPath);
            }

            $image = new Image();
            $image->subdirectory = $subdirectory;
            $image->filename = $filename;
            $image->save();

            session()->flash('message', 'Image uploaded successfully.');
        } catch (Exception) {
            session()->flash('error', 'Image upload failed, please try again.');
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
        } catch (ModelNotFoundException $e) {
            session()->flash('error', 'Image not found.');
            return redirect()->back();
        }

        try {
            if (config('filesystems.default') === 's3') {
                $s3Path = self::$imagesDir . "/$image->subdirectory/$image->filename";
                if (config('filesystems.disks.s3.path_prefix') !== null) {
                    $s3Path = config('filesystems.disks.s3.path_prefix') . '/' . $s3Path;
                }
                Storage::disk('s3')->delete($s3Path);
            } else {
                $localPath = self::getImagePublicPath($image->subdirectory, $image->filename);
                unlink($localPath);
            }

            $image->delete();
            session()->flash('message', 'Image deleted.');
        } catch (Exception) {
            session()->flash('error', 'Image deletion failed, please try again.');
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
        if (config('filesystems.default') === 's3') {
            $assetPath = config('filesystems.disks.s3.public_url') . '/' . self::$imagesDir . "/$subdirectory/$imageName"; // phpcs:ignore
            if (config('filesystems.disks.s3.path_prefix') !== null) {
                $assetPath = config('filesystems.disks.s3.public_url') . '/' . config('filesystems.disks.s3.path_prefix') . '/' . self::$imagesDir . "/$subdirectory/$imageName"; // phpcs:ignore
            }
            return $assetPath;
        } else {
            return isset($subdirectory, $imageName)
                ? asset('storage/' . self::$imagesDir . "/$subdirectory/$imageName")
                : null;
        }
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
        if (config('filesystems.default') === 's3') {
            $publicPath = config('filesystems.disks.s3.public_url') . '/' . self::$imagesDir . "/$subdirectory/$imageName"; // phpcs:ignore
            if (config('filesystems.disks.s3.path_prefix') !== null) {
                $publicPath = config('filesystems.disks.s3.public_url') . '/' . config('filesystems.disks.s3.path_prefix') . '/' . self::$imagesDir . "/$subdirectory/$imageName"; // phpcs:ignore
            }
            return $publicPath;
        } else {
            return isset($subdirectory, $imageName)
                ? public_path('storage/' . self::$imagesDir . "/$subdirectory/$imageName")
                : null;
        }
    }
}
