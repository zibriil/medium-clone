<?php

use App\Http\Controllers\ClapController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicProfileController;
use App\Http\Controllers\SavePostController;
use Illuminate\Support\Facades\Route;


Route::get('/@{user:username}', [PublicProfileController::class, 'show'])->name('profile.show');
Route::get('/@{username}/{post:slug}', [PostController::class, 'show'])->name('post.show');
Route::get('/category/{category:name}', [PostController::class, 'category'])->name('post.filterByCategory');
Route::get('/', [PostController::class, 'index'])->name('dashboard');
// Route::get('/editor', [PostController::class, 'index'])->name('dashboard');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('post.create');
    Route::post('/posts/create', [PostController::class, 'store'])->name('post.store');
    Route::get('/posts/{post:slug}/edit', [PostController::class, 'edit'])->name('post.edit');
    Route::patch('/posts/{post}', [PostController::class, 'update'])->name('post.update');
    Route::delete('/posts/{post:slug}', [PostController::class, 'destroy'])->name('post.destroy');

    Route::get('/my-posts', [PostController::class, 'myPosts'])->name('myPosts');

    Route::post('/follow/{user:username}', [FollowerController::class, 'followUnfollow'])->name('follow');
    Route::post('/clap/{post}', [ClapController::class, 'clap'])->name('clap');

    Route::post('/posts/{post}/comments', [CommentController::class, 'store'])->name('comment.store');
    Route::delete('/comments/{comment}', [CommentController::class, 'destroy'])->name('comment.destroy');

    Route::post('/posts/{post}/comments/{comment}/reply', [CommentController::class, 'reply'])->name('comment.reply');
    Route::post('posts/{post}/save', [SavePostController::class, 'toggle'])->name('post.save');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
