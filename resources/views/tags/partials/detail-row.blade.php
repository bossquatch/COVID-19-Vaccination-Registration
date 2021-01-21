<div class="row">
    <div class="col-3">
        <span class="py-1">@include('tags.partials.badge', ['tag' => $tag])</span>
    </div>
    <div class="col-6">
        <span class="py-1">{{ $tag->description }}</span>
    </div>
    <div class="col-3">
        <button class="btn btn-link py-1" onclick="editTag({{ $tag->id }})">Edit</button>
        <button class="btn btn-link py-1" onclick="deleteTag({{ $tag->id }})">Delete</button>
    </div>
</div>