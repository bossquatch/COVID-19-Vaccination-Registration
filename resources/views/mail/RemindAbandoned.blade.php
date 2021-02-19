@component('mail::message')
# {{ $name }}, you need to verify your email address to complete your registration.

@component('mail::panel')
<h1>Important</h1>
<p>It looks like you started a registration for the COVID-19 vaccine in our portal but did not complete it.</p>
<p>If you are still interested in receiving the COVID-19 vaccine, please complete your registration by using the button or link below.</p>
<p>If you are no longer interested in receiving the COVID-19 vaccine, no further action is required. Your account will be purged on February 26, 2021.</p>
@endcomponent

@component('mail::button', ['url' => $url])
{{ $actionText }}
@endcomponent

<p>If you have questions or need assistance in completing your registration please reach out to us here at the call center.</p>
<h4>Call Center: (863) 298-7500</h4>

Thanks,

{{ config('app.name') }}

@component('mail::subcopy')
If you’re having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below into your web browser: {{ $url }}
@endcomponent

@endcomponent
