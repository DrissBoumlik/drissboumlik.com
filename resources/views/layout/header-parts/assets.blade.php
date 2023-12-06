
<!-- Fonts -->
<link rel="preload" href="{{ asset('/webfonts/fa-solid-900.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('/webfonts/fa-brands-400.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('/webfonts/fa-regular-400.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('/webfonts/fa-v4compatibility.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('/assets/fonts/istokweb.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('/assets/fonts/UntitledSansWeb-Bold.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('/assets/fonts/Harmattan-Regular.ttf') }}" as="font" type="font/ttf" crossorigin>
<link rel="preload" href="{{ asset('/assets/fonts/My Epic Selfie.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('/assets/fonts/Helvetica.ttf') }}" as="font" type="font/ttf" crossorigin>
<link rel="preload" href="{{ asset('/assets/fonts/Fira_Code_v6.2/woff2/FiraCode-Regular.woff2') }}" as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ asset('/assets/fonts/font-mfizz.woff') }}" as="font" type="font/woff" crossorigin>

@vite(['resources/sass/externals.sass'])
@vite(['resources/sass/app.sass'])
<script src="{{ asset('/plugins/particles/particles.js') }}"></script>
@vite(['resources/js/app.js'])
