<x-app-layout>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg lg:p-8 p-6">
                <h1 class="text-2xl font-bold bg-gray-950 text-white p-1">Edit Post: {{ $post->title }}</h1>
                <form action="{{ route('post.update', $post->id) }}" enctype="multipart/form-data" method="POST"
                    class="space-y-6">
                    @csrf
                    @method('patch')

                    <!-- Image -->
                    @if ($post->imageUrl())
                        <img src="{{ $post->imageUrl('large') }}" alt="thumbnail image" class="w-full object-cover" />
                    @endif

                    <div>
                        <x-input-label for="image" :value="__('Image')" />
                        <x-text-input id="image" class="block mt-1 w-full" type="file" name="image"
                            :value="old('image', $post->image)" autofocus />
                        <x-input-error :messages="$errors->get('image')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="title" :value="__('Title')" />
                        <x-text-input id="title" class="block mt-1 w-full" type="text" name="title"
                            :value="old('title', $post->title)" autofocus />
                        <x-input-error :messages="$errors->get('title')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="category_id" :value="__('Category')" />
                        <select name="category_id" id="category_id"
                            class="block mt-1 w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm">
                            <option value="">Select a category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" @selected(old('category_id', $post->category_id) == $category->id)>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('category_id')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="content" :value="__('Content')" />
                        <x-input-textarea id="content" class="block mt-1 w-full" type="text" name="content"
                            autofocus>{{ old('content', $post->content) }}</x-input-textarea>
                        <x-input-error :messages="$errors->get('content')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="published_at" :value="__('Published At')" />
                        <x-text-input id="published_at" class="block mt-1 w-full" type="datetime-local"
                            name="published_at" :value="old('published_at', $post->published_at)" autofocus />
                        <x-input-error :messages="$errors->get('published_at')" class="mt-2" />
                    </div>

                    <div class="flex justify-end pt-8">
                        <x-primary-button>Publish</x-primary-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

</x-app-layout>
