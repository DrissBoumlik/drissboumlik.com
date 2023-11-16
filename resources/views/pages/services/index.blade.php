@extends('layout.page-content-wide')

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="services">
            <div class="section py-5">
                <div class="container">
                    <div class="section row">
                        <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                            @include('pages.services.partials.' . $service->id, ['service' => $service])
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
