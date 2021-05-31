<div class="py-5" id="recommandations">
    <div class="section recommandations">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                    <hr class="section-title-line">
                    <h1 class="section-title text-uppercase">{{ $recommandations->header }}</h1>
                </div>
            </div>

            <div class="row">
                <div class='offset-md-1 col-md-10 col-12'>
                    <div id="recommandations-carousel" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            @php $count = count($recommandations->items) @endphp
                            @for($index = 0; $index < $count; $index++)
                                <button type="button" data-bs-target="#recommandations-carousel" data-bs-slide-to="{{ $index }}"
                                aria-current="true" aria-label="Slide {{ $index }}" class="btn-indicator {{ ($index == 0 ? 'active' : '') }}"></button>
                            @endfor
                        </div>
                        <div class="carousel-inner">
                            @foreach ($recommandations->items as $index => $recommandation)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <div class="carousel-item-wrapper row">
                                        <div class="carousel-img col-12">
                                            <img src="{{ asset('/assets/img/people/' . $recommandation->icon) }}"
                                            class="d-block square-100 rounded-circle" alt="...">
                                        </div>
                                        <div class="carousel-txt col-12">
                                            {!! $recommandation->content !!}
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        {{-- <button class="carousel-control-prev" type="button" data-bs-target="#recommandations-carousel" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#recommandations-carousel" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
