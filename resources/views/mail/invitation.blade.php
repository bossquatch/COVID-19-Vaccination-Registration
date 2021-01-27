@component('mail::message')
# Your invitation to our vaccination event

Please login and either accept your invitation or decline if you are not able or willing to attend.

Due to limited supply and overwhelming response to this campaign, this invitation will expire three hours from when it was sent. Once expired, you will be placed back into the system and offered an invitation at a later date.

@component('mail::button', ['url' => 'https://dev.register.polk.health','color' => 'primary'])
    Click to login to your account
@endcomponent

@endcomponent
