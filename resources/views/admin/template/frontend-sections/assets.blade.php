
<!-- Icons -->
<!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
<link rel="shortcut icon" href="{{ asset('/assets/img/me/circle-256.ico') }}">
<link rel="icon" type="image/png" sizes="192x192" href="{{ asset('/assets/img/me/circle-256.ico') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('/assets/img/me/circle-256.ico') }}">
<!-- END Icons -->

<!-- Stylesheets -->
<!-- OneUI framework -->
@yield('css')
<link href="{{ asset('/css/externals.css') }}" rel="preload" as="style">
<link href="{{ asset('/css/externals.css') }}" rel="stylesheet">
<link href="{{ asset('/template/css/main.css') }}" rel="preload" as="style">
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
<script defer src="{{ asset('/template/assets/js/oneui.app.min.js') }}"></script>
<script src={{ asset("/template/assets/js/lib/jquery.min.js") }}></script>
@yield('js')
<script defer src="{{ asset('/template/assets/js/plugins/bootstrap-notify/bootstrap-notify.min.js') }}"></script>
<script defer src="{{ asset('/js/admin/app.js') }}"></script>
