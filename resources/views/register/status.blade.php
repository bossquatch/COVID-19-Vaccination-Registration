@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Status
@endsection

@section('content')
@if (isset($message))
@switch($message)
    @case('success')
        <div class="alert alert-success mb-0" role="alert">
            Your application has been submitted!
        </div>
        @break
    @case('failure')
        <div class="alert alert-danger mb-0" role="alert">
            Your application was not submitted successfully.  Please verify that you have provided all information required to submit your application and try again.
        </div>
        @break
    @default

@endswitch
@endif

<!-- Header -->
<div class="page-header page-header-inner header-filter page-header-default"></div>

<section class="main main-raised pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 text-center">
                <!-- Badge -->
                <span class="badge badge-pill badge-primary-soft mb-3">
                    <span class="h6 text-uppercase">
                        Process
                    </span>
                </span>

                <!-- Heading -->
                <h1>
                    View your <span class="text-primary">registration status.</span>
                </h1>

                <!-- Text -->
                <p class="lead text-gray-dark mb-7 mb-md-9">
                    Check back anytime to view your registration status.
                </p>
            </div>
        </div>
        <div class="col-12">
            <div class="text-center mb-6">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    <span class="fad fa-sign-out mr-1"></span> Sign out
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>
        <div class="row align-items-center">
            <div class="col-12 col-md-6">
                <div class="mb-8 mb-md-0">
                    <!-- Card -->
                    <div class="card card-body p-6">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-12 text-center mb-0">
                                <!-- Logo -->
                                <div class="text-primary mb-4">
                                    <span class="fad fa-user-circle fa-4x"></span>
                                </div>

                                <!-- Title -->
                                <h2 class="mb-2">
                                    {{ Auth::user()->registration->first_name.' '.Auth::user()->registration->last_name }}
                                </h2>

                                <div class="badge badge-outline-muted mb-2">
                                    <span class="{{ Auth::user()->registration->status->fa_icon }} mr-1"></span> {{ Auth::user()->registration->status->name }}
                                </div>

                                <!-- Text -->
                                <p class="text-gray-dark mb-2">
                                    Application #{{ Auth::user()->registration->id }}
                                </p>

                                <p class="text-gray-dark mb-2">
                                    Code {{ Auth::user()->registration->code }}
                                </p>

                                <!-- Button -->
                               {{--@if ($application->status_id != '1' && $application->status_id != '5')--}}
                                {{--<a class="btn btn-header btn-round btn-lg" href="/Application/review">
                                    View application
                                </a>--}}
                                {{--@else
                                <a class="btn btn-header btn-round btn-lg" href="/Application">
                                    Continue application
                                </a>
                                @endif--}}

                                {{--@if ($application->status_id == '2')
                                <a class="btn btn-header btn-round btn-lg mt-2" data-toggle="modal" data-target="#unlockModal">
                                    Unlock application
                                </a>
                                @endif--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <!-- List -->
                <div class="d-flex">
                    <!-- Badge -->
                    <div class="badge badge-lg badge-rounded-circle badge-primary-soft font-size-lg mt-1">
                        <span>1</span>
                    </div>

                    <!-- Body -->
                    <div class="ml-5">
                        <!-- Heading -->
                        <h2 class="h3">
                            Complete your registration
                        </h2>

                        <!-- Text -->
                        <p class="text-gray-dark mb-6">
                            Fill out a registration on our website. Most applicants finish in less than an hour.
                        </p>
                    </div>
                </div>
                <div class="d-flex">
                    <!-- Badge -->
                    <div class="badge badge-lg badge-rounded-circle badge-primary-soft font-size-lg mt-1">
                        <span>2</span>
                    </div>

                    <!-- Body -->
                    <div class="ml-5">
                        <!-- Heading -->
                        <h2 class="h3">
                            Await scheduling
                        </h2>

                        <!-- Text -->
                        <p class="text-gray-dark mb-6">
                            You'll be scheduled for an appointment and notified of the time.
                        </p>
                    </div>
                </div>
                <div class="d-flex">
                    <!-- Badge -->
                    <div class="badge badge-lg badge-rounded-circle badge-primary-soft font-size-lg mt-1">
                        <span>3</span>
                    </div>

                    <!-- Body -->
                    <div class="ml-5">
                        <!-- Heading -->
                        <h2 class="h3">
                            Come to your Appointment
                        </h2>

                        <!-- Text -->
                        <p class="text-gray-dark mb-0">
                            Once scheduled, you just need to show up.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{--@if ($application->status_id == '2')
<div class="modal fade" id="unlockModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Unlock Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fad fa-exclamation-triangle fa-5x text-warning"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-5"><b>Warning!</b></p>
                        <p class="text-gray-dark mb-5">By unlocking your application, you will be able to edit it, but you will have to re-submit your application in order for it to get processed.</p>
                        <div class="row">
                            <div class="col">
                                <form action="/Application/unlock" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-header btn-round btn-lg">Unlock</button>
                                </form>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-header btn-round btn-lg" data-dismiss="modal">Cancel</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif--}}
@endsection