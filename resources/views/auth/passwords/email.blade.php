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
                <div class="h-100 w-cover bg-cover" style="background-image: url({{ asset('images/register-image.jpg') }});"></div>
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

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif

                <!-- Form -->
                <form class="mb-6" method="POST" action="{{ route('password.email') }}">
                    @csrf

                    <!-- Email -->
                    <div class="form-group mb-5">
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

                    <!-- Submit -->
                    <button class="btn btn-header btn-round btn-lg btn-block" type="submit">
                        {{ __('Send Password Reset Link') }}
                    </button>
                </form>

                <!-- Text -->
                <p class="mb-0 font-size-sm text-muted">
                    Already have an account? <a class="ml-1" href="{{ route('login') }}">Log in</a>
                </p>
                {{--<p class="mb-0 font-size-sm text-muted">
                    Don't have an account yet? <a class="ml-1" href="{{ route('register') }}">Register</a>
                </p>--}}
            </div>
        </div>
    </div>
</section>
@endsection
