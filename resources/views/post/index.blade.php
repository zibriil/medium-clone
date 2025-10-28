<x-app-layout>

    <div class="bg-white">
        <div class="max-w-3xl h-dvh mx-auto sm:px-6 lg:px-8">
            <div class="overflow-hidden pt-8 pb-6">
                <div class="text-gray-900">
                    <x-category-tabs>
                        Categories not found!
                    </x-category-tabs>
                </div>
            </div>

            <div class="divide-y">
                @forelse ($posts as $post)
                    <x-post-item :post="$post" />
                @empty
                    <div class="text-gray-500 text-center py-16">Posts not found!</div>
                @endforelse
            </div>
            {{ $posts->links() }}
        </div>
    </div>
</x-app-layout>
