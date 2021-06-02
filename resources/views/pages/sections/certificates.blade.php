<div class="py-5" id="certificates">
    <div class="section certificates">
        <div class="container">
            <div class="row section-header">
                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                    <hr class="section-title-line">
                    <h1 class="section-title">{{ $certificates->header }}</h1>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    @foreach ($certificates->items as $index => $certificate)
                        <div class="col-md-6 col-12 mb-3">
                            <div class="list-group-item box-item py-3">
                                <!-- .lits-group-item-figure -->
                                <div class="list-group-item-figure box-header mb-3">
                                    <div class="has-badge d-flex align-items-center">
                                        <div class="box-icon me-2">
                                           {{-- <img src="{{ $certificate->icon }}" alt=""> --}}
                                            <img src="{{ asset('/assets/img/icons/maps-and-flags.png') }}" />
                                        </div>
                                        <div class="box-header-txt">
                                            <h4 class="text-capitalize">{{ $certificate->title }}</h4>
                                        </div>
                                    </div>
                                </div><!-- .lits-group-item-figure -->
                                <!-- .lits-group-item-body -->
                                <div class="list-group-item-body box-body ps-2">
                                    <p class="card-subtitle">{{ $certificate->content }}</p>
                                </div><!-- .lits-group-item-body -->
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
