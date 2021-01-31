@component('mail::message')
# You have chosen to postpone your vaccination invitation

There is no further action that you need to take.  Your registration has been placed back on the wait list and you will be contacted for our next event.

@component('mail::button', ['url' => 'https://dev.register.polk.health/home','color' => 'primary'])
    Login to your account
@endcomponent

@endcomponent
