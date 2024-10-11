
<!-- Fonts -->
<link rel="preload" href="{{ Vite::asset('node_modules/@fortawesome/fontawesome-free/webfonts/fa-solid-900.woff2') }}"
      as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ Vite::asset('node_modules/@fortawesome/fontawesome-free/webfonts/fa-brands-400.woff2') }}"
      as="font" type="font/woff2" crossorigin>
<link rel="preload" href="{{ Vite::asset('node_modules/@fortawesome/fontawesome-free/webfonts/fa-regular-400.woff2') }}"
      as="font" type="font/woff2" crossorigin>

<link rel="preload" href="{{ Vite::asset('resources/assets/fonts/istokweb.woff2') }}" as="font" type="font/woff2"
      crossorigin>
<link rel="preload" href="{{ Vite::asset('resources/assets/fonts/UntitledSansWeb-Bold.woff2') }}" as="font"
      type="font/woff2" crossorigin>
{{--<link rel="preload" href="{{ Vite::asset('resources/assets/fonts/Harmattan-Regular.ttf') }}" as="font" type="font/ttf"--}}
{{--      crossorigin>--}}
<link rel="preload" href="{{ Vite::asset('resources/assets/fonts/My Epic Selfie.woff2') }}" as="font" type="font/woff2"
      crossorigin>
{{--<link rel="preload" href="{{ Vite::asset('resources/assets/fonts/Helvetica.ttf') }}" as="font" type="font/ttf"--}}
{{--      crossorigin>--}}
<link rel="preload" href="{{ Vite::asset('resources/assets/fonts/Fira_Code_v6.2/woff2/FiraCode-Regular.woff2') }}"
      as="font" type="font/woff2" crossorigin>
{{--<link rel="preload" href="{{ Vite::asset('resources/assets/fonts/font-mfizz.woff') }}" as="font" type="font/woff"--}}
{{--      crossorigin>--}}

@vite(['resources/sass/externals.sass'])
@vite(['resources/sass/app.sass'])
<script async src="{{ asset('/plugins/particles/particles.min.js') }}"></script>
@vite(['resources/js/app.js'])
