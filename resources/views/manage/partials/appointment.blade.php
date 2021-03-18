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
                                    Appointment Time:<br>{{ \Carbon\Carbon::parse($registration->pending_invitation->event->date_held)->format('M d, Y') . ' ' . \Carbon\Carbon::parse($registration->pending_invitation->slot->starting_at)->format('h:iA') }}
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

                                <form action="/manage/{{ $registration->id }}/invitation/accept" class="form mb-3 justify-content-center" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-success" aria-describedby="acceptInfo">Accept</button>
                                    <br><p id="acceptInfo" class="form-text font-weight-light font-size-xs text-muted">I accept this invitation.</p>
                                </form>
                                <form action="/manage/{{ $registration->id }}/invitation/postpone" class="form mb-3 justify-content-center" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-warning" aria-describedby="postponeInfo">Decline</button>
                                    <br><p id="postponeInfo" class="form-text font-weight-light font-size-xs text-muted">I cannot attend this event but would like to be considered for future events.</p>
                                </form>
                                <form action="/manage/{{ $registration->id }}/invitation/decline" class="form mb-3 justify-content-center" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-outline-danger" aria-describedby="declineInfo">Remove Registration</button>
                                    <br><p id="declineInfo" class="form-text font-weight-light font-size-xs text-muted">I am no longer interested in receiving a vaccination through this program.</p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                @include('manage.partials.invitations', ['registration' => $registration])
            </div>
        </div>
    @endcan
@elseif($registration->has_appointment)
    <div class="col-12 col-lg-3">
        <div class="mb-8 mb-md-0">
            <div class="card mb-2">
                <div class="card-body p-6">
                    <div class="row">
                        <div class="col-12 d-flex align-items-center">
                            <span class="text-info fad fa-calendar fa-5x mx-auto"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12 text-center">
                            @if ($registration->active_invite->invite_status->name == "Accepted")
                                <h2 class="h4 mb-1">Next Appointment</h2>
                            @else
                                <h2 class="h4 mb-1">Current Appointment</h2>
                            @endif
                            <p class="text-gray-dark mb-2">
                                Appointment Time:<br>{{ \Carbon\Carbon::parse($registration->appointment->event->date_held)->format('M d, Y') . ' ' . \Carbon\Carbon::parse($registration->appointment->starting_at)->format('h:iA') . '-' . \Carbon\Carbon::parse($registration->appointment->ending_at)->format('h:iA') }}
                            </p>
                            <p class="text-gray-dark mb-2">
                                Location:<br>{{ $registration->appointment->event->location->address . ' ' . $registration->appointment->event->location->city . ', ' . $registration->appointment->event->location->state . ' ' . $registration->appointment->event->location->zip }}
                            </p>
                            
                            @can('check_in')
                            @if ($registration->active_invite->invite_status->name == "Accepted")
                                <form action="/manage/{{ $registration->id }}/invitation/checkin" class="form-inline mb-1 justify-content-center" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-info" @if (\Carbon\Carbon::parse($registration->active_invite->event->date_held)->notEqualTo(\Carbon\Carbon::today())) disabled aria-disabled="true" title="Can only check into event on the day of the event!" @endif>Check In</button>
                                </form>
                            @else
                                <div class="row justify-content-center mb-2">
                                    <span class="badge badge-pill badge-info">{{ $registration->active_invite->invite_status->name }}</span>
                                </div>    

                                <form action="/manage/{{ $registration->id }}/invitation/complete" class="form-inline mb-1 justify-content-center" method="post">
                                    @csrf
                                    <button type="submit" class="btn btn-success">Check Out</button>
                                </form>
                            @endif

                            <form action="/manage/{{ $registration->id }}/invitation/turndown" class="form-inline mb-1 justify-content-center" method="post">
                                @csrf
                                <button type="submit" class="btn btn-danger">Turned Down</button>
                            </form>
                            @endcan
                        </div>
                    </div>
                </div>
            </div>
            @include('manage.partials.invitations', ['registration' => $registration])
        </div>
    </div>
@else
    @can('keep_inventory')
        <div class="col-12 col-lg-3">
            <div class="mb-8 mb-md-0">
                @include('manage.partials.invitations', ['registration' => $registration])
            </div>
        </div>
    @endcan
@endif