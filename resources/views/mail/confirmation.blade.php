@component('mail::message')
# {{ $userName }}, you are confirmed for your vaccination appointment

You have been confirmed for your COVID-19 vaccination appointment.  Your appointment is at **Legoland in Winter Haven, FL** (1 Legoland Way, Winter Haven, FL 33884).  Your appointment time is **8:30 AM**.

<div class="text-center">
    <img src="{{ env('CDN_URL') .'/images/qr-code-doug.png' }}">
</div>

@component('mail::button', ['url' => 'https://dev.register.polk.health/home','color' => 'doug'])
    Login to your account
@endcomponent

Remember, proof of Florida residency is ***required*** at your appointment.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
