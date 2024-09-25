<div class="get-in-touch py-5" id="get-in-touch">
    <div class="container">
        @include('components.headline', ['headline' => 'Get in Touch'])
        <div class="row">
            <div class="col-12 col-md-8 offset-md-2 col-lg-8 offset-lg-2 col-xl-6 offset-xl-3">
                <form id="contact-form" class="mb-3">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="form-name" placeholder="" name="name"
                               autocomplete="on" required />
                        <label for="form-name">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="form-email" placeholder="" name="email"
                               autocomplete="off" required />
                        <label for="form-email">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="form-body" rows="3" name="body" placeholder=""
                                  required maxlength="1000"></textarea>
                        <label for="form-body">Message</label>
                    </div>
                    <div class="form-floating mb-3">
                        <!-- Google Recaptcha -->
                        <div id="form-g-recaptcha-response" class="g-recaptcha w-100"
                             data-sitekey={{ config('services.recaptcha.key') }}></div>
                    </div>
                    <button type="submit" class="btn tc-blue-dark-2-bg tc-blue-bg-hover w-100 br-50px">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>
