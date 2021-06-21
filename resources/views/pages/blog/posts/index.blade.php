@extends('app')

@section('header-assets')
    <script src="https://unpkg.com/react@16.8.6/umd/react.production.min.js"></script>
    <script src="https://unpkg.com/react-dom@16.8.6/umd/react-dom.production.min.js"></script>

    <link rel="stylesheet" href="{{asset('vendor/laraberg/css/laraberg.css')}}">
    <script src="{{ asset('vendor/laraberg/js/laraberg.js') }}"></script>
@endsection

@section('content')
    <div class="container-fluid p-0">
        {{-- @include('pages.partials.about') --}}
        <div class="posts">
            <div class="section py-5">
                <div class="container">
                    <div class="row section-header">
                        <div class="col-md-10 offset-md-1 col-12
                                d-flex flex-column align-items-center justify-content-center">
                            <hr class="section-title-line">
                            <h1 class="section-title">Posts</h1>
                        </div>
                    </div>
                    <div class="row">
                        @foreach ($data->posts as $post)
                            <div class="col-12 col-sm-10 offset-sm-1 col-md-8 offset-md-2
                                            col-lg-6 offset-lg-3 mb-4 post">
                                <div class="post-title mb-3">
                                    <h3>{{ $post->title }}</h3>
                                </div>
                                @if (is_array($post->tags) && count($post->tags))
                                    <div class="post-tags mb-3">
                                        @foreach ($post->tags as $tag)
                                            <a href="/tags/{{ $tag }}">#{{ $tag }}</a>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="post-content">
                                    {!! $post->excerpt !!}
                                </div>
                                <hr>
                            </div>
                        @endforeach
                        @if (!count($data->posts))
                            <div class="col-12">
                                <div class="message-wrapper d-flex justify-content-center align-items-center"
                                        style="min-height: 300px">
                                    <h3 class="text-uppercase">No published posts yet !</h3>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('layout.footer')
@endsection
