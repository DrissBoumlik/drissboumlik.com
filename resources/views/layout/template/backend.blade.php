<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

  <title>{{ $data->title ?? 'Admin Panel' }}</title>

  <meta name="description" content="OneUI - Bootstrap 5 Admin Template &amp; UI Framework created by pixelcave and published on Themeforest">
  <meta name="author" content="pixelcave">
  <meta name="robots" content="noindex, nofollow">

  <!-- Icons -->
  <link rel="shortcut icon" href="{{ asset('/assets/media/favicons/favicon.png') }}">
  <link rel="icon" sizes="192x192" type="image/png" href="{{ asset('/assets/media/favicons/favicon-192x192.png') }}">
  <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/assets/media/favicons/apple-touch-icon-180x180.png') }}">

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
  <div id="page-container" class="sidebar-o enable-page-overlay sidebar-dark side-scroll page-header-fixed main-content-narrow">
    <!-- Side Overlay-->
    <aside id="side-overlay" class="fs-sm">
      <!-- Side Header -->
      <div class="content-header border-bottom">
        <!-- User Avatar -->
        <a class="img-link me-1" href="javascript:void(0)">
          <img class="img-avatar img-avatar32" src="{{ asset('/template/assets/media/avatars/avatar10.jpg') }}" alt="">
        </a>
        <!-- END User Avatar -->

        <!-- User Info -->
        <div class="ms-2">
          <a class="text-dark fw-semibold fs-sm" href="javascript:void(0)">John Smith</a>
        </div>
        <!-- END User Info -->

        <!-- Close Side Overlay -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
        <a class="ms-auto btn btn-sm btn-alt-danger" href="javascript:void(0)" data-toggle="layout" data-action="side_overlay_close">
          <i class="fa fa-fw fa-times"></i>
        </a>
        <!-- END Close Side Overlay -->
      </div>
      <!-- END Side Header -->

      <!-- Side Content -->
      <div class="content-side">
        <p>
          Content..
        </p>
      </div>
      <!-- END Side Content -->
    </aside>
    <!-- END Side Overlay -->

    @include('layout.template.backend-sections.aside')


      @include('layout.template.backend-sections.header')

    <!-- Main Container -->
    <main id="main-container">
      @yield('content')
    </main>
    <!-- END Main Container -->

  @include('layout.template.backend-sections.footer')
  </div>
  <!-- END Page Container -->
</body>

</html>
