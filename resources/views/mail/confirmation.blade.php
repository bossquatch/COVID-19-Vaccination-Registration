@component('mail::message')
# {{ $userName }}, you are confirmed for your vaccination appointment

You have been confirmed for your COVID-19 vaccination appointment.  Here are you appointment details:

@component('mail::panel')
**Location:** Legoland, 1 Legoland Way, Winter Haven, FL 33884

**Date/Time:** February 12, 2021, 8:30 AM
@endcomponent

**Show this QR code at the check in**<br>

<div class="text-center">
    <img src="{{ env('CDN_URL') .'/images/qr-code-doug.png' }}">
</div>
<br>
**If you need to check your status**
<br>
@component('mail::button', ['url' => 'https://dev.register.polk.health/home','color' => 'doug'])
    Login to your account
@endcomponent

<br>
Or contact our call center at <a href="tel:1-863-298-7500">(863) 298-7500</a>
<br>

Remember, proof of Florida residency is ***required*** at your appointment.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
