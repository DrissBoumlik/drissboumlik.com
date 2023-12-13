<div class="py-5" id="passion">
    <div class="section passion">
        <div class="container">
            @include('components.headline', ['headline' => $passion->header])
            <div class="row">
                @foreach ($passion->data as $index => $passionItem)
                    <div class="col-md-6 col-12">
                        <div class="list-group-item box-item">
                            <!-- .lits-group-item-figure -->
                            <div class="list-group-item-figure box-header">
                                <div class="has-badge d-flex align-items-center">
                                    <div class="box-icon me-2">
                                        {!! $passionItem->icon !!}
                                    </div>
                                    <div class="box-header-txt">
                                        <h1 class="text-capitalize">{{ $passionItem->title }}</h1>
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
