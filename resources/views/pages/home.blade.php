@extends('layout.app')

@section('post-header-assets')
    <script src="{{ asset('/js/pages/home.js') }}"></script>
@endsection

@section('content')
    @include('layout.menu')
    <div class="container-fluid p-0">
        @include('pages.shared.about-me')
        <div class="sections">
            <div class="section">
                @include('pages.shared.services', ['services' => $data->sections['services']])
            </div>
            <div class="section">
                @include('pages.shared.work', ['work' => $data->sections['work']])
            </div>
            <div class="section">
                @include('pages.shared.techs', ['techs' => $data->sections['techs']])
            </div>
            {{--            <div class="section">--}}
            {{--                @include('pages.home.sections.posts')--}}
            {{--            </div>--}}
            <div class="section">
                @include('pages.shared.community')
            </div>
            <div class="section">
                @include('pages.shared.testimonials', ['testimonials' => $data->sections['testimonials']])
            </div>
            <div class="section">
                @include('pages.shared.get-in-touch')
            </div>
        </div>
    </div>
    @include('admin.addons.alert-box')
    @include('layout.footer')
@endsection
