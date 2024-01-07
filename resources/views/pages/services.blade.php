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
                    @foreach($data->services->data as $service)
                    <div class="row service-row" id="{{ $service->id }}">
                        @if($loop->index % 2 !== 0)
                        <div class="col-md-5 pe-5">
                            <div class="service-img">
                                <img src='{{ asset("/assets/img/services/compressed/$service->img.webp") }}' alt="{{ $service->text }}"
                                     data-src='{{ asset("/assets/img/services/$service->img.svg") }}'
                                     class="img-fluid w-100 lazyload" width="300" height="300" loading="lazy">
                            </div>
                        </div>
                        @endif
                        <div class="col-12 col-md-7">
                            <div class="service-description ui-ux">
                                <h4 class="service-title">{{ $service->text }}</h4>
                                <p>{{ $service->description }}</p>
                            </div>
                        </div>
                        @if($loop->index % 2 === 0)
                        <div class="col-md-5 pe-5">
                            <div class="service-img">
                                <img src='{{ asset("/assets/img/services/compressed/$service->img.webp") }}' alt="{{ $service->text }}"
                                     data-src='{{ asset("/assets/img/services/$service->img.svg") }}'
                                     class="img-fluid w-100 lazyload" width="300" height="300" loading="lazy">
                            </div>
                        </div>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection