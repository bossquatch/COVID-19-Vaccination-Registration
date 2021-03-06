@component('mail::message')
# {{ $name }}, do not reply to this email. Simply click the link below to verify your email address.

@component('mail::panel')
	<h1>Why do we do this?</h1>
	<p>So that we know that we are sending information to the right person.</p>
	<p>Just click the button below, then complete your registration.</p>
@endcomponent

@component('mail::button', ['url' => $url])
	{{ $actionText }}
@endcomponent

Thanks,

{{ config('app.name') }}

@component('mail::subcopy')
If you’re having trouble clicking the "{{ $actionText }}" button, copy and paste the URL below into your web browser: {{ $url }}
@endcomponent

@endcomponent
