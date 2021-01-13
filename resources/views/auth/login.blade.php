@extends('layouts.no-nav')

@section('title')
    Login
@endsection

@section('content')
<section>
    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-lg-6 align-self-stretch d-none d-lg-block px-0">
                <!-- Image -->
                <div class="h-100 w-cover bg-cover" style="background-image: url({{ asset('images/register-image.jpg') }});"></div>
            </div>

            <div class="col-12 col-md-10 col-lg-6 px-8 px-lg-11 py-8 py-lg-11">
                <!-- Heading -->
                <h1 class="mb-0 font-weight-bold">
                    Sign in
                </h1>

                <!-- Text -->
                <p class="mb-6 text-muted">
                    Access your registration and status.
                </p>

                <!-- Form -->
                <form class="mb-6" method="POST" action="{{ route('login') }}">
                {{ csrf_field() }}

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">
                            Email Address
                        </label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus placeholder="name@address.com">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">
                            Password <span class="font-weight-light small">(Password length is a minimum of 8 characters)</span>
                        </label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <div class="form-group mb-5">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>

                            <label class="form-check-label" for="remember">
                                {{ __('Remember Me') }}
                            </label>
                        </div>
                    </div>

                    <!-- Submit -->
                    <button class="btn btn-header btn-round btn-lg btn-block" type="submit">
                        Sign in
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </form>

                <!-- Text -->
                @if(config('app.allow_self_service'))
                <p class="mb-0 font-size-sm text-muted">
                    Don't have an account yet? <a class="ml-1" href="{{ route('register') }}">Register</a>
                </p>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection
