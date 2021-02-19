@extends('layouts.no-nav')

@section('title')
    Password Change
@endsection

@section('content')
<!-- Page Content -->
<section class="container d-flex justify-content-center align-items-center flex-grow-1 py-7">
    <div class="row justify-content-center w-75">
        <div class="col-12">
            <div class="card border-0 shadow my-5">
                <div class="card-body py-7 px-5">
                    <div>
                        <h1 class="h2 text-center">Change Password</h1>
                        <p class="font-size-xs text-muted mb-4 text-center">Change your password for accessing your registration.</p>

                        <!-- Form -->
                        <form class="mb-6" method="POST" action="/password/change">
                            @csrf

                            <!-- Current Password -->
                            <div class="form-group">
                                <label for="current_password">
                                    Current Password
                                </label>
                                <input id="current_password" type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password" required placeholder="Enter your current password">

                                @error('current_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first("current_password") }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="form-group">
                                <label for="new_password">
                                    New Password
                                </label>
                                <input id="new_password" type="password" class="form-control @error('new_password') is-invalid @enderror" name="new_password" required placeholder="Enter your new password">

                                @error('new_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first("new_password") }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Confirm New Password -->
                            <div class="form-group mb-5">
                                <label for="new_confirm_password">
                                    Confirm Password
                                </label>
                                <input id="new_confirm_password" class="form-control @error('new_confirm_password') is-invalid @enderror" type="password" name="new_confirm_password" required placeholder="Re-enter your new password">

                                @error('new_confirm_password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first("new_confirm_password") }}</strong>
                                    </span>
                                @enderror
                            </div>

                            <!-- Submit -->
                            <button class="btn btn-primary btn-block" type="submit">
                                {{ __('Change Password') }}
                            </button>
                        </form>

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
