<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Intervention\Image\ImageManagerStatic as Image;

class PostController extends Controller
{
    /**
     * Show all of the blogs posts (paginated).
     *
     * @return Illuminate\View\View
     */
    public function readPosts()
    {
        $posts = Post::orderBy('created_at', 'desc')
            ->where('published', '=', 1)
            ->paginate(10);

        $categories = Category::all();

        return view('/posts', compact('posts', 'categories'));
    }

    /**
     * Show the "posts" page and filter by category.
     *
     * @param str $category
     * @return Illuminate\View\View
     */
    public function readPostsByCategory($category)
    {
        $category_record = Category::where('category', '=', $category)->firstOrFail();
        $posts = Post::orderBy('created_at', 'desc')
            ->where('published', '=', 1)
            ->where('category_id', '=', $category_record->id)
            ->paginate(10);

        $categories = Category::all();

        return view('/posts', compact('posts', 'category_record', 'categories'));
    }

    /**
     * Create a new post.
     *
     * Only admins can create posts.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create()
    {
        $post = new Post();

        request()->validate([
            'title'         => 'required|string',
            'slug' => [
                'required',
                Rule::unique('posts')->ignore($post->id)->where(function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
            ],
            'reading_time'  => 'nullable|numeric',
            'keywords'      => 'nullable|string',
            'category'      => 'string',
            'post'          => 'required|string',
        ]);

        $post->title = request()->get('title');
        $post->slug = request()->get('slug');
        $post->published = request()->get('published');
        $post->banner_image_url = request()->get('banner_image_url');
        $post->reading_time = request()->get('reading_time');
        $post->keywords = request()->get('keywords');
        $post->category_id = request()->get('category_id');
        $post->post = request()->get('post');
        $post->user_id = Auth::user()->id;
        $post->save();

        session()->flash("message", "Post created.");
        return redirect('/');
    }

    /**
     * Show the post content on a single page.
     *
     * The page will be viewable regardless of published status for admins and only viewable if published for normal users.
     *
     * @param str $user
     * @param str $slug
     * @return Illuminate\View\View
     */
    public function read($user, $slug)
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
            ->paginate(15); # TODO: Allow users to continue to go through all comments after reaching this limit via table or something similar

        return view('/post', compact('post', 'comments'));
    }

    /**
     * Show the "create post" page.
     *
     * @return Illuminate\View\View
     */
    public function readCreate()
    {
        $categories = Category::all();

        return view('/create-post', compact('categories'));
    }

    /**
     * Show the "edit post" page.
     *
     * @param str $user
     * @param str $slug
     * @return Illuminate\View\View
     */
    public function readEdit($user, $slug)
    {
        $post = Post::where('slug', '=', $slug)
            ->firstOrFail();
        $categories = Category::all();

        return view('/edit-post', compact('post', 'categories'));
    }

    /**
     * Update a post.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update()
    {
        $id = request()->get('id');
        $post = Post::where('id', '=', $id)->first();

        request()->validate([
            'title'         => 'required|string',
            'slug' => [
                'required',
                Rule::unique('posts')->ignore($post->id)->where(function ($query) {
                    return $query->where('user_id', Auth::user()->id);
                })
            ],
            'reading_time'  => 'nullable|numeric',
            'keywords'      => 'nullable|string',
            'category'      => 'string',
            'post'          => 'required|string',
        ]);

        $post->published = request()->get('published');
        $post->banner_image_url = request()->get('banner_image_url');
        $post->title = request()->get('title');
        $post->slug = request()->get('slug');
        $post->reading_time = request()->get('reading_time');
        $post->keywords = request()->get('keywords');
        $post->category_id = request()->get('category_id');
        $post->post = request()->get('post');
        $post->save();

        $url = str_replace(' ', '-', $post->user->name) . '/' . $post->slug;
        session()->flash("message", "Post updated.");
        return redirect($url);
    }

    /**
     * Delete a post.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete()
    {
        $id = request()->get('id');
        Post::find($id)->delete();

        session()->flash("message", "Post deleted.");
        return redirect('/');
    }

    /**
     * Show the image gallery.
     *
     * Images will have a unique ID associated with them which can be referenced to show the images in posts.
     *
     * @return Illuminate\View\View
     */
    public function readImages()
    {
        return view('/images');
    }

    /**
     * Upload an image to local storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function uploadPostImage(Request $request)
    {
        $request->validate([
            'upload_image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
        ]);

        // ~1 billion possible IDs, overlap potential should be small
        $id_min = 1000000000;
        $id_max = 9999999999;
        $id = mt_rand($id_min, $id_max);

        // Upload Avatar (IMAGE INTERVENTION - LARAVEL)
        Image::make($request->file("upload_image"))->save(public_path("storage/images/posts/$id.png"));

        session()->flash("message", "Image uploaded successfully.");
        return redirect()->back();
    }

    /**
     * Delete an image.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function deletePostImage()
    {
        $id = request()->get('id');
        Storage::delete("images/posts/$id");

        session()->flash("message", "Image deleted.");
        return redirect()->back();
    }
}
