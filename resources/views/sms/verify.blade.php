@extends('layouts.no-nav')

@section('title')
    Verify Phone
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
                    Verify Your SMS Capable Phone Number
                </h1>

                <!-- Text -->
                <p class="mb-6 text-muted">
                    Receive text updates on your registration and status.
                </p>

                @if ($errors->any())
                <div class="alert alert-danger">
                    <p>There were the following errors:</p>
                    <ul>
                        @foreach($errors->all(':message') as $message)
                        <li>{{ $message }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
                @if (Session::has('messages'))
                    @foreach(session('messages')->all(':message') as $message)
                    <div class="alert alert-success">{{ $message }}</div>
                    @endforeach
                @endif

                <form method="POST" action="/sms/verify">
                    @csrf
                    <div class="row">
                        <div class="col-12 ml-auto">
                            <label for="code">
                                Enter your code sent to {{ substr(Auth::user()->phone, -4) }}:
                            </label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control font-size-sm" name="code" id="code" type="number" placeholder="Enter code" aria-label="Enter code" aria-describedby="caseBtn">
                                <div class="input-group-append">
                                    <button class="btn btn-primary font-size-sm" type="submit" id="codeBtn">
                                        Verify
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                {{ __('Before proceeding, please check your phone ending in '.substr(Auth::user()->phone, -4).' for a code.') }}
                {{ __('If you did not receive a code') }},
                <form class="d-inline" method="POST" action="{{ url('/sms/resend') }}">
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
