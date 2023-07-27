@extends('layout.page-content')

@section('page-content')

    <div class="container-fluid p-0">

        <div class="_404">
            <div class="row my-5">
                <div class="col-lg-8 offset-lg-2 col-12">
                    <div class="not-found-container">
                        <div class="not-found-bar">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                        <div class="not-found-header"></div>
                        <div class="not-found-body">
                            <div class="row"><i class="fa-solid fa-face-frown"></i></div>
                            <div class="row">
                                <p class="not-found-txt">page not found</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

@endsection
