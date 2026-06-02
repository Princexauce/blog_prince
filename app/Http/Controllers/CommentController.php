<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        // Utiliser les informations de session si disponibles
        $pseudo = $request->pseudo ?: session('user_pseudo');
        $email = $request->email ?: session('user_email');

        $request->validate([
            'contenu' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        if (!$pseudo || !$email) {
            return redirect()->back()->with('comment_error', 'Informations utilisateur manquantes');
        }

        $post = Post::findOrFail($id);
        
        Comment::create([
            'post_id' => $post->id,
            'pseudo' => $pseudo,
            'email' => $email,
            'contenu' => $request->contenu,
            'parent_id' => $request->parent_id,
        ]);

        // Stocker les informations en session
        session(['user_email' => $email]);
        session(['user_pseudo' => $pseudo]);

        return redirect()->back()->with('comment_success', 'Commentaire ajouté avec succès');
    }
}
