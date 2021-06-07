<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        @include('addons.brand-text')
        @include('pages.partials.head-meta')
        @include('pages.partials.assets')
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
