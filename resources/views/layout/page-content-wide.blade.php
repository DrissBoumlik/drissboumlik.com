@extends('layout.app')

@section('content')
    @include('layout.menu', ['headerMenu' => $data->headerMenu])
    <div id="about" class="about section-wrapper py-md-5rem py-3rem">
        <div class="section about-header">
            <div id="particles-js" class="particles-js"></div>
            <div class="container headline-wrapper">
                @yield('headline')
            </div>
        </div>
    </div>

    <div id="page-wide" class="page page-wide container-fluid {{ $py_0 ?? 'py-5' }} {{ $px_0 ?? 'px-2' }}">
        @yield('page-content')
    </div>
    @yield('addons')
    @include('layout.footer', ['footerMenu' => $data->footerMenu])
@endsection
