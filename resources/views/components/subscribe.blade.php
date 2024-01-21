<div class="subscribe w-100">
    <form id="subscribe-form" class="subscribe-form mb-3">
        @csrf
        <div class="mb-3">
            <label for="subscriber-email" class="d-none">Email address</label>
            <input type="email" class="form-control" id="subscriber-email" placeholder="Enter your email here" name="email" autocomplete="off" required />
        </div>
        <div class="mb-3">
            <button type="submit" class="btn tc-blue-dark-2-bg tc-blue-bg-hover d-inline-block w-100">Subscribe</button>
        </div>
    </form>
</div>
