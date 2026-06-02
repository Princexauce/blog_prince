<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminPostController;
use App\Http\Controllers\Admin\AdminCommentController;
use App\Http\Controllers\Admin\AdminLikeController;

// Admin login (no middleware)
Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AdminAuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');

// Protected admin routes
Route::middleware(['admin.auth'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Posts
    Route::get('/posts', [AdminPostController::class, 'index'])->name('posts.index');
    Route::get('/posts/create', [AdminPostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [AdminPostController::class, 'store'])->name('posts.store');
    Route::post('/posts/upload-image', [AdminPostController::class, 'uploadImage'])->name('posts.upload-image');
    Route::get('/posts/{id}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
    Route::post('/posts/{id}', [AdminPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{id}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
    
    // Comments
    Route::get('/comments', [AdminCommentController::class, 'index'])->name('comments');
    Route::delete('/comments/{id}', [AdminCommentController::class, 'destroy'])->name('comments.destroy');
    
    // Likes
    Route::get('/likes', [AdminLikeController::class, 'index'])->name('likes');
});
