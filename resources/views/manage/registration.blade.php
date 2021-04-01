@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Procure Registration
@endsection

@section('header')
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" defer></script>
<style>
    .ui-autocomplete {
        z-index: 1100;
    }
</style>
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
                <a class="btn btn-header btn-round btn-lg" href="{{ url()->previous() == url()->current() ? '/manage' : url()->previous() }}">
                    <span class="fas fa-arrow-left mr-1"></span> Back
                </a>
            </div>
        </div>

        <div class="row align-items-top">
            @include('manage.partials.appointment', ['registration' => $registration])
            <div class="col-12 col-lg-6 @if($registration->pending_invitation) @cannot('update_invite') offset-lg-3 @endcannot @elseif(!$registration->has_appointment) @cannot('keep_inventory') offset-lg-3 @endcannot @endif">
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

                                {{--@can('keep_inventory')
                                <div class="input-group col-12 col-md-6 mx-auto mb-2">
                                    <div class="input-group-prepend">
                                        <label for="submitted-at" class="input-group-text" id="submitted-at-desc">Submitted At:</label>
                                    </div>
                                    <input type="date" class="form-control" id="submitted-at" data-id="{{ $registration->id }}" aria-describedby="submitted-at-desc" value="{{ Carbon\Carbon::parse($registration->submitted_at)->format('Y-m-d') }}">
                                </div>
                                @else--}}
                                <p class="text-gray-dark mb-2">
                                    Submitted: {{ Carbon\Carbon::parse($registration->submitted_at)->format('m-d-Y h:i:s A') }}
                                </p>
                                {{--@endcan--}}

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

						@if ($registration->hasShotRecord)
							<div class="row align-items-center justify-content-center mb-4 mt-6">
								<div class="card border-secondary mb-3" style="max-width: 36rem;">
									<div class="card-header bg-primary text-white">Attention</div>
									<div class="card-body text-secondary">
										<h5 class="card-title">COVID-19 Vaccination Record Found</h5>
										<div class="table-responsive">
											<table class="table">
												<tr>
													<td>Name:</td>
													<td>{{ $registration->shotRecord->name_last . ', ' . $registration->shotRecord->name_first }}</td>
												</tr>
												<tr>
													<td>DOB:</td>
													<td>{{ $registration->shotRecord->date_birth }}</td>
												</tr>
												<tr>
													<td>Date Received:</td>
													<td>{{ $registration->shotRecord->date_given }}</td>
												</tr>
												<tr>
													<td>Vaccine:</td>
													<td>{{ $registration->shotRecord->vaccine }}</td>
												</tr>
												<tr>
													<td>Location:</td>
													<td>{{ $registration->shotRecord->provider_site }}</td>
												</tr>
												<tr>
													<td></td>
													<td>{{ $registration->shotRecord->provider_org }}</td>
												</tr>
												<tr>
													<td></td>
													<td>{{ $registration->shotRecord->provider_site_county }}</td>
												</tr>
											</table>
										</div>
									</div>
								</div>
							</div>
						@else
							@can('create_invite')
							@php
								$available_events = \App\Models\Event::whereHas('slots', function ($query) {
										$query->select('id', 'event_id', 'capacity', 'deleted_at')
										->where('date_held','>=',\Carbon\Carbon::today())
										->withCount([
											'invitations as active_invitations_count' => function ($query) {
												$query->whereHas('invite_status', function ($query) {
													$query->whereNotIn('id', [4, 5, 9]);
												});
											},
										])->havingRaw('`capacity` > `active_invitations_count`');
									})->orderBy('date_held', 'asc')->get();
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
													@foreach ($available_events as $event)
														<option value="{{ $event->id }}" data-id="{{ $event->id }}">{{ $event->title }} - {{ \Carbon\Carbon::parse($event->date_held)->format('M d, Y') }}</option>
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

								<div class="row align-items-center justify-content-center mb-4 mt-6">
									<h3>Vaccinations</h3>
									@can('create_vaccine')
										<button type="button" class="btn btn-outline-primary btn-round ml-3" data-toggle="collapse" data-target="#vaccineCollapse">
											<span class="fad fa-syringe mr-1"></span> Add Vaccination
										</button>
									@endcan
								</div>
								@can('create_vaccine')
									@include('vaccine.partials.collapse', ['registration' => $registration])
								@endcan
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
										{{ ucwords(strtolower($registration->first_name)) }} has not received a vaccine.
									</div>
								</div>

                        	@endcan
						@endif
                        @can('read_registration')
							<div class="card mb-6">
								<div class="card-header" id="headingOne">
									<div class="row align-items-center justify-content-center">
										<h3>Email History</h3>
									</div>
								</div>
								<div class="card-body">
									<div id="js-email-history-section">

										<table class="table table-sm font-size-xs table-hover">
											<thead>
												<tr class="">
													<th scope="col">Date Sent</th>
													<th scope="col">Recipient</th>
													<th scope="col">Subject</th>
													<th scope="col">Status</th>
												</tr>
											</thead>
											<tbody>
											@forelse ($registration->user->emailHistory as $email_history)
												<tr class="{{ $email_history->event == 'delivered' ? 'alert-info' : 'alert-danger' }}">
													<td scope="row">{{ Carbon\Carbon::createFromTimestamp($email_history->timestamp)->isoFormat('M/D/YY h:mm:ss a') }}</td>
													<td>{{ $email_history->headers_to }}</td>
													<td>{{ $email_history->headers_subject }}</td>
													<td data-bs-toggle="tooltip" data-bs-placement="bottom" title="{{ $email_history->delivery_status_message . ' ' . $email_history->severity }}">{{ ucfirst($email_history->event) }}</td>
												</tr>
											@empty
												<tr class="alert-warning mt-6 mb-6">
													<td colspan="5" class="text-center font-size-lg alert-warning">No email history found</td>
												</tr>
											@endforelse
											</tbody>
										</table>
									</div>
								</div>
							</div>

							<div id="accordion">

								<div class="card">
									<div class="card-header" id="headingOne">
										<div class="row align-items-center justify-content-center">
											<h3>Account History</h3>
										</div>
									</div>
									<div class="card-body">

										<div class="table-responsive">
											<table class="table table-hover table-sm font-size-xs">
												<thead>
													<tr>
														<td scope="col">Date</td>
														<td scope="col">User</td>
														<td scope="col">Action</td>
														<td scope="col">Model</td>
													</tr>
												</thead>
												<tbody>
												@php
													$i = 0;
												@endphp

												@foreach($registration->auditLogs as $item)
													@php $i++; @endphp
													<tr data-toggle="collapse" data-target="#accordion{{$i}}" class="clickable alert-primary"  style="cursor: pointer">
														<td>{{$item->dateCreated}}</td>
														<td>{{$item->activeUser ?? ''}}</td>
														<td>{{json_decode($item->json_description)->status}}</td>
														<td>{{$item->model}}</td>
													</tr>
													<tr id="accordion{{$i}}" class="collapse">
														<td colspan="4">
															<ul>
															@foreach(json_decode($item->json_description)->values as $key=>$val)
																<li>{{$key . ': ' . $val}}</li>
															@endforeach
															</ul>
														</td>
													</tr>
												@endforeach
												</tbody>
											</table>
										</div>
									</div>
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

@can('keep_inventory')
<script>
    document.getElementById("submitted-at").addEventListener('focusout', function() {
        let field = this;
        let newVal = field.value;
        let regis = field.dataset.id;
        if (newVal != '') {
            submitDateBorder(field, 'danger');
            $.post('/manage/update-submission-date', {
                    "_token": $('meta[name=csrf-token]').attr('content'),
                    "regis_id": regis,
                    "new_date": newVal
                }, function(data) {
                    if (data.status == 'success') {
                        submitDateBorder(field, 'success');
                    }
            }, 'json');
        } else {
            submitDateBorder(field, 'danger');
        }
    });

    function submitDateBorder(ele, borderType) {
        let oldType = 'danger';
        if (borderType == oldType) {
            oldType = 'success';
        }
        if (!ele.classList.contains('border')) {
            ele.classList.add('border');
        }
        if (ele.classList.contains('border-' + oldType)) {
            ele.classList.remove('border-' + oldType);
        }
        if (!ele.classList.contains('border-' + borderType)) {
            ele.classList.add('border-' + borderType);
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
    @include('vaccine.js.collapse', ['registration' => $registration])
@endcan
@endsection
