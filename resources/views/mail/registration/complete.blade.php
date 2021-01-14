@component('mail::message')
# {{ $registration->suffix_id ? $registration->first_name.' '.$registration->last_name.', '.$registration->suffix->display_name : $registration->first_name.' '.$registration->last_name }}, your Polk COVID-19 Vaccine Registration is Complete

Now all you need to do is wait for us to schedule you an appointment.  We will contact you with your appointment time and date.

Your registration code is:
**{{ $registration->code }}**

Thanks,<br>
{{ config('app.name') }}
@endcomponent
