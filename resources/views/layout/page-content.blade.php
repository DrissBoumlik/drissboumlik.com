@extends('layout.app')

@section('content')
    @include('addons.banner')
    @include('layout.menu')
    <div class="container-fluid p-0">
        <section id="page-content" class="page-content">
            @yield('page-content-header')
            <div class="container p-md-5 py-5 px-2">
                @yield('page-content')
            </div>
        </section>
    </div>
    @yield('addons')
    @include('layout.footer')
@endsection
