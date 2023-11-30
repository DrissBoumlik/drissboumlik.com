<div class="subscribe w-100 py-4">
    <form id="subscribe-form" class="mb-4">
        @csrf
        <div class="mb-3">
            <label for="form-email" class="form-label d-none">Email address</label>
            <input type="email" class="form-control d-inline-block" id="form-email" placeholder="Enter your email here" name="email" required />
            <button type="submit" class="btn tc-blue-dark-2-bg tc-blue-bg-hover d-inline-block">Subscribe</button>
        </div>
    </form>
</div>
