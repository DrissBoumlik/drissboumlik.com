<!doctype html>
<html lang="{{ config('app.locale') }}">

<head>
    @include('admin.template.frontend-sections.meta')

    @include('admin.template.frontend-sections.assets')
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