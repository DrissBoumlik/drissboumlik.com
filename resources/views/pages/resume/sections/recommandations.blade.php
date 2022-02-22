<div class="py-5" id="recommandations">
    <div class="section recommandations">
        <div class="container">
            <div class="row section-header">
                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                    <hr class="section-title-line">
                    <h1 class="section-title">{{ $recommandations->header }}</h1>
                </div>
            </div>

            <div class="row">
                <div class="owl-carousel owl-theme">
                    @foreach ($recommandations->items as $index => $recommandation)
                        @if (!isset($recommandation->hidden) || !$recommandation->hidden)
                        <div class="owl-carousel-item item">
                            <div class="owl-carousel-item-wrapper row">
                                <div class="owl-carousel-img col-12">
                                    <img src="{{ asset('/assets/img/people/' . $recommandation->icon) }}"
                                    class="d-block square-100 rounded-circle" alt="..." height="95" width="95">
                                </div>
                                <div class="owl-carousel-txt col-12">
                                    {!! $recommandation->content !!}
                                </div>
                            </div>
                        </div>
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
