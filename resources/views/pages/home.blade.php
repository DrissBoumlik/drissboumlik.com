@extends('layout.app')

@section('content')
    @php
        if (!isset($data) || $data == null) {
            $data = new \stdClass();
        }

        $data->socialLinks = getSocialLinks();
        $data->headerMenu = getHeaderMenu();
        $data->footerMenu = getFooterMenu();
    @endphp
    @include('pages.partials.about')
    <div class="container-fluid p-0">
        <div class="sections">
            <div class="section">
                <div class="posts py-5">
                    <div class="container">
                            <div class="row section-header">
                                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                                    <hr class="section-title-line">
                                    <h1 class="section-title">{{ $data->headline }}</h1>
                                </div>
                            </div>
                            <div class="row">
                                @foreach ($posts as $post)
                                    <div class="col-12 col-lg-6 col-xl-6 mb-4">
                                        @include('components.post', ['post' => $post])
                                    </div>
                                @endforeach
                            </div>
                        </div>
                </div>
            </div>
            <div class="section">
                <div class="services py-5">
                    <div class="container">
                            <div class="row section-header">
                                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                                    <hr class="section-title-line">
                                    <h1 class="section-title">Services</h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-xl-4 col-lg-4 col-12 mb-4">
                                    <div class="service-box w-100">
                                        <div class="service-icon">
                                            <i class="fa-solid fa-palette"></i>
                                        </div>
                                        <div class="service-title">
                                            <h3>UI/UX Design</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-12 mb-4">
                                    <div class="service-box w-100">
                                        <div class="service-icon">
                                            <i class="fa-solid fa-code"></i>
                                        </div>
                                        <div class="service-title">
                                            <h3>Web Development</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-12 mb-4">
                                    <div class="service-box w-100">
                                        <div class="service-icon">
                                            <i class="fa-solid fa-laptop-code"></i>
                                        </div>
                                        <div class="service-title">
                                            <h3>Workshops</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <div class="section">
                @include('pages.resume.sections.recommendations', ['recommendations' => $data->sections['recommendations']])
            </div>
{{--            <div class="section">--}}
{{--                <div class="get-in-touch">--}}
{{--                    <div class="section py-5">--}}
{{--                        <div class="container">--}}
{{--                            <div class="row section-header">--}}
{{--                                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">--}}
{{--                                    <hr class="section-title-line">--}}
{{--                                    <h1 class="section-title">Get in Touch</h1>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-6 offset-3">--}}
{{--                                    <form action="{{ route('get-in-touch') }}" method="POST">--}}
{{--                                        @csrf--}}
{{--                                        <div class="mb-3">--}}
{{--                                            <label for="form-name" class="form-label">Name</label>--}}
{{--                                            <input type="text" class="form-control" id="form-name" placeholder="" name="name" value="blabla" />--}}
{{--                                        </div>--}}
{{--                                        <div class="mb-3">--}}
{{--                                            <label for="form-email" class="form-label">Email address</label>--}}
{{--                                            <input type="email" class="form-control" id="form-email" placeholder="" name="email" value="blabla@bla.bla" />--}}
{{--                                        </div>--}}
{{--                                        <div class="mb-3">--}}
{{--                                            <label for="form-subject" class="form-label">Subject</label>--}}
{{--                                            <input type="text" class="form-control" id="form-subject" placeholder="" name="subject" value="blabla" />--}}
{{--                                        </div>--}}
{{--                                        <div class="mb-3">--}}
{{--                                            <label for="form-message" class="form-label">Message</label>--}}
{{--                                            <textarea class="form-control" id="form-message" rows="3" name="message">sdfkjsdfjhj</textarea>--}}
{{--                                        </div>--}}
{{--                                        <button type="submit" class="btn btn-primary">Submit</button>--}}
{{--                                    </form>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
        </div>
    </div>

    @include('layout.footer')
@endsection
