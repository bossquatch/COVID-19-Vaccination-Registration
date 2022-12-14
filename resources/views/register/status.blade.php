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
<div class="jumbotron jumbotron-fluid jumbotron-header bg-squares teal-gradient">
    <div class="container position-relative z-1">
        <div class="row">
            <div class="col-12">
                <!-- Badge -->
                <span class="badge badge-pill badge-white-teal mb-3">
                    <span class="h6 text-uppercase">
                        Status
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">View your Online Registration</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Check back anytime to view your registration status.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
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
                    @if (Auth::user()->registration->pending_invitation)
                        <div class="card mb-2">
                            <div class="card-body p-6">
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <div class="col-12 d-flex align-items-center">
                                            <span class="text-info fad fa-envelope fa-5x mx-auto"></span>
                                        </div>
                                        <h2 class="h4 mb-1">Pending Invite!</h2>
                                        <p class="text-gray-dark mb-2">
                                            Appointment Time: {{ \Carbon\Carbon::parse(Auth::user()->registration->pending_invitation->event->date_held)->format('M d, Y') . ' ' . \Carbon\Carbon::parse(Auth::user()->registration->pending_invitation->slot->starting_at)->format('h:iA') }}
                                        </p>
                                        <p class="text-gray-dark mb-2">
                                            Location: {{ Auth::user()->registration->pending_invitation->event->location->address . ' ' . Auth::user()->registration->pending_invitation->event->location->city . ', ' . Auth::user()->registration->pending_invitation->event->location->state . ' ' . Auth::user()->registration->pending_invitation->event->location->zip }}
                                        </p>
                                        <div class="row justify-content-center px-4">
                                            <form action="/home/invitation/accept" class="form mb-3 justify-content-center" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success" aria-describedby="acceptInfo">Accept</button>
                                                <br><p id="acceptInfo" class="form-text font-weight-light font-size-xs text-muted">I accept this invitation.</p>
                                            </form>
                                            <form action="/home/invitation/postpone" class="form mb-3 justify-content-center" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-info" aria-describedby="postponeInfo">Postpone</button>
                                                <br><p id="postponeInfo" class="form-text font-weight-light font-size-xs text-muted">I cannot attend this event but would like to be considered for future events.</p>
                                            </form>
                                            <form action="/home/invitation/decline" class="form mb-3 justify-content-center" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger" aria-describedby="declineInfo">Decline</button>
                                                <br><p id="declineInfo" class="form-text font-weight-light font-size-xs text-muted">I am no longer interested in receiving a vaccination through this program.</p>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                    <!-- Card -->
                    <div class="card">
                        <div class="card-body p-6">
                            <div class="row align-items-center justify-content-center">
                                {{--<div class="col-12">
                                    <button class="btn btn-link float-right text-danger text-sm p-0" data-toggle="modal" data-target="#deleteModal">
                                        <small><span class="fad fa-trash-alt mr-1"></span> Delete Registration</small>
                                    </button>
                                </div>--}}
                                @if(config('app.always_show_qr') || Auth::user()->registration->has_appointment)
                                <div class="col-12 col-lg-4 text-center mb-0">
                                    {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->generate(request()->root()."/".Auth::user()->id."/".Auth::user()->registration->id."/".Auth::user()->registration->code . '?checkin=auto'); !!}
                                </div>
                                @endif
                                <div class="col-12 @if(config('app.always_show_qr') || Auth::user()->registration->has_appointment) col-lg-8 @endif text-center mb-0">
                                    <!-- Logo -->
                                    {{--<div class="text-primary mb-4">
                                        <span class="fad fa-user-circle fa-4x"></span>
                                    </div>--}}

                                    <!-- Title -->
                                    <h2 class="mb-2">
                                        {{ Auth::user()->registration->first_name.' '.Auth::user()->registration->last_name }}
                                    </h2>

                                    <div class="badge badge-outline-muted mb-2">
                                        <span class="{{ Auth::user()->registration->status->fa_icon }} mr-1"></span> {{ Auth::user()->registration->status->name }}
                                    </div>

                                    <!-- Text -->
                                    <p class="text-gray-dark mb-2">
                                        Submitted at: {{ Carbon\Carbon::parse(Auth::user()->registration->submitted_at)->format('m-d-Y h:i:s A') }}
                                    </p>

                                    <p class="text-gray-dark mb-2">
                                        Code: {{ Auth::user()->registration->code }}
                                    </p>

                                    <p class="text-gray-dark mb-0">
                                        Phone number ending in: {{ substr(Auth::user()->phone, -4) }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer py-0 border-top">
                            <div class="row">
                                <div class="col-3 text-center border-right postion-relative">
                                    <button class="btn btn-link p-0 stretched-link" type="button" title="View Registration Details" id="detailsBtn" onclick="popDetails()">
                                        <small><span class="fad fa-eye mr-1"></span>View</small>
                                    </button>
                                </div>
                                <div class="col-3 text-center border-right postion-relative">
{{--                                    <a href="/edit" title="Edit Registration" class="btn btn-link p-0 stretched-link"><small><span class="fad fa-edit mr-1"></span>Edit</small></a>--}}
                                </div>
                                <div class="col-3 text-center border-right postion-relative">
                                    @if (Auth::user()->sms_verified_at != null)
                                    <span class="btn btn-link p-0 disabled text-success">
                                        <small><span class="fad fa-mobile mr-1"></span>SMS Verified</small>
                                    </span>
                                    @else
                                    <form method="POST" action="{{ url('/sms/resend') }}">
                                        @csrf
{{--                                        <button type="submit" class="btn btn-link p-0 stretched-link">--}}
{{--                                            <small><span class="fad fa-mobile mr-1"></span>Text Message Verify</small>--}}
{{--                                        </button>--}}
                                    </form>
                                    @endif
                                </div>
                                <div class="col-3 text-center postion-relative">
{{--                                    <button class="btn btn-link p-0 text-danger stretched-link" data-toggle="modal" data-target="#deleteModal">--}}
{{--                                        <small><span class="fad fa-trash-alt mr-1"></span> Delete</small>--}}
{{--                                    </button>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                    @if (Auth::user()->registration->has_appointment)
                        <div class="card mt-2">
                            <div class="card-body p-6">
                                <div class="row">
                                    <div class="col-4 d-flex align-items-center">
                                        <span class="text-success fad fa-calendar-check fa-5x mx-auto"></span>
                                    </div>
                                    <div class="col-8">
                                        <h2 class="h4 mb-1">Current Appointment:</h2>
                                        <p class="text-gray-dark mb-2">
                                            Appointment Time:<br>{{ \Carbon\Carbon::parse(Auth::user()->registration->appointment->starting_at)->format('M d, Y') . ' ' . \Carbon\Carbon::parse(Auth::user()->registration->appointment->starting_at)->format('h:iA') . '-' . \Carbon\Carbon::parse(Auth::user()->registration->appointment->ending_at)->format('h:iA') }}
                                        </p>
                                        <p class="text-gray-dark mb-2">
                                            Location:<br>{{ Auth::user()->registration->appointment->event->location->address . ' ' . Auth::user()->registration->appointment->event->location->city . ', ' . Auth::user()->registration->appointment->event->location->state . ' ' . Auth::user()->registration->appointment->event->location->zip }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
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
                            Once scheduled, you need to show up.  Be sure to bring a valid ID and a completed <a href="/docs/consent_moderna.pdf" target="_blank" rel="noopener" download aria-download="true">Moderna Consent Form</a>.
                        </p>

                    </div>

                </div>
                <div class="d-flex">
                    <!-- Badge -->
                    <div class="badge badge-lg badge-rounded-circle badge-primary-soft font-size-lg mt-1">
                        <span>4</span>
                    </div>

                    <!-- Body -->
                    <div class="ml-5">
                        <!-- Heading -->
                        <h2 class="h3">
                            Are you "extremely vulnerable"?
                        </h2>

                        <!-- Text -->
                        <p class="text-gray-dark mb-0">
                            You may also receive the vaccine if your phycisian deems you extremely vulnerable. To receive the
                            inoculation as extremely vulnerable you must bring a completed <a href="/docs/EO-21-47-Form.pdf" target="_blank" rel="noopener" download aria-download="true">EO-21-47-Form</a>
                            and include a statement from the physician that the patient meets eligibility criteria outlined on the <a href="https://floridahealthcovid19.gov/high-risk-populations/">
                            Florida Department of Health website</a>.
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
                                    <li style="list-style-type: none;">{{ ('('.substr($phone->value,0,3).') '.substr($phone->value,3,3).'-'.substr($phone->value,6,4)) }}</li>
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

<div class="modal fade" id="deleteModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Registration Delete Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body pb-0 pt-6 px-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fad fa-exclamation-triangle fa-5x text-danger"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-3 font-weight-bold">Danger!</p>
                        <p class="text-gray-dark mb-0">Are you sure you wish to delete your registration?</p>
                        <p class="text-gray-dark"><small>(This will also delete your user account.)</small></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <form class="form-inline" action="/home/delete/" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Registration</button>
                </form>
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
