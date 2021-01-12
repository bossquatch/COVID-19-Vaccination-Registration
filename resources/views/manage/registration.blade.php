@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Procure Registration
@endsection

@section('content')
<!-- Header -->
<div class="page-header page-header-inner header-filter page-header-default"></div>

<section class="main main-raised pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 text-center">
                <!-- Badge -->
                <span class="badge badge-pill badge-primary-soft mb-3">
                    <span class="h6 text-uppercase">
                        Registration
                    </span>
                </span>

                <!-- Heading -->
                <h1>
                    View an <span class="text-primary">online registration.</span>
                </h1>

                <!-- Text -->
                <p class="lead text-gray-dark mb-7 mb-md-9">
                    View a registration for the COVID-19 vaccination.
                </p>
            </div>
        </div>

        <div class="col-12">
            <div class="text-center mb-6">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="/manage">
                    <span class="fad fa-times-circle mr-1"></span> Cancel
                </a>
            </div>
        </div>

        <div class="row align-items-center">
            <div class="col-12">
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
                                <h2 class="mb-1 mt-6">
                                    {{ $registration->first_name.' '.$registration->last_name }}
                                </h2>

                                <div class="badge badge-outline-muted mb-2">
                                    <span class="{{ $registration->status->fa_icon }} mr-1"></span> {{ $registration->status->name }}
                                </div>

                                <p class="text-gray-dark mb-2">
                                    Submitted: {{ Carbon\Carbon::parse($registration->submitted_at)->format('m-d-Y h:i:s A') }}
                                </p>
                            </div>
                            <div class="col-12 text-center mb-0">
                                <div class="row align-items-center justify-content-center">
                                <!-- Text -->
                                <div class="col-12 col-md-6 col-lg-4">
                                    <h3 class="h4">Date of Birth:</h3>
                                    <p class="text-gray-dark mb-2">
                                        {{ Carbon\Carbon::parse($registration->birth_date)->format('m/d/Y') }}
                                    </p>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <h3 class="h4">Code:</h3>
                                    <p class="text-gray-dark mb-2">
                                        {{ $registration->code }}
                                    </p>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <h3 class="h4">Address:</h3>
                                    <p class="text-gray-dark mb-2">
                                        @if ($registration->address2 != null)
                                            {!! $registration->address1.' '.$registration->address2.'<br>'.$registration->city.', '.$registration->state.' '.$registration->zip !!}
                                        @else
                                            {!! $registration->address1.'<br>'.$registration->city.', '.$registration->state.' '.$registration->zip !!}
                                        @endif
                                    </p>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <h3 class="h4">Occupation:</h3>
                                    <p class="text-gray-dark mb-2">
                                        {{ $registration->occupation->display_name }}
                                    </p>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <h3 class="h4">Phone Number(s):</h3>
                                    <ul style="list-style-type: none; margin: 0; padding: 0;" class="text-gray-dark mb-2">
                                        @forelse ($registration->phones() as $phone)
                                            <li style="list-style-type: none;">{{ ('('.substr($phone->value,0,3).') '.substr($phone->value,3,3).'-'.substr($phone->value,6,4)) }}</li>
                                        @empty
                                            <li style="list-style-type: none;">No phone number</li>
                                        @endforelse
                                    </ul>
                                </div>

                                <div class="col-12 col-md-6 col-lg-4">
                                    <h3 class="h4">Email(s):</h3>
                                    <ul style="list-style-type: none; margin: 0; padding: 0;" class="text-gray-dark mb-2">
                                        @forelse ($registration->emails() as $email)
                                            <li style="list-style-type: none;">{{ $email->value }}</li>
                                        @empty
                                            <li style="list-style-type: none;">No email address</li>
                                        @endforelse
                                    </ul>

                                    </div>
                                </div>

                                <div class="col-12">
                                    <h3 class="h4">Underlying Conditions:</h3>
                                    <ul style="list-style-type: none; margin: 0; padding: 0;" class="text-gray-dark mb-2">
                                        @forelse ($registration->conditions as $condition)
                                            <li style="list-style-type: none;">{{ $condition->display_name }}</li>
                                        @empty
                                            <li style="list-style-type: none;">No underlying conditions</li>
                                        @endforelse
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection