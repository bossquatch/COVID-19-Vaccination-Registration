@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - View Event
@endsection

@section('header')
<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/smoothness/jquery-ui.css">
<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js" defer></script>
<script>
    var availableLots = {!! json_encode($lots) !!};
</script>
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
                        Event
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">View an Event</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">View an event for COVID-19 vaccination.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container-fluid">
        <div class="col-12">
            <div class="text-center mb-6">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="{{ $event->date_held < \Carbon\Carbon::today() ? '/events-history' : '/events' }}">
                    <span class="fas fa-arrow-left mr-1"></span>Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-lg-3 offset-lg-3">
                <div class="mb-8 mb-md-0">
                    <!-- Card -->
                    @can('update_event', Model::class)
                    <div class="collapse @if($errors->has('date') || $errors->has('title') || $errors->has('location')) show @endif" id="editCollapse">
                        @include('event.partials.editdetails', ['event' => $event])
                    </div>
                    @endcan
                    
                    <div class="card card-body p-6">
                        <div class="row align-items-center justify-content-center">
                            <div class="col-12 text-center mb-0">
                                <!-- Title -->
                                @can('update_event')
                                <div class="row justify-content-end">
                                    <a class="fad fa-edit text-info font-size-sm" data-toggle="collapse" href="#editCollapse" role="button" aria-expanded="false" aria-controls="editCollapse" title="Edit Event"></a>
                                    <a class="fad fa-cog text-secondary ml-2" href="/events/{{ $event->id }}/settings" title="Edit Event Settings"></a>
                                </div>
                                @endcan
                                <h2 class="mb-1 mt-2">
                                    {{ $event->title }}
                                </h2>

                                @can('delete_event')
                                <div class="row justify-content-center">
                                    <a class="badge badge-danger mb-2" role="button" data-toggle="modal" data-target="#cancelEvent">
                                        <span class="fal fa-ban mr-1"></span> Cancel Event
                                    </a>
                                </div>
                                @endcan

                                <div class="badge @if($event->partner_handled) badge-info-soft @elseif($event->open) badge-success-soft @else badge-danger-soft @endif mb-2">
                                    <span class="fad fa-calendar mr-1"></span> {{ $event->partner_handled ? $event->partners : ($event->open ? 'Scheduling Automatically' : 'Scheduling Closed') }}
                                </div>
                                
                                @can('update_event')
                                @if (!$event->open)
                                <form action="/events/{{ $event->id }}/open" method="post">
                                    @csrf
                                    @method("PUT")
                                    <button type="submit" class="btn btn-sm btn-outline-success">Open for Automatic Scheduling</button>
                                </form>
                                @else
                                <form action="/events/{{ $event->id }}/close" method="post">
                                    @csrf
                                    @method("PUT")
                                    <button type="submit" class="btn btn-sm btn-outline-dark">Close Automatic Scheduling</button>
                                </form>
                                @endif
                                @endcan

                                <p class="text-gray-dark mb-2">
                                    Date: {{ Carbon\Carbon::parse($event->date_held)->format('M d, Y') }}
                                </p>

                                @if($event->edittable)
                                <p class="text-muted mb-2 font-size-sm">
                                    Est. Registrations that Qualify: {{ $event->settings->estimate_count }}
                                </p>
                                @endif
                            </div>
                            <div class="col-12 text-center mb-0">
                                <div class="row align-items-center justify-content-center">
                                    <!-- Text -->
                                    <div class="col-12 text-center">
                                        <p class="h4">{{ $event->location->address }}</p>
                                        <p class="text-gray-dark mb-2">
                                            {{ $event->location->city . ', '. $event->location->state . ' '. $event->location->zip }}
                                        </p>
                                    </div>

                                    <div class="col-12">
                                        <p class="h4">Lot Numbers:</p>
                                        <p class="text-gray-dark" id="lot-numbers">
                                            {{ $event->lot_numbers }}
                                        </p>
                                        <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#lotModal">
                                            <span class="fad fa-plus"></span> Add Lot Numbers
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-3 mt-5 mt-lg-0">
                <div class="card my-auto">
                    <div class="card-body">
                        @can('update_event')
                        <div class="row justify-content-end px-4">
                            <a class="fal fa-plus text-success font-size-sm" href="#newSlotColl" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="newSlotColl" title="New Time Slot"></a>
                        </div>
                        @endcan

                        <h3 class="card-title">Slots</h3>

                        @can('update_event')
                        <div class="collapse card card-body mb-2 @if($errors->has('startTime') || $errors->has('slotLength') || $errors->has('slotCapacity')) show @endif" id="newSlotColl">
                            @include('event.partials.newslot', ['event' => $event])
                        </div>
                        @endcan

                        <div id="slotSection" class="list-group">
                            @foreach ($event->slots()->orderBy('starting_at', 'asc')->get() as $slot)
                                <li class="list-group-item list-group-item-action postition-relative">
                                    @include('event.partials.slot', ['slot' => $slot])
                                </li>
                            @endforeach
                        </div>
                        {{--<div class="col-12">
                            <div class="form-group mb-5">
                                <label for="comment">Add New Comment</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                            </div>
                        </div>
                        <div id="comment-error-text" class="text-danger text-right" role="alert" style="display: none;">
                            <strong id="commentError"></strong>
                        </div>
                        <button class="btn btn-info float-right" id="newComment" data-regis-id="{{ $registration->id }}">Add Comment</button>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@can('delete_event')
<!-- Cancellation Modal -->
<div class="modal fade" id="cancelEvent" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Event Cancellation Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fad fa-exclamation-triangle fa-5x text-danger"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="h3 text-gray-dark font-weight-md mb-5">Warning!</p>
                        <p class="text-gray-dark">Are you sure you wish to cancel this event?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Do Not Cancel</button>

                <form class="form-inline" action="/events/{{ $event->id }}" method="post">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-outline-danger">Cancel Event</button>
                </form>
            </div>        
        </div>
    </div>
</div>
@endcan

@include('event.partials.lotmodal', ['event' => $event, 'type' => 'ajax'])
@endsection