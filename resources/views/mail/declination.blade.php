@component('mail::message')
# You have declined your invitation

You have declined your invitation to any of our events and will not be contacted again for further appointments. If you would like to be placed back on the wait list at a later time please contact our call center at (863) 298-7500.

@component('mail::button', ['url' => 'https://dev.register.polk.health/home','color' => 'doug'])
    Login to your account
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
