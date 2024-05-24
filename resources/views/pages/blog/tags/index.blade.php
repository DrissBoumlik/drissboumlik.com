@extends('layout.page-content-wide')

@section('post-header-assets')
    @vite(['resources/js/pages/blog.js'])
@endsection

@section('headline')
    <div class="flex flex-col items-center justify-center">
        <h1 class="header-txt">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="tags section py-12">
            <div class="py-12" id="tags">
                <div class="section tags">
                    <div class="container">
                        <div class="row">
                            @foreach ($tags as $tag)
                                <div class="w-full md:w-1/2 lg:w-1/3 mb-4">
                                    <div class="tag-item">
                                        <div class="tag-cover">
                                            <img src="/{{ $tag->cover_compressed }}" alt="{{ $tag->name }}"
                                                 data-src="/{{ $tag->cover }}" width="300" height="250"
                                                 class="img-fluid lazyload" loading="lazy" />
                                        </div>
                                        <div class="tag-text">
                                            <a href="/tags/{{ $tag->slug }}" class="tag-link no-underline">
                                                <div class="font-extrabold uppercase tag-link-text">{{ $tag->name }}</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if (!count($tags))
                                <div class="col-12">
                                    <div class="message-wrapper flex justify-center items-center"
                                         style="min-height: 300px">
                                        <h3 class="uppercase">No tags found <i class="fa-solid fa-sad-cry"></i>!</h3>
                                    </div>
                                </div>
                            @endif
                            @if(count($tags) && $tags_data->lastPage() > 1)
                            <div class="w-full md:w-2/3 md:mx-auto
                                        lg:w-2/3 lg:mx-auto xl:w-1/2 xl:mx-auto mt-12">
                                <div class="pagination-wrapper justify-center">
                                    {{ $tags_data->onEachSide(5)->links() }}
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
