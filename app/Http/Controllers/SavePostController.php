<?php

namespace App\Http\Controllers;

use App\Models\Post;

class SavePostController extends Controller
{
    public function toggle(Post $post)
    {
        $user = auth()->user();

        if ($user->savedPosts()->where('post_id', $post->id)->exists()) {
            $user->savedPosts()->detach($post);
            return back()->with('status', 'Post unsaved');
        } else {
            $user->savedPosts()->attach($post);
            return back()->with('status', 'Post saved');
        }
    }
}
