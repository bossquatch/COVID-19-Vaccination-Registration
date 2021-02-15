<div class="modal fade" data-backdrop="static" id="vaccineModal" tabindex="-1" aria-labelledby="vaccineModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <span class="h5 modal-title" id="vaccineModalLabel">Add Vaccination</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>          
            </div>
            <div class="modal-body">
                <form>
                    <input id="registrationId" type="hidden" value="{{ $registration->id }}">
                    <div class="row mb-6">
                        {{--<div class="col-12">
                            <h2>Caller Information</h2>
                        </div>--}}

                        <div class="col-12">
                            <div class="form-group">
                                <label for="dateGiven">
                                    Date Given
                                </label>
                                <input id="dateGiven" type="date" class="form-control" value="{{ \Carbon\Carbon::today()->format('Y-m-d') }}" placeholder="Enter date the vaccination was given">

                                <span class="invalid-feedback js-error-text" role="alert" style="display: none;">
                                    <strong id="dateGivenError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group mb-5">
                                <label for="vaccineName">
                                    Vaccine Name
                                </label>
                                <select id="vaccineName" class="custom-select">
                                    @foreach (\App\Models\VaccineType::get() as $type)
                                        <option value="{{ $type->id }}">{{ $type->name }}</option>    
                                    @endforeach
                                </select>
                
                                <span class="invalid-feedback js-error-text" role="alert" style="display: none;">
                                    <strong id="vaccineNameError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group mb-5">
                                <label for="manufacturer">
                                    Manufacturer
                                </label>
                                <select id="manufacturer" class="custom-select">
                                    @foreach (\App\Models\Manufacturer::get() as $man)
                                        <option value="{{ $man->id }}">{{ $man->abbrev }}</option>    
                                    @endforeach
                                </select>
                
                                <span class="invalid-feedback js-error-text" role="alert" style="display: none;">
                                    <strong id="manufacturerError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="lotNumber">
                                    Lot Number
                                </label>
                                <input id="lotNumber" type="text" class="form-control" placeholder="Enter lot number">

                                <span class="invalid-feedback js-error-text" role="alert" style="display: none;">
                                    <strong id="lotNumberError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <div class="form-group">
                                <label for="ndc">
                                    NDC
                                </label>
                                <input id="ndc" type="text" class="form-control" placeholder="Enter NDC">

                                <span class="invalid-feedback js-error-text" role="alert" style="display: none;">
                                    <strong id="ndcError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="expDate">
                                    Expiration Date
                                </label>
                                <div id="expDate" class="input-group">
                                    <input id="expDateMonth" type="number" min="1" max="12" class="form-control" placeholder="Month (MM)" value="{{ (int) \Carbon\Carbon::now()->addMonth()->format('m') }}">
                                    <span class="input-group-text" style="border-radius: 0;">/</span>
                                    <input id="expDateYear" type="number" min="2021" class="form-control" placeholder="Year (YYYY)" value="2021">
                                </div>

                                <div class="text-danger js-error-text" role="alert" style="display: none; font-size: 80%;">
                                    <strong id="expDateMonthError"></strong>
                                </div>
                                <div class="text-danger js-error-text" role="alert" style="display: none; font-size: 80%;">
                                    <strong id="expDateYearError"></strong>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-lg-6">
                            <div class="form-group">
                                <label for="visPubDate">
                                    VIS Publication Date
                                </label>
                                <input id="visPubDate" type="date" class="form-control" placeholder="Enter VIS publication date">

                                <span class="invalid-feedback js-error-text" role="alert" style="display: none;">
                                    <strong id="visPubDateError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-5">
                                <label for="injectionSite">
                                    Injection Site
                                </label>
                                <select id="injectionSite" class="custom-select">
                                    @foreach (\App\Models\InjectionSite::get() as $site)
                                        <option value="{{ $site->id }}" @if($site->abbrev == "LD") selected @endif>{{ $site->abbrev }}</option>    
                                    @endforeach
                                </select>
                
                                <span class="invalid-feedback js-error-text" role="alert" style="display: none;">
                                    <strong id="injectionSiteError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-5">
                                <label for="injectionRoute">
                                    Injection Route
                                </label>
                                <select id="injectionRoute" class="custom-select">
                                    @foreach (\App\Models\InjectionRoute::get() as $route)
                                        <option value="{{ $route->id }}" @if($route->abbrev == "IM") selected @endif>{{ $route->abbrev }}</option>    
                                    @endforeach
                                </select>
                
                                <span class="invalid-feedback js-error-text" role="alert" style="display: none;">
                                    <strong id="injectionRouteError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-lg-4">
                            <div class="form-group mb-5">
                                <label for="eligibility">
                                    Eligibility
                                </label>
                                <select id="eligibility" class="custom-select">
                                    @foreach (\App\Models\Eligibility::get() as $el)
                                        <option value="{{ $el->id }}">{{ $el->abbrev }}</option>    
                                    @endforeach
                                </select>
                
                                <span class="invalid-feedback js-error-text" role="alert" style="display: none;">
                                    <strong id="eligibilityError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-12">
                            <span class="h6 mb-5">Risk Factors</span>
                        </div>
                        
                        @foreach (\App\Models\RiskFactor::get() as $risk)
                            @if($risk->name != null)
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="form-group mb-5">
                                        <div class="custom-control custom-checkbox">
                                            <input id="risk{{ $risk->id }}" class="custom-control-input js-risk" type="checkbox" data-risk="{{ $risk->id }}">
                                            <label class="custom-control-label" for="risk{{ $risk->id }}">{{ $risk->name }}</label>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach

                        <div class="col-12">
                            <span class="h6 mb-5">Giver Information</span>
                        </div>

                        <div class="col-12">
                            <div class="form-group mb-5">
                                <label for="giver">
                                    Vaccinator
                                </label>
                                <select id="giver" class="custom-select">
                                    <option value="">N/A</option>    
                                    @foreach (\App\Models\User::whereHas('roles', function($query) { $query->where('name', '=', 'vac'); })->get() as $el)
                                        <option value="{{ $el->id }}" @if(Auth::id() == $el->id) selected @endif>{{ $el->creds . ' ' . $el->first_name . ' ' . $el->last_name }}</option>    
                                    @endforeach
                                </select>
                
                                <span class="invalid-feedback js-error-text" role="alert" style="display: none;">
                                    <strong id="giverError"></strong>
                                </span>
                            </div>
                        </div>

                        {{--
                        <div class="col-12 col-md-4 col-lg-2">
                            <div class="form-group">
                                <label for="giverCreds">
                                    Credentials
                                </label>
                                <input id="giverCreds" type="text" class="form-control" placeholder="(i.e. PA,R.Ph.,...)">

                                <span class="invalid-feedback js-error-text" role="alert" style="display: none;">
                                    <strong id="giverCredsError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-md-8 col-lg-5">
                            <div class="form-group">
                                <label for="giverFirstName">
                                    First Name
                                </label>
                                <input id="giverFirstName" type="text" class="form-control" placeholder="Enter giver First Name">

                                <span class="invalid-feedback js-error-text" role="alert" style="display: none;">
                                    <strong id="giverFirstNameError"></strong>
                                </span>
                            </div>
                        </div>

                        <div class="col-12 col-md-8 col-lg-5">
                            <div class="form-group">
                                <label for="giverLastName">
                                    Last Name
                                </label>
                                <input id="giverLastName" type="text" class="form-control" placeholder="Enter giver Last Name">

                                <span class="invalid-feedback js-error-text" role="alert" style="display: none;">
                                    <strong id="giverLastNameError"></strong>
                                </span>
                            </div>
                        </div>
                        --}}

                        {{--<div class="col-12 col-md-6">
                            <div class="form-group mb-5">
                                <label for="dob">
                                    Date of Birth
                                </label>
                                <input id="dob" name="dateOfBirth" class="form-control @error("dateOfBirth") is-invalid @enderror" type="date" value="{{ old('dateOfBirth') }}" required aria-required="true">
                
                                @error('dateOfBirth')
                                    <span class="invalid-feedback js-error-text" role="alert">
                                        <strong>{{ $errors->first('dateOfBirth') }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>--}}

                        
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                {{--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>--}}
                <button id="vacLoadingBtn" type="button" class="btn btn-secondary btn-block" disabled aria-disabled="true" style="display: none">
                    <span class="fad fa-spinner fa-spin"></span>
                </button>
                <button id="vacBtn" type="button" class="btn btn-success btn-block" onclick="submitVacForm()">Submit</button>
            </div>
        </div>
    </div>
</div>

<script>
$( function () {
    $('#lotNumber').autocomplete({
        source: {!! $registration->has_appointment ? json_encode($registration->appointment->event->lots->pluck('number')->all()) : json_encode([]) !!}
    });
});

function submitVacForm() {
    loading(true);
    clearErrors();

    var postInfo = requestInfo();
    console.log(postInfo);

    $.post('/vaccine/add', postInfo, function(data) {
        console.log(data);
        loading(false);
        if (data.status == 'success') {
            document.getElementById('js-no-vaccine-alert').style.display = 'none';
            document.getElementById('js-vaccine-section').innerHTML = document.getElementById('js-vaccine-section').innerHTML + data.html;
            clearInput();
            $('#vaccineModal').modal('hide');
        } else {
            showErrors(data.errors);
        }
    }, 'json');
}

function loading(is) {
    if (is) {
        document.getElementById("vacBtn").style.display = 'none';
        document.getElementById("vacLoadingBtn").style.display = '';
    } else {
        document.getElementById("vacBtn").style.display = '';
        document.getElementById("vacLoadingBtn").style.display = 'none';
    }
}

function requestInfo() {
    return {
        '_token' : $('meta[name=csrf-token]').attr('content'),
        'registrationId' : document.getElementById('registrationId').value,
        'dateGiven' : document.getElementById('dateGiven').value,
        'vaccineName' : document.getElementById('vaccineName').options[document.getElementById('vaccineName').selectedIndex].value,
        'manufacturer' : document.getElementById('manufacturer').options[document.getElementById('manufacturer').selectedIndex].value,
        'lotNumber' : document.getElementById('lotNumber').value,
        'ndc' : document.getElementById('ndc').value,
        'expDateMonth' : document.getElementById('expDateMonth').value,
        'expDateYear' : document.getElementById('expDateYear').value,
        'visPubDate' : document.getElementById('visPubDate').value,
        'injectionSite' : document.getElementById('injectionSite').options[document.getElementById('injectionSite').selectedIndex].value,
        'injectionRoute' : document.getElementById('injectionRoute').options[document.getElementById('injectionRoute').selectedIndex].value,
        'eligibility' : document.getElementById('eligibility').options[document.getElementById('eligibility').selectedIndex].value,
        'risks' : getRisks(),
        'giver' : document.getElementById('giver').options[document.getElementById('giver').selectedIndex].value
        //'giverCreds' : document.getElementById('giverCreds').value,
        //'giverLastName' : document.getElementById('giverLastName').value,
        //'giverFirstName' : document.getElementById('giverFirstName').value
    }
}

function getRisks() {
    var checkboxes = document.getElementsByClassName('js-risk');
    var checked = [];
    for (var i=0; i<checkboxes.length; i++) {
        if (checkboxes[i].checked) {
            checked.push(checkboxes[i].dataset.risk);
        }
    }
    return checked;
}

function clearInput() {
    var today = new Date();
    var dd = String(today.getDate()).padStart(2, '0');
    var mm = String(today.getMonth() + 1).padStart(2, '0'); //January is 0!
    var yyyy = today.getFullYear();

    today = yyyy + '-' + mm + '-' + dd;

    document.getElementById('dateGiven').value = today;
    document.getElementById('lotNumber').value = null;
    document.getElementById('ndc').value = null;
    document.getElementById('expDateMonth').value = null;
    document.getElementById('expDateYear').value = null;
    document.getElementById('visPubDate').value = null;
    //document.getElementById('giverCreds').value = null;
    //document.getElementById('giverLastName').value = null;
    //document.getElementById('giverFirstName').value = null;

    var checkboxes = document.getElementsByClassName('js-risk');
    for (var i=0; i<checkboxes.length; i++) {
        checkboxes[i].checked = false;
    }
}

function showErrors(errors) {
    for (const prop in errors) {
        document.getElementById(prop).classList.add('is-invalid');
        var errorDOM = document.getElementById(prop+'Error');
        errorDOM.innerHTML = errors[prop][0];
        errorDOM.parentElement.style.display = '';
    }
}

function clearErrors() {
    var invalids = document.getElementsByClassName('is-invalid');
    var errorTexts = document.getElementsByClassName('js-error-text');

    for (var i=0; i<invalids.length; i++) {
        invalids[i].classList.remove('is-invalid');
    }
    for (var i=0; i<errorTexts.length; i++) {
        errorTexts[i].style.display = 'none';
    }
}
</script>