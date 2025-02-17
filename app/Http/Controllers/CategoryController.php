<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|unique:categories,name|regex:/^[a-zA-Z0-9\s\-]+$/',
            ]);

            $name = $validated['name'];
            $data = [
                'name' => $name,
                'slug' => Str::slug($validated['name']),
            ];
            Category::create($data);
            return redirect()->route('categories.index')->with('success', 'Category created successfully');
        } catch (\illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }

    public function update(Request $request, Category $category)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\-]+$/|unique:categories,name,' . $category->id,
            ]);
            $category->update([
                'name' => $validated['name'],
                'slug' => Str::slug($validated['name']),
            ]);
            return redirect()->route('categories.index')->with('success', 'Category updated successfully');
        } catch (\illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }

    public function destroy(Category $category)
    {
        try {
            // cek category yang dipakai ditabel posts
            $posts = Post::where('category_id', $category->id)->get();
            if ($posts->count() > 0) {
                return redirect()->back()->with('error', 'Category used in posts, cannot be deleted');
            } else {
                $category->delete();
                return redirect()->route('categories.index')->with('success', 'Category deleted successfully');
            }
        } catch (\illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }
}
