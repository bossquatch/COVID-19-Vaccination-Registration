@component('mail::message')
# Reset your password

{{ $name }}, use this link to reset your password. This link will expire in one hour.

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
