@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Registration Edit
@endsection

@section('header')
<style>
select.read-only {
    background: #e9ecef;
    cursor:no-drop;
}

select.read-only option{
    display:none;
}
</style>
<script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{ config('app.google_maps_key') }}&callback=initAutocomplete&libraries=places&v=weekly" defer></script>
@endsection

@section('content')
<!-- Header -->
<div class="jumbotron jumbotron-fluid jumbotron-header bg-squares teal-gradient">
    <div class="container position-relative z-1">
        <div class="row">
            <div class="col-12">
                <!-- Badge -->
                <span class="badge badge-pill badge-white-teal mb-3">
                    <span class="h6 text-uppercase">
                        Register
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">Edit your Online Registration</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Make needed changes to your registration for your COVID-19 vaccination.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Card -->
                <div class="card card-border border-primary shadow-light-lg">
                    <div class="card-body">
                        <!-- Form -->
                        <form action="/edit" id="RegistrationMainForm" method="post" onkeydown="return event.key != 'Enter';">
                            @csrf

                            <div class="row mb-6">
                                <div class="col-12">
                                    <h2 class="mb-5">Registrant Information</h2>
                                </div>

                                <!-- Name -->
                                <div class="form-group col-12 col-md-7 col-lg-8">
                                    <label for="firstName">
                                        First Name
                                    </label>
                                    <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') ? old('firstName') : $registration->first_name }}" required autocomplete="firstName" autofocus placeholder="Enter your first name">

                                    @error('firstName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-12 col-md-5 col-lg-4">
                                    <label for="middleName">
                                        Middle Name
                                    </label>
                                    <input id="middleName" type="text" class="form-control @error('middleName') is-invalid @enderror" name="middleName" value="{{ old('middleName') ? old('middleName') : $registration->middle_name }}" autocomplete="middleName" autofocus placeholder="Enter middle name">

                                    @error('middleName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="form-group col-12 col-md-7 col-lg-8">
                                    <label for="lastName">
                                        Last Name
                                    </label>
                                    <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') ? old('lastName') : $registration->last_name }}" required autocomplete="lastName" autofocus placeholder="Enter your last name">

                                    @error('lastName')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Date of Birth -->
                                <div class="form-group col-12 col-md-5 col-lg-4">
                                    <label for="suffix">
                                        Suffix <span class="font-weight-light small">(If applicable)</span>
                                    </label>
                                    <select id="suffix" name="suffix" class="custom-select @error("suffix") is-invalid @enderror">
                                        <option value="0" @if (old('suffix') && old('suffix') == '0') selected @endif></option>
                                        @foreach (\App\Models\Suffix::get() as $suffix)
                                            <option value="{{ $suffix->id }}" @if (old('suffix')) @if(old('suffix') == $suffix->id) selected @endif @elseif($registration->suffix_id == $suffix->id) selected @endif>{{ $suffix->display_name }}</option>
                                        @endforeach
                                    </select>

                                    @error('suffix')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('suffix') }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="dob">
                                        Date of Birth <span class="font-weight-light small">(You must be at least 13 years of age to register)</span>
                                    </label>
                                    <input id="dob" name="dateOfBirth" class="form-control @error("dateOfBirth") is-invalid @enderror" type="date" value="{{ old('dateOfBirth') ? old('dateOfBirth') : $registration->birth_date }}" required aria-required="true">
                    
                                    @error('dateOfBirth')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first('dateOfBirth') }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <!-- Phone -->
                                <div class="form-group col-md-6">
                                    <label for="phone">
                                        Primary Phone Number
                                    </label>
                                    <input id="phone" name="phone" class="form-control @error("phone") is-invalid @enderror" type="tel" value="{{ old('phone') ? old('phone') : (isset($registration->phones()[0]) ? ('('.substr($registration->phones()[0]->value,0,3).') '.substr($registration->phones()[0]->value,3,3).'-'.substr($registration->phones()[0]->value,6,4)) : '') }}" placeholder="(XXX) XXX-XXXX" required aria-required="true">
                    
                                    @error("phone")
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first("phone") }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-6">
                                <div class="col-12">
                                    <h2 class="mb-5">Demographics</h2>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="gender">
                                            Gender
                                        </label>
                                        <select id="gender" name="gender" class="custom-select @error("gender") is-invalid @enderror">
                                            @foreach (\App\Models\Gender::get() as $gender)
                                                <option value="{{ $gender->id }}" @if (old('gender')) @if(old('gender') == $gender->id) selected @endif @elseif($registration->gender_id == $gender->id) selected @endif>{{ $gender->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('gender')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('gender') }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="race">
                                            Race/Ethnicity
                                        </label>
                                        <select id="race" name="race" class="custom-select @error("race") is-invalid @enderror">
                                            @foreach (\App\Models\Race::get() as $race)
                                                <option value="{{ $race->id }}" @if (old('race')) @if(old('race') == $race->id) selected @endif @elseif($registration->race_id == $race->id) selected @endif>{{ $race->name }}</option>
                                            @endforeach
                                        </select>

                                        @error('race')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('race') }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mt-4">
                                <div class="col-12">
                                    <h2 class="mb-5">Home Address</h2>
                                </div>
                                <div class="col-12 mb-3">
                                    <div class="form-group">
                                        <label for="autocomplete">Address search</label>
                                        <span id="addressMoreOptions" class="animate-fade text-muted small ml-1">
                                            Address not listed?
                                            <a id="btnCollapsedAddress" data-toggle="collapse" href="#collapsedAddress" role="button" aria-expanded="false" aria-controls="collapsedAddress">see more options</a>
                                        </span>
                                        <input class="form-control @if ($errors->has('street_number') || $errors->has('street_name') || $errors->has('line_2') || $errors->has('locality') || $errors->has('state') || $errors->has('postal_code') || $errors->has('county')) is-invalid @endif" type="text" id="autocomplete" placeholder="Enter your address" onFocus="geolocate()" name="autocomplete" value="{{ old('autocomplete') ?? ($registration->address ? $registration->address->street_number . ' ' . $registration->address->street_name . ', ' . $registration->address->locality . ', ' . $registration->address->state->abbr : '') }}">

                                        @if ($errors->has('street_number') || $errors->has('street_name') || $errors->has('line_2') || $errors->has('locality') || $errors->has('state') || $errors->has('postal_code') || $errors->has('county'))
                                        <span class="invalid-feedback" role="alert">
                                            <strong>
                                                {!! $errors->has('street_number') ? $errors->first('street_number') . '<br>' : '' !!}
                                                {!! $errors->has('street_name') ? $errors->first('street_name') . '<br>' : '' !!}
                                                {!! $errors->has('line_2') ? $errors->first('line_2') . '<br>' : '' !!}
                                                {!! $errors->has('locality') ? $errors->first('locality') . '<br>' : '' !!}
                                                {!! $errors->has('state') ? $errors->first('state') . '<br>' : '' !!}
                                                {!! $errors->has('postal_code') ? $errors->first('postal_code') . '<br>' : '' !!}
                                                {!! $errors->has('county') ? $errors->first('county') . '<br>' : '' !!}
                                            </strong>
                                        </span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group mb-5">
                                        <div class="custom-control custom-checkbox">
                                            <input id="scheculePreference" name="scheculePreference" class="custom-control-input @error("scheculePreference") is-invalid @enderror" type="checkbox">
                                            <label class="custom-control-label" for="scheculePreference">I prefer to get scheduled to the location closest to me instead of being scheduled to the earliest possible appointment.</label>
                        
                                            @error("scheculePreference")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first("scheculePreference") }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                              </div>
                              <div id="collapsedAddress" class="row collapse">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="street_number">Street #</label>
                                        <input class="form-control read-only" type="text" id="street_number" name="street_number" value="{{ old('street_number') ?? ($registration->address->street_number ?? '') }}" readonly="readonly" aria-readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="route">Street name</label>
                                        <input class="form-control read-only" type="text" id="route" name="street_name" value="{{ old('street_name') ?? ($registration->address->street_name ?? '') }}" readonly="readonly" aria-readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="address-line-2">Apt, Ste, Unit, etc.</label>
                                        <input class="form-control read-only" type="text" id="address-line-2" name="line_2" value="{{ old('line_2') ?? ($registration->address->line_2 ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <div class="form-group">
                                        <label for="locality">City</label>
                                        <input class="form-control read-only" type="text" id="locality" name="locality" value="{{ old('locality') ?? ($registration->address->locality ?? '') }}" readonly="readonly" aria-readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="administrative_area_level_1">State</label>
                                        <select id="administrative_area_level_1" name="state" class="custom-select read-only" readonly="readonly" aria-readonly="true">
                                            @foreach (\App\Models\State::get() as $state)
                                                <option value="{{ $state->id }}" @if (old('state')) @if(old('state') == $state->id) selected @endif @elseif(($registration->address->state_id ?? '9') == $state->id) selected @endif>{{ $state->abbr }}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label for="postal_code">Zip code</label>
                                        <input class="form-control read-only" type="text" id="postal_code" name="postal_code" value="{{ old('postal_code') ?? ($registration->address->postal_code ?? '') }}" readonly="readonly" aria-readonly="true">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="administrative_area_level_2">County</label>
                                        <select id="administrative_area_level_2" name="county" class="custom-select" readonly="readonly" aria-readonly="true">
                                            @foreach (\App\Models\County::get() as $county)
                                                <option value="{{ $county->id }}" @if (old('county')) @if(old('county') == $county->id) selected @endif @elseif(($registration->address->county_id ?? '53') == $county->id) selected @endif>{{ $county->name }}</option>    
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6 d-none">
                                    <div class="form-group">
                                        <label for="lat">Latitude</label>
                                        <input class="form-control" type="hidden" id="lat" name="latitude" value="{{ old('latitude') ?? ($registration->address->latitude ?? '') }}">
                                    </div>
                                </div>
                                <div class="col-md-6 d-none">
                                    <div class="form-group">
                                        <label for="lng">Longitude</label>
                                        <input class="form-control" type="hidden" id="lng" name="longitude" value="{{ old('longitude') ?? ($registration->address->longitude ?? '') }}">
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <div class="col-12">
                                    <h2 class="mb-5">Work</h2>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-5">
                                        <label for="occupation">
                                            Occupation
                                        </label>
                                        <select id="occupation" name="occupation" class="custom-select @error("occupation") is-invalid @enderror">
                                            @foreach (\App\Models\Occupation::get() as $occupation)
                                                @if($occupation->display_name != null)
                                                    <option value="{{ $occupation->id }}" @if (old('occupation')) @if(old('occupation') == $occupation->id) selected @endif @elseif($registration->occupation_id == $occupation->id) selected @endif>{{ $occupation->display_name }}</option>
                                                @endif
                                            @endforeach
                                        </select>

                                        @error('occupation')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('occupation') }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-6">
                                <div class="col-12">
                                    <h2 class="mb-5">Check All Underlying Health Conditions that Apply to You</h2>
                                </div>

                                @php
                                    $regis_conditions = $registration->conditions()->pluck('id')->toArray();
                                @endphp
                                @foreach (\App\Models\Condition::get() as $condition)
                                    @if($condition->display_name != null)
                                        <div class="col-12 col-lg-6">
                                            <div class="form-group mb-5">
                                                <div class="custom-control custom-checkbox">
                                                    <input id="condition{{ $condition->id }}" name="condition[{{$condition->id}}]" class="custom-control-input" type="checkbox" @if(old('condition')) @if(array_key_exists($condition->id, old('condition'))) checked aria-checked="true" @endif @elseif (in_array($condition->id, $regis_conditions)) checked aria-checked="true" @endif>
                                                    <label class="custom-control-label" for="condition{{ $condition->id }}">{{ $condition->display_name }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                            </div>

                            <div class="row mb-6">
                                <div class="col-12">
                                    <h2 class="mb-5">Agreements</h2>
                                </div>

                                {{--<div class="col-12">
                                    <div class="form-group mb-5">
                                        <div class="custom-control custom-checkbox">
                                            <input id="illAgreement" name="illAgreement" class="custom-control-input @error("illAgreement") is-invalid @enderror" type="checkbox">
                                            <label class="custom-control-label" for="illAgreement">I am not currently ill.</label>

                                            @error("illAgreement")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first("illAgreement") }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>--}}

                                <div class="col-12">
                                    <div class="form-group mb-5">
                                        <div class="custom-control custom-checkbox">
                                            <input id="availableAgreement" name="availableAgreement" class="custom-control-input @error("availableAgreement") is-invalid @enderror" type="checkbox" checked aria-checked="true">
                                            <label class="custom-control-label" for="availableAgreement">I will be available and present 28 days after my initial vaccination.</label>

                                            @error("availableAgreement")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first("availableAgreement") }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                {{--<div class="col-12">
                                    <div class="form-group mb-5">
                                        <div class="custom-control custom-checkbox">
                                            <input id="vaccineAgreement" name="vaccineAgreement" class="custom-control-input @error("vaccineAgreement") is-invalid @enderror" type="checkbox">
                                            <label class="custom-control-label" for="vaccineAgreement">I have not received any vaccine in the past 14 days.</label>

                                            @error("vaccineAgreement")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first("vaccineAgreement") }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>--}}

                                <div class="col-12">
                                    <div class="form-group mb-5">
                                        <div class="custom-control custom-checkbox">
                                            <input id="reactionAgreement" name="reactionAgreement" class="custom-control-input @error("reactionAgreement") is-invalid @enderror" type="checkbox" checked aria-checked="true">
                                            <label class="custom-control-label" for="reactionAgreement">I have not had any adverse reactions directly caused by a vaccine before.<br><small>(Or you have checked with your primary healthcare physician that you are safe to take the vaccine.)</small></label>

                                            @error("reactionAgreement")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first("reactionAgreement") }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="wizard-nav">
                                        <button id="SubmitBtn" name="SubmitBtn" class="btn btn-header btn-header-success btn-round btn-lg mb-6 mb-md-0" type="submit" data-wizard-type="action-submit">
                                            Save
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    $('#phone').keyup(function(e){
            var ph = this.value.replace(/\D/g,'').substring(0,10);
            // Backspace and Delete keys
            var deleteKey = (e.keyCode == 8 || e.keyCode == 46);
            var len = ph.length;
            if(len==0){
                ph=ph;
            }else if(len<3){
                ph='('+ph;
            }else if(len==3){
                ph = '('+ph + (deleteKey ? '' : ') ');
            }else if(len<6){
                ph='('+ph.substring(0,3)+') '+ph.substring(3,6);
            }else if(len==6){
                ph='('+ph.substring(0,3)+') '+ph.substring(3,6)+ (deleteKey ? '' : '-');
            }else{
                ph='('+ph.substring(0,3)+') '+ph.substring(3,6)+'-'+ph.substring(6,10);
            }
            this.value = ph;
        });
    </script>
@endsection

@section('scripts')
<script>
let placeSearch;
let autocomplete;

const componentForm = {
  street_number: "short_name",
  route: "short_name",
  locality: "long_name",
  administrative_area_level_2: "short_name",
  administrative_area_level_1: "short_name",
  postal_code: "short_name"
};

function initAutocomplete() {
  autocomplete = new google.maps.places.Autocomplete(
    document.getElementById("autocomplete"),
    { types: ["geocode"] }
  );

  autocomplete.setFields(["address_component", "geometry"]);

  autocomplete.addListener("place_changed", fillInAddress);
}

function fillInAddress() {
  const place = autocomplete.getPlace();

  const lat = place.geometry.location.lat(),
    lng = place.geometry.location.lng();

  document.getElementById("lat").value = lat;
  document.getElementById("lng").value = lng;

  for (const component in componentForm) {
    if (component == "administrative_area_level_1") {
        document.getElementById(component).value = "9";
    } else if (component == "administrative_area_level_2") {
        document.getElementById(component).value = "53";
    } else {
        document.getElementById(component).value = "";
    }
    document.getElementById(component).readOnly = true;
    document.getElementById(component).classList.add("read-only");
  }

  for (const component of place.address_components) {
    const addressType = component.types[0];

    if (componentForm[addressType]) {
        if (addressType == "administrative_area_level_1") {
            changeSelectedOptionByText(addressType, component[componentForm[addressType]], 53);
        } else if (addressType == "administrative_area_level_2") {
            changeSelectedOptionByText(addressType, component[componentForm[addressType]].replace(' County', ''), 64);
        } else {
            const val = component[componentForm[addressType]];
            document.getElementById(addressType).value = val;
        }
    }
  }
}

function changeSelectedOptionByText(selectName, optionText, unknownValue) {
    const ele = document.getElementById(selectName);
    var optionId = unknownValue;

    for (optionNum in ele.options) {
        
        if (ele.options[optionNum].text == optionText) {
            optionId = ele.options[optionNum].value;
        }
    }

    ele.value = optionId;
}

function geolocate() {
  if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition((position) => {
      const geolocation = {
        lat: position.coords.latitude,
        lng: position.coords.longitude
      };

      const circle = new google.maps.Circle({
        center: geolocation,
        radius: position.coords.accuracy
      });

      autocomplete.setBounds(circle.getBounds());
    });
  }
}

document.getElementById("btnCollapsedAddress").addEventListener("click", function () {
    if (this.getAttribute("aria-expanded") === "false") {
      for (const component in componentForm) {
        document.getElementById(component).readOnly = false;
        document.getElementById(component).classList.remove("read-only")
      }
    }
});

document.getElementById("autocomplete").addEventListener("input", function () {
  document.getElementById("addressMoreOptions").classList.add("animate-fade-in");
});

</script>
@endsection
