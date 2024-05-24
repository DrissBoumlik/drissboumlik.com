@extends('layout.page-content-wide')

@section('headline')
    <div class="flex flex-col items-center justify-center">
        <h1 class="header-txt">{!! $data->testimonials->header !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid">
        <div class="testimonials section no-slider py-12">
            <div class="py-12" id="testimonials">
                <div class="testimonials">
                    <div class="container">
                        <div class="row">
                            <div class="owl-carousel owl-theme">
                                @foreach ($data->testimonials->data as $index => $testimonial)
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
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
