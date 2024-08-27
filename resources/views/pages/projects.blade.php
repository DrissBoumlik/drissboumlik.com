@extends('layout.page-content-wide')

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->projects->header !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="work-page work section py-5">
            <div class="py-5" id="work">
                <div class="section work">
                    <div class="container">
                        <div class="work-items">
                            <div class="row">
                                @foreach ($data->projects->data as $projectItem)
                                    <div class="col-12 col-md-6">
                                        <div class="work-box box mb-4">
                                            <div class="work-image-cover">
                                                <img
                                                    src="{{ asset('/assets/img/work/compressed/' . $projectItem->image) }}"
                                                    alt="{{ $projectItem->title }}"
                                                    data-src="{{ asset('/assets/img/work/' . $projectItem->image) }}"
                                                    class="img-fluid lazyload" width="300" height="250"/>
                                            </div>
                                            <div class="work-data">
                                                <div class="work-txt">
                                                    <div class="work-name">{{ $projectItem->title }}</div>
                                                    <div class="work-description">{{ $projectItem->description }}</div>
                                                </div>
                                                @isset($projectItem->links)
                                                    <div class="work-links">
                                                        @isset($projectItem->links->repository)
                                                            <div class="work-link">
                                                                <a href="{{ $projectItem->links->repository }}"
                                                                   target="_blank" rel="noopener">
                                                                    <i class="fa-brands fa-github"></i>
                                                                </a>
                                                            </div>
                                                        @endisset
                                                        @isset($projectItem->links->website)
                                                            <div class="work-link">
                                                                <a href="{{ $projectItem->links->website }}"
                                                                   target="_blank" rel="noopener">
                                                                    <i class="fa-solid fa-globe"></i>
                                                                </a>
                                                            </div>
                                                        @endisset
                                                    </div>
                                                @endisset
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
