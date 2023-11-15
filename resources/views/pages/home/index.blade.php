@extends('layout.app')

@section('post-header-assets')
{{--    <link rel="stylesheet" href="{{ asset('/plugins/devicon/devicon.min.css') }}">--}}
    <script src="{{ asset('/js/pages/home.js') }}"></script>
@endsection

@section('content')
    @include('layout.menu')
    <div class="container-fluid p-0">
        @include('pages.home.sections.about-me')
        <div class="sections">
            <div class="section">
                @include('pages.home.sections.services', ['services' => $data->sections['services']])
            </div>
            <div class="section">
                @include('pages.resume.sections.work', ['work' => $data->sections['work']])
            </div>
            <div class="section">
                @include('pages.home.sections.techs', ['techs' => $data->sections['techs']])
            </div>
{{--            <div class="section">--}}
{{--                @include('pages.home.sections.posts')--}}
{{--            </div>--}}
            <div class="section">
                @include('pages.resume.sections.testimonials', ['testimonials' => $data->sections['testimonials']])
            </div>
            <div class="section">
                @include('pages.home.sections.get-in-touch')
            </div>
        </div>
    </div>
    @include('admin.addons.alert-box')
    @include('layout.footer')
@endsection
