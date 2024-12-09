<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

        @include('addons.brand-text')
        @include('layout.header-parts.head-meta')

        @yield('pre-header-assets')

        @include('layout.header-parts.assets')

        @yield('post-header-assets')

        <title>{{ $data->page_title ?? 'Driss Boumlik' }}</title>
    </head>
    <body class="antialiased {{ $mode . '-mode' }}">
        {{-- @include('addons.google-tag-manager-body') --}}
        <div class="banner tc-blue-bg">
            <div class="container banner-container">
                <div class="banner-wrapper">
                    <div class="banner-text">
                        <span class="title">
                            <div>أدعوا لإخواننا في فلسطين</div>
                            <div class="separator">|</div>
                            <div>Pray for our brothers in Palestine</div>
                        </span>
                    </div>
                </div>
                <div class="banner-close">
                    <i class="fa-solid fa-times"></i>
                </div>
            </div>
        </div>
        <div class="wrapper">
            @yield('content')
        </div>
        {{-- @include('addons.loader') --}}
        {{-- @include('addons.fb-btn') --}}
        @include('addons.toggle-darkmode')
    </body>
</html>
