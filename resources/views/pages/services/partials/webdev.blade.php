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
                    <div class="section row">
                        <div class="col-12 col-md-10 offset-md-1 col-lg-8 offset-lg-2">
                            <div class="py-5" id="webdev">
                                <div class="webdev">
                                    <div class="container">
                                        @include('components.headline', ['headline' => $service->text])
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="service webdev">
                                                    <p>
                                                        I'm dedicated to bringing your digital vision to life through robust and innovative web
                                                        development. With a passion for clean code, seamless functionality, and cutting-edge
                                                        technologies, I'm committed to helping you achieve your online goals.
                                                    </p>
                                                    <p>I specialize in crafting tailor-made web solutions that cater to your unique needs.
                                                        Whether you require a dynamic business website, a sleek e-commerce platform, or a powerful web application,
                                                        I have the expertise to create a custom solution that aligns with your objectives.</p>
                                                    <p>Your website will not only look stunning on desktops but also adapt seamlessly to various devices,
                                                        providing an optimal user experience across the board.</p>
                                                    <p>I prioritize <a href="/services/ui-ux">user experience</a> in every line of code. From intuitive navigation to smooth interactions,
                                                        I ensure that your audience enjoys a user-friendly experience, fostering engagement and satisfaction.</p>
                                                    <p>Your digital presence should grow with your ambitions. I design and develop scalable solutions that can adapt to your evolving needs,
                                                        ensuring that your website remains a powerful asset as your business expands.</p>
                                                    <p>I believe in a collaborative development process. Your insights and feedback are essential,
                                                        and I work closely with you to ensure that the final product exceeds your expectations.</p>
                                                    <p>Our collaboration doesn't end at launch. I provide ongoing support to address any issues,
                                                        implement updates, and ensure your website continues to perform at its best.</p>

                                                    <p>Let's embark on a journey to elevate your digital presence. Checkout my <a href="/work">work</a> & <a href="/contact">Contact</a> me today, and let's
                                                        discuss how my web development expertise can bring your vision to the online world.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
