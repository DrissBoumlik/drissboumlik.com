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
                            <div class="py-5" id="workshops">
                                <div class="workshops">
                                    <div class="container">
                                        @include('components.headline', ['headline' => $service->text])
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="service workshops">
                                                    <p>I am passionate about empowering individuals and teams through engaging and informative learning experiences.
                                                        With a commitment to knowledge sharing and skill development, I offer workshops that are designed to inspire,
                                                        educate, and foster growth.</p>
                                                    <p>My workshops are crafted to meet the specific needs of participants.
                                                        Whether you are an individual looking to enhance your skills or an organization seeking team development,
                                                        I customize the content to ensure relevance and maximum impact.</p>
                                                    <p>Learning should be an interactive and enjoyable experience.
                                                        My workshops are designed to actively engage participants through hands-on activities, group discussions,
                                                        and practical exercises, fostering a dynamic learning environment.</p>
                                                    <p>From industry-specific skills to personal development, my workshops cover a diverse range of topics.
                                                        Whether it's honing technical skills, improving communication, or fostering creativity, there's a workshop to suit your needs.</p>
                                                    <p>Your goals and aspirations are at the forefront of my workshop design.
                                                        I work closely with clients to understand their unique needs and ensure that the workshop
                                                        content aligns with their objectives.</p>
                                                    <p>Creating a positive and inclusive learning environment is essential for effective workshops.
                                                        I foster an atmosphere where all participants feel comfortable sharing ideas, asking questions,
                                                        and actively participating in the learning process.</p>

                                                    <p>Let's embark on a journey of learning and growth together. <a href="/contact">Contact</a> me to discuss how my workshops can benefit you or your organization.</p>
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
