<div class="py-5" id="passion">
    <div class="section passion">
        <div class="container">
            <div class="row mb-4">
                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                    <hr class="section-title-line">
                    <h1 class="section-title text-uppercase">{{ $passion->header }}</h1>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    @foreach ($passion->items as $index => $passionItem)
                        <div class="col-md-6 col-12 mb-3">
                            <div class="list-group-item passion-item tc-grey-light-bg">
                                <!-- .lits-group-item-figure -->
                                <div class="list-group-item-figure">
                                    <div class="has-badge d-flex align-items-center">
                                        <div class="passion-img me-2">
                                            <img src="{{ asset('/assets/img/icons/' . $passionItem->icon) }}"
                                            alt="{{ $passionItem->title }}">
                                        </div>
                                        <div class="passion-header">
                                            <h2 class="capitalize">{{ $passionItem->title }}</h2>
                                        </div>
                                    </div>
                                </div><!-- .lits-group-item-figure -->
                                <!-- .lits-group-item-body -->
                                <div class="list-group-item-body">
                                    <p class="card-subtitle mb-1">{!! $passionItem->content !!}</p>
                                </div><!-- .lits-group-item-body -->
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
