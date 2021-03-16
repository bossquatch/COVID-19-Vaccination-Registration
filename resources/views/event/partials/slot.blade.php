<div class="d-flex w-100 justify-content-between">
    <a href="/events/{{ $slot->event_id }}/slots/{{ $slot->id }}" class="h5 mb-1">{{ \Carbon\Carbon::parse($slot->starting_at)->format('h:iA') . '-' . \Carbon\Carbon::parse($slot->ending_at)->format('h:iA') }}</a>
        @if ($slot->capacity > $slot->scheduled_count)
        <span class="font-size-xs"><span class="fad fa-calendar text-muted mr-1"></span>Scheduling...</span>
        @else
        <span class="font-size-xs"><span class="fad fa-badge-check text-success mr-1"></span>Scheduled</span>
        @endif
</div>
<div class="d-flex w-100 justify-content-between">
    <div class="d-inline">
        <p class="mb-0 font-size-xs text-muted">Total Capacity: {{ $slot->capacity }}</p>
        <p class="my-0 font-size-xs text-muted">Total Invites: {{ $slot->active_invitation_count }}</p>
        <p class="my-0 font-size-xs text-muted">Total Scheduled: {{ $slot->scheduled_count }}</p>
        <p class="my-0 font-size-xs text-muted">Amount Awaiting Callback: {{ $slot->callback_count }}</p>
        @if ($slot->reserved > 0)
        <p class="my-0 font-size-xs text-muted">Total Reserved: {{ $slot->reserved }}</p>
        @endif
    </div>
</div>
<div class="d-flex w-100 justify-content-between">
    <div class="w-100">
        <p class="mb-0 font-size-sm text-black font-weight-bold">Check In Breakdown</p>
        <progress class="mb-2 w-100" value="{{ $slot->checked_in }}" max="{{ $slot->to_check_in + $slot->checked_in }}"></progress>

        <div class="row justify-content-center">
            <div class="col-12 col-lg-4">
                <div class="card card-body p-2 mb-2 position-relative">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <!-- Title -->
                            <div class="w-100"><a href="/events/{{ $slot->event_id }}/slots/{{ $slot->id }}?tocheck=1" class="stretched-link initialism font-size-xs text-uppercase text-gray-dark mb-1">Check Ins Left</a></div>
                            <!-- Value -->
                            <span class="h6 mb-0">{{ number_format($slot->to_check_in,0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card card-body p-2 mb-2 position-relative">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <!-- Title -->
                            <div class="w-100"><a href="/events/{{ $slot->event_id }}/slots/{{ $slot->id }}?checkedin=1" class="stretched-link initialism font-size-xs text-uppercase text-gray-dark mb-1">Checked In</a></div>
                            <!-- Value -->
                            <span class="h6 mb-0">{{ number_format($slot->checked_in, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 col-lg-4">
                <div class="card card-body p-2 mb-2 position-relative">
                    <div class="row align-items-center">
                        <div class="col-auto">
                            <!-- Title -->
                            <div class="w-100"><a href="/events/{{ $slot->event_id }}/slots/{{ $slot->id }}" class="stretched-link initialism font-size-xs text-uppercase text-gray-dark mb-1">Total</a></div>
                            <!-- Value -->
                            <span class="h6 mb-0">{{ number_format($slot->checked_in + $slot->to_check_in, 0) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>