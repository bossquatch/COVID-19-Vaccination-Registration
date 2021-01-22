@extends('layouts.app')

@section('title')
    Admin Console
@endsection

@section('header')
<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/css/bootstrap-colorpicker.min.css" rel="stylesheet">
@endsection

@section('content')
<!-- Header -->
<div class="jumbotron jumbotron-fluid jumbotron-header bg-squares teal-gradient">
    <div class="container position-relative z-1">
        <div class="row">
            <div class="col-12">
                <!-- Badge -->
                <span class="badge badge-pill badge-white-teal mb-3">
                    <span class="h6 text-uppercase">
                        Admin
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">Tags Panel</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Modify user tags in your system.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="text-center mb-6">
                    <!-- Button -->
                    <a class="btn btn-header btn-round btn-lg" href="/admin">
                        <span class="fad fa-arrow-left mr-1"></span> Back
                    </a>
                </div>
            </div>
            <div class="col-12">
                <ul class="list-group" id="tags-list">
                    <li class="list-group-item active">
                        <strong class="btn btn-link disabled text-white"><span id="tag-count">{{ $count }}</span> tags</strong>
                        <button class="btn btn-success float-right" onclick="showNewTagForm()"><span class="fad fa-plus-circle mr-1"></span>New Tag</button>
                    </li>
                    <li class="list-group-item" id="tag-row-new" style="display: none;">
                        <div class="row">
                            <div class="col-12">
                                <strong>New Tag</strong>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 form-group">
                                <label for="tag-label-new">Label</label>
                                <input type="text" class="form-control" id="tag-label-new" placeholder="Enter tag label">
                                <span class="invalid-feedback js-error-text-new" role="alert" style="display: none;">
                                    <strong id="tag-label-new-error"></strong>
                                </span>
                            </div>
                            <div class="col-6">
                                <label for="tag-description-new">Description</label>
                                <input type="text" class="form-control" id="tag-description-new" placeholder="Enter tag description">
                                <span class="invalid-feedback js-error-text-new" role="alert" style="display: none;">
                                    <strong id="tag-description-new-error"></strong>
                                </span>
                            </div>
                            <div class="col-3">
                                <label for="tag-color-new">Color</label>
                                <input type="text" class="form-control" id="tag-color-new" placeholder="Enter tag color">
                                <span class="invalid-feedback js-error-text-new" role="alert" style="display: none;">
                                    <strong id="tag-color-new-error"></strong>
                                </span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3 offset-9">
                                <button class="btn btn-primary" id="tagBtnnew" onclick="submitTag()">Submit</button>
                                <button id="tagLoadingBtnnew" type="button" class="btn btn-secondary btn-block" disabled aria-disabled="true" style="display: none">
                                    <span class="fad fa-spinner fa-spin"></span>
                                </button>
                            </div>
                        </div>
                    </li>
                    @foreach ($tags as $tag)
                        <li class="list-group-item" id="tag-row-{{ $tag->id }}">
                            @include('tags.partials.detail-row', ['tag' => $tag])
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</section>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-colorpicker/2.5.3/js/bootstrap-colorpicker.min.js" defer></script>
<script>
$(function () {
    $('#tag-color-new').colorpicker();
});

function showNewTagForm() {
    document.getElementById("tag-row-new").style.display = '';
    clearInput('new');
}

function submitChanges(id) {
    loading(true, id);
    clearErrors(id);

    var postInfo = requestInfo(id);

    $.post('/admin/tags/'+id, postInfo, function(data) {
        loading(false, id);
        if (data.status == 'success') {
            document.getElementById('tag-row-'+id).innerHTML = data.html;
        } else {
            showErrors(data.errors, id);
        }
    }, 'json');
}

function submitTag() {
    loading(true, 'new');
    clearErrors('new');

    var postInfo = requestInfo('new');

    $.post('/admin/tags', postInfo, function(data) {
        loading(false, 'new');
        if (data.status == 'success') {
            //document.getElementById('tag-row-'+id).innerHTML = data.html;
            document.getElementById('tags-list').innerHTML = document.getElementById('tags-list').innerHTML + data.html;
            document.getElementById('tag-count').innerHTML = data.count;
            clearInput('new');
            document.getElementById("tag-row-new").style.display = 'none';
        } else {
            showErrors(data.errors, 'new');
        }
    }, 'json');
}

function editTag(id) {
    $.get('/admin/tags/'+id+'/edit', function(data) {
        if (data.status == 'success') {
            //document.getElementById('tag-row-'+id).innerHTML = data.html;
            document.getElementById('tag-row-'+id).innerHTML = data.html;
            $('#tag-color-'+id).colorpicker();
        }
    }, 'json');
}

function deleteTag(id) {
    var postInfo = {
        '_token' : $('meta[name=csrf-token]').attr('content'),
        '_method' : 'DELETE',
    };

    $.post('/admin/tags/'+id, postInfo, function(data) {
        if (data.status == 'success') {
            //document.getElementById('tag-row-'+id).innerHTML = data.html;
            document.getElementById('tag-row-'+id).remove();
            document.getElementById('tag-count').innerHTML = data.count;
        }
    }, 'json');
}

function loading(is, id) {
    if (is) {
        document.getElementById("tagBtn" + id).style.display = 'none';
        document.getElementById("tagLoadingBtn" + id).style.display = '';
    } else {
        document.getElementById("tagBtn" + id).style.display = '';
        document.getElementById("tagLoadingBtn" + id).style.display = 'none';
    }
}

function requestInfo(id) {
    return {
        '_token' : $('meta[name=csrf-token]').attr('content'),
        'label' : document.getElementById('tag-label-' + id).value,
        'description' : document.getElementById('tag-description-' + id).value,
        'color' : document.getElementById('tag-color-' + id).value
    }
}

function clearInput(id) {
    document.getElementById('tag-label-' + id).value = null;
    document.getElementById('tag-description-' + id).value = null;
    document.getElementById('tag-color-' + id).value = null;
}

function showErrors(errors, id) {
    for (const prop in errors) {
        document.getElementById('tag-'+prop+'-'+id).classList.add('is-invalid');
        document.getElementById('tag-'+prop+'-'+id).classList.add('is-invalid-'+id);
        var errorDOM = document.getElementById('tag-'+prop+'-'+id+'-error');
        errorDOM.innerHTML = errors[prop][0];
        errorDOM.parentElement.style.display = '';
    }
}

function clearErrors(id) {
    var invalids = document.getElementsByClassName('is-invalid-'+id);
    var errorTexts = document.getElementsByClassName('js-error-text' + id);

    for (var i=0; i<invalids.length; i++) {
        invalids[i].classList.remove('is-invalid');
        invalids[i].classList.remove('is-invalid-'+id);
    }
    for (var i=0; i<errorTexts.length; i++) {
        errorTexts[i].style.display = 'none';
    }
}
</script>
@endsection