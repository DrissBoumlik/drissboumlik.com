@extends('layout.app')

@section('content')
    @if(request()->is(['blog', 'blog/*', 'tags', 'tags/*']))
        @include('addons.banner', ['text' => 'Blog in testing phase for now', 'icon' => '<i class="fa-solid fa-circle-info"></i>'])
    @endif
    @include('layout.menu', ['headerMenu' => $data->headerMenu])
    <div id="about" class="about section-wrapper py-md-5rem py-3rem">
        <div class="section about-header">
            <div id="particles-js" class="particles-js"></div>
            <div class="container headline-wrapper">
                @yield('headline')
            </div>
        </div>
    </div>

    <div id="page-wide" class="page page-wide container-fluid py-5 px-2">
        @yield('page-content')
    </div>
    @yield('addons')
    @include('layout.footer', ['footerMenu' => $data->footerMenu])
@endsection
