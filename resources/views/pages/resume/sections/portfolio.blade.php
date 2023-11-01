<div class="py-5" id="portfolio">
    <div class="section portfolio">
        <div class="container">
            @include('components.headline', ['headline' => $portfolio->header])
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
