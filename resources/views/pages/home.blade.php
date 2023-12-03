@extends('layout.app')

@section('post-header-assets')
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
            integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
            crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"
            integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
            crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"
            integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
            crossorigin="anonymous"></script>

    @vite(['resources/js/pages/code-animation.js', 'resources/js/pages/contact.js'])
@endsection

@section('content')
    @include('layout.menu', ['headerMenu' => $data->headerMenu])
    <div class="container-fluid p-0">
        @include('pages.shared.about-me', ['socialLinks' => $data->socialLinks])
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
                @include('pages.shared.community', ['socialLinks' => $data->socialLinksCommunity])
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
    @include('layout.footer', ['footerMenu' => $data->footerMenu])
@endsection
