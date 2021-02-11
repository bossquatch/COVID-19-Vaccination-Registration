@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
<img scr="{{ config('app.cdn_url') }}/images/florida-doh-polk-logo-email.png" class="logo" alt="Florida Department of Health Polk County Logo">
@endcomponent
@endslot

{{-- Body --}}
{{ $slot }}

{{-- Subcopy --}}
@isset($subcopy)
@slot('subcopy')
@component('mail::subcopy')
{{ $subcopy }}
@endcomponent
@endslot
@endisset

{{-- Footer --}}
@slot('footer')
@component('mail::footer')
© {{ date('Y') }} {{ config('app.organization') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
