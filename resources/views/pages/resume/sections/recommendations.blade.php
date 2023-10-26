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
                                        <div class="owl-carousel-img author-image square-60 overflow-hidden">
                                            <img src="{{ asset('/assets/img/people/' . $recommendation->icon) }}"
                                                 class="d-block rounded-circle" alt="...">
                                        </div>
                                        <div class="author-name">
                                            <small class='funny-font'>{!! $recommendation->author !!}</small>
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
