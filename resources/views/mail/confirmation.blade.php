@component('mail::message')
# {{ $userName }}, you are confirmed for your vaccination appointment

You have been confirmed for your COVID-19 vaccination appointment.  Here are you appointment details:

@component('mail::panel')
**Location:**
Legoland
1 Legoland Way, Winter Haven, FL 33884

**Date/Time:**
February 12, 2021, 8:30 AM
@endcomponent

<div class="text-center">
    **Show this QR code at the check in**
    <img src="{{ env('CDN_URL') .'/images/qr-code-doug.png' }}">
</div>

**If you need to check your status**
@component('mail::button', ['url' => 'https://dev.register.polk.health/home','color' => 'doug'])
    Login to your account
@endcomponent

Remember, proof of Florida residency is ***required*** at your appointment.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
