@foreach ($results as $res)
<tr>
    <td>{{ $res->first_name.' '.$res->last_name }}</td>
    <td>{{ $res->id }}</td>
    <td>{{ $res->code }}</td>
    <td>{{ Carbon\Carbon::parse($res->submitted_at)->format('m-d-Y h:i:s A') }}</td>
    <td>{{ $res->status->name }}</td>
    <td>
        @can('read_vaccine')
        <a href="{{ "/".$res->user_id."/".$res->id."/".$res->code }}" title="View Registration" aria-title="View Registration">
            <span class="fad fa-eye ml-1"></span>
        </a>
        @endcan
        @can('update_registration')
        <a href="/manage/edit/{{ $res->id }}" title="Edit Registration" aria-title="Edit Registration">
            <span class="fad fa-edit ml-1"></span>
        </a>    
        @endcan
    </td>
</tr>
@endforeach