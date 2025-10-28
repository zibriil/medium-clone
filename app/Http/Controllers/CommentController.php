<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CommentController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, Post $post)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'min:3', 'max:1000']
        ]);

        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'body' => $validated['body']
        ]);

        return redirect()->back();
    }

    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);

        $comment->delete();
        return redirect()->back();
    }

    public function reply(Request $request, Post $post, Comment $comment)
    {
        $validated = $request->validate([
            'body' => ['required', 'string', 'min:3', 'max:1000'],
        ]);

        if ($comment->parent_id !== null) {
            return redirect()->back()->withErrors('Cannot reply to a comment');
        }

        Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $post->id,
            'parent_id' => $comment->id,
            'body' => $validated['body']
        ]);

        return redirect()->back();
    }
}
