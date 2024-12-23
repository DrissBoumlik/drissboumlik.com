<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="{{ $data->page_data?->page_description ?? 'Here is where you get to know who is Driss Boumlik'}}">
<meta name="author" content="Driss Boumlik">
{{-- <meta http-equiv="refresh" content="60"> --}}
 <meta name="robots" content="index, follow">
 @include('addons.google-analytics')
{{-- @include('addons.google-tag-manager-head') --}}
<!-- CSRF Token -->
<meta name="csrf-token" content="{{ csrf_token() }}">

<link rel="canonical" href="https://www.drissboumlik.com/">
<meta property='og:title' content='{{ $data->page_data?->page_title ?? "HOME" }}'/>
<meta property='og:image' content='{{ $data->page_data?->page_image ?? asset('/assets/img/me/icon.ico') }}'/>
<meta property='og:description' content='{{ $data->page_data?->page_description ?? "Here is where you get to know who is Driss Boumlik" }}'/>
<meta property='og:url' content='{{ $data->page_data?->page_url ?? \URL::to("/") }}'/>
<meta name="og:image" content="{{ $data->page_data?->page_image ?? asset('/assets/img/me/icon.ico') }}">
<meta name="og:image:width" content="1200">
<meta name="og:image:height" content="1200">
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:image" content="{{ $data->page_data?->page_image ?? asset('/assets/img/me/icon.ico') }}">
<meta name="twitter:image:width" content="1200">
<meta name="twitter:image:height" content="1200">
<meta name="twitter:image:alt" content='{{ $data->page_data?->page_title ?? "Main picture" }}'>

<link rel="icon" type="image/x-icon" href="{{ asset('/assets/img/me/icon.ico') }}">
<link rel="apple-touch-icon" href="{{ asset('/assets/img/me/icon.ico') }}">
<script type="application/ld+json">
    {!! $data->page_data?->jsonld ?? getDefaultJsonLD() !!}
</script>
