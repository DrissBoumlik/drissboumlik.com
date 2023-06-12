@extends('admin.template.frontend')

@section('css')
    <link rel="stylesheet" href="/template/assets/js/plugins/magnific-popup/magnific-popup.css">
@endsection
@section('js')
    <script src="/template/assets/js/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
@endsection

@section('content')

    <!-- Hero Content -->
    <div class="bg-image" style="background-image: url('/{{ $post->image }}');">
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
                    <label class="btn btn-alt-secondary">
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

    @if($related_posts && count($related_posts))
    <!-- More Stories -->
    <div class="content content-boxed">
        <!-- Section Content -->
        <div class="row py-5">
            @foreach($related_posts as $related_post)
            <div class="col-md-4">
                <a class="block block-rounded block-link-pop overflow-hidden" href="/blog/{{ $related_post->slug }}">
                <div class="bg-image" style="background-image: url('/{{ $related_post->image }}');">
                    <div class="block-content bg-primary-dark-op">
                    <h4 class="text-white mt-5 push">{{ $related_post->title }}</h4>
                    </div>
                </div>
                <div class="block-content block-content-full fs-sm fw-medium">
                    <span class="text-primary">{{ $related_post->author->name }}</span> · {{ $related_post->published_at }} · <span>{{ $post->read_duration }} min</span>
                </div>
                </a>
            </div>
            @endforeach
        </div>
        <!-- END Section Content -->
    </div>
    <!-- END More Stories -->
    @endif

    @endsection
