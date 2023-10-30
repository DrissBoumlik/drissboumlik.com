<div class="posts py-5">
    <div class="container">
        <div class="row section-header">
            <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                <hr class="section-title-line">
                <h1 class="section-title">Featured Articles</h1>
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
