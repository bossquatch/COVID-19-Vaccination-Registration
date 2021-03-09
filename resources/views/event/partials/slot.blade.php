<div class="d-flex w-100 justify-content-between">
    <a href="/events/{{ $slot->event_id }}/slots/{{ $slot->id }}" class="stretched-link h5 mb-1">{{ \Carbon\Carbon::parse($slot->starting_at)->format('h:iA') . '-' . \Carbon\Carbon::parse($slot->ending_at)->format('h:iA') }}</a>
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