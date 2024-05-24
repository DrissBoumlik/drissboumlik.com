<div class="py-12" id="testimonials">
    <div class="testimonials owl-carousel-wrapper">
        <div class="container">
            @include('components.headline', ['headline' => $testimonials->header])
            <div class="row">
                <div class="owl-carousel owl-theme">
                    @foreach ($testimonials->data as $index => $testimonial)
                        <div class="owl-carousel-item item md:w-1/2 w-full">
                            <span class="testimonial-icon">
                                <i class="fa-solid fa-quote-right"></i>
                            </span>
                            <div class="owl-carousel-item-wrapper row">
                                <div class="owl-carousel-txt w-full">
                                    <div class="testimonial-content">
                                        {!! $testimonial->content !!}
                                    </div>
                                    <div class="testimonial-author">
                                        <div class="owl-carousel-img author-image square-50 overflow-hidden">
                                            <img src="{{ asset('/assets/img/people/' . $testimonial->icon) }}"
                                                class="block rounded-full w-full h-full" alt="{{ $testimonial->author }}"
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
            <div class="row mt-12">
                <div class="w-full">
                    <div class="see-more"><a href="/testimonials" class="btn tc-blue-dark-2-bg tc-blue-bg-hover br-50px">See More</a></div>
                </div>
            </div>
        </div>
    </div>
</div>
