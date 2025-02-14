@extends('layout.page-content-wide')

@section('post-header-assets')
    @vite(['resources/js/pages/blog.js', 'resources/sass/_imports/pages/post/_post-import.sass'])
@endsection

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt post-title capitalize-first-letter text-center">{!! $post->title !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="post-page">
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2 mb-4 post">
                            <div class="post-meta-data d-flex flex-column align-items-center">
                                @if(! isGuest(session()->get('guest-view')))
                                    <div class="admin-area mb-2">
                                        <span class="me-4"><i class="fa fa-eye"></i> {{ $post->views }}</span>
                                        <span class="me-4"><i class="fa fa-thumbs-up"></i> {{ $post->likes }}</span>
                                        <span><a href="/admin/posts/edit/{{ $post->slug }}" target="_blank">
                                            <i class="fa fa-fw fa-pencil"></i> Edit</a></span>
                                    </div>
                                @endif
                                <div class="post-date mb-2">
                                    @if($post->published_at)
                                        <div class="published_date">
                                            <span title="{{ $post->published_at }}">{{ $post->published_at_short_format }}</span>
                                            <span class="fw-bold">•</span>
                                            <span>{{ $post->read_duration }} min read</span>
                                        </div>
                                    @else
                                        <div class="published_date">Not Published</div>
                                    @endif
                                </div>
                                @if ($post->tags)
                                    <div class="post-tags">
                                        @foreach ($post->tags as $tag)
                                            <div class="post-tag">
                                                <i class="fa-solid fa-tag fs-small"></i>
                                                <a href="/tags/{{ $tag->slug }}">
                                                    <span>{{ $tag->name }}</span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <article>
                                <div class="post-content mt-3">
                                    {!! $post->content !!}
                                </div>
                            </article>
                            <div class="report-actions highlight-box mt-5 px-3 py-2">
                                <p class="m-0">If you noticed a tpyo, bug <i class="fa-solid fa-bug"></i> or have an idea <i class="fa-solid fa-lightbulb"></i> for the next article,
                                    Feel free to email me at hi@drissboumlik.com</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
