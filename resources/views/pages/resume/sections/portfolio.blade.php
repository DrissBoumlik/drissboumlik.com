<div class="py-5" id="portfolio">
    <div class="section portfolio">
        <div class="container">
            <div class="row section-header">
                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                    <hr class="section-title-line">
                    <h1 class="section-title uppercase">{{ $portfolio->header }}</h1>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    @foreach ($portfolio->items as $portfolioItem)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="box">
                                <div class="project-image">
                                    <img class="w-100" src="{{ asset('/assets/img/portfolio/' . $portfolioItem->image) }}" alt="">
                                </div>
{{--                                <div class="tuto-title">--}}
{{--                                    {!! $portfolioItem->content !!}--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
