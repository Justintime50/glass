<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

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

        // TODO: If creating a previously deleted category, re-enable it instead of erroring
        $category = new Category();
        $category->category = request()->get('category');
        $category->save();

        session()->flash('message', 'Category created.');
        return redirect()->back();
    }

    /**
     * Update a category.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function update(Request $request, int $id)
    {
        request()->validate([
            'category' => 'required|string',
        ]);

        $category = Category::find($id);
        $category->category = $request->input('category');
        $category->save();

        session()->flash('message', 'Category updated.');
        return redirect()->back();
    }

    /**
     * Delete a category.
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function delete(Request $request, int $id)
    {
        Category::find($id)->delete();

        session()->flash('message', 'Category deleted.');
        return redirect()->back();
    }
}
