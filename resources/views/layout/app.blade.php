<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        @include('layout.header-parts.head-meta')

        @yield('pre-header-assets')

        @include('layout.header-parts.assets')

        @yield('post-header-assets')

        <title>{{ $data->page_title ?? 'Driss Boumlik' }}</title>
    </head>
    <body class="antialiased {{ $mode . '-mode' }}">
        {{-- @include('addons.google-tag-manager-body') --}}
        <div class="wrapper">
            @yield('content')
        </div>
        {{-- @include('addons.loader') --}}
        {{-- @include('addons.fb-btn') --}}
        @include('addons.toggle-darkmode')
    </body>
</html>
