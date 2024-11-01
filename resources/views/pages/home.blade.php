@extends('layout.app')

@section('post-header-assets')
    <script defer src="https://www.google.com/recaptcha/api.js"></script>
    @vite([
        'resources/sass/_imports/pages/_home.sass',
        'resources/sass/_imports/pages/_contact.sass',
        'resources/sass/_imports/layout/_about.sass',
        'resources/sass/_imports/custom/_owl.carousel.sass',
        'resources/js/pages/code-animation.js',
        'resources/js/pages/contact.js',
        'resources/js/pages/carousel.js',
    ])
@endsection

@section('content')
    @include('layout.menu', ['headerMenu' => $data->headerMenu])
    <div class="container-fluid p-0 home">
        @include('pages.shared.about-me', ['socialLinks' => $data->socialLinks])
        <div class="sections">
            <div class="section py-5">
                <section>
                    @include('pages.shared.services', ['services' => $data->sections['services']])
                </section>
            </div>
            <div class="section py-5">
                <section>
                    @include('pages.shared.community', ['socialLinks' => $data->communityLinks])
                </section>
            </div>
            <div class="section py-5">
                <section>
                    @include('pages.shared.testimonials', ['testimonials' => $data->sections['testimonials']])
                </section>
            </div>
            <div class="section py-5">
                <section>
                    @include('pages.shared.get-in-touch')
                </section>
            </div>
        </div>
    </div>
    @include('admin.addons.alert-box')
    @include('layout.footer', ['footerMenu' => $data->footerMenu])
@endsection
