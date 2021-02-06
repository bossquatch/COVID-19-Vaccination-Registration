@component('mail::message')
# You have an invitation available to an upcoming event

Please login and accept your invitation to the COVID-19 vaccination event.

@component('mail::button', ['url' => config('app.url') . '/home','color' => 'success'])
    Login to your account
@endcomponent

@endcomponent
