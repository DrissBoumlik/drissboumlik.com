@extends('layout.page-content-wide')

@section('headline')
    <div class="flex flex-col items-center justify-center">
        <h1 class="header-txt">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="services">
            <div class="section py-12">
                <div class="container">
                    @foreach($data->services->data as $service)
                    <div class="row service-row" id="{{ $service->id }}">
                        @if($loop->index % 2 !== 0)
                        <div class="md:w-5/12 pr-20">
                            <div class="service-img">
                                <img src='{{ asset("/assets/img/services/compressed/$service->img.webp") }}' alt="{{ $service->text }}"
                                     data-src='{{ asset("/assets/img/services/$service->img.svg") }}'
                                     class="img-fluid w-full lazyload" width="300" height="300" loading="lazy">
                            </div>
                        </div>
                        @endif
                        <div class="w-full md:w-7/12">
                            <div class="service-description ui-ux">
                                <h4 class="service-title">{{ $service->text }}</h4>
                                <p>{{ $service->description }}</p>
                            </div>
                        </div>
                        @if($loop->index % 2 === 0)
                        <div class="md:w-5/12 pl-20">
                            <div class="service-img">
                                <img src='{{ asset("/assets/img/services/compressed/$service->img.webp") }}' alt="{{ $service->text }}"
                                     data-src='{{ asset("/assets/img/services/$service->img.svg") }}'
                                     class="img-fluid w-full lazyload" width="300" height="300" loading="lazy">
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
