<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class RssFeedController extends Controller
{
    /**
     * Return an RSS feed of the most recent posts.
     *
     * @return Response
     */
    public function getFeed(Request $request): Response
    {
        $posts = Post::orderBy('created_at', 'desc')
            ->where('published', '=', 1)
            ->limit(50)
            ->get();

        return response()
            ->view('rss.feed', compact('posts'))
            ->header('Content-Type', 'application/xml');
    }
}
