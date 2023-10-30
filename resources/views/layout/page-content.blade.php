@extends('layout.app')

@section('content')
    @if(request()->is(['blog', 'blog/*', 'tags', 'tags/*']))
        @include('addons.announcement', ['text' => 'Blog in testing phase for now', 'icon' => '<i class="fa-solid fa-circle-info"></i>'])
    @endif
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
