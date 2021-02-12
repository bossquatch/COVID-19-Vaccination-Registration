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
<img src="data:image/png;base64, {!! base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(100)->generate('QrCode as PNG image!')) !!}">

Remember, proof of Florida residency is ***required*** at your appointment.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
