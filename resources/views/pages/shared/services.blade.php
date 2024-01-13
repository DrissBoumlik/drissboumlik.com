<div class="services py-5">
    <div class="container">
        @include('components.headline', ['headline' => $services->header])
        <div class="row justify-content-center mb-4">
            @foreach($services->data as $service)
            <div class="service-box-container">
                <div class="service-box w-100">
                    <a href="/services#{{ $service->id }}" >
                    <div class="service-img">
                        <img src='{{ asset("/assets/img/services/compressed/$service->img.webp") }}'
                             data-src='{{ asset("/assets/img/services/$service->img.svg") }}'
                            width="300" height="300" alt="{{ $service->text }}" class="img-fluid lazyload">
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
