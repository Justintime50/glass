<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Auth;

class CommentsController extends Controller
{
    public function readComments(Request $request)
    {
        $comments = Comment::all();

        return view('/comments', compact('comments'));
    }

    public function create(Request $request)
    {
        request()->validate([
            'comment'       => 'required|string',
        ]);

        $comment = new Comment();
        $comment->comment = request()->get('comment');
        $comment->user_id = Auth::user()->id;
        $comment->post_id = request()->get('post_id');
        $comment->save();

        session()->flash("message", "Comment created.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $id = request()->get('id');
        $comment = Comment::find($id)->delete();

        session()->flash("message", "Comment deleted.");
        return redirect('/');
    }
}
