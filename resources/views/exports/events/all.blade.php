<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Middle Name</th>
            <th>Date of Birth</th>
            <th>Address 1</th>
            <th>Address 2</th>
            <th>Locality</th>
            <th>State</th>
            <th>Postal Code</th>
            <th>Contact Phone</th>
            <th>Contact Email</th>
            <th>Event Name</th>
            <th>Time Slot</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($invites as $i)
            <tr>
                <td>{{ $i->registration->id }}</td>
                <td>{{ $i->registration->last_name }}</td>
                <td>{{ $i->registration->first_name }}</td>
                <td>{{ $i->registration->middle_name }}</td>
                <td>{{ $i->registration->user->birth_date }}</td>
                <td>{{ $i->registration->address1 }}</td>
                <td>{{ $i->registration->address2 }}</td>
                <td>{{ $i->registration->city }}</td>
                <td>{{ $i->registration->state }}</td>
                <td>{{ $i->registration->zip }}</td>
                <td>{{ $i->registration->phones()->first() ? $i->registration->phones()->first()->value : '' }}</td>
                <td>{{ $i->registration->emails()->first() ? $i->registration->emails()->first()->value : '' }}</td>
                <td>{{ $i->event->title }}</td>
                <td>{{ $i->slot->starting_at }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
