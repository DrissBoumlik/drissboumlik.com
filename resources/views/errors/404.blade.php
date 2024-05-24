@extends('layout.page-content')

@section('page-content')

    <div class="container p-0">

        <div class="_404 flex items-center justify-center" style="height: 90vh">
            <div class="row my-12 w-full">
                <div class="w-full lg:w-2/3 lg:ml-1/6">
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
