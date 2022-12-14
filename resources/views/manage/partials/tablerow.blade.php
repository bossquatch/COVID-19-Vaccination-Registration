@foreach ($results as $res)
<tr>
    <td>{{ $res->first_name.' '.$res->last_name }}</td>
    <td>{{ $res->registration ? Carbon\Carbon::parse($res->registration->birth_date)->format('m-d-Y') : 'No date of birth' }}</td>
    @can('read_user')
    <td>{{ $res->registration->id ?? '' }}</td>    
    @endcan
    <td>{{ $res->registration->code ?? '' }}</td>
    <td><span title="{{ $res->registration ? Carbon\Carbon::parse($res->registration->submitted_at)->format('m-d-Y h:i:s A') : 'No registration' }}">{{ $res->registration ? Carbon\Carbon::parse($res->registration->submitted_at)->format('m-d-Y') : 'No registration' }}</span></td> 
    <td>{{ $res->registration->status->name ?? 'Emailed: '.$res->email }}</td>
    <td class="text-center">
        @if ($res->email_verified_at)
            <span class="fad fa-badge-check fa-lg text-success" title="{{ Carbon\Carbon::parse($res->email_verified_at)->format('m-d-Y h:i:s A') }}"></span>
        @endif
    </td>
    <td class="text-right" style="white-space: nowrap;">
        @if ($res->registration)
            @can('read_registration')
            <a href="{{ "/".$res->id."/".$res->registration->id."/".$res->registration->code }}" title="View Registration" aria-title="View Registration">
                <span class="fad fa-eye fa-lg ml-1"></span></a>
            @endcan
            @can('update_registration')
            <a href="/manage/edit/{{ $res->registration->id }}" title="Edit Registration" aria-title="Edit Registration">
                <span class="fad fa-edit fa-lg ml-1"></span>
            </a>    
            @endcan
        @else
            @can('update_registration')
            @if ($res->deleted_at) 
            <span class="badge badge-pill badge-danger">Deleted</span>
            @else
            <a href="#" title="Delete User" aria-title="Delete User" class="text-danger" onclick="deleteUser('{{ $res->id }}')">
                <span class="fad fa-trash-alt fa-lg ml-1"></span>
            </a>
            @endif
            @endcan
        @endif
    </td>
</tr>
@endforeach