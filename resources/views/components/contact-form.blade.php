<form id="contact-form" class="contact-form">
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
        <textarea class="form-control" id="form-body" rows="3" name="body" placeholder="" required maxlength="200"></textarea>
        <span id="current-text-length" class="current-text-length">0/200</span>
        <label for="form-body">Message</label>
    </div>
    <div class="form-floating mb-3">
        <!-- Google Recaptcha -->
        <div id="form-g-recaptcha-response" class="g-recaptcha w-100" data-sitekey={{ config('services.recaptcha.key') }}></div>
    </div>
    <div class="btns d-flex gap-2">
        <button type="submit" class="btn btn-send tc-blue-dark-2-bg tc-blue-bg-hover w-100 br-50px">Send</button>
        <button type="button" class="btn tc-blue-dark-1-outline tc-blue-dark-1-bg-hover w-100 br-50px"
            data-cal-link="drissboumlik/30min"
            data-cal-namespace="30min"
            data-cal-config='{"layout":"month_view"}'
        >
            Book 30min call<i class="ms-2 fa-solid fa-phone-flip"></i></button>
    </div>
</form>
