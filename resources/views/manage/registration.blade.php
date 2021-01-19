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
                <a class="btn btn-header btn-round btn-lg" href="/manage">
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
            <div class="col-12 col-lg-6 offset-lg-3">
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
                        @can('read_vaccine')
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

<script>
    $('#newComment').click(function(event){
        console.log('hit');
        event.preventDefault();
        console.log('hit2');
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