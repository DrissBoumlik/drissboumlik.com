@extends('layout.page-content-wide')


@section('page-content')
    <div class="container-fluid p-0">
        <div class="work section py-5">
            <div class="py-5" id="work">
                <div class="section work">
                    <div class="container">
                        @include('components.headline', ['headline' => $data->work->header])
                        <div class="work-items">
                            <div class="row">
                                @foreach ($data->work->items as $workItem)
                                    <div class="col-12 col-md-6">
                                        <div class="work-box box mb-4">
                                            <div class="work-image-cover" style="background-image: url('{{ asset('/assets/img/work/' . $workItem->image) }}')">
                                            </div>
                                            <div class="work-data">
                                                <div class="work-txt">
                                                    {{ $workItem->description }}
                                                </div>
                                                @isset($workItem->links)
                                                    <div class="work-links">
                                                        @isset($workItem->links->repository)
                                                            <div class="work-link">
                                                                <a href="{{ $workItem->links->repository }}"
                                                                   target="_blank">
                                                                    <i class="fa-brands fa-github"></i>
                                                                </a>
                                                            </div>
                                                        @endisset
                                                        @isset($workItem->links->website)
                                                            <div class="work-link">
                                                                <a href="{{ $workItem->links->website }}"
                                                                   target="_blank">
                                                                    <i class="fa-solid fa-globe"></i>
                                                                </a>
                                                            </div>
                                                        @endisset
                                                    </div>
                                                @endisset
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
