@component('mail::message')
# {{ $registration->suffix_id ? $registration->first_name.' '.$registration->last_name.', '.$registration->suffix->display_name : $registration->first_name.' '.$registration->last_name }}, you have an Appointment!

You have been scheduled for an appointment for your COVID-19 vaccination!  Your appointment is at {{ $location->address . ' ' . $location->city . ', ' . $location->state . ' ' . $location->zip }}.  Your appointment is between {{ \Carbon\Carbon::parse($slot->starting_at)->format('h:iA') . '-' . \Carbon\Carbon::parse($slot->ending_at)->format('h:iA') }}.  Please do not arrive early or late to avoid backing up traffic.

Please log into the COVID-19 vaccination registration website to accept your appointment.  This offer will expire at {{ $expires }}.

@component('mail::button', ['url' => 'https://register.polk.health/home'])
Log into the Website
@endcomponent

Remember, you will need to bring proof of Florida residency to your appointment.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
