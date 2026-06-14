<?php

namespace App\Http\Controllers;

use App\Models\Like;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LikeController extends Controller
{
    public function store(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        $existingLike = Like::where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($existingLike) {
            return redirect()->back()->with('like_error', 'Vous avez déjà liké cet article');
        }

        Like::create([
            'post_id' => $post->id,
            'user_id' => $user->id,
            'pseudo' => $user->name,
            'email' => $user->email,
        ]);

        return redirect()->back()->with('like_success', 'Like ajouté avec succès');
    }

    public function destroy(Request $request, $id)
    {
        $post = Post::findOrFail($id);
        $user = Auth::user();

        $like = Like::where('post_id', $post->id)
            ->where('user_id', $user->id)
            ->first();

        if ($like) {
            $like->delete();

            return redirect()->back()->with('like_success', 'Like retiré avec succès');
        }

        return redirect()->back()->with('like_error', 'Like non trouvé');
    }
}
