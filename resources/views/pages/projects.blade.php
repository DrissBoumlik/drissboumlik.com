@extends('layout.page-content-wide')

@section('post-header-assets')
    @vite('resources/sass/_imports/pages/_projects.sass')
@endsection

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->projects->header !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="projects-page projects section py-5">
            <div class="py-5" id="projects">
                <div class="section projects">
                    <div class="container">
                        <div class="projects-items">
                            <div class="row">
                                @foreach ($data->projects->data as $projectItem)
                                    <div class="col-12 col-md-6">
                                        <div class="project-box box mb-4">
                                            <div class="project-image-cover">
                                                <img
                                                    src="{{ asset('/' . $projectItem->image?->compressed) }}"
                                                    alt="{{ $projectItem->title }}"
                                                    data-src="{{ asset('/' . $projectItem->image?->original) }}"
                                                    class="img-fluid lazyload" width="300" height="250"/>
                                            </div>
                                            <div class="project-data">
                                                <div class="project-txt">
                                                    <div class="project-name">{{ $projectItem->title }}</div>
                                                    <div class="project-description">{{ $projectItem->description }}</div>
                                                </div>
                                                @isset($projectItem->links)
                                                    <div class="project-links">
                                                        <div class="project-link-wrapper">
                                                        @isset($projectItem->links->website)
                                                            <div class="project-link">
                                                                <a href="{{ $projectItem->links->website }}"
                                                                   target="_blank" rel="noopener">view</a>
                                                            </div>
                                                        @endisset
                                                        @isset($projectItem->links->repository)
                                                            <div class="project-link">
                                                                <a href="{{ $projectItem->links->repository }}"
                                                                   target="_blank" rel="noopener">repository</a>
                                                            </div>
                                                        @endisset
                                                        </div>
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
