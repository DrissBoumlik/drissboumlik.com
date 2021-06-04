<div class="py-5" id="passion">
    <div class="section passion">
        <div class="container">
            <div class="row section-header">
                <div class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                    <hr class="section-title-line">
                    <h1 class="section-title">{{ $passion->header }}</h1>
                </div>
            </div>
            <div class="container">
                <div class="row">
                    @foreach ($passion->items as $index => $passionItem)
                        <div class="col-md-6 col-12 mb-3">
                            <div class="list-group-item box-item">
                                <!-- .lits-group-item-figure -->
                                <div class="list-group-item-figure box-header">
                                    <div class="has-badge d-flex align-items-center">
                                        <div class="box-icon me-2">
                                            <img src="{{ asset('/assets/img/icons/' . $passionItem->icon) }}"
                                            alt="{{ $passionItem->title }}">
                                        </div>
                                        <div class="box-header-txt">
                                            <h4 class="text-capitalize">{{ $passionItem->title }}</h4>
                                        </div>
                                    </div>
                                </div><!-- .lits-group-item-figure -->
                                <!-- .lits-group-item-body -->
                                <div class="list-group-item-body box-body">
                                    <p class="card-subtitle">{!! $passionItem->content !!}</p>
                                </div><!-- .lits-group-item-body -->
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
