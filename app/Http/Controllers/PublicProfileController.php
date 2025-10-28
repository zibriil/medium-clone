<?php

namespace App\Http\Controllers;

use App\Models\User;

class PublicProfileController extends Controller
{
    public function show(User $user)
    {
        $posts = $user->posts()
            ->where('published_at', '<=', now())
            ->latest()
            ->paginate(10);

        return view('profile.show', [
            'user' => $user,
            'posts' => $posts,
        ]);
    }
}
