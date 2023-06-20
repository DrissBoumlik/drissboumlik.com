@extends('admin.template.frontend')


@section('content')
    @if($subscriber && $subscriber->token_verification != null)
    <!-- Page Content -->
    <div class="content content-boxed">
        <!-- User Profile -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Update subscription data</h3>
            </div>
            <div class="block-content">
                <form action="/subscribers/{{ $subscriber->email }}" method="POST">
                    @method('put')
                    @csrf
                    <div class="row push">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="mb-4">
                                <label class="form-label" for="example-static-input-plain">Email :</label>
                                <input type="text" readonly class="form-control-plaintext d-inline w-auto" id="example-static-input-plain" name="email" value="{{ $subscriber->email }}">
                            </div>
                            <div class="row mb-4">
                                <div class="col-6">
                                    <label class="form-label" for="one-profile-edit-firstname">Firstname</label>
                                    <input type="text" class="form-control" id="one-profile-edit-firstname" name="first_name" value="{{ $subscriber->first_name }}">
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="one-profile-edit-lastname">Lastname</label>
                                    <input type="text" class="form-control" id="one-profile-edit-lastname" name="last_name" value="{{ $subscriber->last_name }}">
                                </div>
                            </div>
{{--                            <div class="row mb-4">--}}
{{--                                <div class="col-6">--}}
{{--                                     <div class="form-floating">--}}
{{--                                        <input type="text" class="form-control" id="example-text-input-floating" name="example-text-input-floating" placeholder="Enter your Firstname..">--}}
{{--                                        <label for="example-text-input-floating">Firstname</label>--}}
{{--                                     </div>--}}
{{--                                </div>--}}
{{--                                <div class="col-6">--}}
{{--                                     <div class="form-floating">--}}
{{--                                        <input type="text" class="form-control" id="example-text-input-floating" name="example-text-input-floating" placeholder="Enter your Lastname..">--}}
{{--                                        <label for="example-text-input-floating">Lastname</label>--}}
{{--                                     </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
                            <div class="mb-4">
                                <button type="submit" class="btn btn-alt-primary">Update</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- END User Profile -->
    </div>
    <!-- END Page Content -->

    @include('admin.addons.alert-box')
    @else
        @include('pages.subscription.not-found')
    @endif
@endsection
