@foreach ($tags as $tag)
    @include('tags.partials.badge', ['tag' => $tag])
@endforeach