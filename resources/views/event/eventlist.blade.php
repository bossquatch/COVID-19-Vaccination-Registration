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
                <a class="btn btn-header btn-round btn-lg" href="/events/{{ $event->id }}">
                    <span class="fad fa-arrow-left mr-1"></span>Back
                </a>

                @if ($restricted)
                <a class="btn btn-header-outline btn-round btn-lg" href="/events/{{ $event->id }}/list">
                    <span class="fas fa-clipboard-list-check mr-1"></span>Show All Invites
                </a>
                @else
                <a class="btn btn-header-outline btn-round btn-lg" href="/events/{{ $event->id }}/list?callback=1">
                    <span class="fas fa-clipboard-list mr-1"></span>Show Only Invites Awaiting Callback
                </a>    
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="list-group" id="events-list">
                    <div class="list-group-item active">
                        <h3 class="h4 d-inline align-text-top">Active Invitations for {{ $event->title }}</h3>
                    </div>
                    
                    @foreach ($invites as $invite)
                        <a href="{{ "/".$invite->user->id."/".$invite->registration->id."/".$invite->registration->code }}" class="list-group-item list-group-item-action">
                            {{ $invite->registration->suffix_id ? $invite->registration->first_name.' '.$invite->registration->last_name.', '.$invite->registration->suffix->display_name : $invite->registration->first_name.' '.$invite->registration->last_name }} <span class="font-italic">- {{ $invite->invite_status->name }}</span>
                        </a>
                    @endforeach

                    @if($invites->hasPages())
                    <div class="list-group-item list-group-item-light d-flex justify-content-center">
                        {!! $invites->appends(request()->query())->links() !!}
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
@endsection