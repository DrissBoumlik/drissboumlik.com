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
                                <form id="contact-form" class="mb-3 mb-md-0">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="form-name" placeholder="" name="name" autocomplete="off" required />
                                        <label for="form-name">Name</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control" id="form-email" placeholder="" name="email" autocomplete="off" required />
                                        <label for="form-email">Email address</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <textarea class="form-control" id="form-body" rows="3" name="body" placeholder="" required maxlength="1000"></textarea>
                                        <label for="form-body">Message</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <!-- Google Recaptcha -->
                                        <div id="form-g-recaptcha-response" class="g-recaptcha w-100" data-sitekey={{ config('services.recaptcha.key') }}></div>
                                    </div>
                                    <div class="btns d-flex gap-2">
                                        <button type="submit" class="btn tc-blue-dark-2-bg tc-blue-bg-hover w-100">Send</button>
                                        <a href="https://calendly.com/drissboumlik/30min" target="_blank" class="btn tc-blue-dark-1-outline tc-blue-dark-1-bg-hover w-100">
                                            Book 30min call<i class="ms-2 fa-solid fa-phone-flip"></i></a>
                                    </div>
                                </form>
                            </div>
                            <div class="col-lg-6 col-md-5 col-11">
                                <div class="img-wrapper">
                                    <img class="img-fluid w-100 lazyload" src="{{ asset('/assets/img/activities/compressed/hangouts.webp') }}"
                                         data-src="{{ asset('/assets/img/activities/hangouts.svg') }}"
                                         alt="" width="300" height="300" loading="lazy">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
