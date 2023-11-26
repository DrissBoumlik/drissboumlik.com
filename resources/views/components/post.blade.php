<div class="post h-100">
    <div class="post-cover" style="background-image: url('/{{ $post->cover }}')"></div>
    <div class="post-data">
        <div class="post-title mb-1">
            <a href="/blog/{{ $post->slug }}" class="text-dark text-decoration-none">
                <h3 class="font-weight-bolder">{{ $post->title }}</h3>
            </a>
        </div>
        <div class="post-metadata">
            {{ $post->published_at_short_format }}
        </div>
        @if ($post->tags)
            <div class="post-tags">
                @foreach ($post->tags as $tag)
                    <div class="post-tag d-inline-block">
                        <i class="fa-solid fa-tag fs-small"></i><a class="ms-1" href="/tags/{{ $tag->slug }}"><span>{{ $tag->name }}</span></a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</div>
