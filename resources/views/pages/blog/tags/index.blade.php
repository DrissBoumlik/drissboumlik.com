@extends('layout.page-content')


@section('page-content')
    <div class="container-fluid p-0">
        <div class="posts">
            <div class="section py-5">
                <div class="container">
                    <div class="row">
                        @foreach ($tags as $tag)
                            <div class="col-12 col-lg-8 offset-lg-2 col-xl-8 offset-xl-2 mb-4">
                                <div class="post">
                                    <div class="post-cover" style="background-image: url('/{{ $tag->cover }}')"></div>
                                    <div class="post-data">
                                        <div class="post-title mb-1">
                                            <a href="/tags/{{ $tag->slug }}" class="text-dark text-decoration-none">
                                                <h3 class="font-weight-bolder text-uppercase">{{ $tag->name }} ({{ $tag->posts_count }})</h3>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{--                <a href="/tags/{{ $tag->slug }}">--}}
                            {{--                        <span style="background-color: {{ $tag->color }}"--}}
                            {{--                              class="fs-sm fw-semibold d-inline-block py-1 px-3 mb-2--}}
                            {{--                                        rounded-pill text-white">{{ $tag->name }} ({{ $tag->posts_count }})</span>--}}
                            {{--                </a>--}}
                        @endforeach
                        @if (!count($tags))
                            <div class="col-12">
                                <div class="message-wrapper d-flex justify-content-center align-items-center"
                                     style="min-height: 300px">
                                    <h3 class="text-uppercase">No tags found <i class="fa-solid fa-sad-cry"></i>!</h3>
                                </div>
                            </div>
                        @endif
                        <div class="col-12 col-md-8 offset-md-2
                                                    col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
                            <div class="pagination-wrapper justify-content-center">
                                {{ $tags->onEachSide(5)->links() }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
