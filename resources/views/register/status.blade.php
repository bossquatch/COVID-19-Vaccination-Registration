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
            <div class="col-12 col-md-7">
                <div class="mb-8 mb-md-0">
                    <!-- Card -->
                    <div class="card card-body p-6">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-12 col-lg-4 text-center mb-0">
                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->generate(request()->root()."/".Auth::user()->id."/".Auth::user()->registration->id."/".Auth::user()->registration->code); !!}
                            </div>
                            <div class="col-12 col-lg-8 text-center mb-0">
                                <!-- Logo -->
                                {{--<div class="text-primary mb-4">
                                    <span class="fad fa-user-circle fa-4x"></span>
                                </div>--}}
                                

                                <!-- Title -->
                                <h2 class="mb-2 mt-6">
                                    {{ Auth::user()->registration->first_name.' '.Auth::user()->registration->last_name }}<button class="btn btn-link p-1 ml-1" type="button" title="View Registration Details" id="detailsBtn" onclick="popDetails()"><span class="fad fa-eye fa-lg"></span></button>
                                </h2>

                                <div class="badge badge-outline-muted mb-2">
                                    <span class="{{ Auth::user()->registration->status->fa_icon }} mr-1"></span> {{ Auth::user()->registration->status->name }}
                                </div>

                                <!-- Text -->
                                <p class="text-gray-dark mb-2">
                                    Submitted at: {{ Carbon\Carbon::parse(Auth::user()->registration->submitted_at)->format('m-d-Y h:i:s A') }}
                                </p>

                                <p class="text-gray-dark mb-2">
                                    Code {{ Auth::user()->registration->code }}
                                </p>

                                <p class="text-gray-dark mb-0">
                                    Phone number ending in: {{ substr(Auth::user()->phone, -4) }}
                                </p>
                                @if (Auth::user()->sms_verified_at != null)
                                <p class="text-success">
                                    Verified
                                </p>
                                @else
                                <form method="POST" action="{{ url('/sms/resend') }}">
                                    @csrf
                                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('I wish to receive to text updates to this number.') }}</button>
                                </form>
                               {{-- <a href="/sms/verify">
                                    I wish to receive to text updates to this number.
                                </a>    --}}
                                @endif

                                <!-- Button -->
                               {{--@if ($application->status_id != '1' && $application->status_id != '5')--}}
                                
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
            <div class="col-12 col-md-5">
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

<div class="modal fade" id="detailModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Detail Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-6">
                <div class="row">
                    <div class="col-12 text-center">
                        <span class="fad fa-user-circle fa-4x text-info"></span>
                    </div>
                </div>
                <div class="row justify-content-center mb-1">
                    <div class="col-12 text-center mb-0">
                        <!-- Title -->
                        <h2 class="mb-1 mt-6">
                            {{ Auth::user()->registration->first_name.' '.Auth::user()->registration->last_name }}
                        </h2>

                        <div class="badge badge-outline-muted mb-2">
                            <span class="{{ Auth::user()->registration->status->fa_icon }} mr-1"></span> {{ Auth::user()->registration->status->name }}
                        </div>

                        <p class="text-gray-dark mb-2">
                            Submitted: {{ Carbon\Carbon::parse(Auth::user()->registration->submitted_at)->format('m-d-Y h:i:s A') }}
                        </p>
                    </div>
                    <div class="col-12 text-center mb-0">
                        <div class="row align-items-center justify-content-center">
                        <!-- Text -->
                        <div class="col-12 col-md-6 col-lg-4">
                            <h3 class="h4">Date of Birth:</h3>
                            <p class="text-gray-dark mb-2">
                                {{ Carbon\Carbon::parse(Auth::user()->registration->birth_date)->format('m/d/Y') }}
                            </p>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <h3 class="h4">Code:</h3>
                            <p class="text-gray-dark mb-2">
                                {{ Auth::user()->registration->code }}
                            </p>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <h3 class="h4">Address:</h3>
                            <p class="text-gray-dark mb-2">
                                @if (Auth::user()->registration->address2 != null)
                                    {!! Auth::user()->registration->address1.' '.Auth::user()->registration->address2.'<br>'.Auth::user()->registration->city.', '.Auth::user()->registration->state.' '.Auth::user()->registration->zip !!}
                                @else
                                    {!! Auth::user()->registration->address1.'<br>'.Auth::user()->registration->city.', '.Auth::user()->registration->state.' '.Auth::user()->registration->zip !!}
                                @endif
                            </p>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <h3 class="h4">Occupation:</h3>
                            <p class="text-gray-dark mb-2">
                                {{ Auth::user()->registration->occupation->display_name }}
                            </p>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <h3 class="h4">Phone Number(s):</h3>
                            <ul style="list-style-type: none; margin: 0; padding: 0;" class="text-gray-dark mb-2">
                                @forelse (Auth::user()->registration->phones() as $phone)
                                    <li style="list-style-type: none;">{{ $phone->value }}</li>
                                @empty
                                    <li style="list-style-type: none;">No phone number</li>
                                @endforelse
                            </ul>
                        </div>

                        <div class="col-12 col-md-6 col-lg-4">
                            <h3 class="h4">Email(s):</h3>
                            <ul style="list-style-type: none; margin: 0; padding: 0;" class="text-gray-dark mb-2">
                                @forelse (Auth::user()->registration->emails() as $email)
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
                                @forelse (Auth::user()->registration->conditions as $condition)
                                    <li style="list-style-type: none;">{{ $condition->display_name }}</li>
                                @empty
                                    <li style="list-style-type: none;">No underlying conditions</li>
                                @endforelse
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <button type="button" class="btn btn-header btn-round btn-lg" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function popDetails() {
        $('#detailModal').modal('show');
    }
</script>
@endsection