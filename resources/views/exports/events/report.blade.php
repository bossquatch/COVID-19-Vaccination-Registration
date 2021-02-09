<table>
    <thead>
    <tr>
        <th>Last Name</th>
        <th>First Name</th>
        <th>DOB (mm/dd/yyyy)</th>
        <th>Sex</th>
        <th>Street Address</th>
        <th>City</th>
        <th>State</th>
        <th>Zipcode</th>
        <th>FL County Of Residence</th>
        <th>Phone Number</th>
        <th>Race</th>
        <th>Ethnicity</th>
        <th>Date Given (mm/dd/yyyy)</th>
        <th>Vaccine</th>
        <th>Manufacturer</th>
        <th>Lot Number</th>
        <th>NDC</th>
        <th>Vaccine Exp. Date (mm/yyyy or mm/dd/yyyy)</th>
        <th>VIS Pub Date (mm/dd/yyyy)</th>
        <th>Inj Site</th>
        <th>Inj Route</th>
        <th>Eligibility</th>
        <th>Risk Factors</th>
        <th>Given By Name</th>
        <th>Given by Credentials</th>
    </tr>
    </thead>
    <tbody>
    @foreach($registrations_vaccine as $registration)
        @php
            $vaccine = $registration->vaccines->first();
        @endphp
        <tr>
            <td>{{ $registration->last_name }}</td>                                                                                                                                            {{--<th>Last Name</th>--}}
            <td>{{ $registration->first_name }}</td>                                                                                                                                           {{--<th>First Name</th>--}}
            <td>{{ $registration->birth_date ? \Carbon\Carbon::parse($registration->birth_date)->format('m/d/Y') : $registration->birth_date }}</td>                                           {{--<th>DOB (mm/dd/yyyy)</th>--}}
            <td>{{ $registration->gender ? substr($registration->gender->name,0,1) : 'U' }}</td>                                                                                               {{--<th>Sex</th>--}}
            <td>{{ ($registration->address2 != null) ? $registration->address1.' '.$registration->address2 : $registration->address1 }}</td>                                                   {{--<th>Street Address</th>--}}
            <td>{{ $registration->city }}</td>                                                                                                                                                 {{--<th>City</th>--}}
            <td>{{ $registration->state }}</td>                                                                                                                                                {{--<th>State</th>--}}
            <td>{{ $registration->zip }}</td>                                                                                                                                                  {{--<th>Zipcode</th>--}}
            <td>{{ $registration->county }}</td>                                                                                                                                               {{--<th>FL County Of Residence</th>--}}
            <td>{{ $registration->phone_number }}</td>                                                                                                                                         {{--<th>Phone Number</th>--}}
            <td>{{ $registration->race ? ($registration->race->name == 'HISPANIC OR HAITIAN ORIGIN' ? 'WHITE' : $registration->race->name) : 'UNKNOWN' }}</td>                                 {{--<th>Race</th>--}}
            <td>{{ $registration->race ? ($registration->race->name == 'HISPANIC OR HAITIAN ORIGIN' ? $registration->race->name : 'NON-HISPANIC OR HAITIAN ORIGIN') : 'UNKNOWN' }}</td>        {{--<th>Ethnicity</th>--}}
            <td>{{ \Carbon\Carbon::parse($date)->format('m/d/Y') }}</td>                                                                                                                       {{--<th>Date Given (mm/dd/yyyy)</th>--}}
            <td>{{ $vaccine->vaccine_type->name }}</td>                                                                                                                                        {{--<th>Vaccine Name</th>--}}
            <td>{{ $vaccine->manufacturer->name }}</td>                                                                                                                                        {{--<th>Vaccine Manufacturer</th>--}}
            <td>{{ $vaccine->lot_number }}</td>                                                                                                                                                {{--<th>Lot Number</th>--}}
            <td>{{ $vaccine->ndc }}</td>                                                                                                                                                       {{--<th>NDC</th>--}}
            <td>{{ $vaccine->exp_month . '/' . $vaccine->exp_year }}</td>                                                                                                                      {{--<th>Vaccine Exp. Date (mm/yyyy or mm/dd/yyyy)</th>--}}
            <td>{{ \Carbon\Carbon::parse($vaccine->vis_publication)->format('m/d/Y') }}</td>                                                                                                   {{--<th>VIS Pub Date (mm/dd/yyyy)</th>--}}
            <td>{{ $vaccine->injection_site->abbrev }}</td>                                                                                                                                    {{--<th>Inj Site</th>--}}
            <td>{{ $vaccine->injection_route->abbrev }}</td>                                                                                                                                   {{--<th>Inj Route</th>--}}
            <td>{{ $vaccine->eligibility->abbrev }}</td>                                                                                                                                       {{--<th>Eligibility</th>--}}
            <td>{{ implode(";", $vaccine->risk_factors->pluck('name')->all()) }}</td>                                                                                                          {{--<th>Risk Factors</th>--}}
            <td>{{ ($vaccine->giver_lname && $vaccine->giver_fname) ? $vaccine->giver_lname . ', ' . $vaccine->giver_fname : $vaccine->giver_lname . $vaccine->giver_fname }}</td>             {{--<th>Given By Name</th>--}}
            <td>{{ $vaccine->giver_creds ?? '' }}</td>                                                                                                                                         {{--<th>Given by Credentials</th>--}}
        </tr>
    @endforeach
    @foreach($registrations_no_vaccine as $registration)
        <tr>
            <td>{{ $registration->last_name }}</td>                                                                                                                                            {{--<th>Last Name</th>--}}
            <td>{{ $registration->first_name }}</td>                                                                                                                                           {{--<th>First Name</th>--}}
            <td>{{ $registration->birth_date ? \Carbon\Carbon::parse($registration->birth_date)->format('m/d/Y') : $registration->birth_date }}</td>                                           {{--<th>DOB (mm/dd/yyyy)</th>--}}
            <td>{{ $registration->gender ? substr($registration->gender->name,0,1) : 'U' }}</td>                                                                                               {{--<th>Sex</th>--}}
            <td>{{ ($registration->address2 != null) ? $registration->address1.' '.$registration->address2 : $registration->address1 }}</td>                                                   {{--<th>Street Address</th>--}}
            <td>{{ $registration->city }}</td>                                                                                                                                                 {{--<th>City</th>--}}
            <td>{{ $registration->state }}</td>                                                                                                                                                {{--<th>State</th>--}}
            <td>{{ $registration->zip }}</td>                                                                                                                                                  {{--<th>Zipcode</th>--}}
            <td>{{ $registration->county }}</td>                                                                                                                                               {{--<th>FL County Of Residence</th>--}}
            <td>{{ $registration->phone_number }}</td>                                                                                                                                         {{--<th>Phone Number</th>--}}
            <td>{{ $registration->race ? ($registration->race->name == 'HISPANIC OR HAITIAN ORIGIN' ? 'WHITE' : $registration->race->name) : 'UNKNOWN' }}</td>                                 {{--<th>Race</th>--}}
            <td>{{ $registration->race ? ($registration->race->name == 'HISPANIC OR HAITIAN ORIGIN' ? $registration->race->name : 'NON-HISPANIC OR HAITIAN ORIGIN') : 'UNKNOWN' }}</td>        {{--<th>Ethnicity</th>--}}
            <td>{{ \Carbon\Carbon::parse($date)->format('m/d/Y') }}</td>                                                                                                                       {{--<th>Date Given (mm/dd/yyyy)</th>--}}
            <td></td>                                                                                                                                                                          {{--<th>Vaccine Name</th>--}}
            <td></td>                                                                                                                                                                          {{--<th>Vaccine Manufacturer</th>--}}
            <td></td>                                                                                                                                                                          {{--<th>Lot Number</th>--}}
            <td></td>                                                                                                                                                                          {{--<th>NDC</th>--}}
            <td></td>                                                                                                                                                                          {{--<th>Vaccine Exp. Date (mm/yyyy or mm/dd/yyyy)</th>--}}
            <td></td>                                                                                                                                                                          {{--<th>VIS Pub Date (mm/dd/yyyy)</th>--}}
            <td></td>                                                                                                                                                                          {{--<th>Inj Site</th>--}}
            <td></td>                                                                                                                                                                          {{--<th>Inj Route</th>--}}
            <td></td>                                                                                                                                                                          {{--<th>Eligibility</th>--}}
            <td></td>                                                                                                                                                                          {{--<th>Risk Factors</th>--}}
            <td></td>                                                                                                                                                                          {{--<th>Given By Name</th>--}}
            <td></td>                                                                                                                                                                          {{--<th>Given by Credentials</th>--}}
        </tr>
    @endforeach
    </tbody>
</table>
