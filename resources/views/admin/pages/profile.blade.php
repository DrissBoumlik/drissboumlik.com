@extends('admin.template.backend')

@section('css')

@endsection
@section('js')

@endsection

@section('content')
    <!-- Hero -->
    <div class="bg-image" style="background-image: url('/template/assets/media/photos/photo10@2x.jpg');">
        <div class="bg-primary-dark-op">
            <div class="content content-full text-center">
                <div class="my-3">
                    <img class="img-avatar img-avatar-thumb" src="{{ asset('/assets/img/me/circle-256.ico') }}" alt="">
                </div>
                <h1 class="h2 text-white mb-0">Edit Account</h1>
                <h2 class="h4 fw-normal text-white-75">
                    {{ $user->name }}
                </h2>
            </div>
        </div>
    </div>
    <!-- END Hero -->

    <!-- Page Content -->
    <div class="content content-boxed">
        <!-- User Profile -->
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">User Profile</h3>
            </div>
            <div class="block-content">
                <form action="/admin/profile" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row push">
                        <div class="col-lg-6 offset-lg-3">
                            <div class="mb-4">
                                <input type="text" class="form-control" id="one-profile-edit-name" name="name" placeholder="Enter your name.." value="{{ $user->name }}">
                            </div>
                            <div class="mb-4">
                                <input type="email" class="form-control" id="one-profile-edit-email" name="email" placeholder="Enter your email.." value="{{ $user->email }}">
                            </div>
                            <div class="mb-4 password-form-input">
                                <input type="password" class="form-control" id="one-profile-edit-password" placeholder="Password" name="password">
                                <div class="show-password"><i class="fa-solid fa-eye"></i></div>
                            </div>
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
@endsection
