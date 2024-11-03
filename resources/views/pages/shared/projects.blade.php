<div class="py-5" id="projects">
    <div class="section projects">
        <div class="container">
            @include('components.headline', ['headline' => $projects->header])
            <div class="container">
                <div class="row">
                    @foreach ($projects->data as $projectItem)
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="project-box box mb-4">
                                <div class="project-image-cover">
                                    <img src="{{ asset('/' . $projectItem->image?->compressed) }}"
                                         alt="{{ $projectItem->title }}"
                                         data-src="{{ asset('/' . $projectItem->image?->original) }}"
                                         class="img-fluid lazyload" loading="lazy" width="300" height="250"/>
                                </div>
                                <div class="project-data">
                                    <div class="project-txt">
                                        <div class="project-name">{{ $projectItem->title }}</div>
                                        <div class="project-description">{{ $projectItem->description }}</div>
                                    </div>
                                    @isset($projectItem->links)
                                        <div class="project-links">
                                            <span>Links : </span>
                                            <div class="project-link-wrapper">
                                                @isset($projectItem->links->website)
                                                    <div class="project-link">
                                                        <a href="{{ $projectItem->links->website }}"
                                                           target="_blank" rel="noopener">
                                                            Link
                                                        </a>
                                                    </div>
                                                @endisset
                                                @isset($projectItem->links->repository)
                                                    <div class="project-link">
                                                        <a href="{{ $projectItem->links->repository }}"
                                                           target="_blank" rel="noopener">
                                                            Repository
                                                        </a>
                                                    </div>
                                                @endisset
                                            </div>
                                        </div>
                                    @endisset
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="row mt-5">
                    <div class="col-12">
                        <div class="see-more d-flex justify-content-center align-items-center">
                            <a href="/work" class="btn tc-blue-dark-2-bg tc-blue-bg-hover br-50px">
                                See More</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
