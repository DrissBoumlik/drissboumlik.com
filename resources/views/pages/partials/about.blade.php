<div id="about" class="about section-wrapper py-md-4rem py-3rem">
    <div class="section about-header">
        <div id="particles-js" class="particles-js"></div>
        <div class="container">
            <div class="row">
                <div class="col-8 offset-2">
                    <div class="img-wrapper d-flex justify-content-center">
                        <img src="{{ asset('/assets/img/me/circle-256.png') }}"
                        class="img-fluid rounded-circle mb-4" alt="" height="130" width="130">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    @include('layout.header-parts.header-menu')
                </div>
            </div>
            <div class="row">
                <div class="col-10 offset-1 col-md-8 offset-md-2">
                    <div class="welcome-message">
                        <div class="welcome-message-wrapper text-center tc-black-almost fs-4">
                            <div class="welcome text-capitalize">welcome</div>
                            <div class="txt">
                                <div class="">
                                    <p class="capitalize-first-letter">this is my resume ... ish</p>
                                    <p class="capitalize-first-letter">
                                        {{-- <span>{{ $data->general['whois']}} </span> --}}
                                        <span class="text-capitalize funny-font">driss boumlik</span>
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-12">
                    <div class="social-icons">
                        @include('addons.social-links')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

