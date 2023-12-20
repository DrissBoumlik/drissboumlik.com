@extends('layout.page-content-wide')

@section('post-header-assets')
    <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/prismjs/prism-tomorrow-night.css') }}">
    <script src="{{ asset('/plugins/prismjs/prism-tomorrow-night.js') }}"></script>
@endsection

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt post-title capitalize-first-letter">{!! $post->title !!}
            @auth
                <span class="fs-5"><a href="/admin/posts/edit/{{ $post->slug }}" target="_blank">
                        <i class="fa fa-fw fa-pencil tc-grey-dark"></i></a></span>
            @endauth
        </h1>
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
                                <div class="post-date mb-2">
                                    @if($post->published_at)
                                        <div class="published_date">
                                            <span title="{{ $post->published_at }}">{{ $post->published_at_short_format }}</span>
                                            <span class="fw-bold">•</span>
                                            <span>{{ $post->read_duration }} min read</span>
                                            <span class="fw-bold">•</span>
                                            <span><i class="fa fa-fw fa-eye"></i> {{ $post->views }}</span>
                                        </div>
                                    @else
                                        <div class="published_date">Not Published</div>
                                    @endif
                                </div>
                                @if ($post->tags)
                                    <div class="post-tags">
                                        @foreach ($post->tags as $tag)
                                            <div class="post-tag d-inline-block">
                                                <i class="fa-solid fa-tag fs-small"></i>
                                                <a href="/tags/{{ $tag->slug }}">
                                                    <span>{{ $tag->name }}</span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="post-content mt-3">
                                {!! $post->content !!}
                            </div>
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
