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
                        {{--@can('create_event')
                        <button class="btn btn-success btn-sm float-right" onclick="eventForm('')"><span class="fad fa-plus-circle mr-1"></span>Add</button>    
                        @endcan--}}
                    </li>
                    {{--@can('create_event')
                        <li class="list-group-item" id="event-row-new" @if ($errors->isEmpty()) style="display: none;" @endif>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <strong>New Event</strong>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="eventForm('none')"><span class="fal fa-times mr-1"></span>Cancel</button>
                                </div>
                            </div>
                            @include('event.partials.form')
                        </li>    
                    @endcan--}}
                    
                    @foreach ($events as $event)
                        <li class="list-group-item list-group-item-light">
                            <div class="d-flex w-100 justify-content-between">
                                <h4 class="h5 mb-1">{{ $event->title }}</h5>
                                <small>{{ $event->percent_filled }} scheduled</small>
                            </div>
                            <div class="d-flex w-100 justify-content-between">
                                <div class="d-inline">
                                    <p class="mb-0 font-size-xs text-muted">{{ $event->date_held }} from {{ \Carbon\Carbon::parse($event->start_time)->format('h:i A') . ' to ' . \Carbon\Carbon::parse($event->end_time)->format('h:i A') }}</p>
                                    <p class="my-0 font-size-xs text-muted">{{ $event->open ? 'Automatic Scheduling' : 'Closed Scheduling Only' }}</p>
                                </div>
                                
                                {{--@can('delete_event')
                                    <a class="text-danger" href="#" onclick="deleteModal('{{ $event->id }}')"><span class="fad fa-trash-alt"></span><span class="sr-only">Delete</span></a>
                                @endcan--}}
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

{{--@can('delete_event')
<div class="modal fade" id="deleteModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="event Delete Modal" aria-hidden="true">
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
                        <p class="text-gray-dark mb-0">Are you sure you wish to delete this event?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <form class="form-inline" id="deleteEventForm" action="/events/" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Event</button>
                </form>
            </div>        
        </div>
    </div>
</div>

<script>
    function deleteModal(eventId) {
        document.getElementById('deleteEventForm').action = '/events/' + eventId;
        $('#deleteModal').modal('show');
        return false;
    }
</script>
@endcan

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

        $(".lot-input").autocomplete({
            source: availableLots
        });
    });

    function valToHour(val) {
        var ampm = "AM";
        var time = ":00";

        if(val == 0) {
            time = "12" + time;
        } else if(val == 12) {
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
</script>
@endcan--}}
@endsection