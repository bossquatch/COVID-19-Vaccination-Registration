<div class="{{ $css ?? '' }}">
    {{ Illuminate\Mail\Markdown::parse($slot) }}
</div>
