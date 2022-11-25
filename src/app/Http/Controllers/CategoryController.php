<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Create a new category.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function create()
    {
        request()->validate([
            'category' => 'required|unique:categories|string',
        ]);

        $category = new Category();
        $category->category = request()->get('category');
        $category->user_id = Auth::user()->id;
        $category->save();

        session()->flash('message', 'Category created.');
        return redirect()->back();
    }

    /**
     * Update a category.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update()
    {
        request()->validate([
            'category' => 'required|string',
        ]);

        $id = request()->get('id');
        $category = Category::find($id);
        $category->category = request()->get('category');
        $category->save();

        session()->flash('message', 'Category updated.');
        return redirect()->back();
    }

    /**
     * Delete a category.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete()
    {
        $id = request()->get('id');
        $category = Category::find($id)->delete();

        session()->flash('message', 'Category deleted.');
        return redirect('/');
    }
}
