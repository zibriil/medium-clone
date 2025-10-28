<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class ClapController extends Controller
{
    public function clap(Post $post)
    {
        $userId = Auth::id();
        $user = Auth::user();

        /** @var \App\Models\User $user */
        $hasClapped = $user->hasClapped($post);


        if (!$userId) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        if ($hasClapped) {
            $post->claps()->where('user_id', $userId)->delete();
        } else {
            $post->claps()->create([
                'user_id' => $userId
            ]);
        }

        return response()->json([
            'clapsCount' => $post->claps()->count()
        ]);
    }
}
