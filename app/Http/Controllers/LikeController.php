<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;

class LikeController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'pseudo' => 'required|string|max:255',
            'email' => 'required|email|max:255',
        ]);

        $post = Post::findOrFail($id);
        
        $existingLike = Like::where('post_id', $post->id)
            ->where('email', $request->email)
            ->first();

        if ($existingLike) {
            return redirect()->back()->with('like_error', 'Vous avez déjà liké cet article');
        }

        Like::create([
            'post_id' => $post->id,
            'pseudo' => $request->pseudo,
            'email' => $request->email,
        ]);

        // Stocker l'email et pseudo en session
        session(['user_email' => $request->email]);
        session(['user_pseudo' => $request->pseudo]);

        return redirect()->back()->with('like_success', 'Like ajouté avec succès');
    }

    public function destroy(Request $request, $id)
    {
        $request->validate([
            'email' => 'required|email|max:255',
        ]);

        $post = Post::findOrFail($id);
        
        $like = Like::where('post_id', $post->id)
            ->where('email', $request->email)
            ->first();

        if ($like) {
            $like->delete();
            return redirect()->back()->with('like_success', 'Like retiré avec succès');
        }

        return redirect()->back()->with('like_error', 'Like non trouvé');
    }
}
