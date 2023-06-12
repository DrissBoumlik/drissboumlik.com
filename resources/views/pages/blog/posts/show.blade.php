@extends('admin.template.frontend')

@section('css')
    <link rel="stylesheet" href="/template/assets/js/plugins/magnific-popup/magnific-popup.css">
@endsection
@section('js')
    <script src="/template/assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
@endsection

@section('content')

    <!-- Hero Content -->
    <div class="bg-image" style="background-image: url('{{ $post->image }}');">
        <div class="bg-primary-dark-op">
            <div class="content content-full text-center pt-9 pb-8">
                <h1 class="text-white mb-2">{{ $post->title }}</h1>
                <h2 class="h4 fw-normal text-white-75 mb-0">Experience life to its fullest.</h2>
            </div>
        </div>
    </div>
    <!-- END Hero Content -->

    <!-- Page Content -->
    <div class="bg-body-extra-light">
        <div class="content content-boxed">
        <div class="text-center fs-sm push">
            <span class="d-inline-block py-2 px-4 bg-body fw-medium rounded">
            <a class="link-effect" href="be_pages_generic_profile.html">{{ $post->author->name }}</a> · {{ $post->published_at }} · <span>{{ $post->read_duration }} min read</span>
            </span>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-8">
            <!-- Story -->
            <article class="story">
                {!! $post->content !!}
                <div class="tags my-4">
                    @foreach ($post->tags as $tag)
                        <a href="/tags/{{ $tag->slug }}">
                        <span style="background-color: {{ $tag->color }}"
                              class="fs-sm fw-semibold d-inline-block py-1 px-3 mb-2
                                        rounded-pill text-white">{{ $tag->name }}</span>
                        </a>
                    @endforeach
                </div>
            </article>
            <!-- END Story -->

            <!-- Actions -->
            <div class="mt-5 d-flex justify-content-between push">
                <div class="btn-group">
                    <button class="btn btn-alt-primary like-post" data-post="{{ json_encode($post) }}">
                        <span class="post-likes-count">{{ $post->likes }} Likes</span><i class="fa fa-heart ms-1"></i>
                    </button>
                </div>
                <div class="btn-group">
                    <label class="btn btn-alt-secondary" id="dropdown-blog-story" data-bs-toggle="dropdown">
                        {{ $post->views }} Views <i class="fa fa-eye ms-1"></i>
                    </label>
                </div>
            </div>
            <!-- END Actions -->
            </div>
        </div>
        </div>
    </div>
    <!-- END Page Content -->

    <!-- More Stories -->
    <div class="content content-boxed">
        <!-- Section Content -->
        <div class="row py-5">
        <div class="col-md-4">
            <a class="block block-rounded block-link-pop overflow-hidden" href="javascript:void(0)">
            <div class="bg-image" style="background-image: url('/template/assets/media/photos/photo2.jpg');">
                <div class="block-content bg-primary-dark-op">
                <h4 class="text-white mt-5 push">10 Productivity Tips</h4>
                </div>
            </div>
            <div class="block-content block-content-full fs-sm fw-medium">
                <span class="text-primary">Danielle Jones</span> on July 2, 2019 · <span>12 min</span>
            </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="block block-rounded block-link-pop overflow-hidden" href="javascript:void(0)">
            <div class="bg-image" style="background-image: url('/template/assets/media/photos/photo10.jpg');">
                <div class="block-content bg-primary-dark-op">
                <h4 class="text-white mt-5 push">Travel &amp; Work</h4>
                </div>
            </div>
            <div class="block-content block-content-full fs-sm fw-medium">
                <span class="text-primary">Susan Day</span> on July 6, 2019 · <span>15 min</span>
            </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="block block-rounded block-link-pop overflow-hidden" href="javascript:void(0)">
            <div class="bg-image" style="background-image: url('/template/assets/media/photos/photo3.jpg');">
                <div class="block-content bg-primary-dark-op">
                <h4 class="text-white mt-5 push">New Image Gallery</h4>
                </div>
            </div>
            <div class="block-content block-content-full fs-sm fw-medium">
                <span class="text-primary">David Fuller</span> on June 29, 2019 · <span>10 min</span>
            </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="block block-rounded block-link-pop overflow-hidden" href="javascript:void(0)">
            <div class="bg-image" style="background-image: url('/template/assets/media/photos/photo23.jpg');">
                <div class="block-content bg-primary-dark-op">
                <h4 class="text-white mt-5 push">Explore the World</h4>
                </div>
            </div>
            <div class="block-content block-content-full fs-sm fw-medium">
                <span class="text-primary">Jack Estrada</span> on June 16, 2019 · <span>13 min</span>
            </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="block block-rounded block-link-pop overflow-hidden" href="javascript:void(0)">
            <div class="bg-image" style="background-image: url('/template/assets/media/photos/photo22.jpg');">
                <div class="block-content bg-primary-dark-op">
                <h4 class="text-white mt-5 push">Follow Your Dreams</h4>
                </div>
            </div>
            <div class="block-content block-content-full fs-sm fw-medium">
                <span class="text-primary">Sara Fields</span> on May 23, 2019 · <span>10 min</span>
            </div>
            </a>
        </div>
        <div class="col-md-4">
            <a class="block block-rounded block-link-pop overflow-hidden" href="javascript:void(0)">
            <div class="bg-image" style="background-image: url('/template/assets/media/photos/photo24.jpg');">
                <div class="block-content bg-primary-dark-op">
                <h4 class="text-white mt-5 push">Top 10 Destinations</h4>
                </div>
            </div>
            <div class="block-content block-content-full fs-sm fw-medium">
                <span class="text-primary">Carl Wells</span> on May 15, 2019 · <span>7 min</span>
            </div>
            </a>
        </div>
        </div>
        <!-- END Section Content -->
    </div>
    <!-- END More Stories -->

    @endsection
