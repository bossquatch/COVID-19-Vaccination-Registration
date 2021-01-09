@extends('layouts.no-nav')

@section('title')
    Password Reset
@endsection

@section('content')
<section>
    <div class="container-fluid d-flex flex-column">
        <div class="row align-items-center justify-content-center min-vh-100">
            <div class="col-lg-6 align-self-stretch d-none d-lg-block px-0">
                <!-- Image -->
                <div class="h-100 w-cover bg-cover" style="background-image: url({{ asset('images/downtown-bartow.jpg') }});"></div>
            </div>

            <div class="col-12 col-md-10 col-lg-6 px-8 px-lg-11 py-8 py-lg-11">
                <!-- Heading -->
                <h1 class="mb-0 font-weight-bold">
                    {{ __('Reset Password') }}
                </h1>

                <!-- Text -->
                <p class="mb-6 text-muted">
                    Access your registration and status.
                </p>

                <!-- Form -->
                <form class="mb-6" method="POST" action="{{ route('password.update') }}">
                    @csrf

                    <input type="hidden" name="token" value="{{ $token }}">

                    <!-- Email -->
                    <div class="form-group">
                        <label for="email">
                            Email Address
                        </label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ $email ?? old('email') }}" required autocomplete="email" autofocus placeholder="name@address.com">

                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">
                            Password
                        </label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password" placeholder="Enter your password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="form-group mb-5">
                        <label for="password-confirm">
                            Confirm Password
                        </label>
                        <input id="password-confirm" class="form-control" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Re-enter your password">
                    </div>

                    <!-- Submit -->
                    <button class="btn btn-header btn-round btn-lg btn-block" type="submit">
                        {{ __('Reset Password') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
