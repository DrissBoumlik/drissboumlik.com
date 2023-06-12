<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>{{ $data->title ?? 'Driss Boumlik' }}</title>

    <meta name="description"
        content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework">
    <meta property="og:site_name" content="OneUI">
    <meta property="og:description"
        content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="/assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="/assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/media/favicons/apple-touch-icon-180x180.png">
    <!-- END Icons -->

    <!-- Stylesheets -->
    <!-- OneUI framework -->
    @yield('css')
    <link href="{{ asset('/template/css/main.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" id="css-main" href="/template/assets/css/oneui.min.css"> --}}

    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="assets/css/themes/amethyst.min.css"> -->
    <!-- END Stylesheets -->
    <!--
    OneUI JS

    Core libraries and functionality
    webpack is putting everything together at assets/_js/main/app.js
    -->
    <script src="{{ asset('/template/assets/js/oneui.app.min.js') }}"></script>
    <script src={{ asset("/template/assets/js/lib/jquery.min.js") }}></script>
    @yield('js')
    <script src="{{ asset('/js/app.js') }}"></script>
</head>

<body>
    <!-- Page Container -->
    <div id="page-container" class="sidebar-dark side-scroll page-header-fixed page-header-dark main-content-boxed">

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
