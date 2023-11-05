<div class="py-5" id="work">
    <div class="section work">
        <div class="container">
            @include('components.headline', ['headline' => $work->header])
            <div class="container">
                <div class="row">
                    @foreach ($work->items as $workItem)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="box">
                                <div class="project-image">
                                    <img class="w-100" src="{{ asset('/assets/img/work/' . $workItem->image) }}"
                                         alt="" loading="lazy">
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
