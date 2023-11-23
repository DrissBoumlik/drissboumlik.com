<div class="py-5" id="certificates">
    <div class="section certificates">
        <div class="container">
            @include('components.headline', ['headline' => $certificates->header])
            <div class="row">
                @foreach ($certificates->items as $index => $certificate)
                    <div class="col-md-6 col-12">
                        <div class="list-group-item box-item">
                            <!-- .lits-group-item-figure -->
                            <div class="list-group-item-figure box-header">
                                <div class="has-badge d-flex align-items-center">
                                    <div class="box-icon me-2">
                                        <i class="fa-brands fa-microsoft"></i>
                                    </div>
                                    <div class="box-header-txt">
                                        <h5 class="text-capitalize">{{ $certificate->title }}</h5>
                                    </div>
                                </div>
                            </div><!-- .lits-group-item-figure -->
                            <!-- .lits-group-item-body -->
                            <div class="list-group-item-body box-body">
                                <p class="card-subtitle">{{ $certificate->content }}</p>
                            </div><!-- .lits-group-item-body -->
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
