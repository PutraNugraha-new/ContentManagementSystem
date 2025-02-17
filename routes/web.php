<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    Route::prefix('settings')->group(function () {
        Route::get('/', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/', [SettingController::class, 'update'])->name('settings.update');
    });

    Route::resource('categories', CategoryController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('posts', PostController::class);
    Route::resource('tags', TagController::class);
    Route::resource('users', UserController::class);

    Route::post('/upload-image', [PostController::class, 'upload'])->name('ckeditor.upload');
    Route::get('/posts/author/{id}', [PostController::class, 'postsByAuthor'])->name('posts.byAuthor');
    Route::get('/posts/category/{id}', [PostController::class, 'postsByCategory'])->name('posts.byCategory');
    Route::post('/admin/posts/bulk-action', [PostController::class, 'bulkAction'])->name('posts.bulk-action');
    Route::post('/admin/comments/bulk-action', [CommentController::class, 'bulkAction'])->name('comments.bulk-action');
});
