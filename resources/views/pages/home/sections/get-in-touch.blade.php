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
                <form id="contact-form" class="mb-4">
                    @csrf
                    <div class="mb-3">
                        <label for="form-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="form-name" placeholder="John Doe" name="name"/>
                    </div>
                    <div class="mb-3">
                        <label for="form-email" class="form-label">Email address</label>
                        <input type="email" class="form-control" id="form-email" placeholder="jd@email.com" name="email"/>
                    </div>
                    <div class="mb-3">
                        <label for="form-body" class="form-label">Message</label>
                        <textarea class="form-control" id="form-body" rows="3" name="body" placeholder="Your Message" maxlength="1000"></textarea>
                    </div>
                    <button type="submit" class="btn tc-blue-dark-1-bg tc-blue-dark-2-bg-hover w-100">
                        Submit
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>
