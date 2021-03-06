@component('mail::message')
# Reset your password

{{ $name }}, use this link to reset your password.

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

This link will expire in an hour: **{{ Carbon\Carbon::now()->addHour()->format('M d, Y g:i:s A') }}**

Some email services delay sending your email which may give you less time to respond to this reset link.

If the link does not work, be sure to check the expiration date above. If it has expired, you can delete this message and request another reset email.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
