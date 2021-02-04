@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Partner Page
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
                <h2 class="title">Events History</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">View Stats on Old Events.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        {{--<div class="col-12">
            <div class="text-center mb-6">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="/manage">
                    <span class="fad fa-arrow-left mr-1"></span> Back
                </a>
                
                <a class="btn btn-header btn-round btn-lg" href="/locations">
                    <span class="fad fa-map-marker-alt mr-1"></span>Locations
                </a>
            </div>
        </div>--}}

        <div class="row">
            <div class="col-12">
                <ul class="list-group" id="events-list">
                    <li class="list-group-item active">
                        <h3 class="h4 d-inline align-text-top">Hisorical Event List</h3>
                        <a href="/my-events" class="ml-2 text-white align-bottom font-italic">View Active</a>
                    </li>
                    
                    @forelse ($events as $event)
                        <li class="list-group-item list-group-item-light">
                            <div class="d-flex w-100 justify-content-between">
                                <h4 class="h5 mb-1">{{ $event->title }}</h4>
                                <small>{{ $event->percent_filled }} scheduled</small>
                            </div>
                            <div class="d-flex w-100 justify-content-between">
                                <div class="d-inline">
                                    <p class="mb-0 font-size-xs text-muted">{{ $event->date_held }} from {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') . ' to ' . \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
                                    {{--<p class="my-0 font-size-xs @if($event->partner_handled) text-info @elseif($event->open) text-success @else text-danger @endif">{{ $event->partner_handled ? 'Partner Handled' : ($event->open ? 'Scheduling Automatically' : 'Scheduling Closed') }}</p>--}}
                                </div>
                                <div class="text-right">
                                    @can('manage_partner_event')
                                        @if ($event->has_pending_callbacks)
                                            {{--<a class="text-warning" href="/my-events/{{ $event->id }}/pending" title="Registrations waiting for callback!"><span class="fad fa-bell-exclamation"></span><span class="sr-only">Pending Callbacks</span></a>--}}   
                                        @endif
                                    @endcan

                                    {{--<a class="text-info" href="/my-events/{{ $event->id }}" title="Event Details"><span class="fad fa-eye"></span><span class="sr-only">Event Details</span></a>--}}
                                </div>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item list-group-item-light">
                            <div class="row">
                                <div class="col-12 alert alert-info text-center mb-0">
                                    No events coming up!
                                </div>
                            </div>
                        </li>
                    @endforelse
                    @if($events->hasPages())
                    <li class="list-group-item list-group-item-light d-flex justify-content-center">
                        {!! $events->links() !!}
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>
@endsection