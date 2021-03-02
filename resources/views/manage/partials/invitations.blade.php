@can('keep_inventory')
<div class="card mb-2">
    <div class="card-body p-6">
        <div class="row">
            <div class="col-12 text-center">
                <h2 class="h4 mb-1">Invitations</h2>
                
                <div id="js-invitation-section">

                    <table class="table table-sm font-size-xs table-hover">
                        <thead>
                            <tr class="">
                                <th scope="col">Date</th>
                                <th scope="col">Status</th>
                                <th scope="col"></th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($registration->invitations as $invite)
                            <tr class="{{ !in_array($invite->invite_status->name, ['Expired', 'Declined', 'No Show', 'Turned Down']) ? 'alert-info' : 'alert-danger' }}">
                                <td scope="row">{{ Carbon\Carbon::parse($invite->event->date_held)->isoFormat('M/D/YY') }}</td>
                                <td>{{ $invite->invite_status->name }}</td>
                                <td><a href="#" class="text-danger" onclick="event.preventDefault(); document.getElementById('remove-invite-form-{{ $invite->registration_id }}-{{ $invite->slot_id }}').submit();"><span class="fad fa-trash-alt" title="Remove Invite"></span></a></td>
                                <form id="remove-invite-form-{{ $invite->registration_id }}-{{ $invite->slot_id }}" action="/manage/invitation/remove" method="POST" style="display: none;">
                                    @method('DELETE')
                                    <input type="hidden" name="registration_id" value="{{ $invite->registration_id }}">
                                    <input type="hidden" name="slot_id" value="{{ $invite->slot_id }}">
                                    @csrf
                                </form>
                            </tr>
                        @empty
                            <tr class="alert-warning mt-6 mb-6">
                                <td colspan="5" class="text-center font-size-lg alert-warning">No invitations found</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan