@component('mail::message')
# {{ $suffix ? $firstName.' '.$lastName.', '.$suffixDisplay : $firstName.' '.$lastName }}, you have chosen to postpone your vaccination appointment!

You have been placed back on the waiting list and will be contacted for our next available event.

@component('mail::button', ['url' => $actionUrl, 'color' => 'primary'])
{{ $actionText }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
