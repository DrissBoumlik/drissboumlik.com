
<!-- Fonts -->
<link rel="preload" href="{{ asset('/webfonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('/webfonts/fa-brands-400.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('/webfonts/fa-regular-400.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('/assets/fonts/istokweb.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('/assets/fonts/UntitledSansWeb-Bold.woff2') }}" as="font" type="font/woff2" crossorigin>

@vite(['resources/sass/externals.sass'])
@vite(['resources/sass/app.sass'])
<script src="/plugins/particles/particles.js"></script>
@vite(['resources/js/app.js'])
