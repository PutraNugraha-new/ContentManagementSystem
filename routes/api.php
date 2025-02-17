<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\PostController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Public routes (tanpa autentikasi)
// Route::post('register', [AuthController::class, 'register']);
// Route::post('login', [AuthController::class, 'login']);

Route::apiResource('posts', PostController::class);
Route::get('/posts/slug/{slug}', [PostController::class, 'showBySlug']);
Route::get('/posts/search/{title}', [PostController::class, 'showByTitle']);

// Protected routes (hanya bisa diakses dengan token)
// Route::middleware('auth:sanctum')->group(function () {
//     Route::post('logout', [AuthController::class, 'logout']);
// });
