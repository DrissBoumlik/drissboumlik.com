<div class="py-5">
    <div class="section other-experiences block-inverse" id="other-experiences">
        <div class="container">
            <div class="row section-header">
                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                    <hr class="section-title-line">
                    <h1 class="section-title">{{ $other_exp->header }}</h1>
                </div>
            </div>
            <div class="row">
                @foreach ($other_exp->items as $index => $other_expItem)
                    <div class="col-md-6 col-12">
                        <div class="list-group-item box-item">
                            <!-- .lits-group-item-figure -->
                            <div class="list-group-item-figure box-header">
                                <div class="has-badge d-flex align-items-center">
                                    <div class="box-icon me-2">
                                        {!! $other_expItem->icon !!}
                                    </div>
                                    <div class="box-header-txt">
                                        <h1 class="text-capitalize">{{ $other_expItem->title }}</h1>
                                    </div>
                                </div>
                            </div><!-- .lits-group-item-figure -->
                            <!-- .lits-group-item-body -->
                            <div class="list-group-item-body box-body">
                                <p class="card-subtitle">{!! $other_expItem->content !!}</p>
                            </div><!-- .lits-group-item-body -->
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
