<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Create a new category.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function create(Request $request): RedirectResponse
    {
        $category = Category::where(['category' => $request->input('category')])
            ->withTrashed()
            ->first() ?: new Category();

        $request->validate([
            'category' => 'required|string',
        ]);

        if ($category->trashed()) {
            $category->restore();
        } else {
            $category->category = $request->input('category');
            $category->save();
        }

        session()->flash('message', 'Category created.');
        return redirect()->back();
    }

    /**
     * Update a category.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse
    {
        $request->validate([
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
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(Request $request, int $id): RedirectResponse
    {
        Category::find($id)->delete();

        session()->flash('message', 'Category deleted.');
        return redirect()->back();
    }
}
