<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function show($id)
    {
        $post = Post::findOrFail($id);
        $posts = Post::orderBy('created_at', 'desc')->get();

        $viewedKey = 'viewed_post_'.$id;
        if (! session()->has($viewedKey)) {
            $post->increment('vues');
            session()->put($viewedKey, true);
        }

        $comments = $this->buildCommentTree(
            $post->comments()->orderBy('created_at')->get()
        );

        $hasLiked = Auth::check()
            && $post->likes()->where('user_id', Auth::id())->exists();

        return view('posts.show', compact('post', 'posts', 'comments', 'hasLiked'));
    }

    private function buildCommentTree($comments)
    {
        $grouped = $comments->groupBy(fn ($comment) => $comment->parent_id ?? 'root');

        $attachReplies = function ($comment) use ($grouped, &$attachReplies) {
            $children = $grouped->get($comment->id, collect());
            $comment->setRelation('replies', $children->map(fn ($child) => $attachReplies($child)));

            return $comment;
        };

        return $grouped->get('root', collect())->map(fn ($comment) => $attachReplies($comment));
    }
}
