<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\LikeController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');
Route::post('/posts/{id}/like', [LikeController::class, 'store'])->name('likes.store');
Route::post('/posts/{id}/unlike', [LikeController::class, 'destroy'])->name('likes.destroy');
Route::post('/posts/{id}/comment', [CommentController::class, 'store'])->name('comments.store');
