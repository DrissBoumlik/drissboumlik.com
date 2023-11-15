<div class="post h-100">
    <div class="post-cover" style="background-image: url('/{{ $post->cover }}')"></div>
    <div class="post-data">
        <div class="post-title mb-1">
            <a href="/blog/{{ $post->slug }}" class="text-dark text-decoration-none">
                <h3 class="font-weight-bolder">{{ $post->title }}</h3>
            </a>
        </div>
        <div class="post-content mt-2">
            {{ $post->published_at_short_format }}
        </div>
    </div>
</div>
