@extends('layout.app')

@section('post-header-assets')
    @vite(['resources/sass/idf.sass', 'resources/js/pages/idf.js'])
@endsection


@section('content')

    @include('pages.job-applications.component')

@endsection
