<div class="posts py-5">
    <div class="container">
        @include('components.headline', ['headline' => 'Featured Articles'])
        <div class="row">
            @foreach ($posts as $post)
                <div class="col-12 col-md-6 col-lg-6 col-xl-6 mb-4">
                    @include('components.post', ['post' => $post])
                </div>
            @endforeach
        </div>
    </div>
</div>
