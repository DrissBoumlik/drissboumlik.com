<div class="col-12 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2 mb-4">
    <div class="post">
        <div class="post-cover" style="background-image: url('/{{ $post->cover }}')"></div>
        <div class="post-data">
            <div class="post-title mb-1">
                <a href="/blog/{{ $post->slug }}" class="text-dark text-decoration-none" wire:navigate>
                    <h3 class="font-weight-bolder">{{ $post->title }}</h3>
                </a>
            </div>
            <div class="post-meta-data">
                <span title="{{ $post->published_at }}">Posted {{ $post->published_at_formatted }} · {{ $post->read_duration }} min</span>
            </div>
            <div class="post-content mt-2">
                {!! $post->excerpt !!}
            </div>
        </div>
    </div>
</div>