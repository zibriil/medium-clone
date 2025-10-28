<x-app-layout>

    <div class="bg-white">
        <div class="max-w-3xl mx-auto">
            <div x-data="{
                hasClapped: {{ auth()->check() && auth()->user()->hasClapped($post) ? 'true' : 'false' }},
                clapsCount: {{ $post->claps()->count() }},
                clap() {
                    axios.post('/clap/{{ $post->id }}')
                        .then(res => {
                            this.hasClapped = !this.hasClapped
                            this.clapsCount = res.data.clapsCount
                        })
                        .catch(err => {
                            console.error(err);
                        })
                }
            }" class="py-16">
                <div class="mb-8">
                    <h1 class="text-4xl font-extrabold">{{ $post->title }}</h1>
                </div>
                <div class="flex items-center justify-between">
                    {{-- user avatar sec --}}
                    <div class="flex items-center gap-4">
                        <x-user-avatar :user="$user" size="8" />
                        <x-follow-container :user="$user" class="flex items-center gap-x-4">
                            <a href="{{ route('profile.show', $user->username) }}"
                                class="text-sm text-stone-800 hover:underline">{{ $user->name }}</a>
                            <button @click="follow()" type="button" class="border px-3.5 py-1.5 rounded-full text-sm"
                                x-text="following ? 'Unfollow' : 'Follow'"
                                :class="following ? 'border-red-600 text-red-600' : 'border-gray-950 text-gray-950'" />
                        </x-follow-container>
                        <div class="flex gap-2 text-sm text-gray-500">
                            <span>{{ $post->readingTime() }} min read</span>
                            &middot;
                            <span>{{ $post->created_at->format('M d, Y') }}</span>
                        </div>
                    </div>
                    @if ($post->user_id === Auth::id())
                        <div class="flex gap-x-2">
                            <a href="{{ route('post.edit', $post->slug) }}" class="bg-gray-950 text-white p-2 rounded"
                                title="Edit Post">
                                <x-pencil-icon />
                            </a>
                            <form action="{{ route('post.destroy', $post->slug) }}" method="POST" class="flex">
                                @csrf
                                @method('delete')
                                <button class="bg-red-600 text-white p-2 rounded" title="Delete Post">
                                    <x-trash-icon />
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
                {{-- end user avatar sec --}}

                {{-- clap section --}}
                <div class="flex items-center justify-between border-t border-b mt-8 mb-14 py-3.5 text-sm">
                    <div class="flex items-center gap-6">
                        <template x-if="!hasClapped">
                            <button
                                @click="
                            @if (auth()->check()) clap()
                            @else
                            window.location.href = '{{ route('login') }}' @endif
                            "
                                class="text-gray-500 hover:text-gray-900 flex items-center gap-1" title="Clap">
                                <x-outline-clap-icon />
                                <span class="mt-1" x-text="clapsCount"></span>
                            </button>
                        </template>
                        <template x-if="hasClapped">
                            <button @click="clap()" class="text-gray-500 hover:text-gray-900 flex items-center gap-1"
                                title="Clap">
                                <x-solid-clap-icon />
                                <span class="mt-1" x-text="clapsCount"></span>
                            </button>
                        </template>
                        <button class="text-gray-500 hover:text-gray-900 flex items-center gap-1" title="Comment">
                            <x-comment-icon />
                            <span class="mt-1">{{ $post->comments->count() }}</span>
                        </button>
                    </div>

                    <div x-data="{ isShow: false }" class="relative flex items-center gap-6">
                        <form action="{{ route('post.save', $post) }}" method="POST">
                            @csrf
                            <button class="text-gray-500 hover:text-gray-900 flex items-center gap-1 duration-300"
                                title="{{ auth()->check() && auth()->user()->savedPosts->contains($post) ? 'Unsave' : 'Save' }}">
                                @if (auth()->check() && auth()->user()->savedPosts->contains($post))
                                    <x-solid-save-icon />
                                @else
                                    <x-outline-save-icon />
                                @endif
                            </button>
                        </form>
                        <button class="text-gray-500 hover:text-gray-900 flex items-center gap-1 duration-300"
                            title="Share" @click="isShow = !isShow">
                            <x-share-icon />
                        </button>

                        <div x-show="isShow" x-transition class="absolute bg-white w-64 shadow-md rounded-sm top-12">
                            <ul class="divide-y text-gray-600 font-medium">
                                <li class="py-4 px-8 text-nowrap"><a href="#" class="block">Copy Link</a></li>
                                <li class="py-4 px-8 text-nowrap"><a href="#" class="block">Share on Facebook</a>
                                </li>
                                <li class="py-4 px-8 text-nowrap"><a href="#" class="block">Share on
                                        X/Twitter</a></li>
                                <li class="py-4 px-8 text-nowrap"><a href="#" class="block">Share on LinkedIn</a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                {{-- end clap section --}}

                {{-- content section --}}
                <div>
                    <div>
                        <img src="{{ $post->imageUrl('large') }}" alt="{{ $post->title }}"
                            class="w-full h-full object-cover">
                    </div>
                    <div class="mt-16">
                        <p>{!! $post->content !!}</p>
                    </div>
                </div>
                {{-- end content section --}}

                {{-- category --}}
                <div class="mt-12">
                    <button class="bg-gray-200 py-2 px-4 rounded-full">{{ $category->name }}</button>
                </div>
                {{-- end category --}}

                <div class="flex items-center justify-between mt-8">
                    <div class="flex items-center gap-6 text-sm">
                        <template x-if="!hasClapped">
                            <button
                                @click="
                            @if (auth()->check()) clap()
                            @else
                            window.location.href = '{{ route('login') }}' @endif
                            "
                                class="text-gray-500 hover:text-gray-900 flex items-center gap-1" title="Clap">
                                <x-outline-clap-icon />
                                <span class="mt-1" x-text="clapsCount"></span>
                            </button>
                        </template>
                        <template x-if="hasClapped">
                            <button @click="clap()" class="text-gray-500 hover:text-gray-900 flex items-center gap-1"
                                title="Clap">
                                <x-solid-clap-icon />
                                <span class="mt-1" x-text="clapsCount"></span>
                            </button>
                        </template>
                        <button class="text-gray-500 hover:text-gray-900 flex items-center gap-1" title="Comment">
                            <x-comment-icon />
                            <span class="mt-1">{{ $post->comments->count() }}</span>
                        </button>
                    </div>

                    <div class="flex items-center gap-6">
                        <button class="text-gray-500 hover:text-gray-900 flex items-center gap-1" title="Save">
                            <x-outline-save-icon />
                        </button>
                        <button class="text-gray-500 hover:text-gray-900 flex items-center gap-1" title="Share">
                            <x-share-icon />
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
<hr class="border-t my-3">
<div class="max-w-3xl mx-auto mb-28">
    <section class="mt-16">
        <h2 class="text-lg font-semibold">Comments ({{ $post->comments->count() }})</h2>

        {{-- Form Tambah Komentar --}}
        @auth
            <div>
                <div class="flex items-center gap-3 mt-8 mb-3">
                    <x-user-avatar :user="auth()->user()" size="8" />
                    <p class="text-sm">{{ auth()->user()->name }}</p>
                </div>
                <form action="{{ route('comment.store', $post) }}" method="POST">
                    @csrf
                    @method('post')
                    <x-input-textarea class="w-full border rounded p-2" name="body" rows="3"
                        placeholder="Write a comment..."></x-input-textarea>
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-2 rounded">Send</button>
                </form>
            </div>
        @else
            <p><a href="{{ route('login') }}" class="text-blue-500">Login</a> to comment.</p>
        @endauth

        {{-- Daftar Komentar --}}
        <div class="mt-10 divide-y">
            @foreach ($post->comments()->whereNull('parent_id')->with('replies.user')->latest()->get() as $comment)
                <div class="py-8">
                    {{-- Komentar Utama --}}
                    <div class="flex items-center gap-2">
                        <x-user-avatar :user="$comment->user" size="8" />
                        <div>
                            <p class="font-medium">{{ $comment->user->name }}</p>
                            <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                        </div>
                    </div>
                    <p class="mt-2">{{ $comment->body }}</p>

                    {{-- Form Balas Komentar --}}
                    @auth
                        <div x-data="{ showReplyForm: false }" class="mt-4">
                            <div class="flex items-center gap-6">
                                <button class="text-gray-500 hover:text-gray-900 flex items-center gap-1"
                                    title="Clap"><x-outline-clap-icon />
                                    <span class="text-sm">0</span>
                                </button>
                                <button class="text-gray-500 hover:text-gray-900 flex items-center gap-1"
                                    title="Clap"><x-comment-icon />
                                    <span class="text-sm">0</span>
                                </button>
                                <button type="button" @click="showReplyForm = !showReplyForm"
                                    class="text-sm text-stone-800 underline"> <span
                                        x-text="showReplyForm ? 'Cancel' : 'Reply'"></span>
                                </button>
                            </div>
                            <form x-show="showReplyForm" x-transition
                                action="{{ route('comment.reply', [$post, $comment]) }}" method="POST">
                                @csrf
                                <textarea class="w-full p-1 border" rows="2" name="body" placeholder="Reply..."></textarea>

                                <button class="text-sm mt-1 bg-gray-800 text-white px-3 py-1 rounded">Reply</button>
                            </form>
                        </div>
                    @endauth

                    {{-- 🔁 REPLIES (Balasan) --}}
                    @foreach ($comment->replies as $reply)
                        <div class="ms-6 mt-4 border-l ps-4 py-2 bg-gray-50 rounded">
                            <div class="flex items-center gap-2">
                                <x-user-avatar :user="$reply->user" size="6" />
                                <div>
                                    <p class="font-medium">{{ $reply->user->name }}</p>
                                    <p class="text-sm text-gray-500">{{ $reply->created_at->diffForHumans() }}</p>
                                </div>
                            </div>
                            <p class="mt-1">{{ $reply->body }}</p>

                            {{-- Hapus Komentar Reply --}}
                            @if (auth()->id() === $reply->user_id)
                                <form action="{{ route('comment.destroy', $reply) }}" method="POST" class="mt-2">
                                    @csrf
                                    @method('delete')
                                    <button class="text-sm text-red-500">Delete</button>
                                </form>
                            @endif
                        </div>
                    @endforeach

                    {{-- Hapus Komentar Utama --}}
                    @if (auth()->id() === $comment->user_id)
                        <form action="{{ route('comment.destroy', $comment) }}" method="POST" class="mt-2">
                            @csrf
                            @method('delete')
                            <button class="text-sm text-red-500">Delete</button>
                        </form>
                    @endif
                </div>
            @endforeach

        </div>
    </section>
</div>
