@extends('layouts.no-nav')

@section('title')
    Verify Phone
@endsection

@section('content')
<!-- Page Content -->
<section class="container d-flex justify-content-center align-items-center flex-grow-1 pt-7 pb-4">
    <div class="row justify-content-center">
        <div class="col-12 col-md-9">
            <div class="card border-0 shadow my-5">
                <div class="card-body py-7 px-5">
                    <div>
                        <h1 class="h2 text-center">Verify Your SMS Capable Phone Number</h1>
                        <p class="font-size-xs text-muted mb-4 text-center">Receive text updates on your registration and status.</p>

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
                                        <input type="text" class="form-control font-size-sm" name="code" id="code" type="number" placeholder="Enter code" aria-label="Enter code" aria-describedby="caseBtn" required aria-required="true">
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
        </div>
    </div>
</section>
@endsection
