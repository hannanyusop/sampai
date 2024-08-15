<?php

namespace App\Http\Controllers\Backend;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController
{

    public function index()
    {
        return view('backend.category.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255|unique:categories,title,'
        ],[
            'title.required' => 'The category title field is required.',
            'title.unique' => 'The category title has already been taken.',
            'title.max' => 'The category title may not be greater than 255 characters.'
        ]);

        Category::create([
            'title' => $request->title
        ]);

        return redirect()->back()->with('message', 'Category created successfully.');
    }

    //update method
    public function updateCat(Request $request, Category $category)
    {

        $request->validate([
            'title' => 'required|string|max:255|unique:categories,title,'.$category->id
        ],[
            'title.required' => 'The category title field is required.',
            'title.unique' => 'The category title has already been taken.',
            'title.max' => 'The category title may not be greater than 255 characters.'
        ]);

        $category->update([
            'title' => $request->title
        ]);
        return redirect()->back()->with('message', 'Category updated to '.$request->title);
    }


}
