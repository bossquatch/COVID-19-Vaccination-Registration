@extends('layouts.no-nav')

@section('title')
    Password Change
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
                    {{ __('Change Password') }}
                </h1>

                <!-- Text -->
                <p class="mb-6 text-muted">
                    Change your password for accessing your registration.
                </p>

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
                    <button class="btn btn-header btn-round btn-lg btn-block" type="submit">
                        {{ __('Change Password') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
