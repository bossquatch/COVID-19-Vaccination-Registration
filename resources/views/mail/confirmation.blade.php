@component('mail::message')
# {{ $suffix ? $firstName.' '.$lastName.', '.$suffixDisplay : $firstName.' '.$lastName }}, you are confirmed for your vaccination appointment!

Here are your appointment details:

@component('mail::code')
<span class="token green">{{ $locationName }}</span><br>
<span class="token light-blue">{{ $apptDate }}</span><br>
{{ $locationAddress }}<br>
{{ $locationCity.', '.$locationState.' '.$locationZip }}
@endcomponent

<div class="text-center">
<p class="text-center">Your registration code is:</p>
{!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->generate(config('app.url').'/'.$userId.'/'.$regId.'/'.$code.'?checkin=auto'); !!}
<p class="h2 text-center">{{ $code }}</p>
</div>

For quick check-in, log into the COVID-19 vaccination registration website and show your QR Code.

@component('mail::button', ['url' => $actionUrl, 'color' => 'primary'])
{{ $actionText }}
@endcomponent

Remember, proof of Florida residency is ***required*** at your appointment.

{!! $message !!}

Thanks,<br>
{{ config('app.name') }}
@endcomponent
