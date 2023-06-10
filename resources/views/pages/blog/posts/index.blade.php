@extends('layout.template.frontend')


@section('content')
    <!-- Hero Content -->
    <div class="bg-primary-dark">
        <div class="content content-full text-center pt-7 pb-6">
            <h1 class="h2 text-white mb-2">
                The latest stories only for you.
            </h1>
            <h2 class="h4 fw-normal text-white-75 mb-0">
                Feel free to explore and read.
            </h2>
        </div>
    </div>
    <!-- END Hero Content -->

    <!-- Page Content -->
    <div class="content content-boxed">
        <div class="row">
            @foreach ($data->posts as $post)
                <!-- Story -->
                <div class="col-lg-4">
                    <a class="block block-rounded block-link-pop overflow-hidden" href="/posts/{{ $post->slug }}">
                        <img class="img-fluid" src="/template/assets/media/photos/photo8@2x.jpg" alt="">
                        <div class="block-content">
                            <h4 class="mb-1">{{ $post->title }}</h4>
                            <p class="fs-sm fw-medium mb-2">
                                <span class="text-primary">Albert Ray</span> on July 16, 2021 · <span class="text-muted">10 min</span>
                            </p>
                            <p class="fs-sm text-muted">
                                {!! $post->excerpt !!}...
                            </p>
                            <div class="tags mb-4">
                                @foreach ($post->tags as $tag)
                                <span style="background-color: {{ $tag->color }}"
                                    class="fs-sm fw-semibold d-inline-block py-1 px-3 
                                    rounded-pill text-white">{{ $tag->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    </a>
                </div>
                <!-- END Story -->
            @endforeach
        </div>
        <!-- Pagination -->
        <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center push">
                <li class="page-item active">
                    <a class="page-link" href="javascript:void(0)">1</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)">2</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)">3</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)">4</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)">5</a>
                </li>
                <li class="page-item">
                    <a class="page-link" href="javascript:void(0)" aria-label="Next">
                        <span aria-hidden="true">
                            <i class="fa fa-angle-right"></i>
                        </span>
                        <span class="visually-hidden">Next</span>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- END Pagination -->
    </div>
    <!-- END Page Content -->
@endsection
