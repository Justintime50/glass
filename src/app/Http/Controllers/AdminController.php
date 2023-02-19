<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Show the admin page including users, settings, posts, and categories.
     *
     * @return Illuminate\View\View
     */
    public function read()
    {
        $users = User::orderBy('name', 'asc')
            ->paginate(10, ['*'], 'users');
        $settings = Setting::first();
        $posts = Post::orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'posts');
        $categories = Category::orderBy('category', 'asc')
            ->paginate(10);

        return view('/admin', compact('users', 'settings', 'posts', 'categories'));
    }

    /**
     * Update the settings of the blog.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update()
    {
        request()->validate([
            'title'       => 'required|string',
            'comments'    => 'integer',
            'theme'       => 'integer',
        ]);

        $settings = Setting::first();
        $settings->title = request()->get('title');
        $settings->comments = request()->get('comments');
        $settings->theme = request()->get('theme');

        $settings->save();

        session()->flash('message', 'Settings updated.');
        return redirect()->back();
    }

    /**
     * Update a user's role (eg: switch someone from a user to an admin)
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function updateUserRole()
    {
        request()->validate([
            'role'  => 'integer',
        ]);

        $id = request()->get('id');
        $settings = User::find($id);
        $settings->role = request()->get('role');

        $settings->save();

        session()->flash('message', 'User role updated.');
        return redirect()->back();
    }
}
