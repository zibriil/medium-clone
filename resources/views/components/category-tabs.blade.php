<div class="max-w-full" aria-multiselectable="false">
    <ul class="flex items-center justify-center border-b border-gray-200" role="tablist">
        <li role="presentation">
            <a href="/"
                class="{{ request('category')
                    ? 'inline-flex items-center justify-center w-full h-12 gap-2 px-6 -mb-px text-sm font-medium tracking-wide transition duration-300 border-b border-transparent rounded-t focus-visible:outline-none justify-self-center hover:border-gray-500 focus:border-gray-600 whitespace-nowrap text-slate-700 stroke-slate-700 hover:text-gray-500 focus:stroke-gray-600 focus:bg-gray-50 focus:text-gray-600 hover:stroke-gray-600 disabled:cursor-not-allowed disabled:text-slate-500'
                    : 'inline-flex items-center justify-center w-full h-12 gap-2 px-6 -mb-px text-sm font-medium tracking-wide transition duration-300 border-b rounded-t focus-visible:outline-none whitespace-nowrap border-gray-500 hover:border-gray-600 focus:border-gray-700 text-gray-500 hover:text-gray-600 focus:text-gray-700 focus:bg-gray-50 disabled:cursor-not-allowed disabled:border-slate-500 stroke-gray-500 hover:stroke-gray-600 focus:stroke-gray-700' }}"
                id="tab-label-1d" role="tab" aria-setsize="3" aria-posinset="1" tabindex="0"
                aria-controls="tab-panel-1d" aria-selected="true">
                <span>All</span>
            </a>
        </li>
        @forelse ($categories as $category)
            <li role="presentation">
                <a href="{{ route('post.filterByCategory', $category->name) }}"
                    class="{{ Route::currentRouteNamed('post.filterByCategory') && request('category')->name === $category->name
                        ? 'inline-flex items-center justify-center w-full h-12 gap-2 px-6 -mb-px text-sm font-medium tracking-wide transition duration-300 border-b rounded-t focus-visible:outline-none whitespace-nowrap border-gray-500 hover:border-gray-600 focus:border-gray-700 text-gray-500 hover:text-gray-600 focus:text-gray-700 focus:bg-gray-50 disabled:cursor-not-allowed disabled:border-slate-500 stroke-gray-500 hover:stroke-gray-600 focus:stroke-gray-700'
                        : 'inline-flex items-center justify-center w-full h-12 gap-2 px-6 -mb-px text-sm font-medium tracking-wide transition duration-300 border-b border-transparent rounded-t focus-visible:outline-none justify-self-center hover:border-gray-500 focus:border-gray-600 whitespace-nowrap text-slate-700 stroke-slate-700 hover:text-gray-500 focus:stroke-gray-600 focus:bg-gray-50 focus:text-gray-600 hover:stroke-gray-600 disabled:cursor-not-allowed disabled:text-slate-500' }}"
                    id="tab-label-2d" role="tab" aria-setsize="3" aria-posinset="2" tabindex="-1"
                    aria-controls="tab-panel-2d" aria-selected="false">
                    <span>{{ $category->name }}</span>
                </a>
            </li>
        @empty
            {{ $slot }}
        @endforelse
    </ul>
</div>
