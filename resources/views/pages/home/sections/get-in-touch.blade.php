<div class="get-in-touch py-5">
    <div class="container">
        @include('components.headline', ['headline' => 'Get in Touch'])
        <div class="row">
            <div class="col-12 col-lg-6 offset-lg-3">
                <form id="contact-form" class="mb-4">
                    @csrf
                    <div class="form-floating mb-3">
                        <input type="text" class="form-control" id="form-name" placeholder="" name="name" required />
                        <label for="form-name">Name</label>
                    </div>
                    <div class="form-floating mb-3">
                        <input type="email" class="form-control" id="form-email" placeholder="" name="email" required />
                        <label for="form-email">Email address</label>
                    </div>
                    <div class="form-floating mb-3">
                        <textarea class="form-control" id="form-body" rows="3" name="body" placeholder="" required maxlength="1000"></textarea>
                        <label for="form-body">Message</label>
                    </div>
                    <button type="submit" class="btn tc-blue-dark-2-bg tc-blue-bg-hover w-100">Send</button>
                </form>
            </div>
        </div>
    </div>
</div>
