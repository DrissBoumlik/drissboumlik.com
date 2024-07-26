@extends('auth.app')

@section('post-header-assets')
    @vite(['resources/js/pages/auth.js'])
@endsection

@section('content')
    <div class="container-fluid auth-box">
        <section class="h-screen">
            <div class="container flex justify-center items-center h-full">
                <div class="flex flex-row justify-center items-center w-full">
                    <div class="lg:w-1/2 md:w-5/6 w-full login-block">
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
                            <div class="flex justify-between items-center mb-2">
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
                    <div class="lg:w-1/2 md:w-1/6 w-full img-block">
                        <img src="{{ asset('/assets/img/activities/workshops.svg') }}" alt="" class="auth-img max-w-full h-auto w-full" width="300" height="300" loading="lazy">
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
