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
                            <div class="py-5" id="ui-ux">
                                <div class="ui-ux">
                                    <div class="container">
                                        @include('components.headline', ['headline' => $service->text])
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="service ui-ux">
                                                    <p>Thanks to my first ugly websites & designs (which I liked at that time),
                                                        I learned how to build beautiful interfaces & assure simple experience.</p>
                                                    <p>One of my main mistakes I use to do back in the days, is that I wasn't advising my clients with what's best for their product or design,
                                                        and sometimes we end up building something they didn't like, which led to rebuilding.</p>
                                                    <p>I spend most of my experience focusing on the backend side,
                                                        but since I like to learn about other fields and not be restricted to only one, I allowed myself to dive into the design world.</p>
                                                    <p>I don't claim to be one of the best but here is how I can help your business,
                                                        I do believe in collaboration, working closely with you to understand your goals,
                                                        ask many questions, gather feedback, ensuring the final product aligns seamlessly with your vision</p>
                                                    <p>Let's collaborate to turn your ideas into a visually stunning and user-friendly reality.
                                                        Checkout my <a href="https://codepen.com/drissboumlik" target="_blank">codepen</a>, <a href="/work">work</a> &
                                                        <a href="/contact">Contact</a> me today to discuss how my UI/UX design services can elevate your digital presence.</p>
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
