@component('mail::message')
# {{ $suffix ? $firstName.' '.$lastName.', '.$suffixDisplay : $firstName.' '.$lastName }}, you have an appointment!

You have been scheduled for an appointment for your COVID-19 vaccination. Your appointment is at:

@component('mail::panel')
{{ $locationName.'<br>'.$locationAddress.'<br>'.$locationCity.', '.$locationState.' '.$locationZip }}
@endcomponent

Your appointment is scheduled for:

@component('mail::panel')
{{ $apptDate }}
@endcomponent

Please log into the COVID-19 vaccination registration website to accept your appointment. This offer will expire **{{ $invitationExpires }}**.

@component('mail::button', ['url' => $actionUrl, 'color' => 'primary'])
{{ $actionText }}
@endcomponent

Remember, proof of Florida residency is ***required*** at your appointment.

Thanks,<br>
{{ config('app.name') }}

@component('mail::subcopy')
If you’re having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below into your web browser:
[{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endcomponent
