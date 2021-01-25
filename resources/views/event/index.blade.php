@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Events
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
                <a class="btn btn-header btn-round btn-lg" href="/manage">
                    <span class="fad fa-arrow-left mr-1"></span> Back
                </a>
                
                <a class="btn btn-header btn-round btn-lg" href="/locations">
                    <span class="fad fa-map-marker-alt mr-1"></span>Locations
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <ul class="list-group" id="events-list">
                    <li class="list-group-item active">
                        <h3 class="h4 d-inline align-text-top">Upcoming Event List</h3>
                        <a href="/events-history" class="ml-2 text-white align-bottom font-italic">View History</a>
                        @can('create_event')
                        <button class="btn btn-success btn-sm float-right" onclick="eventForm('')"><span class="fad fa-plus-circle mr-1"></span>Add</button>    
                        @endcan
                    </li>
                    @can('create_event')
                        <li class="list-group-item" id="event-row-new" @if ($errors->isEmpty()) style="display: none;" @endif>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <strong>New Event</strong>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="eventForm('none')"><span class="fal fa-times mr-1"></span>Cancel</button>
                                </div>
                            </div>
                            @include('event.partials.form')
                        </li>    
                    @endcan
                    
                    @foreach ($events as $event)
                        <li class="list-group-item list-group-item-light">
                            <div class="d-flex w-100 justify-content-between">
                                <h4 class="h5 mb-1">{{ $event->title }}</h4>
                                <small>{{ $event->percent_filled }} scheduled</small>
                            </div>
                            <div class="d-flex w-100 justify-content-between">
                                <div class="d-inline">
                                    <p class="mb-0 font-size-xs text-muted">{{ $event->date_held }} from {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') . ' to ' . \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
                                    <p class="my-0 font-size-xs @if($event->open) text-success @else text-danger @endif">{{ $event->open ? 'Scheduling Automatically' : 'Scheduling Closed' }}</p>
                                </div>
                                <div class="text-right">
                                    @can('update_invite')
                                        @if ($event->has_pending_callbacks)
                                            <a class="text-warning" href="/events/{{ $event->id }}/pending" title="Registrations waiting for callback!"><span class="fad fa-bell-exclamation"></span><span class="sr-only">Pending Callbacks</span></a>   
                                        @endif
                                    @endcan

                                    @can('update_event')
                                        <a class="text-info" href="/events/{{ $event->id }}" title="Event Details"><span class="fad fa-eye"></span><span class="sr-only">Event Details</span></a>
                                    @endcan
                                </div>
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

@can('create_event')
<script type="text/javascript">
    $( function() {
        document.getElementById('slider-time').innerHTML = valToHour(document.getElementById('start').value);
        document.getElementById('slider-time2').innerHTML = valToHour(document.getElementById('end').value);

        $('#slider').slider({
            range: true,
            min: 0,
            max: 23,
            step: 1,
            values: [document.getElementById('start').value, document.getElementById('end').value],
            slide: function (e, ui) {
                document.getElementById('start').value = ui.values[0];
                document.getElementById('slider-time').innerHTML = valToHour(ui.values[0]);
                document.getElementById('end').value = ui.values[1];
                document.getElementById('slider-time2').innerHTML = valToHour(ui.values[1]);
            }
        });

        $(".lot-input")      
            // don't navigate away from the field on tab when selecting an item
            .on( "keydown", function( event ) {
                if ( event.keyCode === $.ui.keyCode.TAB &&
                    $( this ).autocomplete( "instance" ).menu.active ) {
                event.preventDefault();
                }
            })
            .autocomplete({
                minLength: 0,
                source: function( request, response ) {
                    // delegate back to autocomplete, but extract the last term
                    response( $.ui.autocomplete.filter(
                        availableLots, extractLast( request.term ) ) );
                },
                focus: function() {
                    // prevent value inserted on focus
                    return false;
                },
                select: function( event, ui ) {
                    var terms = split( this.value );
                    // remove the current input
                    terms.pop();
                    // add the selected item
                    terms.push( ui.item.value );
                    // add placeholder to get the comma-and-space at the end
                    terms.push( "" );
                    this.value = terms.join( ", " );
                    return false;
                }
            });
    });

    function valToHour(val) {
        var ampm = "AM";
        var time = ":00";

        if(val == 0) {
            time = "12" + time;
        } else if(val == 12) {
            time = val + time
            ampm = "PM";
        } else if(val > 12) {
            time = (val - 12) + time;
            ampm = "PM";
        } else {
            time = val + time;
        }

        return time + ampm;
    }

    function eventForm(display) {
        document.getElementById('event-row-new').style.display = display;
    }

    function split( val ) {
      return val.split( /,\s*/ );
    }

    function extractLast( term ) {
      return split( term ).pop();
    }
</script>
@endcan
@endsection