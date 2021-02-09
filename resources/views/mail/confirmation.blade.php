@component('mail::message')
# {{ $userName }}, you are confirmed for your vaccination appointment

Here are your appointment details:

@component('mail::panel')
**Location:** Legoland, 1 Legoland Way, Winter Haven, FL 33884

**Date/Time:** February 12, 2021, 8:30 AM
@endcomponent

<div class="text-center" markdown="1">
**Show this QR code at the check in**
</div>

<div class="text-center">
    <img src="{{ env('CDN_URL') .'/images/qr-code-doug.png' }}">
</div>

**If you need to check your status**<br>

@component('mail::button', ['url' => 'https://dev.register.polk.health/home','color' => 'power'])
    Login to your account
@endcomponent

Or contact our call center at <a href="tel:1-863-298-7500">(863) 298-7500</a><br>

Remember, proof of Florida residency is ***required*** at your appointment.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
