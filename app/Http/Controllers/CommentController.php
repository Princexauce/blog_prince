<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'contenu' => 'required|string',
            'parent_id' => 'nullable|exists:comments,id',
        ]);

        $post = Post::findOrFail($id);
        $user = Auth::user();

        if ($request->filled('parent_id')) {
            Comment::where('post_id', $post->id)->findOrFail($request->parent_id);
        }

        Comment::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'pseudo' => $user->name,
            'email' => $user->email,
            'contenu' => $request->contenu,
            'parent_id' => $request->parent_id,
        ]);

        return redirect()->back()->with('comment_success', 'Commentaire ajouté avec succès');
    }
}
