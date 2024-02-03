<div class="post h-100">
    <div class="post-cover">
        <img src="/{{ $post->cover_compressed }}" alt="{{ $post->title }}"
             data-src="/{{ $post->cover }}"
             class="img-fluid lazyload" loading="lazy" width="500" height="350" />
    </div>
    <div class="post-data">
        <div class="post-title mb-1">
            <a href="/blog/{{ $post->slug }}" class="text-dark text-decoration-none">
                <h3 class="font-weight-bolder post-title-content" title={{ $post->title}}>{{ $post->title }}</h3>
            </a>
        </div>
        <div class="post-metadata">
        @if($post->published_at_short_format)
            {{ $post->published_at_short_format }}
        @else <span class="tc-orange-red">Not Published</span> @endif
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
