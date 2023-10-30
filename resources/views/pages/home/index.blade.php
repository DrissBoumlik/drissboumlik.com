@extends('layout.app')

@section('post-header-assets')
    <link rel="stylesheet" href="{{ asset('/plugins/devicon/devicon.min.css') }}">
    <script src="{{ asset('/js/pages/home.js') }}"></script>
@endsection

@section('content')
    @include('layout.menu')
    <div class="container-fluid p-0">
        @include('pages.home.sections.about-me')
        <div class="sections">
            <div class="section">
                @include('pages.home.sections.services')
            </div>
            <div class="section">
                @include('pages.resume.sections.portfolio', ['portfolio' => $data->sections['portfolio']])
            </div>
            <div class="section">
                @include('pages.home.sections.techs', ['techs' => $data->sections['techs']])
            </div>
            <div class="section">
                @include('pages.home.sections.posts')
            </div>
            <div class="section">
                @include('pages.resume.sections.recommendations', ['recommendations' => $data->sections['recommendations']])
            </div>
            <div class="section">
                @include('pages.home.sections.get-in-touch')
            </div>
        </div>
    </div>
    @include('admin.addons.alert-box')
    @include('layout.footer')
@endsection
