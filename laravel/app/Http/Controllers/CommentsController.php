<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Post;

class CommentsController extends Controller
{
    public function create(Request $request) 
    {
        request()->validate([

        ]);

        $post = new Post();
        $post->title = request()->get('title');
        $post->slug = request()->get('slug');
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
        $user = User($id);
        $slug = Post($slug);

        $post = Post::find($id);

        return view('/post', compact('post'));
    }

    public function edit(Request $request) 
    {

    }

    public function delete(Request $request) 
    {
        $post = Post::find($id)->delete();

        session()->flash("message", "Post deleted.");
        return redirect('/');
    }
}
