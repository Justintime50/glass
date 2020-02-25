<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Auth;

class CategoryController extends Controller
{
    public function readCategories(Request $request)
    {
        $categories = Category::all();
        // TODO: Use pagination instead

        return view('/categories', compact('categories'));
    }

    public function create(Request $request)
    {
        request()->validate([
            'category'       => 'required|string',
        ]);

        $category = new Category();
        $category->category = request()->get('category');
        $category->user_id = Auth::user()->id;
        $category->save();

        session()->flash("message", "Category created.");
        return redirect()->back();
    }

    public function update(Request $request)
    {
        request()->validate([
            'category'       => 'required|string',
        ]);

        $id = request()->get('id');
        $category = Category::find($id);
        $category->category = request()->get('category');
        $category->save();

        session()->flash("message", "Category created.");
        return redirect()->back();
    }

    public function delete(Request $request)
    {
        $id = request()->get('id');
        $category = Category::find($id)->delete();

        session()->flash("message", "Category deleted.");
        return redirect("/");
    }
}
