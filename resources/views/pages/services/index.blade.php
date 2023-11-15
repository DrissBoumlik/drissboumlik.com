@extends('layout.page-content')

@section('page-content')
    <div class="container-fluid p-0">
        <div class="testimonials">
            <div class="section py-5">
                <div class="container">
                    <div class="section">
                        @include('pages.services.partials.' . $service->id, ['service' => $service])
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
