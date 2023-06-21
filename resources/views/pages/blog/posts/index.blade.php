@extends('admin.template.frontend')


@section('content')
    <!-- Hero Content -->
    <div class="bg-image" style="background-image: url('/assets/img/blog/default.jfif');">
        <div class="bg-primary-dark-op">
            <div class="content content-full text-center pt-7 pb-6">
                <h1 class="h2 text-white mb-2">
                    {{ $data->headline }}
                </h1>
{{--                <h2 class="h4 fw-normal text-white-75 mb-0">--}}
{{--                    Feel free to explore and read.--}}
{{--                </h2>--}}
            </div>
        </div>
    </div>
    <!-- END Hero Content -->

    <!-- Page Content -->
    <div class="content content-boxed">
        <div class="row">
            @forelse ($posts as $post)
                <!-- Story -->
                <div class="col-md-4 col-sm-6">
                    <a class="block block-rounded block-link-pop overflow-hidden" href="/blog/{{ $post->slug }}">
                        <div class="post-cover" style="background-image: url('/{{ $post->cover }}')">
{{--                            <img class="img-fluid" src="/{{ $post->image }}" alt="">--}}
                        </div>
                        <div class="block-content">
                            <h4 class="mb-1" title="{{ $post->title }}">{{ $post->short_title }}</h4>
                            <p class="fs-sm fw-medium mb-2">
                                Posted {{ $post->published_at }} · <span class="text-muted">{{ $post->read_duration }} min read</span>
                            </p>
{{--                            <p class="fs-sm text-muted">--}}
{{--                                {!! $post->excerpt ?? \Str::limit($post->content, 20); !!}--}}
{{--                            </p>--}}
                        </div>
                    </a>
                </div>
                <!-- END Story -->
            @empty
                <div class="col-md-6 offset-md-3">
                    <p class="text-muted text-center">No posts found on this page!</p>
                </div>
            @endforelse
        </div>
        @if ($posts_data->lastPage > 1)
            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination justify-content-center push">
                    <li class="page-item">
                        <a class="page-link" {{ $posts_data->currentPage == 1 ? "" : "href=?page=" . ($posts_data->currentPage - 1) }} aria-label="Next">
                        <span aria-hidden="true">
                            <i class="fa fa-angle-left"></i>
                        </span>
                            <span class="visually-hidden">Prev</span>
                        </a>
                    </li>
                    @if ($posts_data->lastPage != 1)
                        @for ($i = 1; $i <= $posts_data->lastPage; $i++)
                            <li class="page-item {{ $posts_data->currentPage == $i ? 'active' : '' }}">
                                <a class="page-link" {{ $posts_data->currentPage == $i ? '' : "href=?page=$i" }}>{{ $i }}</a>
                            </li>
                        @endfor
                    @endif
                    <li class="page-item">
                        <a class="page-link" {{ $posts_data->currentPage == $posts_data->lastPage ? "" : "href=?page=" . ($posts_data->currentPage + 1) }} aria-label="Next">
                        <span aria-hidden="true">
                            <i class="fa fa-angle-right"></i>
                        </span>
                            <span class="visually-hidden">Next</span>
                        </a>
                    </li>
                </ul>
            </nav>
            <!-- END Pagination -->
        @endif
    </div>
    <!-- END Page Content -->
@endsection
