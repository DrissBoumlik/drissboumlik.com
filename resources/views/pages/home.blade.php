@extends('layout.app')

@section('post-header-assets')
    <script src="{{ asset('/js/pages/contact.js') }}"></script>
@endsection

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
                                    <div class="col-12 col-md-6 col-lg-6 col-xl-6 mb-4">
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
                            <div class="row justify-content-center">
                                <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-4">
                                    <div class="service-box w-100">
                                        <div class="service-icon">
                                            <i class="fa-solid fa-palette"></i>
                                        </div>
                                        <div class="service-title">
                                            <h3>UI/UX Design</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-4">
                                    <div class="service-box w-100">
                                        <div class="service-icon">
                                            <i class="fa-solid fa-code"></i>
                                        </div>
                                        <div class="service-title">
                                            <h3>Web Development</h3>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-4 col-lg-4 col-md-6 col-12 mb-4">
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
            <div class="section">
                <div class="get-in-touch py-5">
                    <div class="container">
                            <div class="row section-header">
                                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                                    <hr class="section-title-line">
                                    <h1 class="section-title">Get in Touch</h1>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-lg-6 offset-lg-3">
                                    <form id="contact-form">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="form-name" class="form-label">Name</label>
                                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="form-name" placeholder="" name="name" value="blabla" />
                                            @error('name')
                                            <div class="tc-alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="form-email" class="form-label">Email address</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" id="form-email" placeholder="" name="email" value="blabla@bla.bla" />
                                            @error('email')
                                            <div class="tc-alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="form-subject" class="form-label">Subject</label>
                                            <input type="text" class="form-control @error('subject') is-invalid @enderror" id="form-subject" placeholder="" name="subject" value="blabla" />
                                            @error('subject')
                                            <div class="tc-alert">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="mb-3">
                                            <label for="form-message" class="form-label">Message</label>
                                            <textarea class="form-control @error('message') is-invalid @enderror" id="form-message" rows="3" name="message" _maxlength="1000">sdfkjsdfjhj</textarea>
                                            @error('message')
                                            <div class="tc-alert tc-alert-error">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn tc-blue-dark-1-bg tc-blue-dark-2-bg-hover w-100">Submit</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
        </div>
    </div>
    @include('admin.addons.alert-box')
    @include('layout.footer')
@endsection
