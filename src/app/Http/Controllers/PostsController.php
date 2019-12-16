<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;
use Auth;

class PostsController extends Controller
{
    public function readPosts(Request $request)
    {
        $posts = Post::all()
            ->sortByDesc('created_at');

        return view('/posts', compact('posts'));
    }

    public function create(Request $request)
    {
        request()->validate([
            'title'         => 'required|string',
            'slug' => Rule::unique('posts')->where(function ($query) {
                return $query->where('user_id', Auth::user()->id);
            }),
            'reading_time'  => 'nullable|numeric',
            'keywords'      => 'nullable|string',
            'category'      => 'string',
            'post'          => 'required|string',
        ]);

        $post = new Post();
        $post->title = request()->get('title');
        $post->slug = request()->get('slug');
        $post->banner_image_url = request()->get('banner_image_url');
        $post->reading_time = request()->get('reading_time');
        $post->keywords = request()->get('keywords');
        $post->category = request()->get('category');
        $post->post = request()->get('post');
        $post->user_id = Auth::user()->id;
        $post->save();

        session()->flash("message", "Post created.");
        return redirect('/');
    }

    public function read($user, $slug)
    {
        $post = Post::where('slug', '=', $slug)
            ->first();
        $comments = Comment::where('post_id', '=', $post->id)
            ->get();

        return view('/post', compact('post', 'comments'));
    }

    public function readEdit($user, $slug)
    {
        $post = Post::where('slug', '=', $slug)
            ->first();

        return view('/edit-post', compact('post'));
    }

    public function update(Request $request)
    {
        request()->validate([
            'title'         => 'required|string',
            /* TODO: fix validation to allow the same slug
            'slug' => Rule::unique('posts')->where(function ($query) {
                return $query->where('user_id', Auth::user()->id);
            }),
            */
            'reading_time'  => 'nullable|numeric',
            'keywords'      => 'nullable|string',
            'category'      => 'string',
            'post'          => 'required|string',
        ]);

        $id = request()->get('id');
        $post = Post::where('id', '=', $id)->first();
        $post->banner_image_url = request()->get('banner_image_url');
        $post->title = request()->get('title');
        $post->slug = request()->get('slug');
        $post->reading_time = request()->get('reading_time');
        $post->keywords = request()->get('keywords');
        $post->category = request()->get('category');
        $post->post = request()->get('post');
        $post->save();

        $url = str_replace(' ', '-', $post->user->name).'/'.$post->slug;
        session()->flash("message", "Post updated.");
        return redirect($url);
    }

    public function delete(Request $request)
    {
        $id = request()->get('id');
        $post = Post::find($id)->delete();

        session()->flash("message", "Post deleted.");
        return redirect('/');
    }
}
