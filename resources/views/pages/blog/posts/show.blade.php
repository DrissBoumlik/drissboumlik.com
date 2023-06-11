@extends('layout.template.frontend')

@section('css')
    <link rel="stylesheet" href="/template/assets/js/plugins/magnific-popup/magnific-popup.css">
@endsection
@section('js')
    <script src="/template/assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
@endsection

@section('content')

    <!-- Hero Content -->
    <div class="bg-image" style="background-image: url('{{ $data->post->image }}');">
        <div class="bg-primary-dark-op">
            <div class="content content-full text-center pt-9 pb-8">
                <h1 class="text-white mb-2">{{ $data->post->title }}</h1>
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
            <a class="link-effect" href="be_pages_generic_profile.html">{{ $data->post->author->name }}</a> · {{ $data->post->published_at }} · <span>5 min</span>
            </span>
        </div>
        <div class="row justify-content-center">
            <div class="col-sm-8">
            <!-- Story -->
            <article class="story">
                {!! $data->post->content !!}
                <div class="tags my-4">
                    @foreach ($data->post->tags as $tag)
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
                <a class="btn btn-alt-primary" href="javascript:void(0)">
                <i class="fa fa-heart me-1"></i> Recommend
                </a>
                <div class="btn-group" role="group">
                <button type="button" class="btn btn-alt-secondary" data-bs-toggle="tooltip" title="Like Story">
                    <i class="fa fa-thumbs-up"></i>
                </button>
                <div class="btn-group">
                    <button type="button" class="btn btn-alt-secondary dropdown-toggle" id="dropdown-blog-story" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-share-alt me-1"></i> Share
                    </button>
                    <div class="dropdown-menu dropdown-menu-end fs-sm" aria-labelledby="dropdown-blog-story">
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="fab fa-fw fa-facebook me-1"></i> Facebook
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="fab fa-fw fa-twitter me-1"></i> Twitter
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="fab fa-fw fa-google-plus me-1"></i> Google+
                    </a>
                    <a class="dropdown-item" href="javascript:void(0)">
                        <i class="fab fa-fw fa-linkedin me-1"></i> LinkedIn
                    </a>
                    </div>
                </div>
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
