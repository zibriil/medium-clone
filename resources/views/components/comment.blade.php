<section>
    <h2 class="text-lg font-semibold">Komentar</h2>

    {{-- Form Tambah Komentar --}}
    @auth
        <form x-data="{ body: '' }"
            @submit.prevent="axios.post('/comments', { post_id: {{ $post->id }}, body })
            .then(res => { window.location.reload() })">
            <textarea x-model="body" class="w-full border rounded p-2" rows="3" placeholder="Tulis komentar..."></textarea>
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 mt-2 rounded">Kirim</button>
        </form>
    @else
        <p><a href="{{ route('login') }}" class="text-blue-500">Login</a> untuk berkomentar.</p>
    @endauth

    {{-- Daftar Komentar --}}
    <div class="mt-4 space-y-4">
        @foreach ($post->comments as $comment)
            <div class="border-b pb-2">
                <div class="flex items-center gap-2">
                    <x-user-avatar :user="$comment->user" size="8" />
                    <div>
                        <p class="font-medium">{{ $comment->user->name }}</p>
                        <p class="text-sm text-gray-500">{{ $comment->created_at->diffForHumans() }}</p>
                    </div>
                </div>
                <p class="mt-2">{{ $comment->body }}</p>
                @if (auth()->id() === $comment->user_id)
                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" class="mt-1">
                        @csrf @method('DELETE')
                        <button class="text-sm text-red-500">Hapus</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</section>
