@extends('layout.page-content')

@section('pre-header-assets')
    <link id="highlightjs-style" rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/styles/{{ $mode == 'light' ? 'default.min.css' : 'dark.min.css' }}">
@endsection
@section('post-header-assets')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/highlight.min.js"></script>
    {{--    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.8.0/languages/go.min.js"></script>--}}
    <script>

    </script>
@endsection

@section('page-content')
    <livewire:post :post="$post" />
@endsection
