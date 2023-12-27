@extends('layout.page-content-wide')

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="services">
            <div class="section py-5">
                <div class="container">
                    <div class="row service-row">
                        <div class="col-12 col-md-7">
                            <div class="service-description ui-ux">
                                <h4 class="service-title">UI/UX Design</h4>
                                <p>Thanks to my first ugly websites & designs (which I liked at that time), I learned how to build beautiful
                                    interfaces & assure simple experience.
                                    One of my main mistakes I use to do back in the days, is that I wasn't advising my clients with what's best
                                    for their product or design, and sometimes we end up building something they didn't like,
                                    which led to rebuilding...</p>
                                <div class="read-more"><a href="/services/ui-ux">Read More</a></div>
                            </div>
                        </div>
                        <div class="col-md-5 pe-5">
                            <div class="service-img">
                                <img src="{{ asset('/assets/img/services/compressed/ui-ux.webp') }}" alt="UI/UX Design"
                                     data-src="{{ asset('/assets/img/services/ui-ux.svg') }}"
                                     class="img-fluid w-100 lazyload" width="300" height="300" loading="lazy">
                            </div>
                        </div>
                    </div>
                    <div class="row service-row">
                        <div class="col-md-5 ps-5">
                            <div class="service-img">
                                <img src="{{ asset('/assets/img/services/compressed/webdev.webp') }}" alt="Web Development"
                                     data-src="{{ asset('/assets/img/services/webdev.svg') }}"
                                     class="img-fluid w-100 lazyload" width="300" height="300" loading="lazy">
                            </div>
                        </div>
                        <div class="col-12 col-md-7">
                            <div class="service-description webdev">
                                <h4 class="service-title">Web Development</h4>
                                <p>I'm dedicated to bringing your digital vision to life through robust and innovative web development. With a passion for clean code ,
                                    seamless functionality, and cutting-edge technologies, I'm committed to helping you achieve your online goals.
                                    I specialize in crafting tailor-made web solutions that cater to your unique needs. Whether you require a dynamic business website,
                                    a sleek e-commerce platform, or a powerful web application, I have the expertise to create a custom solution that aligns with your
                                    objectives...</p>
                                <div class="read-more"><a href="/services/webdev">Read More</a></div>
                            </div>
                        </div>
                    </div>
                    <div class="row service-row">
                        <div class="col-12 col-md-7">
                            <div class="service-description workshops">
                                <h4 class="service-title">Workshops</h4>
                                <p>I am passionate about empowering individuals and teams through engaging and informative learning experiences.
                                    With a commitment to knowledge sharing and skill development, I offer workshops that are designed to inspire,
                                    educate, and foster growth.
                                    My workshops are crafted to meet the specific needs of participants. Whether you are an individual looking to
                                    enhance your skills or an organization seeking team development, I customize the content to ensure
                                    relevance and maximum impact...</p>
                                <div class="read-more"><a href="/services/workshops">Read More</a></div>
                            </div>
                        </div>
                        <div class="col-md-5 pe-5">
                            <div class="service-img">
                                <img src="{{ asset('/assets/img/services/compressed/workshops.webp') }}" alt="Workshops"
                                     data-src="{{ asset('/assets/img/services/workshops.svg') }}"
                                     class="img-fluid w-100 lazyload" width="300" height="300" loading="lazy">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
