<div class="py-5" id="work">
    <div class="section work">
        <div class="container">
            @include('components.headline', ['headline' => $work->header])
            <div class="container">
                <div class="row">
                    @foreach ($work->data as $workItem)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="work-box box mb-4">
                                <div class="work-image-cover">
                                    <img src="{{ asset('/assets/img/work/compressed/' . $workItem->image) }}" alt="{{ $workItem->name }}"
                                         data-src="{{ asset('/assets/img/work/' . $workItem->image) }}"
                                         class="img-fluid lazyload" loading="lazy" width="300" height="250" />
                                </div>
                                @isset($workItem->links)
                                    <div class="work-links">
                                        @isset($workItem->links->repository)
                                        <div class="work-link">
                                            <a href="{{ $workItem->links->repository }}" target="_blank">
                                                <i class="fa-brands fa-github"></i>
                                            </a>
                                        </div>
                                        @endisset
                                        @isset($workItem->links->website)
                                        <div class="work-link">
                                            <a href="{{ $workItem->links->website }}" target="_blank">
                                                <i class="fa-solid fa-globe"></i>
                                            </a>
                                        </div>
                                        @endisset
                                    </div>
                                @endisset
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="see-more"><a href="/work" class="btn tc-blue-dark-2-bg tc-blue-bg-hover br-50px">See More</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
