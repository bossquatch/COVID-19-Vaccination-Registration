@php
    list($r, $g, $b) = sscanf($tag->color ?? '#6c8aec', "#%02x%02x%02x");
@endphp
<span class="badge badge-pill js-user-tag" style="color: {{ $tag->color ?? '#6c8aec' }}; background-color: rgba({{ $r . ',' . $g . ',' . $b }},0.2); border: 1px solid {{ $tag->color ?? '#6c8aec' }}" data-label="{{ $tag->label }}">{{ $tag->label }}</span>
