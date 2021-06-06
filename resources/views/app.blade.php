<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        @include('addons.brand-text')
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="This is my resume.">
        <meta name="keywords" content="teacode, teacodema, javascript, php, laravel, discord, html, css, learn, programming, nodejs, web, development, programmers, developers, bugs, debug, debugging, programmer, coding, developer, bug, code, webdesign, software">
        <meta name="author" content="Driss Boumlik">
        {{-- <meta http-equiv="refresh" content="60"> --}}
        {{-- <meta name="robots" content="index, follow"> --}}
        {{-- @include('addons.google-analytics') --}}
        {{-- @include('addons.google-tag-manager-head') --}}

        <link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/drissboumlik/me.ico') }}">
        <link rel="apple-touch-icon" href="{{ asset('/assets/img/drissboumlik/me.ico') }}">

        <!-- Fonts -->
        <link rel="preload" href="{{ asset('/webfonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="{{ asset('/webfonts/fa-brands-400.woff2') }}" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="{{ asset('/assets/fonts/istokweb.woff2') }}" as="font" type="font/woff2" crossorigin>
        <link rel="preload" href="{{ asset('/assets/fonts/UntitledSansWeb-Bold.woff2') }}" as="font" type="font/woff2" crossorigin>

        <link href="{{ asset('/css/externals.css') }}" rel="preload" as="style">
        <link href="{{ asset('/css/externals.css') }}" rel="stylesheet">
        <link id="app-css-preload" href="{{ asset('/css/app.css') }}" rel="preload" as="style">
        <link id="app-css" href="{{ asset('/css/app.css') }}" rel="stylesheet">
        <script defer src="{{ asset('/js/app.js') }}"></script>
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
