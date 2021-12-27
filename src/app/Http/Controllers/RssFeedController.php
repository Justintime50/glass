<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class RssFeedController extends Controller
{
    /**
     * Return an RSS feed of the most recent posts.
     *
     * @return Illuminate\View\View
     */
    public function feed()
    {
        $posts = Post::orderBy('created_at', 'desc')
            ->where('published', '=', 1)
            ->limit(50)->get();

        return response()->view('rss.feed', compact('posts'))->header('Content-Type', 'application/xml');
    }
}
