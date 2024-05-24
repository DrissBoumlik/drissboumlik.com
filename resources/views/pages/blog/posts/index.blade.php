@extends('layout.page-content-wide')

@section('post-header-assets')
    @vite(['resources/js/pages/blog.js'])
@endsection

@section('headline')
    <div class="flex flex-col items-center justify-center">
        <h1 class="header-txt">{!! $data->headline !!}
            @if(\Auth::check() && isset($tag))
                <span class="fs-5"><a href="/admin/tags/edit/{{ $tag->slug }}" target="_blank">
                    <i class="fa fa-fw fa-pencil tc-grey-dark"></i></a></span>
            @endif
        </h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="posts section py-12">
            <div class="py-12" id="posts">
                <div class="section posts">
                    <div class="container">
                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="w-full md:w-1/2 mb-4">
                                    @include('components.post', ['post' => $post])
                                </div>
                            @endforeach
                            @if (!count($posts))
                                <div class="w-full">
                                    <div class="message-wrapper flex justify-center items-center"
                                         style="min-height: 300px">
                                        <h3 class="uppercase">No posts found <i class="fa-solid fa-sad-cry"></i>!</h3>
                                    </div>
                                </div>
                            @endif
                            @if(count($posts) && $posts_data->lastPage() > 1)
                            <div class="w-full md:w-2/3 md:ml-auto md:mr-auto
                                        lg:w-2/3 lg:ml-auto lg:mr-auto
                                        xl:w-1/2 xl:ml-auto xl:mr-auto mt-12">
                                <div class="pagination-wrapper justify-center">
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
