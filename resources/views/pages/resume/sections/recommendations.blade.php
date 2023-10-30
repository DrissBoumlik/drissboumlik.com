<div class="py-5" id="recommendations">
    <div class="recommendations">
        <div class="container">
            <div class="row section-header">
                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                    <hr class="section-title-line">
                    <h1 class="section-title">{{ $recommendations->header }}</h1>
                </div>
            </div>

            <div class="row">
                <div class="owl-carousel owl-theme">
                    @foreach ($recommendations->items as $index => $recommendation)
                        @if (!isset($recommendation->hidden) || !$recommendation->hidden)
                        <div class="owl-carousel-item item">
                            <div class="owl-carousel-item-wrapper row">
                                <div class="owl-carousel-txt col-12">
                                    {!! $recommendation->content !!}
                                    <div class="recommendation-author">
                                        <div class="owl-carousel-img author-image square-50 overflow-hidden">
                                            <img src="{{ asset('/assets/img/people/' . $recommendation->icon) }}"
                                                 class="d-block rounded-circle" alt="...">
                                        </div>
                                        <div class="author-name">
                                            <span class='tiny-font'>{!! $recommendation->author !!}<br/>{!! $recommendation->position !!}</span>
                                        </div>
                                    </div>
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
