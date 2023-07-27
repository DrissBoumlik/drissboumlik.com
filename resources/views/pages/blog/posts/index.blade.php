@extends('layout.page-content')


@section('page-content')
    <div class="container-fluid p-0">
{{--        @include('pages.partials.about')--}}
        <div class="posts">
            <div class="section py-5">
                <div class="container">
                    <div class="row">
                        @foreach ($posts as $post)
                            <div class="col-12 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2 mb-4">
                                <div class="post">
                                    <div class="post-cover" style="background-image: url('/{{ $post->cover }}')"></div>
                                    <div class="post-data">
                                        <div class="post-title mb-1">
                                            <a href="/blog/{{ $post->slug }}" class="text-dark text-decoration-none">
                                                <h3 class="font-weight-bolder">{{ $post->title }}</h3>
                                            </a>
                                        </div>
                                        <div class="post-meta-data">
                                            <span title="{{ $post->published_at }}">Posted {{ $post->published_at_formatted }} · {{ $post->read_duration }} min</span>
                                        </div>
                                        <div class="post-content mt-2">
                                            {!! $post->excerpt !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        @if (!count($posts))
                            <div class="col-12">
                                <div class="message-wrapper d-flex justify-content-center align-items-center"
                                     style="min-height: 300px">
                                    <h3 class="text-uppercase">No posts found <i class="fa-solid fa-sad-cry"></i>!</h3>
                                </div>
                            </div>
                        @endif
                        <div class="col-12 col-md-8 offset-md-2
                                    col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
                            <div class="pagination-wrapper justify-content-center">
                                {{ $posts_data->onEachSide(5)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
