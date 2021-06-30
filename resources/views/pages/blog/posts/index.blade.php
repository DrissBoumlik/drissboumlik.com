@extends('app')


@section('content')
    <div class="container-fluid p-0">
        @include('pages.partials.about')
        <div class="posts">
            <div class="section py-5">
                <div class="container">
{{--                    <div class="row section-header d-none">--}}
{{--                        <div class="col-md-10 offset-md-1 col-12--}}
{{--                                d-flex flex-column align-items-center justify-content-center">--}}
{{--                            <hr class="section-title-line">--}}
{{--                            <h1 class="section-title">Posts</h1>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="row">
                        @foreach ($data->posts as $post)
                            <div class="col-12 col-md-8 offset-md-2
                                            col-lg-8 offset-lg-2 col-xl-6 offset-xl-3 mb-5 post">
                                <div class="post-title mb-3">
                                    <a href="/blog/{{ $post->slug }}" class="text-dark text-decoration-none">
                                        <h2 class="font-weight-bolder">{{ $post->title }}</h2>
                                    </a>
                                </div>
                                @if ($post->meta_keywords)
                                @php $tags = explode(' ', $post->meta_keywords) @endphp
                                    <div class="post-tags mb-3">
                                        @foreach ($tags as $tag)
                                            <div class="post-tag d-inline-block me-2">
                                                <i class="fas fa-tag fs-small"></i>
                                                <a href="/tags/{{ $tag }}">
                                                    <span>{{ $tag }}</span>
                                                </a>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="post-content">
                                    {!! $post->excerpt !!}
                                </div>
                                <div class="btn-actions mt-3">
                                    <div class="btn-read-more">
                                        <a href="/blog/{{ $post->slug }}">Continue...</a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if (!count($data->posts))
                            <div class="col-12">
                                <div class="message-wrapper d-flex justify-content-center align-items-center"
                                        style="min-height: 300px">
                                    <h3 class="text-uppercase">No posts found <i class="fas fa-sad-cry"></i>!</h3>
                                </div>
                            </div>
                        @endif
                        <div class="col-12 col-md-8 offset-md-2
                                    col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
                            <div class="pagination-wrapper justify-content-center">
                                {{ $data->posts->onEachSide(5)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('layout.footer')
@endsection
