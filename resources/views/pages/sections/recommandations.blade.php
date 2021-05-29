<div class="section recommandations block-inverse" id="recommandations">
    <div class="container">
        <div class="row">
            <hr class="section-title-line">
            <h1 class="section-title uppercase">{{ $recommandations->header }}</h1>
        </div>
        <div class='row'>
            <div class='col-md-offset-2 col-md-8 col-sm-offset-1 col-sm-10'>
                <div class="carousel slide recommandations-carousel" data-ride="carousel" id="quote-carousel-1">
                    <!-- Bottom Carousel Indicators -->
                    <ol class="carousel-indicators">
                        @php $count = count($recommandations->items) @endphp
                        @for($index = 0; $index < $count; $index++)
                            <li data-target="#quote-carousel-1" data-slide-to="{{ $index }}"
                                {{ ($index == 0 ? 'class=active' : '') }}></li>
                        @endfor
                    </ol>

                    <!-- Carousel Slides / Quotes -->
                    <div class="carousel-inner">
                        @foreach ($recommandations->items as $index => $recommandation)
                            <div class="item {{ $index == 0 ? 'active' : '' }}">
                                <blockquote>
                                    <div class="row">
                                        <div class="col-sm-3 text-center">
                                            <img class="img-circle" src="{{ $recommandation->icon }}">
                                        </div>
                                        <div class="col-sm-9">
                                            {!! $recommandation->content !!}
                                        </div>
                                    </div>
                                </blockquote>
                            </div>
                        @endforeach
                    </div>

                    <!-- Carousel Buttons Next/Prev -->
                    <div class="left-say left carousel-control opaque">
                        <a data-slide="prev" href="#quote-carousel-1" class=""><i class="fa fa-chevron-left"></i>
                            <!-- <span class="control-bg"></span> -->
                        </a>
                    </div>
                    <div class="right-say right carousel-control opaque">
                        <a data-slide="next" href="#quote-carousel-1" class=""><i class="fa fa-chevron-right"></i>
                            <!-- <span class="control-bg"></span> -->
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
