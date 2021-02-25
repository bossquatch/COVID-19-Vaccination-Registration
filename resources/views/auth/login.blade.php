@extends('layouts.no-nav')

@section('title')
    Login
@endsection

@section('content')
<!-- Page Content -->
<section class="container d-flex justify-content-center align-items-center flex-grow-1 py-7">
    <div class="row justify-content-center">
        <div class="col-12 col-md-9">
            <div class="card border-0 shadow my-5">
                <div class="card-body py-7 px-5">
                    <div>
                        <h1 class="h2 text-center">Sign in</h1>
                        <p class="font-size-xs text-muted mb-4 text-center">Sign in to your account using email and password provided during registration.</p>

                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            {{ csrf_field() }}
                            @error('email')
                                <span class="text-danger" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="input-group-overlay form-group @error('email') border border-danger rounded @enderror">
                                <div class="input-group-prepend-overlay"><span class="input-group-text"><span class="fal fa-envelope"></span></span></div>
                                <input class="form-control prepended-form-control" id="email" name="email" type="email" placeholder="Email" required="" autocomplete="email" autofocus>
                            </div>
                            <div class="input-group-overlay cs-password-toggle form-group @error('password') border border-danger rounded @enderror">
                                <div class="input-group-prepend-overlay"><span class="input-group-text"><span class="fal fa-lock"></span></span></div>
                                <input class="form-control prepended-form-control" id="password" name="password" type="password" placeholder="Password" required="" autocomplete="current-password">
                            </div>
                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                            <div class="d-flex justify-content-between align-items-center form-group">
                                <div class="custom-control custom-checkbox">
                                    <input class="custom-control-input" type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="remember">Keep me signed in</label>
                                </div>
                                @if (Route::has('password.request'))
                                    <a class="nav-link-style font-size-xs" href="{{ route('password.request') }}">
                                        Forgot password?
                                    </a>
                                @endif
                            </div>
                            <button class="btn btn-primary btn-block" type="submit">Sign in</button>
                        </form>

                        @if(config('app.allow_self_service'))
                        <p class="font-size-sm pt-4 mb-0 text-center">
                            Don't have an account yet? <a class="font-weight-medium ml-1" href="{{ route('register') }}">Sign up</a>
                        </p>
                        @endif

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
