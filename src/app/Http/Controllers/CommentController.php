<?php

namespace App\Http\Controllers;

use App\Mail\CommentNotification;
use App\Models\Comment;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

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

        $settings = Setting::first();
        if ($settings->comments) {
            $admins = User::where('role', '1')->get();
            foreach ($admins as $admin) {
                # TODO: Only send email to admins who have enabled email notifications
                Mail::to($admin->email)->queue(new CommentNotification(
                    $comment->user,
                    $comment->post,
                    $comment->comment
                ));
            }
        }

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
