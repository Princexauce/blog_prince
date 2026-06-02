<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::orderBy('created_at', 'desc')->get();
        
        // Récupérer les catégories dynamiques depuis les articles
        $categories = Post::whereNotNull('categorie')
            ->select('categorie')
            ->distinct()
            ->pluck('categorie')
            ->toArray();
        
        return view('home', compact('posts', 'categories'));
    }
}
