<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Show all the blog's comments on one page.
     *
     * @param Request $request
     * @return View
     */
    public function showComments(Request $request): View
    {
        $comments = Comment::orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'comments');

        return view('comments', compact('comments'));
    }

    /**
     * Create a comment on a post.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = new Comment();
        $comment->comment = $request->input('comment');
        $comment->user_id = Auth::user()->id;
        $comment->post_id = $request->input('post_id');
        $comment->save();

        session()->flash('message', 'Comment created.');
        return redirect()->back();
    }

    /**
     * Delete a comment.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(Request $request, int $id): RedirectResponse
    {
        Comment::find($id)->delete();

        session()->flash('message', 'Comment deleted.');
        return redirect()->back();
    }
}
