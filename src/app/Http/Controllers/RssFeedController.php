<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;

class RssFeedController extends Controller
{
    public function feed()
    {
        $posts = Post::orderBy('created_at', 'desc')
            ->where('published', '=', 1)
            ->limit(50)->get();

        return response()->view('rss.feed', compact('posts'))->header('Content-Type', 'application/xml');
    }
}
