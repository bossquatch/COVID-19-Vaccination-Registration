<div class="row">
    <div class="col-3 offset-9">
        <button class="btn btn-link py-1" onclick="deleteTag({{ $tag->id }})">Delete</button>
    </div>
</div>
<div class="row">
    <div class="col-3 form-group">
        <label for="tag-label-{{ $tag->id }}">Label</label>
        <input type="text" class="form-control" id="tag-label-{{ $tag->id }}" value="{{ $tag->label }}" placeholder="Enter tag label">
        <span class="invalid-feedback js-error-text-{{ $tag->id }}" role="alert" style="display: none;">
            <strong id="tag-label-{{ $tag->id }}-error"></strong>
        </span>
    </div>
    <div class="col-6">
        <label for="tag-description-{{ $tag->id }}">Description</label>
        <input type="text" class="form-control" id="tag-description-{{ $tag->id }}" value="{{ $tag->description }}" placeholder="Enter tag description">
        <span class="invalid-feedback js-error-text-{{ $tag->id }}" role="alert" style="display: none;">
            <strong id="tag-description-{{ $tag->id }}-error"></strong>
        </span>
    </div>
    <div class="col-3">
        <label for="tag-color-{{ $tag->id }}">Color</label>
        <input type="text" class="form-control" id="tag-color-{{ $tag->id }}" value="{{ $tag->color }}" placeholder="Enter tag color">
        <span class="invalid-feedback js-error-text-{{ $tag->id }}" role="alert" style="display: none;">
            <strong id="tag-color-{{ $tag->id }}-error"></strong>
        </span>
    </div>
</div>
<div class="row">
    <div class="col-3 offset-9">
        <button class="btn btn-primary" id="tagBtn{{ $tag->id }}" onclick="submitChanges({{ $tag->id }})">Submit</button>
        <button id="tagLoadingBtn{{ $tag->id }}" type="button" class="btn btn-secondary btn-block" disabled aria-disabled="true" style="display: none">
            <span class="fad fa-spinner fa-spin"></span>
        </button>
    </div>
</div>

<script>
    $('#tag-color-{{ $tag->id }}').colorpicker();
</script>
