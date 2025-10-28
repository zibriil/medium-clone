<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostCreateRequest;
use App\Http\Requests\PostUpdateRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $query = Post::with(['user', 'media'])
            ->where('published_at', '<=', now())
            ->withCount('claps')
            ->latest();

        if ($user) {
            /** @var \App\Models\User $user */
            $ids = $user->following()->pluck('users.id');
            $query->whereIn('user_id', $ids);
        }

        $posts = $query->simplePaginate(10);
        return view('post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::get();
        return view('post.create', ['categories' => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PostCreateRequest $request)
    {
        $data = $request->validated();

        // $image = $data['image'];
        $data['user_id'] = Auth::id();
        $data['slug'] = Str::slug($data['title']);

        // $imagePath = $image->store('posts', 'public');
        // $data['image'] = $imagePath;

        $post = Post::create($data);

        $post->addMediaFromRequest('image')
            ->toMediaCollection();

        return redirect()->route('myPosts');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $username, Post $post)
    {
        return view('post.show', [
            'post' => $post,
            'user' => $post->user,
            'category' => $post->category,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }
        $categories = Category::get();

        return view('post.edit', [
            'post' => $post,
            'categories' => $categories,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(PostUpdateRequest $request, Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $data = $request->validated();
        $post->update($data);

        if ($data['image'] ?? false) {
            $post->addMediaFromRequest('image')
                ->toMediaCollection();
        }

        return redirect()->route('myPosts');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== Auth::id()) {
            abort(403);
        }

        $post->delete();
        return redirect()->route('dashboard');
    }

    public function category(Category $category)
    {
        $user = Auth::user();
        $query = $category
            ->posts()
            ->where('published_at', '<=', now())
            ->with(['user', 'media'])
            ->withCount('claps')
            ->latest();

        if ($user) {
            /** @var \App\Models\User $user */
            $ids = $user->following()->pluck('users.id');
            $query->whereIn('user_id', $ids);
        }

        $posts = $query->simplePaginate(10);

        return view('post.index', ['posts' => $posts]);
    }

    public function myPosts()
    {
        $user = Auth::user();
        /** @var \App\Models\User $user */
        $posts = $user->posts()->with(['user', 'media'])->withCount('claps')->latest()->simplePaginate(10);

        return view('post.index', ['posts' => $posts]);
    }
}
