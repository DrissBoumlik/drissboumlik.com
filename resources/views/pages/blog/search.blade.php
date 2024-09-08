@extends('layout.page-content-wide')

@section('post-header-assets')
    @vite(['resources/js/pages/blog.js'])
@endsection

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt fs-small text-transform-unset">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="search-results py-5">
            <div class="py-5" id="search-results">
                <div class="section">
                    <div class="container">
                        <div class="row">
                            @foreach ($data->results as $result)
                                <div class="col-12 col-md-8 offset-md-2 col-lg-6 col-lg-0 mb-4">
                                    <div class="search-result-item">
                                        <a href="{{ $result->link }}" class="search-result-link text-decoration-none">
                                            <div class="search-result-cover">
                                                <img src="/{{ $result->cover->compressed }}" alt="{{ $result->short_title }}"
                                                     data-src="/{{ $result->cover->original }}"
                                                     class="img-fluid lazyload" loading="lazy" />
                                            </div>
                                            <div class="search-result-text p-3 text-center">
                                                <div class="font-weight-bolder search-result-link-text">{!! $result->type !!} {{ $result->short_title }}</div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                            @if (!count($data->results))
                                <div class="col-12">
                                    <div class="message-wrapper d-flex justify-content-center align-items-center"
                                         style="min-height: 300px">
                                        <h3 class="text-uppercase">Nothing found for {{ $data->term }} <i class="fa-solid fa-sad-cry"></i>!</h3>
                                    </div>
                                </div>
                            @endif
                            @if(count($data->results) && $data->results_metadata->lastPage() > 1)
                                <div class="col-12 col-md-8 offset-md-2
                                    col-lg-8 offset-lg-2 col-xl-6 offset-xl-3 mt-5">
                                    <div class="pagination-wrapper justify-content-center">
                                        {{ $data->results_metadata->onEachSide(5)->appends($_GET)->links() }}
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
