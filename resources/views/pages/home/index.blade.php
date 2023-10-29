@extends('layout.app')

@section('post-header-assets')
    <script src="{{ asset('/js/pages/home.js') }}"></script>
@endsection

@section('content')
    @php
        if (!isset($data) || $data == null) {
            $data = new \stdClass();
        }

        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
        $data->footerMenu = getFooterMenu();
    @endphp
    @include('layout.menu')
{{--    @include('pages.partials.about')--}}
    <div class="container-fluid p-0">
            @include('pages.home.sections.about-me')
        <div class="sections">
            <div class="section">
                @include('pages.home.sections.services')
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
