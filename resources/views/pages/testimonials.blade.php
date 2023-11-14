@extends('layout.page-content')


@section('page-content')
    <div class="container-fluid p-0">
        <div class="testimonials">
            <div class="section py-5">
                <div class="container">
                    <div class="section no-slider">
                        @include('pages.resume.sections.testimonials', ['testimonials' => $data->sections['testimonials']])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
