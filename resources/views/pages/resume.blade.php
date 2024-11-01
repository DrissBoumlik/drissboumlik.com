@extends('layout.page-content-wide', ['px_0' => 'px-0', 'py_0' => 'py-0'])

@section('post-header-assets')
    @vite([
        'resources/sass/_imports/custom/_owl.carousel.sass',
        'resources/sass/_imports/pages/resume/_resume-import.sass',
        'resources/js/pages/carousel.js',
        'resources/js/pages/tooltip.js',
     ])
@endsection

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="sections">
            @foreach ($data->sections as $key => $section)
                <div class="{{ $key }} section py-5">
                    @include("pages.shared.$key", [$key => $section])
                </div>
            @endforeach
            @include('pages.resume.menu')
        </div>
    </div>
@endsection
