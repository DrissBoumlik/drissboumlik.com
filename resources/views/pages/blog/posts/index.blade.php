@extends('layout.page-content-wide')

@section('post-header-assets')
    @vite(['resources/js/pages/blog.js'])
@endsection

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->headline !!}
            @auth
                @isset($tag)
                    <span class="fs-5"><a href="/admin/tags/edit/{{ $tag->slug }}" target="_blank">
                        <i class="fa fa-fw fa-pencil tc-grey-dark"></i></a></span>
                @endisset
            @endauth
        </h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="posts section py-5">
            <div class="py-5" id="posts">
                <div class="section posts">
                    <div class="container">
                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="col-12 col-md-8 offset-md-2 col-lg-6 col-lg-0 col-xl-6 col-xl-0 mb-4">
                                    @include('components.post', ['post' => $post])
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
                            @if(count($posts) && $posts_data->lastPage() > 1)
                            <div class="col-12 col-md-8 offset-md-2
                                        col-lg-8 offset-lg-2 col-xl-6 offset-xl-3
                                        mt-5">
                                <div class="pagination-wrapper justify-content-center">
                                    {{ $posts_data->onEachSide(5)->links() }}
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('components.search-blog')
@endsection
