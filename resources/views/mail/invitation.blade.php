@component('mail::message')
# {{ $registration->suffix_id ? $registration->first_name.' '.$registration->last_name.', '.$registration->suffix->display_name : $registration->first_name.' '.$registration->last_name }}, you have an appointment!

You have been scheduled for an appointment for your COVID-19 vaccination. Your appointment is at **{{ $registration->invitations->last()->slot->event->location->name.' in '.$registration->invitations->last()->slot->event->location->city.', '.$registration->invitations->last()->slot->event->location->state }}** ({{ $registration->invitations->last()->slot->event->location->address.', '.$registration->invitations->last()->slot->event->location->city.', '.$registration->invitations->last()->slot->event->location->state.' '.$registration->invitations->last()->slot->event->location->zip }}).

Your appointment is scheduled for **{{ $registration->invitations->last()->slot->starting_at.' to '.$registration->invitations->last()->slot->ending_at }}**.

Please log into the COVID-19 vaccination registration website to accept your appointment. This offer will expire **{{ $registration->invitations->last()->contacted_at->add(new DateInterval('PT'.config('app.invitation_expire').'H')) }}**. Expires in {{ config('app.invitation_expire') }} hours.

@component('mail::button', ['url' => {{ config('app.url').'/home' }}])
    Login
@endcomponent

Remember, proof of Florida residency is ***required*** at your appointment.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
