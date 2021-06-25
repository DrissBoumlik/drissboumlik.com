@extends('app')

@section('content')
    <div class="container-fluid p-0">
        @include('pages.partials.about')
        <div class="posts">
            <div class="section py-5">
                <div class="container">
                    <div class="row section-header d-none">
                        <div class="col-md-10 offset-md-1 col-12
                                d-flex flex-column align-items-center justify-content-center">
                            <hr class="section-title-line">
                            <h1 class="section-title">Post</h1>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 col-md-8 offset-md-2
                                        col-lg-8 offset-lg-2 col-xl-6 offset-xl-3 mb-4 post">
                            <div class="post-image mb-3">
                                <img src="/storage/{{ $data->post->image }}" alt=""
                                        class="w-100">
                            </div>
                            <div class="post-title mb-3">
                                <h2 class="font-weight-bolder">{{ $data->post->title }}</h2>
                            </div>
                            <div class="post-meta-data">
                                <div class="post-date">
                                    <i class="far fa-clock"></i>
                                    {{ $data->post->updated_at->format('j F Y') }}
                                </div>
                                @if ($data->post->meta_keywords)
                                @php $tags = explode(' ', $data->post->meta_keywords) @endphp
                                    <div class="post-tags mb-3">
                                        @foreach ($tags as $tag)
                                            <a href="/tags/{{ $tag }}">#{{ $tag }}</a>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="post-content mt-3">
                                {!! $data->post->body !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    @include('layout.footer')
@endsection
