@extends('layout.app')

@section('content')
    @if(request()->is(['blog', 'blog/*', 'tags', 'tags/*']))
        @include('addons.banner', ['text' => 'Blog in testing phase for now', 'icon' => '<i class="fa-solid fa-circle-info"></i>'])
    @endif
    @include('layout.menu')
    <div id="page" class="page container py-5 px-2">
        @yield('page-content')
    </div>
    @yield('addons')
    @include('layout.footer')
@endsection
