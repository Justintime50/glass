<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use Auth;

class CommentController extends Controller
{
    /**
     * Show all the blog's comments on one page.
     *
     * @return Illuminate\View\View
     */
    public function readComments()
    {
        $comments = Comment::orderBy('created_at', 'desc')
            ->paginate(20);

        return view('/comments', compact('comments'));
    }

    /**
     * Create (or leave) a comment on a post.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create()
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

    /**
     * Delete a comment.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete()
    {
        $id = request()->get('id');
        $comment = Comment::find($id)->delete();

        session()->flash("message", "Comment deleted.");
        return redirect()->back();
    }
}
