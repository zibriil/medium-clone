<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Image\Enums\Fit;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Post extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'user_id',
        'category_id',
        'published_at'
    ];

    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('thumbnail')
            ->fit(Fit::Contain, 300, 200);

        $this
            ->addMediaConversion('large')
            ->fit(Fit::Contain, 1200, 800);
    }

    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('default')
            ->singleFile()
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif']);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function claps()
    {
        return $this->hasMany(Clap::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function readingTime($wpm = 250): int
    {
        // $wpm = 250; // Assuming average reading speed of 250 words per minute
        $wordCount = str_word_count(strip_tags($this->content));
        $readingTime = ceil($wordCount / $wpm);
        return max($readingTime, 1); // Ensure at least 1 minute
    }

    public function imageUrl($conversionName = ''): string
    {
        $media = $this->getFirstMedia();
        if ($media->hasGeneratedConversion($conversionName)) {
            return $media->getUrl($conversionName);
        }
        return $media->getUrl();
        // return $this->getFirstMedia()?->getUrl($conversionName);
    }

    public function savedPosts()
    {
        return $this->belongsToMany(User::class, 'post_user_saves')->withTimestamps();
    }
}
