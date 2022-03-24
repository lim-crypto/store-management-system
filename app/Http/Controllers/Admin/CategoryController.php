<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\Category;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }
    public function store(CategoryRequest $request)
    {
        $category = new Category();
        $category->name = $request->name;
        $category->save();
        return redirect()->back()->with('success', 'Product category created successfully');
    }
    public function update(CategoryRequest $request,  Category $category)
    {
        $category->name = $request->name;
        $category->save();
        return redirect()->route('category.index')->with('success', 'Product category updated successfully');
    }
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return redirect()->back()->with('error', 'Cannot Delete Category because of assiociated product(s)');
        }
        $category->delete();
        return redirect()->back()->with('success', 'Product category Deleted successfully');;
    }

}
