@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Events
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
        <div class="row">
            <div class="col-12">
                <ul class="list-group" id="events-list">
                    <li class="list-group-item active">
                        <h3 class="h4 d-inline align-text-top">Hisorical Event List</h3>
                        <a href="/events" class="ml-2 text-white align-bottom font-italic">View Active</a>
                    </li>
                    
                    @foreach ($events as $event)
                        <li class="list-group-item list-group-item-light">
                            <div class="d-flex w-100 justify-content-between">
                                <h4 class="h5 mb-1">{{ $event->title }}</h4>
                                <small>{{ $event->percent_filled }} scheduled</small>
                            </div>
                            <div class="d-flex w-100 justify-content-between">
                                <div class="d-inline">
                                    <p class="mb-0 font-size-xs text-muted">{{ $event->date_held }} from {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') . ' to ' . \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
                                    <p class="my-0 font-size-xs text-muted">No longer scheduling</p>
                                </div>
                                
                                @can('update_event')
                                <div class="text-right">
                                    <a class="text-info" href="/events/{{ $event->id }}" title="Event Details"><span class="fad fa-eye fa-lg"></span><span class="sr-only">Event Details</span></a>
                                    <a class="text-success" href="/events/{{ $event->id }}/report" title="Event Report" target="_blank" rel="noopener noreferrer"><span class="fad fa-file-download fa-lg"></span><span class="sr-only">Event Report</span></a>
                                </div>
                                @endcan
                            </div>
                        </li>
                    @endforeach
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