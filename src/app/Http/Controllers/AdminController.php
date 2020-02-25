<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Setting;
use App\Models\Category;
use App\Models\Post;

use Auth;

class AdminController extends Controller
{
    public function read()
    {
        $users = User::orderBy('name', 'asc')
            ->paginate(10, ['*'], 'users');
        $settings = Setting::first();
        $posts = Post::orderBy('created_at', 'desc')
            ->paginate(10, ['*'], 'posts');
        $categories = Category::orderBy('category', 'asc')
            ->paginate(10, ['*'], 'categories');
            
        return view('/admin', compact('users', 'settings', 'posts', 'categories'));
    }

    public function update(Request $request)
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

        session()->flash("message", "Settings updated.");
        return redirect()->back();
    }

    public function updateUserRole(Request $request)
    {
        request()->validate([
            'role'  => 'integer',
        ]);

        $id = request()->get('id');
        $settings = User::find($id);
        $settings->role = request()->get('role');

        $settings->save();

        session()->flash("message", "User role updated.");
        return redirect()->back();
    }
}
