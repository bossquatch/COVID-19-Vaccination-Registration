<div class="card card-body p-4">
    <div class="row align-items-center justify-content-center">
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Date Given</h4>
            <p class="text-gray-dark mb-2">
                {{ Carbon\Carbon::parse($vaccine->date_given)->format('m/d/Y') }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Vaccine Name</h4>
            <p class="text-gray-dark mb-2">
                {{ $vaccine->vaccine_type->name }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Manufacturer</h4>
            <p class="text-gray-dark mb-2">
                {{ $vaccine->manufacturer->abbrev }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Lot Number</h4>
            <p class="text-gray-dark mb-2">
                {{ $vaccine->lot_number }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>NDC</h4>
            <p class="text-gray-dark mb-2">
                {{ $vaccine->ndc }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Exp. Date</h4>
            <p class="text-gray-dark mb-2">
                {{ $vaccine->exp_month . '/' . $vaccine->exp_year }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>VIS Publication Date</h4>
            <p class="text-gray-dark mb-2">
                {{ $vaccine->vis_publication ? Carbon\Carbon::parse($vaccine->vis_publication)->format('m/d/Y') : 'N/A' }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Injection Site</h4>
            <p class="text-gray-dark mb-2">
                {{ $vaccine->injection_site->abbrev }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Injection Route</h4>
            <p class="text-gray-dark mb-2">
                {{ $vaccine->injection_route->abbrev }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Eligibility</h4>
            <p class="text-gray-dark mb-2">
                {{ $vaccine->eligibility->abbrev }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Giver Name</h4>
            <p class="text-gray-dark mb-2">
                {{ $vaccine->giver_lname ? ($vaccine->giver_lname . ', ' . $vaccine->giver_fname) : 'N/A' }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Giver Credentials</h4>
            <p class="text-gray-dark mb-2">
                {{ $vaccine->giver_creds ? $vaccine->giver_creds : 'N/A' }}
            </p>
        </div>
        <div class="col-12 text-center">
            <h4>Risk Factors</h4>
            <ul style="list-style-type: none; margin: 0; padding: 0;" class="text-gray-dark mb-2">
                @forelse ($vaccine->risk_factors as $risk)
                    <li style="list-style-type: none;">{{ $risk->name }}</li>
                @empty
                    <li style="list-style-type: none;">No risk factors</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>