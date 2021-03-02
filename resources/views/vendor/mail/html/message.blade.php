@component('mail::layout')
{{-- Header --}}
@slot('header')
@component('mail::header', ['url' => config('app.url')])
@if(config('mail.logo'))
<img src="{{ config('mail.logo') }}" alt="{{ config('mail.logo_alt') }}">
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
<a href="{{ config('app.organization_url') }}" title="{{ config('app.organization') }}" class="logo">
<img src="{{ config('mail.organization_logo') }}" alt="{{ config('mail.organization_logo_alt') }}">
</a><br>
© {{ date('Y') }} {{ config('app.organization') }}. @lang('All rights reserved.')
@endcomponent
@endslot
@endcomponent
