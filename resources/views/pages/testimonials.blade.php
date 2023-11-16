@extends('layout.page-content')


@section('page-content')
    <div class="container-fluid p-0">
        <div class="testimonials section no-slider py-5">
            @include('pages.resume.sections.testimonials', ['testimonials' => $data->sections['testimonials']])
        </div>
    </div>
@endsection
