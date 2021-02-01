@component('mail::message')
# Reminder - You have an upcoming event

This is just to remind you that you have an upcoming event.

@component('mail::button', ['url' => 'https://dev.register.polk.health/home','color' => 'success'])
    Login to your account
@endcomponent

@endcomponent
