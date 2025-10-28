<x-app-layout>
    <div class="">
        <div class="">
            <div class="bg-white">
                <div class="flex mx-auto max-w-7xl h-dvh">
                    <div class="w-[75%] flex-1">
                        <div class="max-w-2xl mx-auto sm:pe-6 lg:pe-8" aria-multiselectable="false">
                            <div class="my-12">
                                <h1 class="text-5xl text-gray-950 font-bold">{{ $user->name }}</h1>
                            </div>
                            <ul class="flex items-center border-b border-gray-200 mb-7 space-x-6" role="tablist">
                                <li role="presentation">
                                    <button
                                        class="inline-flex items-center justify-center w-full h-12 gap-2 -mb-px text-sm font-medium tracking-wide transition duration-300 border-b rounded-t focus-visible:outline-none whitespace-nowrap border-gray-500 focus:border-gray-700 text-gray-500 hover:text-gray-900 focus:text-gray-700 focus:bg-gray-50 disabled:cursor-not-allowed disabled:border-gray-500 stroke-gray-500 hover:stroke-gray-600 focus:stroke-gray-700"
                                        id="tab-label-1c" role="tab" aria-setsize="3" aria-posinset="1"
                                        tabindex="0" aria-controls="tab-panel-1c" aria-selected="true">
                                        <span>Home</span>
                                    </button>
                                </li>
                                <li role="presentation">
                                    <button
                                        class="inline-flex items-center justify-center w-full h-8 gap-2 -mb-px text-sm font-medium tracking-wide transition duration-300 border-b border-transparent rounded-t focus-visible:outline-none justify-self-center whitespace-nowrap text-slate-500 stroke-slate-700 hover:text-gray-900 focus:stroke-gray-600 focus:bg-gray-50 focus:text-gray-600 hover:stroke-gray-600 disabled:cursor-not-allowed disabled:text-slate-500"
                                        id="tab-label-2c" role="tab" aria-setsize="3" aria-posinset="2"
                                        tabindex="-1" aria-controls="tab-panel-2c" aria-selected="false">
                                        <span>About</span>
                                    </button>
                                </li>
                            </ul>
                            <div>
                                <div class="" id="tab-panel-1c" aria-hidden="false" role="tabpanel"
                                    aria-labelledby="tab-label-1c" tabindex="-1">
                                    <div class="divide-y">
                                        @forelse ($posts as $post)
                                            <x-post-item :post="$post" />
                                        @empty
                                            <div class="text-gray-500 text-center py-16">Posts not found!</div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- End Basic sm sized tab -->
                    </div>
                    <x-follow-container :user="$user" class="w-[25%] border-l pt-10 ps-10">
                        <div class="space-y-3">
                            <x-user-avatar :user="$user" size="[88px]" />
                            <div>
                                <h3 class="text-lg font-bold">{{ $user->name }}</h3>
                                <p class="text-gray-500 font-medium mt-1 mb-3"><span x-text="followersCount"></span>
                                    followers</p>
                                <p class="text-sm text-gray-500">{{ $user->bio }}</p>
                            </div>
                        </div>
                        <div class="mt-5 mb-8">
                            @if (Auth::user()?->id !== $user->id)
                                <button
                                    @click="
                            @if (Auth::check()) follow()
                            @else
                            window.location.href = '{{ route('login') }}' @endif
                            "
                                    type="button" class="text-white text-sm px-4 py-2 rounded-full"
                                    x-text="following ? 'Unfollow' : 'Follow'"
                                    :class="following ? 'bg-red-600' : 'bg-slate-950'" />
                            @endif
                        </div>

                        <div>
                            <h3 class="font-bold">Following</h3>
                        </div>
                    </x-follow-container>
                </div>
            </div>
        </div>
</x-app-layout>
