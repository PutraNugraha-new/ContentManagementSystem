<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Post;
use App\Models\User;
use App\Models\Setting;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::withCount(['comments' => function ($query) {}])
            ->orderBy('created_at', 'desc') // Mengurutkan berdasarkan tanggal terbaru
            ->get();

        return view('admin.posts.index', compact('posts'));
    }

    public function postsByAuthor($id)
    {
        $author = User::findOrFail($id); // Ambil data author berdasarkan ID
        $posts = Post::where('user_id', $id) // Ganti 'user_id' dengan kolom yang sesuai
            ->withCount('comments')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.posts.author', compact('posts', 'author')); // Ganti 'posts.index' dengan view yang sesuai
    }

    public function postsByCategory($id)
    {
        $category = Category::findOrFail($id); // Ambil data author berdasarkan ID
        $posts = Post::where('category_id', $id) // Ganti 'user_id' dengan kolom yang sesuai
            ->withCount('comments')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.posts.category', compact('posts', 'category')); // Ganti 'posts.index' dengan view yang sesuai
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function edit(Post $post)
    {
        $siteTitle = Setting::where('key', 'site_title')->value('value');
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags', 'siteTitle'));
    }

    public function bulkAction(Request $request)
    {
        $request->validate([
            'action' => 'required|in:delete,draft,published',
            'post_ids' => 'required|array',
            'post_ids.*' => 'exists:posts,id'
        ]);

        $posts = Post::whereIn('id', $request->post_ids);

        switch ($request->action) {
            case 'delete':
                $posts->delete();
                $message = 'Post berhasil dihapus';
                break;
            case 'draft':
                $posts->update(['status' => 'draft']);
                $message = 'Status post berhasil diubah menjadi draft';
                break;
            case 'published':
                $posts->update(['status' => 'published']);
                $message = 'Post berhasil dipublish';
                break;
        }

        return response()->json([
            'message' => $message
        ]);
    }

    public function store(Request $request)
    {
        try {
            $request->merge([
                'category_id' => $request->category_id ?: 9
            ]);
            // Validasi input
            $validate = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'required|integer|exists:categories,id', // Validasi kategori
                'tags' => 'array', // Validasi bahwa tags adalah array
                'tags.*' => 'string|max:100', // Validasi setiap tag
                'status' => 'required|in:draft,published', // Validasi status
                'seo_title' => 'nullable|string|max:255',
                'seo_description' => 'nullable|string',
                'seo_keywords' => 'nullable|string',
                'published_at' => 'nullable|date', // Validasi tanggal
            ]);

            $featured_image = $request->hasFile('image') ? $request->file('image')->store('images', 'public') : null;

            if (empty($request->seo_title) && empty($request->seo_keywords) && empty($request->seo_description)) {
                $seo_title = $validate['title'];
                $seo_description = Str::words(strip_tags($validate['content']), 10, '...');
                $seo_keywords = $validate['title'];
            } else {
                $seo_title = $request->seo_title;
                $seo_description = $request->seo_description;
                $seo_keywords = $request->seo_keywords;
            }

            $social_title = $validate['title'];
            $social_description = Str::words(strip_tags($validate['content']), 10, '...');
            $social_image = $featured_image;

            // Siapkan data untuk disimpan
            $postData = [
                'title' => $validate['title'],
                'slug' => Str::slug($validate['title']),
                'content' => $validate['content'],
                'image' => $featured_image, // Simpan gambar
                'category_id' => $validate['category_id'],
                'user_id' => Auth::user()->id,
                'status' => $validate['status'],
                'seo_title' => $seo_title,
                'seo_description' => $seo_description,
                'seo_keywords' => $seo_keywords,
                'social_title' => $social_title,
                'social_description' => $social_description,
                'social_image' => $social_image,
                'published_at' => $validate['published_at'] ?? now(),
            ];

            // Simpan data ke tabel posts
            $post = Post::create($postData);

            // Ambil ID dari post yang baru dibuat
            $postId = $post->id;

            if (!empty($validate['tags'])) {
                // Proses tags
                $tagIds = []; // Array untuk menyimpan ID tag

                foreach ($validate['tags'] as $tagName) {
                    // Cek apakah tag sudah ada
                    $tag = Tag::firstOrCreate(
                        ['name' => $tagName], // Kondisi pencarian
                        ['slug' => Str::slug($tagName)] // Data yang akan disimpan jika tag baru
                    );

                    // Tambahkan ID tag ke array
                    $tagIds[] = $tag->id;
                }

                // Mengaitkan tags dengan post
                $post->tags()->attach($tagIds);
            }

            return redirect()->route('posts.index')->with('success', 'Post created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }

    public function update(Post $post, Request $request)
    {
        try {
            $request->merge([
                'category_id' => $request->category_id ?: 9
            ]);
            // Validasi input
            $validate = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'category_id' => 'nullable|integer|exists:categories,id', // Validasi kategori
                'tags' => 'array', // Validasi bahwa tags adalah array
                'tags.*' => 'string|max:100', // Validasi setiap tag
                'status' => 'required|in:draft,published', // Validasi status
                'seo_title' => 'nullable|string|max:255',
                'seo_description' => 'nullable|string',
                'seo_keywords' => 'nullable|string',
                'published_at' => 'nullable|date', // Validasi tanggal
            ]);

            if (empty($request->seo_title) && empty($request->seo_keywords) && empty($request->seo_description)) {
                $seo_title = $validate['title'];
                $seo_description = Str::words(strip_tags($validate['content']), 10, '...');
                $seo_keywords = $validate['title'];
            } else {
                $seo_title = $request->seo_title;
                $seo_description = $request->seo_description;
                $seo_keywords = $request->seo_keywords;
            }

            $social_title = $validate['title'];
            $social_description = Str::words(strip_tags($validate['content']), 10, '...');

            // Siapkan data untuk diupdate
            $postData = [
                'title' => $validate['title'],
                'slug' => Str::slug($validate['title']),
                'content' => $validate['content'],
                'category_id' => $validate['category_id'],
                'user_id' => Auth::user()->id,
                'status' => $validate['status'],
                'seo_title' => $seo_title,
                'seo_description' => $seo_description,
                'seo_keywords' => $seo_keywords,
                'social_title' => $social_title,
                'social_description' => $social_description,
                'published_at' => $validate['published_at'] ?? now(), // Gunakan waktu sekarang jika tidak ada
            ];

            // Cek apakah ada gambar yang diupload
            if ($request->hasFile('image')) {
                // Simpan gambar dan tambahkan ke data
                $featured_image = $request->file('image')->store('images', 'public');
                $postData['image'] = $featured_image;
                $postData['social_image'] = $featured_image;
            }

            // Update post dengan data baru
            $post->update($postData);

            // Proses tags
            if (!empty($validate['tags'])) {
                $tagIds = []; // Array untuk menyimpan ID tag

                foreach ($validate['tags'] as $tagName) {
                    // Cek apakah tag sudah ada, jika tidak ada, buat tag baru
                    $tag = Tag::firstOrCreate(
                        ['name' => $tagName], // Kondisi pencarian
                        ['slug' => Str::slug($tagName)] // Data yang akan disimpan jika tag baru
                    );

                    $tagIds[] = $tag->id; // Simpan ID tag
                }

                // Update relasi tags
                $post->tags()->sync($tagIds); // Mengaitkan tag baru dan menghapus yang tidak ada
            } else {
                // Jika tidak ada tags, hapus semua relasi tags
                $post->tags()->detach();
            }
            return redirect()->route('posts.index')->with('success', 'Post Updated successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors());
        }
    }


    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = time() . '_' . $file->getClientOriginalName();

            try {
                // Simpan file ke storage/app/public/uploads
                $path = $file->storeAs('uploads', $fileName, 'public');

                return response()->json([
                    'uploaded' => true,
                    'url' => Storage::url($path)
                ]);
            } catch (\Exception $e) {
                return response()->json([
                    'uploaded' => false,
                    'error' => [
                        'message' => $e->getMessage()
                    ]
                ], 400);
            }
        }

        return response()->json([
            'uploaded' => false,
            'error' => [
                'message' => 'No file uploaded'
            ]
        ], 400);
    }

    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('posts.index')->with('success', 'Post Deleted successfully');
    }
}
