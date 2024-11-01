@extends('auth.app')

@section('post-header-assets')
    @vite(['resources/js/pages/auth.js', 'resources/sass/_imports/modules/_auth.sass'])
@endsection

@section('content')
    <div class="container-fluid auth-box">
        <section class="vh-100">
            <div class="container d-flex justify-content-center align-items-center h-100">
                <div class="row d-flex justify-content-center align-items-center w-100">
                    <div class="col-lg-6 col-md-10 login-block">
                        <form class="login-form" method="POST" action="{{ route('login') }}">
                            @csrf
                            <!-- Email input -->
                            <div class="form-outline mb-2">
                                <input type="email" id="email" class="form-control @error('email') is-invalid @enderror" placeholder="Enter a valid email address"
                                       name="email" value="{{ old('email')}}" required autocomplete="email" autofocus/>
                                @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <!-- Password input -->
                            <div class="form-outline mb-2 password-form-input">
                                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Enter password"
                                       name="password" required autocomplete="current-password"/>
                                <div class="show-password"><i class="fa-solid fa-eye"></i></div>
                                @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <!-- Checkbox -->
                                <div class="form-check">
                                    <input class="form-check-input me-2" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }} />
                                    <label class="form-check-label" for="remember">Remember me</label>
                                </div>
                                <div class="password-request">
                                    <a href="{{ route('password.request') }}" class="">Forgot password?</a>
                                </div>
                            </div>
                            <div class="form-outline mb-0">
                                <button type="submit" class="btn tc-blue-dark-2-bg tc-blue-bg-hover w-100" id="log">Login</button>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-6 col-md-2 img-block">
                        <img src="{{ asset('/assets/img/activities/workshops.svg') }}" alt="" class="auth-img img-fluid w-100" width="300" height="300" loading="lazy">
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
