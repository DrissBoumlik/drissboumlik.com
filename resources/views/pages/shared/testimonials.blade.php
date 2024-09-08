<div class="py-5" id="testimonials">
    <div class="testimonials owl-carousel-wrapper">
        <div class="container">
            @include('components.headline', ['headline' => $testimonials->header])
            <div class="row">
                <div class="owl-carousel owl-theme">
                    @foreach ($testimonials->data as $index => $testimonial)
                        <div class="owl-carousel-item item col-md-6 col-12">
                            <span class="testimonial-icon">
                                <i class="fa-solid fa-quote-right"></i>
                            </span>
                            <div class="owl-carousel-item-wrapper row">
                                <div class="owl-carousel-txt col-12">
                                    <div class="testimonial-content">
                                        {!! $testimonial->content !!}
                                    </div>
                                    <div class="testimonial-author">
                                        <div class="owl-carousel-img author-image square-50 overflow-hidden">
                                            <img src="{{ asset('/' . $testimonial->image->original) }}"
                                                 class="d-block rounded-circle w-100 h-100" alt="{{ $testimonial->author }}"
                                                 width="60" height="60" loading="lazy">
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
            <div class="row mt-5">
                <div class="col-12">
                    <div class="see-more"><a href="/testimonials" class="btn tc-blue-dark-2-bg tc-blue-bg-hover br-50px">See More</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
