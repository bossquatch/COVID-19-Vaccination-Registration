<option selected>Choose Slot...</option>
@foreach ($slots as $slot)
    <option value="{{ $slot->id }}" data-id="{{ $slot->id }}">{{ \Carbon\Carbon::parse($slot->starting_at)->format('h:iA') . '-' . \Carbon\Carbon::parse($slot->ending_at)->format('h:iA') }} - {{ $slot->stock }} seats left</option>
@endforeach