<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $posts = Post::orderBy('created_at', 'desc')->get();
        
        // Vérifier si l'utilisateur a déjà vu cet article dans cette session
        $viewedKey = 'viewed_post_' . $id;
        if (!session()->has($viewedKey)) {
            $post->increment('vues');
            session()->put($viewedKey, true);
        }
        
        $comments = $post->comments()->whereNull('parent_id')->with('replies')->get();
        
        // Vérifier si l'utilisateur a déjà liké cet article (basé sur l'email en session)
        $userEmail = session('user_email');
        $hasLiked = false;
        if ($userEmail) {
            $hasLiked = $post->likes()->where('email', $userEmail)->exists();
        }
        
        return view('posts.show', compact('post', 'posts', 'comments', 'hasLiked'));
    }
}
