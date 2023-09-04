<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Show the admin page including users, settings, posts, and categories.
     *
     * @param Request $request
     * @return View
     */
    public function showAdminDashboard(Request $request): View
    {
        $users = User::orderBy('name', 'asc')
            ->paginate(10, ['*'], 'users');
        $settings = Setting::first();
        $posts = Post::orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'posts');
        $categories = Category::orderBy('category', 'asc')
            ->paginate(10, ['*'], 'categories');

        return view('admin', compact('users', 'settings', 'posts', 'categories'));
    }

    /**
     * Update the settings of the blog.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateSettings(Request $request): RedirectResponse
    {
        $request->validate([
            'title'       => 'required|string',
            'comments'    => 'required|integer',
            'theme'       => 'required|integer',
        ]);

        $settings = Setting::first();
        $settings->title = $request->input('title');
        $settings->comments = $request->input('comments');
        $settings->theme = $request->input('theme');

        $settings->save();

        session()->flash('message', 'Settings updated.');
        return redirect()->back();
    }

    /**
     * Update a user's role (eg: switch someone from a user to an admin)
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateUserRole(Request $request, int $id): RedirectResponse
    {
        $request->validate([
            'role'  => 'required|integer',
        ]);

        $settings = User::find($id);
        $settings->role = $request->input('role');

        $settings->save();

        session()->flash('message', 'User role updated.');
        return redirect()->back();
    }
}
