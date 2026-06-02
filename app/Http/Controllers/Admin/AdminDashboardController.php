<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use App\Models\Like;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_posts' => Post::count(),
            'total_vues' => Post::sum('vues'),
            'total_likes' => Like::count(),
            'total_comments' => Comment::count(),
        ];

        $recentPosts = Post::orderBy('created_at', 'desc')->take(5)->get();
        $recentComments = Comment::orderBy('created_at', 'desc')->take(5)->get();
        $recentLikes = Like::orderBy('created_at', 'desc')->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentPosts', 'recentComments', 'recentLikes'));
    }
}
