@extends('layout.page-content-wide')

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="tags section py-5">
            <div class="py-5" id="tags">
                <div class="section tags">
                    <div class="container">
                        <div class="row">
                            @foreach ($tags as $tag)
                                <div class="col-12 col-md-6 col-lg-4 mb-4">
                                    <div class="tag-item">
                                        <div class="tag-cover" style="background-image: url('/{{ $tag->cover }}')"></div>
                                        <div class="tag-text">
                                            <a href="/tags/{{ $tag->slug }}" class="tag-link text-decoration-none">
                                                <div class="font-weight-bolder text-uppercase tag-link-text">{{ $tag->name }}</div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                            @if (!count($tags))
                                <div class="col-12">
                                    <div class="message-wrapper d-flex justify-content-center align-items-center"
                                         style="min-height: 300px">
                                        <h3 class="text-uppercase">No tags found <i class="fa-solid fa-sad-cry"></i>!</h3>
                                    </div>
                                </div>
                            @endif
                            @if(count($tags) && $tags->lastPage() > 1)
                            <div class="col-12 col-md-8 offset-md-2
                                        col-lg-8 offset-lg-2 col-xl-6 offset-xl-3 mt-5">
                                <div class="pagination-wrapper justify-content-center">
                                    {{ $tags->onEachSide(5)->links() }}
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
