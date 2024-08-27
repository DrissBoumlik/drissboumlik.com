<div class="services py-5">
    <div class="container">
        @include('components.headline', ['headline' => $services->header])
        <div class="row justify-content-center mb-4">
            @foreach($services->data as $service)
            <div class="service-box-container">
                <div class="service-box w-100">
                    <a href="/services#{{ $service->slug }}" >
                    <div class="service-img">
                        <img src='{{ asset("/assets/img/services/compressed/$service->image.webp") }}'
                             data-src='{{ asset("/assets/img/services/$service->image.svg") }}'
                            width="300" height="300" alt="{{ $service->title }}" class="img-fluid lazyload">
                    </div>
                    <div class="service-title">
                        <span>{{ $service->title }}</span>
                    </div>
                    </a>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
