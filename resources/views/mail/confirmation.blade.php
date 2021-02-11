@component('mail::message')
# {{ $suffix ? $firstName.' '.$lastName.', '.$suffixDisplay : $firstName.' '.$lastName }}, you are confirmed for your vaccination appointment!

Here are your appointment details:

@component('mail::code')
<span class="token string">{{ $locationName }}</span><br>
<span class="token punctuation">{{ $apptDate }}</span><br>
{{ $locationAddress }}<br>
{{ $locationCity.', '.$locationState.' '.$locationZip }}
@endcomponent

**Show this QR code at check-in:**

{{-- SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->merge('https://cdn.polk.design/images/polk-logo-email.png', 0.3, true)->generate('test') --}}
<img src="{!!$message->embedData(QrCode::format('png')->generate('Embed me into an e-mail!'), 'QrCode.png', 'image/png')!!}">

Remember, proof of Florida residency is ***required*** at your appointment.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
