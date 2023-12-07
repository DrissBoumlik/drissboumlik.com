<div class="py-5" id="non-it-experiences">
    <div class="section non-it-experiences block-inverse">
        <div class="container">
            @include('components.headline', ['headline' => $non_it_experiences->header])
            <div class="row">
                @foreach ($non_it_experiences->items as $index => $non_it_experiencesItem)
                    <div class="col-md-6 col-12">
                        <div class="list-group-item box-item">
                            <!-- .lits-group-item-figure -->
                            <div class="list-group-item-figure box-header">
                                <div class="has-badge d-flex align-items-center">
                                    <div class="box-icon me-2">
                                        {!! $non_it_experiencesItem->icon !!}
                                    </div>
                                    <div class="box-header-txt">
                                        <h1 class="text-capitalize">{{ $non_it_experiencesItem->title }}</h1>
                                    </div>
                                </div>
                            </div><!-- .lits-group-item-figure -->
                            <!-- .lits-group-item-body -->
                            <div class="list-group-item-body box-body">
                                <p class="card-subtitle">{!! $non_it_experiencesItem->content !!}</p>
                            </div><!-- .lits-group-item-body -->
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
