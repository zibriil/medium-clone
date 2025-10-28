@props(['user', 'size'])

<div class="w-{{ $size }} h-{{ $size }} bg-gray-100 rounded-full border overflow-hidden">
    @if ($user->avatar)
        <img src="{{ $user->avatarUrl() }}" alt="{{ $user->name }}'s avatar"
            class="w-{{ $size }} h-{{ $size }} rounded-full object-cover">
    @else
        <img src="https://avatar.iran.liara.run/username?username={{ urlencode($user->name) }}" alt="dummy avatar"
            class="w-{{ $size }} h-{{ $size }} rounded-full object-cover">
    @endif
</div>
