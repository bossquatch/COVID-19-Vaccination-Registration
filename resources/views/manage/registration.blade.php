@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Procure Registration
@endsection

@section('content')
<!-- Header -->
<div class="jumbotron jumbotron-fluid jumbotron-header bg-squares teal-gradient">
    <div class="container position-relative z-1">
        <div class="row">
            <div class="col-12">
                <!-- Badge -->
                <span class="badge badge-pill badge-white-teal mb-3">
                    <span class="h6 text-uppercase">
                        Registration
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">View an Online Registration</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">View a registration for a caller's COVID-19 vaccination.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container-fluid">
        <div class="col-12">
            <div class="text-center mb-6">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="{{ url()->previous() }}">
                    <span class="fad fa-times-circle mr-1"></span> Cancel
                </a>

                @can('create_vaccine')
                <button type="button" class="btn btn-header-outline btn-round btn-lg" data-toggle="modal" data-target="#vaccineModal">
                    <span class="fad fa-syringe mr-1"></span> Add Vaccination
                </button>
                @endcan
            </div>
        </div>

        <div class="row align-items-center">
            @if ($registration->pending_invitation)
                @can('update_invite')
                    <div class="col-12 col-lg-3">
                        <div class="mb-8 mb-md-0">
                            <div class="card mb-2">
                                <div class="card-body p-6">
                                    <div class="row">
                                        <div class="col-12 d-flex align-items-center">
                                            <span class="text-info fad fa-envelope fa-5x mx-auto"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12 text-center">
                                            <h2 class="h4 mb-1">Pending Invite!</h2>
                                            <p class="text-gray-dark mb-2">
                                                Appointment Time:<br>{{ \Carbon\Carbon::parse($registration->pending_invitation->event->date_held)->format('M d, Y') . ' ' . \Carbon\Carbon::parse($registration->pending_invitation->slot->starting_at)->format('h:iA') . '-' . \Carbon\Carbon::parse($registration->pending_invitation->slot->ending_at)->format('h:iA') }}
                                            </p>
                                            <p class="text-gray-dark mb-2">
                                                Location:<br>{{ $registration->pending_invitation->event->location->address . ' ' . $registration->pending_invitation->event->location->city . ', ' . $registration->pending_invitation->event->location->state . ' ' . $registration->pending_invitation->event->location->zip }}
                                            </p>
                                            <p class="text-gray-dark mb-2">
                                                Expires:<br>
                                                @if ($registration->pending_invitation->contacted_at)
                                                    {{ \Carbon\Carbon::parse($registration->pending_invitation->contacted_at)->addHours(config('app.invitation_expire'))->format('M d, Y h:iA') }}
                                                @else
                                                    @if (config('app.invitation_expire') > 24)
                                                        @if ((config('app.invitation_expire') % 24) > 0)
                                                        {{ floor(config('app.invitation_expire') / 24) . ' day(s) and ' . (config('app.invitation_expire') % 24) . ' hour(s) from contact' }}
                                                        @else
                                                        {{ floor(config('app.invitation_expire') / 24) . ' day(s) from contact' }}
                                                        @endif
                                                    @else
                                                    {{ config('app.invitation_expire') . ' hour(s) from contact' }}    
                                                    @endif
                                                @endif
                                            </p>

                                            <form action="/manage/{{ $registration->id }}/invitation/accept" class="form-inline mb-1 justify-content-center" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-success">Accept</button>
                                            </form>
                                            <form action="/manage/{{ $registration->id }}/invitation/decline" class="form-inline mb-1 justify-content-center" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-danger">Decline</button>
                                            </form>
                                        
                                            <form action="/manage/{{ $registration->id }}/invitation/phone" class="form-inline mb-1 justify-content-center" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-secondary btn-small">Left Voicemail</button>
                                            </form>
                                        
                                            <form action="/manage/{{ $registration->id }}/invitation/email" class="form-inline mb-1 justify-content-center" method="post">
                                                @csrf
                                                <button type="submit" class="btn btn-outline-secondary btn-small">Left Email</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcan
            @endif
            <div class="col-12 col-lg-6 @if($registration->pending_invitation) @cannot('update_invite') offset-lg-3 @endcannot @else offset-lg-3 @endif">
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
                                        {{ '(' . $registration->Age . ' years old.)'}}
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
                        @can('create_invite')
                        @php
                            $past_events = \App\Models\Event::where([
                                    ['date_held', '<', DB::raw('CURDATE()')],
                                    ['date_held', '>=', \Carbon\Carbon::today()->subDays(14)],
                                ])->whereHas('slots', function ($query) {
                                    $query->withCount([
                                        'invitations as active_invitations_count' => function ($query) {
                                            $query->whereHas('invite_status', function ($query) {
                                                $query->whereNotIn('id', [4, 5]);
                                            });
                                        },
                                    ])->having('capacity', '>', 'acivate_invitations_count');
                                })->orderBy('date_held', 'desc')->get();
                        @endphp
                            <hr>
                            <div id="forceSchedulingRow">
                                <div class="row align-items-center justify-content-center">
                                    <h3>Add Appointment Data for Record</h3>
                                </div>
                                <div class="row">
                                    <div class="col-12 col-lg-10 mx-auto">
                                        <div class="input-group">
                                            <select class="custom-select" id="forceSchedule" aria-label="Force a registration to a past event for historical data">
                                                <option selected>Choose Event...</option>
                                                @foreach ($past_events as $event)
                                                    <option value="{{ $event->id }}" data-id="{{ $event->id }}">{{ $event->title }}</option>
                                                @endforeach
                                            </select>
                                            <select class="custom-select" id="forceSlot" aria-label="Force a registration to a past slot for historical data">
                                                <option selected>No available slots</option>
                                            </select>
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary btn-disabled" disabled type="button" id="forceSchedulingLoading" style="display: none;"><span class="fad fa-spinner fa-spin"></span></button>
                                                <button class="btn btn-outline-success" type="button" id="forceSchedulingAdd" onclick="submitInvite()">Add</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row" id="forceSchedulingStatus"></div>
                            </div>
                        @endcan
                        @can('read_registration')
                            <hr>
                            <div class="row align-items-center justify-content-center">
                                <h3>Vaccinations</h3>
                            </div>
                            <div id="js-vaccine-section">
                                @php
                                    $no_vacs = false;
                                @endphp
                                @forelse ($registration->vaccines as $vaccine)
                                    @include('vaccine.partials.info', ['vaccine' => $vaccine])
                                @empty
                                    @php
                                        $no_vacs = true;
                                    @endphp
                                @endforelse
                                <div id="js-no-vaccine-alert" class="alert alert-info text-center" @if (!$no_vacs) style="display: none" @endif>
                                    This registrant has not received a vaccine.
                                </div>
                            </div>
                        @endcan
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 mt-5 mt-lg-0">
                <div class="card my-auto">
                    <div class="card-body">
                        <h3 class="card-title">Comments</h3>
                        <div id="commentSection">
                            @include('manage.partials.comments', ['comments' => $registration->comments])
                        </div>
                        <div class="col-12">
                            <div class="form-group mb-5">
                                <label for="comment">Add New Comment</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                            </div>
                        </div>
                        <div id="comment-error-text" class="text-danger text-right" role="alert" style="display: none;">
                            <strong id="commentError"></strong>
                        </div>
                        <button class="btn btn-info float-right" id="newComment" data-regis-id="{{ $registration->id }}">Add Comment</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@can('create_invite')
    <script>
        $('#forceSchedule').on('change', function() {
            var eventId = this.value;

            if (eventId > 0) {
                $.get('/slots/'+eventId, {}, function(data) {
                        if (data.status == 'success') {
                            $('#forceSlot').html(data.html);
                        } else {
                            $('#forceSlot').html('<option selected>No available slots</option>');
                        }
                }, 'json');
            } else {
                $('#forceSlot').html('<option selected>No available slots</option>');
            }
        });

        function submitInvite() {
            document.getElementById('forceSchedulingAdd').style.display = 'none';
            document.getElementById('forceSchedulingLoading').style.display = '';
            var event = document.getElementById('forceSchedule').options[document.getElementById('forceSchedule').selectedIndex].value;
            var slot = document.getElementById('forceSlot').options[document.getElementById('forceSlot').selectedIndex].value;

            if (event > 0 && slot > 0) {
                $.post('/slots/force-invite/{{ $registration->id }}', {
                        '_token' : $('meta[name=csrf-token]').attr('content'),
                        'event' : event,
                        'slot' : slot,
                    }, function(data) {
                        document.getElementById('forceSchedulingAdd').style.display = '';
                        document.getElementById('forceSchedulingLoading').style.display = 'none';
                        if (data.status == 'success') {
                            document.getElementById('forceSchedulingStatus').innerHTML = '<div class=" col-12 col-lg-10 mx-auto mt-2 alert alert-success text-center">The registration was associated with the event time slot!</div>';
                        } else {
                            document.getElementById('forceSchedulingStatus').innerHTML = '<div class=" col-12 col-lg-10 mx-auto mt-2 alert alert-danger text-center">' + data.message + '</div>';
                        }
                    }, 'json');
            } else {
                document.getElementById('forceSchedulingStatus').innerHTML = '<div class=" col-12 col-lg-10 mx-auto mt-2 alert alert-danger text-center">The event and slot fields need input!</div>';
            }
        }
    </script>
@endcan

<script>
    $('#newComment').click(function(event){
        event.preventDefault();
        regisId = $(this).data('regis-id');
        commentText = document.getElementById('comment').value;

        console.log(regisId);
        console.log(commentText);
        if (regisId && commentText) {
            document.getElementById('comment-error-text').style.display = "none";
            $.post('/comments', {
                    "_token": $('meta[name=csrf-token]').attr('content'),
                    "regis_id": regisId,
                    "comment": commentText
                }, function(data) {
                    if (data.status == 'success') {
                        document.getElementById('comment').value = "";
                        $('#commentSection').html(data.html);
                    } else {
                        CommentError();
                    }
            }, 'json');
        } else {
            CommentError();
        }
    });

    function CommentError() {
        document.getElementById('comment-error-text').style.display = "";
        document.getElementById('commentError').innerHTML = "Comment must have input!";
    }
</script>

@can('create_vaccine')
    @include('vaccine.partials.modal', ['registration_id' => $registration->id])
@endcan
@endsection