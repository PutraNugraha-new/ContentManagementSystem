<?php

namespace App\Http\Controllers;

use App\Models\Post_tag;
use App\Models\Tag;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::all();
        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.create');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.edit', compact('tag'));
    }

    public function store(Request $request)
    {
        try {
            $validate = $request->validate([
                'name' => 'required|string|max:255|unique:tags,name|regex:/^[a-zA-Z0-9\s\-]+$/',
            ]);
            $name = $validate['name'];
            $data = [
                'name' => $name,
                'slug' => Str::slug($name)
            ];
            Tag::create($data);
            return redirect()->route('tags.index')->with('success', 'Tag created successfully');
        } catch (\illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }

    public function update(Request $request, Tag $tag)
    {
        try {
            $validate = $request->validate([
                'name' => 'required|string|max:255|regex:/^[a-zA-Z0-9\s\-]+$/|unique:tags,name,' . $tag->id
            ]);
            $name = $validate['name'];
            $data = [
                'name' => $name,
                'slug' => Str::slug($name)
            ];
            $tag->update($data);
            return redirect()->route('tags.index')->with('success', 'Tag updated successfully');
        } catch (\illuminate\validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }

    public function destroy(Tag $tag)
    {
        try {
            // cek apakah tag dipakai ditabel pivot post_tags
            $post_tags = Post_tag::where('tag_id', $tag->id)->get();
            if ($post_tags->count() > 0) {
                return redirect()->back()->with('error', 'Tag cannot be deleted because it is used in Post');
            } else {
                $tag->delete();
                return redirect()->route('tags.index')->with('success', 'Tag deleted successfully');
            }
        } catch (\illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }
}
