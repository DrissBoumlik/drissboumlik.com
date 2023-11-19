@extends('layout.page-content-wide')

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="sections">
            @foreach ($data->sections as $key => $section)
                <div class="{{ $key }} section">
                    @include("pages.shared.$key", [$key => $section])
                </div>
            @endforeach
        </div>
    </div>
@endsection
