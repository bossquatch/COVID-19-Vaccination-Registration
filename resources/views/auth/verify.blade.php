@extends('layouts.no-nav')

@section('title')
    Verify Email
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
                    Verify Your Email Address
                </h1>

                <!-- Text -->
                <p class="mb-6 text-muted">
                    Access your registration and status.
                </p>

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('Be aware, that emails to certain providers such as msn.com, ymail.com, yahoo.com, netzero.com, and aol.com may be delayed up to 20 minutes.') }}
                {{ __('If you did not receive the email') }},
                <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                    @csrf
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                </form>

                <div class="mb-6"></div>
                <a class="btn btn-header btn-round btn-lg btn-block" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                            document.getElementById('logout-form').submit();">
                    Return to Main Page
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
