@component('mail::message')
# There has been a change to your event

Your appointment has been changed at blah

@component('mail::button', ['url' => 'https://dev.register.polk.health/home','color' => 'doug'])
    Login to your account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
