@foreach ($results as $res)
<tr>
    <td>{{ $res->first_name.' '.$res->last_name }}</td>
    <td>{{ $res->id }}</td>
    <td>{{ $res->code }}</td>
    <td>{{ Carbon\Carbon::parse($res->submitted_at)->format('m-d-Y h:i:s A') }}</td>
    <td>{{ $res->status->name }}</td>
    <td>
        <a href="/manage/edit/{{ $res->id }}">
            <span class="fad fa-edit"></span>
        </a>
    </td>
</tr>
@endforeach