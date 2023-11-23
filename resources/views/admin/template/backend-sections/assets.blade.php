

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
<script defer src="{{ asset('/js/admin/app.js') }}"></script>
