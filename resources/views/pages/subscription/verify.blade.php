@extends('layout.page-content-wide')

@section('post-header-assets')
    @vite(['resources/js/pages/subscription.js'])
@endsection

@section('headline')
    <div class="d-flex flex-column align-items-center justify-content-center">
        <h1 class="header-txt">{!! $data->headline !!}</h1>
    </div>
@endsection

@section('page-content')
    <div class="container-fluid p-0">
        <div class="get-in-touch section py-5">
            <div class="py-5" id="get-in-touch">
                <div class="section">
                    <div class="container">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-lg-6 col-md-7 col-12">
                            @if($subscriber)
                                <form id="subscribe-update-form" class="subscribe-update-form" data-action="subscribers/{{ $subscriber->subscription_id }}">
                                    @csrf
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="form-email" placeholder="" name="email" autocomplete="off" value="{{ $subscriber->email }}" readonly />
                                        <label for="form-email">Email</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="form-firstname" placeholder="" name="first_name" autocomplete="off" value="{{ $subscriber->first_name }}" />
                                        <label for="form-firstname">Firstname</label>
                                    </div>
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control" id="form-lastname" placeholder="" name="last_name" autocomplete="off" value="{{ $subscriber->last_name }}" />
                                        <label for="form-lastname">Lastname</label>
                                    </div>
                                    <div class="mb-4">
                                        <button type="submit" class="btn tc-blue-dark-2-bg tc-blue-bg-hover w-100">Update</button>
                                    </div>
                                </form>
                                <div id="subscribe-form-response"></div>
                            @else
                                @include('pages.subscription.not-found')
                            @endif
                            </div>
                            <div class="col-lg-6 col-md-5 col-11">
                                <div class="img-wrapper">
                                    <img class="img-fluid w-100 lazyload" src="{{ asset('/assets/img/activities/compressed/hangouts.webp') }}"
                                         data-src="{{ asset('/assets/img/activities/hangouts.svg') }}"
                                         alt="" width="300" height="300" loading="lazy">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
