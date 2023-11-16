@extends('layout.page-content-wide')

@section('post-header-assets')
    <link rel="stylesheet" type="text/css" href="{{ asset('/plugins/prismjs/prism-tomorrow-night.css') }}">
    <script src="{{ asset('/plugins/prismjs/prism-tomorrow-night.js') }}"></script>
@endsection

@section('headline')
    <div class="container">
        <div class="row">
            <div class="col-12 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2">
                <div class="post-title mb-3">
                    <h2 class="font-weight-bolder">{{ $post->title }}</h2>
                </div>
                <div class="post-meta-data">
                    <div class="post-date mb-1">
                        <span title="{{ $post->published_at }}">Posted {{ $post->published_at_formatted }}</span>
                        @auth
                            ·
                            <a href="/admin/posts/edit/{{ $post->slug }}" target="_blank" class="text-secondary animated-underline">
                                <i class="fa fa-fw fa-pencil"></i> Edit
                            </a>
                        @endauth
                    </div>
                    @if ($post->tags)
                        <div class="post-tags mb-3">
                            @foreach ($post->tags as $tag)
                                <div class="post-tag d-inline-block me-2">
                                    <i class="fa-solid fa-tag fs-small"></i>
                                    <a href="/tags/{{ $tag->slug }}">
                                        <span>{{ $tag->name }}</span>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
{{--        @include('pages.partials.about')--}}
        <div class="post-page">
            <div class="section">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2 mb-4 post">

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
