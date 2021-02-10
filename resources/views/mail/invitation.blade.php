@component('mail::message')
# {{ $suffixId ? $firstName.' '.$lastName.', '.$suffix : $firstName.' '.$lastName }}, you have an appointment!

You have been scheduled for an appointment for your COVID-19 vaccination. Your appointment is at **{{ $locationName.' in '.$locationCity.', '.$locationState }}** ({{ $locationAddress.', '.$locationCity.', '.$locationState.' '.$locationZip }}).

Your appointment is scheduled for **{{ $slotStart.' to '.$slotEnd }}**.

Please log into the COVID-19 vaccination registration website to accept your appointment. This offer will expire **{{ $invitationExpires }}**.

@component('mail::button', ['url' => {{ config('app.url') }}])
    Login
@endcomponent

Remember, proof of Florida residency is ***required*** at your appointment.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
