<div class="py-5" id="testimonials">
    <div class="testimonials">
        <div class="container">
            @include('components.headline', ['headline' => $testimonials->header])
            <div class="row">
                <div class="owl-carousel owl-theme">
                    @foreach ($testimonials->items as $index => $testimonial)
                        <div class="owl-carousel-item item col-md-6 col-12">
                            <span class="testimonial-icon">
                                <i class="fa-solid fa-quote-right"></i>
                            </span>
                            <div class="owl-carousel-item-wrapper row">
                                <div class="owl-carousel-txt col-12">
                                    {!! $testimonial->content !!}
                                    <div class="testimonial-author">
                                        <div class="owl-carousel-img author-image square-50 overflow-hidden">
                                            <img src="{{ asset('/assets/img/people/' . $testimonial->icon) }}"
                                                 class="d-block rounded-circle w-100 h-100" alt="{{ $testimonial->author }}"
                                                 width="60" height="60" >
                                        </div>
                                        <div class="author-name">
                                            <span>{!! $testimonial->author !!}<br/>{!! $testimonial->position !!}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
