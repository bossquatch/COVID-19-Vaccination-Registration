@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Pending Invites
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
                        Events
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">Manage Events</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Manage the events to distribute vaccinations.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="col-12">
            <div class="text-center mb-6">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="/events/{{ $slot->event_id }}">
                    <span class="fad fa-arrow-left mr-1"></span>Back
                </a>

                @can('delete_event')
                @if ($slot->event->edittable)
                <a class="btn btn-header btn-header-danger btn-round btn-lg" href="#" onclick="event.preventDefault();
                    document.getElementById('slot-delete-form').submit();">
                    <span class="fad fa-times-circle mr-1"></span>Remove Slot
                </a>

                <form action="/events/{{ $slot->event_id }}/slots/{{ $slot->id }}" method="post" class="d-none" id="slot-delete-form">
                    @csrf
                    @method('DELETE')
                </form>
                @endif
                @endcan
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="list-group" id="events-list">
                    <div class="list-group-item active">
                        <h3 class="h4 d-inline align-text-top">Active Invitations for {{ \Carbon\Carbon::parse($slot->event->date_held)->format('M d, Y') . ' ' . \Carbon\Carbon::parse($slot->starting_at)->format('h:iA') . '-' . \Carbon\Carbon::parse($slot->ending_at)->format('h:iA') }}</h3>
                        <span class="ml-2 text-white align-bottom font-italic">{{ $slot->reserved }} reserved slots</span>
                        @can('create_invite')
                        <button class="btn btn-success btn-sm float-right" onclick="reserveForm('')"><span class="fad fa-plus-circle mr-1"></span>Reserve Seats</button>    
                        @endcan
                    </div>
                    @can('create_invite')
                        <li class="list-group-item" id="slot-row-reserve" @if ($errors->isEmpty()) style="display: none;" @endif>
                            <div class="row justify-content-end">
                                <button class="btn btn-outline-secondary btn-sm" onclick="reserveForm('none')"><span class="fal fa-times mr-1"></span>Cancel</button>
                            </div>
                            <form action="/events/{{ $slot->event_id }}/slots/{{ $slot->id }}/reserve" method="post">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group mb-5">
                                            <label for="amount">
                                                Amount to Reserve (Max: {{ $slot->capacity - $slot->active_invitation_count }})
                                            </label>
                                            <input type="number" name="amount" id="amount" class="form-control @error("amount") is-invalid @enderror" value="{{ old('amount') }}" min="0" max="{{ $slot->capacity - $slot->active_invitation_count }}" required aria-required="true">
                                            @error('amount')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first('amount') }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="row justify-content-end">
                                    <div class="col-12 col-sm-5 col-md-4 col-lg-3">
                                        <button type="submit" class="btn btn-success btn-block">Submit</button>
                                    </div>
                                </div>
                            </form>
                        </li>    
                    @endcan
                    
                    @foreach ($invites as $invite)
                        <a href="{{ "/".$invite->user->id."/".$invite->registration->id."/".$invite->registration->code }}" class="list-group-item list-group-item-action">
                            {{ $invite->registration->suffix_id ? $invite->registration->first_name.' '.$invite->registration->last_name.', '.$invite->registration->suffix->display_name : $invite->registration->first_name.' '.$invite->registration->last_name }} <span class="font-italic">- {{ $invite->invite_status->name }}</span>
                        </a>
                    @endforeach

                    @if($invites->hasPages())
                    <div class="list-group-item list-group-item-light d-flex justify-content-center">
                        {!! $invites->links() !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
    <script>
        function reserveForm(display) {
            document.getElementById('slot-row-reserve').style.display = display;
        }
    </script>
@endsection