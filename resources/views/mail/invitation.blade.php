@component('mail::message')
# {{ $suffix ? $firstName.' '.$lastName.', '.$suffixDisplay : $firstName.' '.$lastName }}, you have an appointment!

Please log into the COVID-19 vaccination registration website to accept your appointment.<br>

This offer will expire:

@component('mail::code')
<span class="token yellow">{{ $invitationExpires }}</span>
@endcomponent

<p style="margin-bottom: 0;">
@component('mail::button', ['url' => $actionUrl, 'color' => 'primary'])
{{ $actionText }}
@endcomponent
</p>

Remember, proof of Florida residency is ***required*** at your appointment.

Thanks,<br>
{{ config('app.name') }}

@component('mail::subcopy')
If you’re having trouble clicking the "{{ $actionText }}" button, copy and paste the URL into your web browser:
[{{ $actionUrl }}]({{ $actionUrl }})
@endcomponent
@endcomponent
