<?php

namespace App\Providers;

use App\Models\Comment;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Menggunakan view composer untuk menyediakan data ke sidebar
        View::composer('admin.layouts.sidebar', function ($view) {
            // Cache selama 5 menit untuk mengurangi query ke database
            $pendingCommentsCount = Cache::remember('pending_comments_count', 300, function () {
                return Comment::where('status', 'pending')->count();
            });

            $view->with('pendingCommentsCount', $pendingCommentsCount);
        });
    }
}
