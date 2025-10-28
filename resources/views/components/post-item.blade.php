<!-- Component: Blog card with action button -->
<div class="bg-white text-slate-500 py-7">
    <!-- Body-->
    <div class="flex">
        <div class="pe-8 flex-1">
            <div class="flex gap-4">
                <div>
                    <a href="{{ route('post.show', ['username' => $post->user->username, 'post' => $post->slug]) }}">
                        <h3 class="text-2xl font-bold text-slate-950 line-clamp-1">{{ $post->title }}
                    </a>
                    </h3>
                </div>
            </div>
            <div>
                <p class="line-clamp-2 mb-4">
                    {{ $post->content }}
                </p>
            </div>
            <div class="flex items-center justify-between pe-6 text-stone-500">
                <div class="flex items-center gap-x-4 text-sm">
                    <p>
                        {{ $post->created_at->format('M d, Y') }}
                    </p>
                    <button class="flex items-center gap-x-1">
                        <x-solid-clap-icon />
                        <span>{{ $post->claps_count }}</span>
                    </button>
                    <button class="flex items-center gap-x-1">
                        <x-solid-comment-icon />
                        <span>50</span>
                    </button>
                </div>
                <div>
                    <x-outline-save-icon />
                </div>
            </div>
        </div>
        <!-- Image -->
        <div>
            <img src="{{ $post->imageUrl('thumbnail') }}" alt="thumbnail image"
                class="aspect-video object-cover w-[180px] h-[120px]" />
        </div>
    </div>
</div>
<!-- End Blog card with action button -->
