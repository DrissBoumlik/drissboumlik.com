@extends('layout.page-content')

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
