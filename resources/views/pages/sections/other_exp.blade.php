<div class="section other-experiences block-inverse" id="other-experiences">
    <div class="container">
        <div class="row">
            <hr class="section-title-line">
            <h1 class="section-title uppercase">{{ $other_exp->header }}</h1>
        </div>
        <div class="container">
            <div class="row">
                @foreach ($other_exp->items as $index => $other_expItem)
                    <div class="col-sm-6">
                        <div class="list-group-item small">
                            <!-- .lits-group-item-figure -->
                            <div class="list-group-item-figure">
                                <div class="has-badge">
                                    <img src="{{ $other_expItem->icon }}" alt="">
                                    <h2 class="capitalize">{{ $other_expItem->title }}</h2>
                                </div>
                            </div><!-- .lits-group-item-figure -->
                            <!-- .lits-group-item-body -->
                            <div class="list-group-item-body">
                                <p class="card-subtitle text-muted mb-1">{!! $other_expItem->content !!}</p>
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
