@extends('layout.app')

@section('post-header-assets')
    <script src="{{ asset('/plugins/jquery/jquery-3.7.1.slim.js') }}"></script>
    @vite(['resources/js/pages/code-animation.js', 'resources/js/pages/contact.js'])
@endsection

@section('content')
    @include('layout.menu', ['headerMenu' => $data->headerMenu])
    <div class="container-fluid p-0">
        @include('pages.shared.about-me', ['socialLinks' => $data->socialLinks])
        <div class="sections">
            <div class="section py-5">
                @include('pages.shared.services', ['services' => $data->sections['services']])
            </div>
            <div class="section py-5">
                @include('pages.shared.work', ['work' => $data->sections['work']])
            </div>
            <div class="section py-5">
                @include('pages.shared.techs', ['techs' => $data->sections['techs']])
            </div>
            {{--            <div class="section">--}}
            {{--                @include('pages.home.sections.posts')--}}
            {{--            </div>--}}
            <div class="section py-5">
                @include('pages.shared.community', ['socialLinks' => $data->socialLinksCommunity])
            </div>
            <div class="section py-5">
                @include('pages.shared.testimonials', ['testimonials' => $data->sections['testimonials']])
            </div>
            <div class="section py-5">
                @include('pages.shared.get-in-touch')
            </div>
        </div>
    </div>
    @include('admin.addons.alert-box')
    @include('layout.footer', ['footerMenu' => $data->footerMenu])
@endsection
