<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <!-- External Addons-->
        {{-- @include('addons.google-analytics') --}}
        {{-- @include('addons.google-optimize') --}}

        <!-- Addons-->
        @include('addons.brand-text')
        @include('layout.header-parts.head-meta')

        {{-- @include('addons.google-tag-manager-head') --}}

        @yield('pre-header-assets')
        @include('layout.header-parts.assets')
        @yield('post-header-assets')
        <title>{{ $data->title ?? 'Admin Panel' }}</title>
    </head>
    <body class="antialiased {{ $mode . '-mode' }}">
        {{-- @include('addons.google-tag-manager-body') --}}
        <div class="wrapper">
                @yield('content')
        </div>
        @include('addons.toggle-darkmode')
        {{-- @include('addons.alert') --}}
    </body>
</html>
