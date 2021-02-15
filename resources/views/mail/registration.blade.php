@component('mail::message')
# {{ $registration->suffix_id ? $registration->first_name.' '.$registration->last_name.', '.$registration->suffix->display_name : $registration->first_name.' '.$registration->last_name }}, your Polk COVID-19 Vaccine registration is complete

We will contact you soon with your appointment details.

Your registration code is:
**{{ $registration->code }}**

Thanks,<br>
{{ config('app.name') }}
@endcomponent
