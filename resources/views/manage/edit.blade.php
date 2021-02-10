@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Edit Registration
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
                        Registration
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">Edit Registration</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Edit a registration for a caller's COVID-19 vaccination.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="col-12">
            <div class="text-center mb-6">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="/manage">
                    <span class="fad fa-times-circle mr-1"></span> Cancel
                </a>

                <!-- Button -->
                <button class="btn btn-header btn-header-warning btn-round btn-lg" data-toggle="modal" data-target="#forceResetModal">
                    <span class="fal fa-unlock mr-1"></span> Reset Password
                </button>

                @can('delete_registration')
                <button class="btn btn-header btn-header-danger btn-round btn-lg" data-toggle="modal" data-target="#deleteModal">
                    <span class="fad fa-trash-alt mr-1"></span> Delete Registration
                </button>
                @endcan

                @can('keep_inventory')
                <button class="btn btn-header btn-header-success btn-round btn-lg" data-toggle="modal" data-target="#completeModal">
                    <span class="fad fa-clipboard-check mr-1"></span> Complete Registration
                </button>

                @if($registration->status_id == 2)
                <button class="btn btn-header-outline btn-round btn-lg" data-toggle="modal" data-target="#waitlistModal">
                    <span class="fad fa-clipboard-list mr-1"></span> Return to Waitlist
                </button>
                @endif
                @endcan
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Card -->
                <div class="card card-border border-primary shadow-light-lg">
                    <div class="card-body">
                        <!-- Form -->
                        <form action="/manage/edit/{{ $registration->id }}" id="RegistrationMainForm" method="post">
                            @csrf

                            <div class="row mb-6">
                                <div class="col-12">
                                    <h2>Caller Information</h2>
                                </div>

                                <!-- Name -->
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="firstName">
                                            First Name
                                        </label>
                                        <input id="firstName" type="text" class="form-control @error('firstName') is-invalid @enderror" name="firstName" value="{{ old('firstName') ?? $registration->first_name }}" required autocomplete="firstName" autofocus placeholder="Enter your first name">

                                        @error('firstName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="middleName">
                                            Middle Name
                                        </label>
                                        <input id="middleName" type="text" class="form-control @error('middleName') is-invalid @enderror" name="middleName" value="{{ old('middleName') ?? $registration->middle_name }}" autocomplete="middleName" autofocus placeholder="Enter your middle name (leave blank if no middle name)">

                                        @error('middleName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="lastName">
                                            Last Name
                                        </label>
                                        <input id="lastName" type="text" class="form-control @error('lastName') is-invalid @enderror" name="lastName" value="{{ old('lastName') ?? $registration->last_name }}" required autocomplete="lastName" autofocus placeholder="Enter your last name">

                                        @error('lastName')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="suffix">
                                            Suffix <span class="font-weight-light small">(If applicable)</span>
                                        </label>
                                        <select id="suffix" name="suffix" class="custom-select @error("suffix") is-invalid @enderror">
                                            <option value="0" @if (old('suffix')) @if(old('suffix') == '0') selected @endif @elseif($registration->suffix_id == null) selected @endif></option>
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
                                </div>

                                <!-- Date of Birth -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="dob">
                                            Date of Birth <span class="font-weight-light small">(You must be at least 16 years of age to register)</span>
                                        </label>
                                        <input id="dob" name="dateOfBirth" class="form-control @error("dateOfBirth") is-invalid @enderror" type="date" value="{{ old('dateOfBirth') ?? $registration->birth_date }}" required aria-required="true">

                                        @error('dateOfBirth')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('dateOfBirth') }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group">
                                        <label for="email">
                                            Email Address
                                        </label>
                                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') ?? (isset($registration->emails()[0]) ? $registration->emails()[0]->value : '') }}" autocomplete="email" placeholder="name@address.com">

                                        @error('email')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="phone">
                                            Primary Phone Number
                                        </label>
                                        <input id="phone" name="phone" class="form-control @error("phone") is-invalid @enderror" type="tel" value="{{ old('phone') ?? (isset($registration->phones()[0]) ? ('('.substr($registration->phones()[0]->value,0,3).') '.substr($registration->phones()[0]->value,3,3).'-'.substr($registration->phones()[0]->value,6,4)) : '') }}" placeholder="(XXX) XXX-XXXX">

                                        @error("phone")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first("phone") }}</strong>
                                            </span>
                                        @enderror
                                    </div>
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

                            <div class="row mb-6">
                                <div class="col-12">
                                    <h2 class="mb-5">Home Address</h2>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="address1">
                                            Address 1
                                        </label>
                                        <input id="address1" name="address1" class="form-control @error("address1") is-invalid @enderror" type="text" value="{{ old('address1') ?? $registration->address1 }}" placeholder="Address 1" onchange="checkInlineAddress()">

                                        @error("address1")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first("address1") }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="address2">
                                            Address 2
                                        </label>
                                        <input id="address2" name="address2" class="form-control @error("address2") is-invalid @enderror" type="text" value="{{ old('address2') ?? $registration->address2 }}" placeholder="Address 2" onchange="checkInlineAddress()">

                                        @error("address2")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first("address2") }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="city">
                                            City
                                        </label>
                                        <input id="city" name="city" class="form-control @error("city") is-invalid @enderror" type="text" value="{{ old('city') ?? $registration->city }}" placeholder="City" onchange="checkInlineAddress()">

                                        @error("city")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first("city") }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="state">
                                            State
                                        </label>
                                        {{--<input type="hidden" name="state" value="FL">--}}
                                        <select id="state" name="state" class="custom-select @error("state") is-invalid @enderror" aria-disabled="false">
                                            <option value="AL" @if($registration->state == "AL") selected @endif>Alabama</option>
                                            <option value="AK" @if($registration->state == "AK") selected @endif>Alaska</option>
                                            <option value="AZ" @if($registration->state == "AZ") selected @endif>Arizona</option>
                                            <option value="AR" @if($registration->state == "AR") selected @endif>Arkansas</option>
                                            <option value="CA" @if($registration->state == "CA") selected @endif>California</option>
                                            <option value="CO" @if($registration->state == "CO") selected @endif>Colorado</option>
                                            <option value="CT" @if($registration->state == "CT") selected @endif>Connecticut</option>
                                            <option value="DE" @if($registration->state == "DE") selected @endif>Delaware</option>
                                            <option value="DC" @if($registration->state == "DC") selected @endif>District of Columbia</option>
                                            <option value="FL" @if($registration->state == "FL") selected @endif>Florida</option>
                                            <option value="GA" @if($registration->state == "GA") selected @endif>Georgia</option>
                                            <option value="HI" @if($registration->state == "HI") selected @endif>Hawaii</option>
                                            <option value="ID" @if($registration->state == "ID") selected @endif>Idaho</option>
                                            <option value="IL" @if($registration->state == "IL") selected @endif>Illinois</option>
                                            <option value="IN" @if($registration->state == "IN") selected @endif>Indiana</option>
                                            <option value="IA" @if($registration->state == "IA") selected @endif>Iowa</option>
                                            <option value="KS" @if($registration->state == "KS") selected @endif>Kansas</option>
                                            <option value="KY" @if($registration->state == "KY") selected @endif>Kentucky</option>
                                            <option value="LA" @if($registration->state == "LA") selected @endif>Louisiana</option>
                                            <option value="ME" @if($registration->state == "ME") selected @endif>Maine</option>
                                            <option value="MD" @if($registration->state == "MD") selected @endif>Maryland</option>
                                            <option value="MA" @if($registration->state == "MA") selected @endif>Massachusetts</option>
                                            <option value="MI" @if($registration->state == "MI") selected @endif>Michigan</option>
                                            <option value="MN" @if($registration->state == "MN") selected @endif>Minnesota</option>
                                            <option value="MS" @if($registration->state == "MS") selected @endif>Mississippi</option>
                                            <option value="MO" @if($registration->state == "MO") selected @endif>Missouri</option>
                                            <option value="MT" @if($registration->state == "MT") selected @endif>Montana</option>
                                            <option value="NE" @if($registration->state == "NE") selected @endif>Nebraska</option>
                                            <option value="NV" @if($registration->state == "NV") selected @endif>Nevada</option>
                                            <option value="NH" @if($registration->state == "NH") selected @endif>New Hampshire</option>
                                            <option value="NJ" @if($registration->state == "NJ") selected @endif>New Jersey</option>
                                            <option value="NM" @if($registration->state == "NM") selected @endif>New Mexico</option>
                                            <option value="NY" @if($registration->state == "NY") selected @endif>New York</option>
                                            <option value="NC" @if($registration->state == "NC") selected @endif>North Carolina</option>
                                            <option value="ND" @if($registration->state == "ND") selected @endif>North Dakota</option>
                                            <option value="OH" @if($registration->state == "OH") selected @endif>Ohio</option>
                                            <option value="OK" @if($registration->state == "OK") selected @endif>Oklahoma</option>
                                            <option value="OR" @if($registration->state == "OR") selected @endif>Oregon</option>
                                            <option value="PA" @if($registration->state == "PA") selected @endif>Pennsylvania</option>
                                            <option value="PR" @if($registration->state == "PR") selected @endif>Puerto Rico</option>
                                            <option value="RI" @if($registration->state == "RI") selected @endif>Rhode Island</option>
                                            <option value="SC" @if($registration->state == "SC") selected @endif>South Carolina</option>
                                            <option value="SD" @if($registration->state == "SD") selected @endif>South Dakota</option>
                                            <option value="TN" @if($registration->state == "TN") selected @endif>Tennessee</option>
                                            <option value="TX" @if($registration->state == "TX") selected @endif>Texas</option>
                                            <option value="UT" @if($registration->state == "UT") selected @endif>Utah</option>
                                            <option value="VT" @if($registration->state == "VT") selected @endif>Vermont</option>
                                            <option value="VA" @if($registration->state == "VA") selected @endif>Virginia</option>
                                            <option value="VI" @if($registration->state == "VI") selected @endif>Virgin Islands</option>
                                            <option value="WA" @if($registration->state == "WA") selected @endif>Washington</option>
                                            <option value="WV" @if($registration->state == "WV") selected @endif>West Virginia</option>
                                            <option value="WI" @if($registration->state == "WI") selected @endif>Wisconsin</option>
                                            <option value="WY" @if($registration->state == "WY") selected @endif>Wyoming</option>
                                        </select>

                                        @error("state")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first("state") }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="zipCode">
                                            Zip code
                                        </label>
                                        <input id="zipCode" name="zip" class="form-control @error("zip") is-invalid @enderror" type="text" value="{{ old('zip') ?? $registration->zip }}" placeholder="Zip code" onchange="checkInlineAddress()">

                                        @error("zip")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first("zip") }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="county">
                                            County
                                        </label>
                                        <select id="county" name="county" class="custom-select @error("county") is-invalid @enderror">
                                            @foreach (\App\Models\County::get() as $county)
                                                <option value="{{ $county->id }}" @if (old('county')) @if(old('county') == $county->id) selected @endif @elseif($registration->county_id == $county->id) selected @endif>{{ $county->county }}</option>
                                            @endforeach
                                        </select>

                                        @error('county')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first('county') }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-5">
                                        <div class="custom-control custom-checkbox">
                                            <input id="scheculePreference" name="scheculePreference" class="custom-control-input @error("scheculePreference") is-invalid @enderror" type="checkbox" @if ($registration->prefer_close_location) checked aria-checked="true" @endif>
                                            <label class="custom-control-label" for="scheculePreference">I prefer to get scheduled to the location closest to me instead of being scheduled to the earliest possible appointment.</label>

                                            @error("scheculePreference")
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $errors->first("scheculePreference") }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12" style="display: none" id="addressStatusBlock"></div>
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
                                                    <input id="condition{{ $condition->id }}" name="condition[{{$condition->id}}]" class="custom-control-input" type="checkbox" @if (in_array($condition->id, $regis_conditions)) checked aria-checked="true" @endif>
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
                                    <h2 class="mb-5">Comments</h2>
                                </div>
                                @if ($registration->hasComments())
                                    <div class="col-12" id="commentSection">
                                        @include('manage.partials.comments', ['comments' => $registration->comments])
                                    </div>
                                @endif
                                <div class="col-12">
                                    <div class="form-group mb-5">
                                        <label for="comment">Add New Comment</label>
                                        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="wizard-nav">
                                        <button id="SubmitBtn" name="SubmitBtn" class="btn btn-header btn-header-success btn-round btn-lg mb-6 mb-md-0" type="submit" data-wizard-type="action-submit">
                                            Submit
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>

                        <script type="text/javascript">
                            function checkInlineAddress() {
                                var addrInfo = {
                                    'address1': $("#address1").val(),
                                    'address2': $("#address2").val(),
                                    'city': $("#city").val(),
                                    'zip': $("#zipCode").val(),
                                    'state': $('#state').find(":selected").val()
                                };

                                if (addrInfo.address1 != "" && addrInfo.city != "" && addrInfo.zip != ""){
                                    $("#adressStatusBlock").html(
                                        "<div class='row justify-content-center'><span class='fad fa-spinner fa-pulse fa-2x'></span></div>"
                                    );

                                    $.get('/address/validate', addrInfo, function(data) {
                                        var type, text = "";

                                        if (data.hasOwnProperty('error')) {
                                            text = data.error;
                                            type = 'danger';
                                        } else {
                                            addr = data.address.Address2;
                                            if (data.address.Address1 !== undefined) {
                                                addr += " "+data.address.Address1;
                                            }
                                            addr += " "+data.address.City+", "+data.address.State+" "+data.address.Zip5;
                                            if (data.address.Zip4 !== undefined) {
                                                addr += "-"+data.address.Zip4;
                                            }
                                            text = "<strong>Address was successufully validated!</strong><br><strong>Found address:</strong> "+addr+"<button type='button' class='ml-2 btn btn-outline-success btn-sm' onclick=\"syncInlineAddress('"+data.address.Address2+"', '"+data.address.Address1+"', '"+data.address.City+"', '"+data.address.Zip5+"', '"+data.address.State+"');$(this).hide();\">Sync Address</button>";
                                            if (data.address.ReturnText !== undefined) {
                                                text += "<br>"+data.address.ReturnText;
                                            }
                                            type = 'success';
                                        }

                                        $("#addressStatusBlock").html(
                                            "<div class='alert alert-"+type+"' role='alert'>"+text+"</div>"
                                        );
                                        $("#addressStatusBlock").css('display', 'block');
                                    }, 'json');
                                } else {
                                    $("#addressStatusBlock").html(
                                        "<div class='alert alert-warning' role='alert'>Incomplete address information.</div>"
                                    );
                                    $("#addressStatusBlock").css('display', 'block');
                                }
                            }

                            function syncInlineAddress(address1, address2, city, zip, state) {
                                if (address1 !== undefined && address1 != 'undefined') {
                                    $("#address1").val(address1);
                                } else {
                                    $("#address1").val("");
                                }

                                if (address2 !== undefined && address2 != 'undefined') {
                                    $("#address2").val(address2);
                                } else {
                                    $("#address2").val("");
                                }

                                if (city !== undefined && city != 'undefined') {
                                    $("#city").val(city);
                                } else {
                                    $("#city").val("");
                                }

                                if (zip !== undefined && zip != 'undefined') {
                                    $("#zipCode").val(zip);
                                } else {
                                    $("#zipCode").val("");
                                }

                                if (state !== undefined && state != 'undefined') {
                                    $("#state").val(state).change();
                                } else {
                                    $("#state").val("FL").change();
                                }
                            }
                        </script>
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
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Warning Modal -->
<div class="modal fade" id="forceResetModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Password Reset Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body pb-0 pt-6 px-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fad fa-exclamation-triangle fa-5x text-warning"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-3 font-weight-bold">Warning!</p>
                        <p class="text-gray-dark">Are you sure you wish to reset this user's password?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <form class="form-inline" action="/manage/forcereset" method="POST">
                    @csrf
                    <input type="hidden" name="user" value="{{ $registration->user_id }}">
                    <button type="submit" class="btn btn-danger">Reset Password</button>
                </form>
            </div>
        </div>
    </div>
</div>

@can('delete_registration')
<div class="modal fade" id="deleteModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Registration Delete Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body pb-0 pt-6 px-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fad fa-exclamation-triangle fa-5x text-danger"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-3 font-weight-bold">Danger!</p>
                        <p class="text-gray-dark">Are you sure you wish to delete this registration?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <form class="form-inline" action="/manage/delete/{{ $registration->id }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Registration</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endcan

@can('keep_inventory')
<div class="modal fade" id="completeModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Registration Complete Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body pb-0 pt-6 px-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fad fa-exclamation-triangle fa-5x text-warning"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-3 font-weight-bold">Warning!</p>
                        <p class="text-gray-dark">Are you sure you wish to mark this registration as complete?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <form class="form-inline" action="/manage/complete/{{ $registration->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">Complete Registration</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@if($registration->status_id == 2)
<div class="modal fade" id="waitlistModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Registration Waitlist Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body pb-0 pt-6 px-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fad fa-exclamation-triangle fa-5x text-warning"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-3 font-weight-bold">Warning!</p>
                        <p class="text-gray-dark">Are you sure you wish to return this registration to the waitlist?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                    <form class="form-inline" action="/manage/waitlist/{{ $registration->id }}" method="POST">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning">Return to Waitlist</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
@endcan
@endsection
