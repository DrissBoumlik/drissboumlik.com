<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    @include('admin.template.frontend-sections.meta')

    @include('admin.template.frontend-sections.assets')
</head>

<body>
    <!-- Page Container -->
    <div id="page-container" class="side-scroll main-content-boxed page-header-fixed {{ $theme == 'dark-mode' ? 'page-header-dark dark-mode sidebar-dark' : '' }}">

       @include('admin.template.frontend-sections.nav')


        @include('admin.template.frontend-sections.header')

        <!-- Main Container -->
        <main id="main-container">
            @yield('content')
        </main>
        <!-- END Main Container -->

        @include('admin.template.frontend-sections.footer')
    </div>
    <!-- END Page Container -->

</body>

</html>
