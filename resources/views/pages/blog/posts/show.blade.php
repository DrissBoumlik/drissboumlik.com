@extends('layout.page-content-wide')

@section('post-header-assets')
    <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/prismjs/prism-tomorrow-night.css') }}">
    <script src="{{ asset('/plugins/prismjs/prism-tomorrow-night.js') }}"></script>
@endsection

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt post-title">{!! $post->title !!}</h1>
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
                                <div class="post-date mb-1">
                                    @if($post->published_at)
                                        <span title="{{ $post->published_at }}">Posted: {{ $post->published_at_short_format }} • {{ $post->read_duration }} min read</span>
                                    @endif
                                    @auth
                                        ·
                                        <a href="/admin/posts/edit/{{ $post->slug }}" target="_blank" class="text-secondary animated-underline">
                                            <i class="fa fa-fw fa-pencil"></i> Edit
                                        </a>
                                    @endauth
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
