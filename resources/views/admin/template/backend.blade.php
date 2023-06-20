<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  <title>{{ $data->title ?? 'Admin Panel' }}</title>

  <meta name="description" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
  <meta name="author" content="pixelcave">
  <meta name="robots" content="noindex, nofollow">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('/assets/img/me/circle-256.ico') }}">
  <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('/assets/img/me/circle-256.ico') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/assets/img/me/circle-256.ico') }}">

  <!-- Modules -->
  @yield('css')
  <link href="{{ asset('/template/css/main.css') }}" rel="stylesheet">
  @yield('css-after')

  <!-- Alternatively, you can also include a specific color theme after the main stylesheet to alter the default color theme of the template -->
  {{-- @vite(['resources/sass/main.scss', 'resources/sass/oneui/themes/amethyst.scss', 'resources/js/oneui/app.js']) --}}

  {{-- <script src="{{ asset('/js/oneui/app.js') }}"></script> --}}

  <script src="{{ asset('/template/assets/js/oneui.app.min.js') }}"></script>
  <script src={{ asset("/template/assets/js/lib/jquery.min.js") }}></script>
  @yield('js')
  <script defer src="{{ asset('/js/app.js') }}"></script>
</head>

<body>
  <!-- Page Container -->
  <div id="page-container" class="sidebar-o  enable-page-overlay side-scroll main-content-narrow {{ $theme == 'dark-mode' ? 'page-header-dark dark-mode sidebar-dark' : '' }}">


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
