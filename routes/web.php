<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

// Auth visiteurs (inscription / connexion)
Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// Actions réservées aux utilisateurs connectés
Route::middleware('auth')->group(function () {
    Route::post('/posts/{id}/like', [LikeController::class, 'store'])->name('likes.store');
    Route::post('/posts/{id}/unlike', [LikeController::class, 'destroy'])->name('likes.destroy');
    Route::post('/posts/{id}/comment', [CommentController::class, 'store'])->name('comments.store');
});
