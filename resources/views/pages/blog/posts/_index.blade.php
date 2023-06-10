@extends('app')


@section('content')
    <div class="container-fluid p-0">
        @include('pages.partials.about')
        <div class="posts">
            <div class="section py-5">
                <!-- Page Content -->
                <div class="content content-boxed">
                    <div class="row">
                        @foreach ($data->posts as $post)
                            <!-- Story -->
                            <div class="col-lg-4">
                                <a class="block block-rounded block-link-pop overflow-hidden" href="/posts/{{ $post->slug }}">
                                    <img class="img-fluid" src="assets/media/photos/photo8@2x.jpg" alt="">
                                    <div class="block-content">
                                        <h4 class="mb-1">{{ $post->title }}</h4>
                                        <p class="fs-sm fw-medium mb-2">
                                            <span class="text-primary">Albert Ray</span> on July 16, 2021 · <span
                                                class="text-muted">10 min</span>
                                        </p>
                                        <p class="fs-sm text-muted">{!! $post->excerpt !!}...</p>
                                    </div>
                                </a>
                            </div>
                            <!-- END Story -->
                        @endforeach
                            
                            
                        <div class="container d-none">
                            {{--                    <div class="row section-header d-none"> --}}
                            {{--                        <div class="col-md-10 offset-md-1 col-12 --}}
                            {{--                                d-flex flex-column align-items-center justify-content-center"> --}}
                            {{--                            <hr class="section-title-line"> --}}
                            {{--                            <h1 class="section-title">Posts</h1> --}}
                            {{--                        </div> --}}
                            {{--                    </div> --}}
                            <div class="row">
                                @foreach ($data->posts as $post)
                                    <div
                                        class="col-12 col-md-8 offset-md-2 col-sm-10 offset-sm-1
                                            col-lg-8 offset-lg-2 col-xl-6 offset-xl-3 mb-5 post">
                                        <div class="post-title mb-3">
                                            <a href="/posts/{{ $post->slug }}" class="text-dark text-decoration-none">
                                                <h2 class="font-weight-bolder">{{ $post->title }}</h2>
                                            </a>
                                        </div>
                                        @if ($post->meta_keywords)
                                            @php $tags = explode(' ', $post->meta_keywords) @endphp
                                            <div class="post-tags mb-3">
                                                @foreach ($tags as $tag)
                                                    <div class="post-tag d-inline-block me-2">
                                                        <i class="fa-solid fa-tag fs-small"></i>
                                                        <a href="/tags/{{ $tag }}">
                                                            <span>{{ $tag }}</span>
                                                        </a>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                        <div class="post-content">
                                            {!! $post->excerpt !!}...
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
                                            <h3 class="text-uppercase">No posts found <i class="fa-solid fa-sad-cry"></i>!
                                            </h3>
                                        </div>
                                    </div>
                                @endif
                                <div
                                    class="col-12 col-md-8 offset-md-2
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
