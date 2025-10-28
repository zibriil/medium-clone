@props(['user'])

<div x-data="{
    following: {{ $user->isFollowing(Auth::user()) ? 'true' : 'false' }},
    followersCount: {{ $user->followers()->count() }},
    follow() {
        axios.post('/follow/{!! addslashes($user->username) !!}')
            .then(res => {
                this.following = !this.following;
                this.followersCount = res.data.followersCount;
            })
            .catch(err => {
                console.error(err);
            });
    }
}" {{ $attributes }}>{{ $slot }}</div>
