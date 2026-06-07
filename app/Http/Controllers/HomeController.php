<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $posts = Post::orderBy('created_at', 'desc')
            ->when($search, function($query) use ($search) {
                $query->where('titre', 'like', '%' . $search . '%')
                      ->orWhere('contenu', 'like', '%' . $search . '%')
                      ->orWhere('categorie', 'like', '%' . $search . '%');
            })
            ->get();

        $categories = Post::whereNotNull('categorie')
            ->select('categorie')
            ->distinct()
            ->pluck('categorie')
            ->toArray();

        return view('home', compact('posts', 'categories'));
    }
}