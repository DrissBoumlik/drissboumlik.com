<div class="services py-5">
    <div class="container">
        @include('components.headline', ['headline' => $services->header])
        <div class="row justify-content-sm-around justify-content-start mb-4">
            @foreach($services->data as $service)
            <div class="service-box-container col-lg-3 col-md-4 col-sm-5 offset-sm-0 col-6 offset-3">
                <div class="service-box w-100">
                    <a href="/services#{{ $service->slug }}" >
                    <div class="service-img">
                        <img src='{{ asset("/" . $service->image?->compressed) }}'
                             data-src='{{ asset("/" . $service->image?->original) }}'
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
