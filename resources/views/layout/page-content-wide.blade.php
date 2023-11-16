@extends('layout.app')

@section('content')
    <div class="page-wide">
    @include('layout.menu')
    <div class="container-fluid p-0">
        <section id="page-content-wide" class="page-content-wide">
            @yield('page-content-header')
            <div class="content py-5 px-2">
                @yield('page-content')
            </div>
        </section>
    </div>
    @yield('addons')
    @include('layout.footer')
    </div>
@endsection
