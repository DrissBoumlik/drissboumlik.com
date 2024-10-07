@extends('layout.page-content-wide')

@section('post-header-assets')
    <script async src="https://www.google.com/recaptcha/api.js"></script>
    @vite(['resources/js/pages/contact.js'])
@endsection

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="get-in-touch section py-5">
            <div class="py-5" id="get-in-touch">
                <div class="section">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-lg-6 col-md-7 col-12">
                            <div class="form-wrapper mb-3 mb-md-0">
                                @include("components.contact-form")
                            </div>
                            </div>
                            <div class="col-lg-6 col-md-5 col-11">
                                <div class="img-wrapper">
                                    <img class="img-fluid w-100 lazyload"
                                         src="{{ asset('/assets/img/activities/compressed/hangouts.webp') }}"
                                         data-src="{{ asset('/assets/img/activities/hangouts.svg') }}"
                                         alt="Contact Me" width="300" height="300" loading="lazy">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
