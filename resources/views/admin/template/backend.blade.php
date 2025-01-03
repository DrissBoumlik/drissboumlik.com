<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    @include('admin.template.backend-sections.meta')

    @yield('pre-header-assets')
    @include('admin.template.backend-sections.assets')
    @yield('post-header-assets')
    <title>{{ $data->page_title ?? 'Admin Panel' }}</title>
</head>

<body>
    <!-- Page Container -->
    <div id="page-container" class="sidebar-o enable-page-overlay side-scroll {{ $theme === 'dark-mode' ? 'page-header-dark dark-mode sidebar-dark' : 'light-mode' }}">


        @include('admin.template.backend-sections.left-sidebar')


        @include('admin.template.backend-sections.header')

        <!-- Main Container -->
        <main id="main-container">
            @yield('content')
        </main>
        <!-- END Main Container -->

        @include('admin.template.backend-sections.footer')
    </div>
    <!-- END Page Container -->
</body>

</html>
