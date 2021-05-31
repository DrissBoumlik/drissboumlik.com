<div class="py-5" id="other-experiences">
    <div class="section other-experiences block-inverse">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                    <hr class="section-title-line">
                    <h1 class="section-title text-uppercase">{{ $other_exp->header }}</h1>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    @foreach ($other_exp->items as $index => $other_expItem)
                        <div class="col-md-6 col-12 mb-3">
                            <div class="list-group-item box-item py-3 tc-white-bg">
                                <!-- .lits-group-item-figure -->
                                <div class="list-group-item-figure box-header mb-3">
                                    <div class="has-badge d-flex align-items-center">
                                        <div class="box-icon me-2">
                                            <img src="{{ asset('/assets/img/icons/' . $other_expItem->icon) }}"
                                            alt="{{ $other_expItem->title }}">
                                        </div>
                                        <div class="box-header-txt">
                                            <h4 class="text-capitalize">{{ $other_expItem->title }}</h4>
                                        </div>
                                    </div>
                                </div><!-- .lits-group-item-figure -->
                                <!-- .lits-group-item-body -->
                                <div class="list-group-item-body box-body ps-2">
                                    <p class="card-subtitle">{!! $other_expItem->content !!}</p>
                                </div><!-- .lits-group-item-body -->
                            </div>
                        </div>
                        @if ($index % 2 != 0)
                            </div><div class="row">
                        @endif
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
