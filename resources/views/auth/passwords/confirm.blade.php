@extends('layouts.no-nav')

@section('title')
    Confirm Password
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
                    {{ __('Confirm Password') }}
                </h1>

                <!-- Text -->
                <p class="mb-6 text-muted">
                    {{ __('Please confirm your password before continuing.') }}
                </p>

                <!-- Form -->
                <form class="mb-6" method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <!-- Password -->
                    <div class="form-group">
                        <label for="password">
                            Password
                        </label>
                        <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>

                    <!-- Submit -->
                    <button class="btn btn-header btn-round btn-lg btn-block" type="submit">
                        {{ __('Confirm Password') }}
                    </button>

                    @if (Route::has('password.request'))
                        <a class="btn btn-link" href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </form>

                <!-- Text -->
                {{--<p class="mb-0 font-size-sm text-muted">
                    Don't have an account yet? <a class="ml-1" href="{{ route('register') }}">Register</a>
                </p>--}}
            </div>
        </div>
    </div>
</section>
@endsection

