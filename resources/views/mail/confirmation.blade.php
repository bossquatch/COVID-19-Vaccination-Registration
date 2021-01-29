@component('mail::message')
# You are confirmed for your vaccination appointment

Your appointment has been confirmed at blah

@component('mail::button', ['url' => 'https://dev.register.polk.health/home','color' => 'doug'])
    Login to your account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
