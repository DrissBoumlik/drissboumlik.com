@extends('layout.app')

@section('content')
    @php
        if (!isset($data) || $data == null) {
            $data = new \stdClass();
        }

        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
        $data->footerMenu = getFooterMenu();
    @endphp
    @include('pages.partials.about')
    <div class="container-fluid p-0">
        <section class="p-md-5 py-5 px-2 page" id="page">
            <div class="container">
                @yield('page-content')
            </div>
        </section>
    </div>
    @yield('addons')
    @include('layout.footer')
@endsection
