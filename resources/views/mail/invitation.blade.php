@component('mail::message')
# Douglas, you have an appointment!

You have been scheduled for an appointment for your COVID-19 vaccination.  Your appointment is at **Legoland in Winter Haven, FL** (1 Legoland Way, Winter Haven, FL 33884).  Your appointment is scheduled for **8:30 AM**.

Please log into the COVID-19 vaccination registration website to accept your appointment.  This offer will expire **February 10, 2021 at 12:00PM**.

@component('mail::button', ['url' => 'https://register.polk.health/home'])
    Log into the Website
@endcomponent

Remember, proof of Florida residency is ***required*** at your appointment.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
