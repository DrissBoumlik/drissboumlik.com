<div class="skills py-5">
    <div class="container">
        @include('components.headline', ['headline' => $techs->header])
        <div class="row">
            @foreach($techs->items as $c)
                <div class="col-4 col-md-3">
                    <div class="skill-item">
                        <div class="skill-icon">{!! $c->icon !!}</div>
                        <div class="skill-text text-capitalize">{{ $c->name }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
