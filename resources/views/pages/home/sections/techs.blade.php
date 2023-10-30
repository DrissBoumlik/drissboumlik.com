<div class="skills py-5">
    <div class="container">
        <div class="row section-header">
            <div
                class="col-md-10 offset-md-1 col-12 d-flex flex-column align-items-center justify-content-center">
                <hr class="section-title-line">
                <h1 class="section-title">{{ $data->sections['techs']->header }}</h1>
            </div>
        </div>
        <div class="row">
            @foreach($data->sections['techs']->items as $c)
                <div class="col-3">
                    <div class="skill-item">
                        <div class="skill-icon">{!! $c->icon !!}</div>
                        <div class="skill-text text-capitalize">{{ $c->name }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
