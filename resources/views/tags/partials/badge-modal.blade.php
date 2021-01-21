<div class="modal fade" data-backdrop="static" id="tagsModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <div class="input-group mb-4">
                    <div class="input-group-prepend font-size-sm">
                        <span class="input-group-text text-primary">
                            <span class="fad fa-search"></span>
                        </span>
                    </div>
                    <input type="text" onkeyup="searchTags()" class="form-control font-size-sm" id="tagSearch" placeholder="Search Tags">
                </div>
            </div>
            <div class="modal-body">
                <input type="hidden" id="userId" value="">
                @foreach ($tags as $tag)
                    <div class="form-check js-tag-input" data-label="{{ $tag->label }}">
                        <input type="checkbox" class="tag-checkbox" id="tag-{{ $tag->id }}" value="{{ $tag->id }}">
                        <label class="form-check-label align-top" for="tag-{{ $tag->id }}">
                            @include('tags.partials.badge', ['tag' => $tag])
                            <br>
                            <small class="text-muted">{{ $tag->description }}</small>
                        </label>
                    </div>    
                @endforeach
            </div>
            <div class="modal-footer">
                <button id="tagLoadingBtn" type="button" class="btn btn-secondary btn-block" disabled aria-disabled="true" style="display: none">
                    <span class="fad fa-spinner fa-spin"></span>
                </button>
                <button id="tagBtn" type="button" class="btn btn-success btn-block" onclick="submitTags()">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
function editTags(userid) {
    clearInput();

    document.getElementById('userId').value = userid;

    var tagsCheckedRaw = document.getElementById('badge-row-'+userid).dataset.tags;
    if (tagsCheckedRaw != '') {
        var tagsChecked = tagsCheckedRaw.split('|');

        for(var i=0; i<tagsChecked.length; i++) {
            document.getElementById('tag-'+tagsChecked[i]).checked = true;
        }
    }

    $('#tagsModal').modal('show');
}

function submitTags() {
    loading(true);

    var postInfo = requestInfo();

    $.post('/admin/tags/sync', postInfo, function(data) {
        loading(false);
        if (data.status == 'success') {
            var badgeRow = document.getElementById('badge-row-'+data.user);
            badgeRow.innerHTML = data.html;
            badgeRow.dataset.tags = data.tags;
            clearInput();
            $('#tagsModal').modal('hide');
        }
    }, 'json');
}

function searchTags() {
    // Declare variables
    var input, filter, cards, label, i;
    input = document.getElementById("tagSearch");
    filter = input.value.toUpperCase();
    cards = document.getElementsByClassName("js-tag-input");

    // Loop through all list items, and hide those who don't match the search query
    for (i = 0; i < cards.length; i++) {
        label = cards[i].dataset.label;
        if (label.toUpperCase().indexOf(filter) > -1) {
            cards[i].style.display = "";
        } else {
            cards[i].style.display = "none";
        }
    }
}

function loading(is) {
    if (is) {
        document.getElementById("tagBtn").style.display = 'none';
        document.getElementById("tagLoadingBtn").style.display = '';
    } else {
        document.getElementById("tagBtn").style.display = '';
        document.getElementById("tagLoadingBtn").style.display = 'none';
    }
}

function getTags() {
    var checkboxes = document.getElementsByClassName('tag-checkbox');
    var checked = [];
    for (var i=0; i<checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checked.push(checkboxes[i].value);
        }
    }
    return checked;
}

function clearInput() {
    document.getElementById('tagSearch').value = '';
    document.getElementById('userId').value = '';

    var checkboxes = document.getElementsByClassName('tag-checkbox');
    for (var i=0; i<checkboxes.length; i++) {
        checkboxes[i].checked = false;
    }

    var cards = document.getElementsByClassName("js-tag-input");
    for (i = 0; i < cards.length; i++) {
        cards[i].style.display = "";
    }
}

function requestInfo() {
    return {
        '_token' : $('meta[name=csrf-token]').attr('content'),
        'userId' : document.getElementById('userId').value,
        'tags' : getTags(),
    }
}
</script>