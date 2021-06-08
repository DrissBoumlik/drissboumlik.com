<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('addons.brand-text')
        @include('layout.header-parts.head-meta')

        @include('addons.google-analytics')

        @include('layout.header-parts.assets')
        <title>{{ $title ?? 'Driss Boumlik' }}</title>
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
