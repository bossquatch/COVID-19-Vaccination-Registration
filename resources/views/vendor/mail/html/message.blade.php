@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
@if(config('mail.logo'))
<img scr="{{ url(config('mail.logo')) }}" class="logo" alt="Florida Department of Health Polk County Logo">
@else
{{ config('app.name') }}
@endif
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
