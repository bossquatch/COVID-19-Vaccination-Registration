@extends('layouts.no-nav')

@section('title')
    Password Reset
@endsection

@section('content')
<!-- Page Content -->
<section class="container d-flex justify-content-center align-items-center flex-grow-1 pt-7 pb-4">
    <div class="row justify-content-center w-75">
        <div class="col-12">
            <div class="card border-0 shadow my-5">
                <div class="card-body py-7 px-5">
                    <div>
                        <h1 class="h2 text-center">Reset Password</h1>
                        <p class="font-size-xs text-muted mb-4 text-center">Access your registration and status.</p>

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

                    </div>
                    {{--<div class="border-top text-center mt-5 pt-5">
                        <p class="font-size-sm font-weight-medium text-gray-dark">Or sign in with</p>
                        <a class="btn-social sb-facebook sb-outline sb-lg mx-1 mb-2" href="#"><span class="sb-icon fab fa-facebook"></span></a>
                        <a class="btn-social sb-twitter sb-outline sb-lg mx-1 mb-2" href="#"><span class="sb-icon fab fa-twitter"></span></a>
                        <a class="btn-social sb-instagram sb-outline sb-lg mx-1 mb-2" href="#"><span class="sb-icon fab fa-instagram"></span></a>
                        <a class="btn-social sb-google sb-outline sb-lg mx-1 mb-2" href="#"><span class="sb-icon fab fa-google"></span></a>
                    </div>--}}
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
