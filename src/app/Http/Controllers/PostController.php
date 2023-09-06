<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;

class PostController extends Controller
{
    /**
     * Show all of the blogs posts (paginated).
     *
     * @param Request $request
     * @return View
     */
    public function showPosts(Request $request): View
    {
        $posts = Post::orderBy('created_at', 'desc')
            ->where('published', '=', 1)
            ->paginate(10);

        $categories = Category::orderBy('category', 'asc')
            ->get();

        $authors = User::orderBy('name', 'asc')
            ->where('role', '=', 1)
            ->get();

        return view('posts', compact('posts', 'categories', 'authors'));
    }

    /**
     * Show the "posts" page and filter by category.
     *
     * @param Request $request
     * @param string $category
     * @return View
     */
    public function showPostsByCategory(Request $request, string $category): View
    {
        $categoryRecord = Category::where('category', '=', $category)->firstOrFail();
        $posts = Post::orderBy('created_at', 'desc')
            ->where('published', '=', 1)
            ->where('category_id', '=', $categoryRecord->id)
            ->paginate(10);

        $categories = Category::orderBy('category', 'asc')
            ->get();

        $authors = User::orderBy('name', 'asc')
            ->where('role', '=', 1)
            ->get();

        return view('posts', compact('categoryRecord', 'posts', 'categories', 'authors'));
    }

    /**
     * Show the "posts" page and filter by author (user).
     *
     * @param Request $request
     * @param string $user
     * @return View
     */
    public function showPostsByUser(Request $request, string $user): View
    {
        $userRecord = User::where('name', '=', $user)->firstOrFail();
        $posts = Post::orderBy('created_at', 'desc')
            ->where('published', '=', 1)
            ->where('user_id', '=', $userRecord->id)
            ->paginate(10);

        $categories = Category::orderBy('category', 'asc')
            ->get();

        $authors = User::orderBy('name', 'asc')
            ->where('role', '=', 1)
            ->get();

        return view('posts', compact('userRecord', 'posts', 'categories', 'authors'));
    }

    /**
     * Show the post content on a single page.
     *
     * The page will be viewable regardless of published status for admins and only
     * viewable if published for normal users.
     *
     * @param Request $request
     * @param string $user
     * @param string $slug
     * @return Illuminate\View\View
     */
    public function showPost(Request $request, string $user, string $slug): View
    {
        if (Auth::user() && Auth::user()->role = 1) {
            $post = Post::where('slug', '=', $slug)
                ->firstOrFail();
        } else {
            $post = Post::where('slug', '=', $slug)
                ->where('published', '=', 1)
                ->firstOrFail();
        }
        $comments = Comment::where('post_id', '=', $post->id)
            ->orderBy('created_at', 'asc')
            ->paginate(10);

        return view('post', compact('post', 'comments'));
    }

    /**
     * Show the "create post" page.
     *
     * @param Request $request
     * @return View
     */
    public function showCreatePage(Request $request): View
    {
        $categories = Category::all();

        return view('create-post', compact('categories'));
    }

    /**
     * Show the "edit post" page.
     *
     * @param Request $request
     * @param string $user
     * @param string $slug
     * @return View
     */
    public function showEditPage(Request $request, string $user, string $slug): View
    {
        $post = Post::where('slug', '=', $slug)
            ->firstOrFail();
        $categories = Category::all();

        return view('edit-post', compact('post', 'categories'));
    }

    /**
     * Create a new post.
     *
     * Only admins can create posts.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        $post = new Post();

        $request->validate([
            'title' => 'required|string',
            'slug' => [
                'required',
                Rule::unique('posts')->ignore($post->id)->where(function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
            ],
            'keywords' => 'nullable|string',
            'category_id' => 'nullable|string',
            'post' => 'required|string',
            'banner_image_url' => 'nullable|string',
            'published' => 'required|integer',
        ]);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->published = $request->input('published');
        $post->banner_image_url = $request->input('banner_image_url');
        $post->keywords = $request->input('keywords');
        $post->category_id = $request->input('category_id');
        $post->post = $request->input('post');
        $post->user_id = Auth::user()->id;
        $post->save();

        session()->flash('message', 'Post created.');
        return redirect('/');
    }

    /**
     * Update a post.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $post = Post::find($id);

        $request->validate([
            'title'         => 'required|string',
            'slug' => [
                'required',
                Rule::unique('posts')->ignore($post->id)->where(function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
            ],
            'keywords' => 'nullable|string',
            'category_id' => 'nullable|string',
            'post' => 'required|string',
            'banner_image_url' => 'nullable|string',
            'published' => 'required|integer',
        ]);

        $post->published = $request->input('published');
        $post->banner_image_url = $request->input('banner_image_url');
        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->keywords = $request->input('keywords');
        $post->category_id = $request->input('category_id');
        $post->post = $request->input('post');
        $post->save();

        $url = str_replace(' ', '-', $post->user->name) . '/' . $post->slug;
        session()->flash('message', 'Post updated.');
        return redirect($url);
    }

    /**
     * Delete a post.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(Request $request, int $id): RedirectResponse
    {
        Post::find($id)->delete();

        session()->flash('message', 'Post deleted.');
        return redirect('/');
    }

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
        return view('images');
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
            'upload_image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // ~1 billion possible IDs, overlap potential should be small
        $idMin = 1000000000;
        $idMax = 9999999999;
        $id = mt_rand($idMin, $idMax);

        Image::make($request->file('upload_image'))->save(self::getImagePublicPath("$id.png"));

        session()->flash('message', 'Image uploaded successfully.');
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
        // TODO: Store image IDs in a database
        unlink(public_path("storage/images/posts/$id.png"));

        session()->flash('message', 'Image deleted.');
        return redirect()->back();
    }

    /**
     * Generate reading time for an article.
     *
     * @param Post $post
     * @return int
     */
    public static function generateReadingTime(Post $post): int
    {
        $averageReaderWordsPerMinute = 200;
        $bufferMinutes = 1; // This accounts for reading times of less than 1 minute

        $readingTime = round(str_word_count($post->post) / $averageReaderWordsPerMinute) + $bufferMinutes;

        return $readingTime;
    }

    /**
     * Gets the image asset path for a post.
     *
     * @param string $imageName
     * @return string
     */
    public static function getImageAssetPath(string $imageName): string
    {
        return asset("storage/images/posts/$imageName");
    }

    /**
     * Gets the public image path for a post.
     *
     * @param string $imageName
     * @return string
     */
    public static function getImagePublicPath(string $imageName): string
    {
        return public_path("storage/images/posts/$imageName");
    }
}
