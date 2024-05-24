<div class="skills py-12">
    <div class="container">
        @include('components.headline', ['headline' => $techs->header])
        <div class="row">
            @foreach($techs->data as $c)
                <div class="w-1/3 sm:w-1/4 md:w-1/6 skill-item-wrapper">
                    <div class="skill-item">
                        <div class="skill-icon">{!! $c->icon !!}</div>
                        <div class="skill-text capitalize">{{ $c->name }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
