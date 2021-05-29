<div class="section passion" id="passion">
    <div class="container">
        <div class="row">
            <hr class="section-title-line">
            <h1 class="section-title uppercase">{{ $passion->header }}</h1>
        </div>
        <div class="container">
            <div class="row">
                @foreach ($passion->items as $index => $passionItem)
                    <div class="col-sm-6 mb-2">
                        <div class="list-group-item small">
                            <!-- .lits-group-item-figure -->
                            <div class="list-group-item-figure">
                                <div class="has-badge">
                                    <img src="{{ $passionItem->icon }}"
                                         alt="">
                                    <h2 class="capitalize">{{ $passionItem->title }}</h2>
                                </div>
                            </div><!-- .lits-group-item-figure -->
                            <!-- .lits-group-item-body -->
                            <div class="list-group-item-body">
                                <p class="card-subtitle text-muted mb-1">{!! $passionItem->content !!}</p>
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
