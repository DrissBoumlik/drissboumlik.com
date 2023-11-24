@extends('layout.page-content-wide')

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->work->header !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="work-page work section py-5">
            <div class="py-5" id="work">
                <div class="section work">
                    <div class="container">
                        <div class="work-items">
                            <div class="row">
                                @foreach ($data->work->items as $workItem)
                                    <div class="col-12 col-md-6">
                                        <div class="work-box box mb-4">
                                            <div class="work-image-cover" style="background-image: url('{{ asset('/assets/img/work/' . $workItem->image) }}')">
                                            </div>
                                            <div class="work-data">
                                                <div class="work-txt">
                                                    <div class="work-name">{{ $workItem->name }}</div>
                                                    <div class="work-description">{{ $workItem->description }}</div>
                                                </div>
                                                @isset($workItem->links)
                                                    <div class="work-links">
                                                        @isset($workItem->links->repository)
                                                            <div class="work-link">
                                                                <a href="{{ $workItem->links->repository }}"
                                                                   target="_blank" rel="noopener">
                                                                    <i class="fa-brands fa-github"></i>
                                                                </a>
                                                            </div>
                                                        @endisset
                                                        @isset($workItem->links->website)
                                                            <div class="work-link">
                                                                <a href="{{ $workItem->links->website }}"
                                                                   target="_blank" rel="noopener">
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
