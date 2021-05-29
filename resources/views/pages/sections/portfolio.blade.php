<div class="section portfolio" id="portfolio">
    <div class="container">
        <div class="row">
            <hr class="section-title-line">
            <h1 class="section-title uppercase">{{ $portfolio->header }}</h1>
        </div>
        <div class="container">
            <div class="row">
                @foreach ($portfolio->items as $portfolioItem)
                    <div class="col-sm-4 col-md-4">
                        <div class="box small">
                            <div class="wrapper"><img src="{{ $portfolioItem->image }}" alt=""></div>
                            <div class="tuto-title">
                                {!! $portfolioItem->content !!}
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
