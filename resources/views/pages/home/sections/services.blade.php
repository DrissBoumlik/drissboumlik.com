<div class="services py-5">
    <div class="container">
        @include('components.headline', ['headline' => $services->header])
        <div class="row justify-content-center mb-4">
            @foreach($services->items as $service)
            <div class="col-sm-6 col-md-4 col-12">
                <div class="service-box w-100">
                    <a href="{{ $service->link }}" >
                    <div class="service-icon">
                        {!! $service->icon !!}
                    </div>
                    <div class="service-title">
                        <span>{{ $service->text }}</span>
                    </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
