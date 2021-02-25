<div class="modal fade" data-backdrop="static" id="lotModal" tabindex="-1" aria-labelledby="lotModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="h5 modal-title" id="lotModalLabel">Add Lot Numbers</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>          
            </div>
            <div class="modal-body">
                <div class="mb-4">
                    <h2 class="font-size-xl mb-3">Known Batches <small class="text-muted font-size-xs">(Choose All That Apply)</small></h2>
                    <div class="custom-btn-group px-3 mb-3 justify-content-center">
                        @foreach (\App\Models\Lot::get() as $lot)
                            <div class="btn-group-item font-weight-medium font-size-sm">
                                <input type="checkbox" id="lot-{{ $lot->id }}" value="{{ $lot->id }}" data-number="{{ $lot->number }}" name="lot[]" @if($event && $event->lots()->where('id', '=', $lot->id)->count() > 0) checked aria-checked="true" @endif>
                                <label for="lot-{{ $lot->id }}">
                                    {{ $lot->number }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
                <button id="lotLoadingBtn" type="button" class="btn btn-secondary btn-block" disabled aria-disabled="true" style="display: none">
                    <span class="fad fa-spinner fa-spin"></span>
                </button>
                @if ($type == 'form')
                    <button id="lotBtn" type="button" class="btn btn-success btn-block" data-dismiss="modal">Accept</button>
                @else
                    <button id="lotBtn" type="button" class="btn btn-success btn-block" onclick="syncLotNum()">Submit</button>
                @endif
            </div>
        </div>
    </div>
</div>

@if ($type == 'form')
<script>
    document.querySelectorAll('input[name="lot[]"]').forEach(item => {
        item.addEventListener('change', event => {
            let checkboxes = document.querySelectorAll('input[name="lot[]"]');
            let numbers = '';
            let ids = [];
            let first = true;
            for (let i=0; i<checkboxes.length; i++) {
                if (checkboxes[i].checked) {
                    if (first) {
                        numbers = numbers + checkboxes[i].dataset.number;
                        first = false;
                    } else {
                        numbers = numbers + ', ' + checkboxes[i].dataset.number;
                    }
                    ids.push(checkboxes[i].value);
                }
            }
            document.getElementById('lot-numbers').innerHTML = numbers;
            document.getElementById('lots').value = ids;
        });
    });
</script>
@else
<script>
function syncLotNum() {
    loading(true);
    lots = getLots();

    $.post('/events/{{ $event->id }}/lots', {
            "_token": $('meta[name=csrf-token]').attr('content'),
            "lots": lots,
        }, function(data) {
            loading(false);
            if (data.status == 'success') {
                $('#lotModal').modal('hide');
                $('#lot-numbers').html(data.html);
            } else {
                console.error('Something went wrong with adding the lot number!')
            }
    }, 'json');
}

function getLots() {
    var checkboxes = document.querySelectorAll('input[name="lot[]"]');
    var checked = [];
    for (var i=0; i<checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checked.push(checkboxes[i].value);
        }
    }
    return checked;
}

function loading(is) {
    if (is) {
        document.getElementById("lotBtn").style.display = 'none';
        document.getElementById("lotLoadingBtn").style.display = '';
    } else {
        document.getElementById("lotBtn").style.display = '';
        document.getElementById("lotLoadingBtn").style.display = 'none';
    }
}
</script>
@endif
