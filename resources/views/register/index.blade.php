@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Registration
@endsection

@section('content')
<!-- Header -->
<div class="page-header page-header-inner header-filter page-header-default"></div>

<section class="main main-raised pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 text-center">
                <!-- Badge -->
                <span class="badge badge-pill badge-primary-soft mb-3">
                    <span class="h6 text-uppercase">
                        Register
                    </span>
                </span>

                <!-- Heading -->
                <h1>
                    Complete your <span class="text-primary">online registration.</span>
                </h1>

                <!-- Text -->
                <p class="lead text-gray-dark mb-7 mb-md-9">
                    Finish your registration for your COVID-19 vaccination.
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Card -->
                <div class="card card-border border-primary shadow-light-lg">
                    <div class="card-body">
                        <!-- Form -->
                        <form action="/home/register" id="RegistrationMainForm" method="post">
                            @csrf

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
                                                <option value="{{ $gender->id }}" @if (old('gender') && old('gender') == $gender->id) selected @endif>{{ $gender->name }}</option>    
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
                                                <option value="{{ $race->id }}" @if (old('race') && old('race') == $race->id) selected @endif>{{ $race->name }}</option>    
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
                                        <input id="address1" name="address1" class="form-control @error("address1") is-invalid @enderror" type="text" value="{{ old('address1') }}" placeholder="Address 1" onchange="checkInlineAddress()">
                        
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
                                        <input id="address2" name="address2" class="form-control @error("address2") is-invalid @enderror" type="text" value="{{ old('address2') }}" placeholder="Address 2" onchange="checkInlineAddress()">
                        
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
                                        <input id="city" name="city" class="form-control @error("city") is-invalid @enderror" type="text" value="{{ old('city') }}" placeholder="City" onchange="checkInlineAddress()">
                        
                                        @error("city")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first("city") }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="stateFront">
                                            State
                                        </label>
                                        <input type="hidden" name="state" value="FL">
                                        <select id="stateFront" name="stateFront" class="custom-select @error("state") is-invalid @enderror" disabled aria-disabled="true">
                                            <option value="AL">Alabama</option>
                                            <option value="AK">Alaska</option>
                                            <option value="AZ">Arizona</option>
                                            <option value="AR">Arkansas</option>
                                            <option value="CA">California</option>
                                            <option value="CO">Colorado</option>
                                            <option value="CT">Connecticut</option>
                                            <option value="DE">Delaware</option>
                                            <option value="DC">District of Columbia</option>
                                            <option value="FL" selected>Florida</option>
                                            <option value="GA">Georgia</option>
                                            <option value="HI">Hawaii</option>
                                            <option value="ID">Idaho</option>
                                            <option value="IL">Illinois</option>
                                            <option value="IN">Indiana</option>
                                            <option value="IA">Iowa</option>
                                            <option value="KS">Kansas</option>
                                            <option value="KY">Kentucky</option>
                                            <option value="LA">Louisiana</option>
                                            <option value="ME">Maine</option>
                                            <option value="MD">Maryland</option>
                                            <option value="MA">Massachusetts</option>
                                            <option value="MI">Michigan</option>
                                            <option value="MN">Minnesota</option>
                                            <option value="MS">Mississippi</option>
                                            <option value="MO">Missouri</option>
                                            <option value="MT">Montana</option>
                                            <option value="NE">Nebraska</option>
                                            <option value="NV">Nevada</option>
                                            <option value="NH">New Hampshire</option>
                                            <option value="NJ">New Jersey</option>
                                            <option value="NM">New Mexico</option>
                                            <option value="NY">New York</option>
                                            <option value="NC">North Carolina</option>
                                            <option value="ND">North Dakota</option>
                                            <option value="OH">Ohio</option>
                                            <option value="OK">Oklahoma</option>
                                            <option value="OR">Oregon</option>
                                            <option value="PA">Pennsylvania</option>
                                            <option value="PR">Puerto Rico</option>
                                            <option value="RI">Rhode Island</option>
                                            <option value="SC">South Carolina</option>
                                            <option value="SD">South Dakota</option>
                                            <option value="TN">Tennessee</option>
                                            <option value="TX">Texas</option>
                                            <option value="UT">Utah</option>
                                            <option value="VT">Vermont</option>
                                            <option value="VA">Virginia</option>
                                            <option value="VI">Virgin Islands</option>
                                            <option value="WA">Washington</option>
                                            <option value="WV">West Virginia</option>
                                            <option value="WI">Wisconsin</option>
                                            <option value="WY">Wyoming</option>
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
                                        <input id="zipCode" name="zip" class="form-control @error("zip") is-invalid @enderror" type="text" value="{{ old('zip') }}" placeholder="Zip code" onchange="checkInlineAddress()">
                        
                                        @error("zip")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first("zip") }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12" style="display: none" id="addressStatusBlock"></div>
                            </div>
                        
                            <div class="row mb-6">
                                <div class="col-12">
                                    <h2 class="mb-5">Check All that Apply to You</h2>
                                </div>
                                
                                @foreach (\App\Models\Agreement::get() as $agreement)
                                    <div class="col-12">
                                        <div class="form-group mb-5">
                                            <div class="custom-control custom-checkbox">
                                                <input id="agreement{{ $agreement->phase . $agreement->phase_classification }}" name="agreement[{{$agreement->id}}]" class="custom-control-input" type="checkbox">
                                                <label class="custom-control-label" for="agreement{{ $agreement->phase . $agreement->phase_classification }}">{{ $agreement->text }}</label>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="row mb-6">
                                <div class="col-12">
                                    <h2 class="mb-5">Agreements</h2>
                                </div>
                                
                                <div class="col-12">
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
                                </div>

                                <div class="col-12">
                                    <div class="form-group mb-5">
                                        <div class="custom-control custom-checkbox">
                                            <input id="reactionAgreement" name="reactionAgreement" class="custom-control-input @error("reactionAgreement") is-invalid @enderror" type="checkbox">
                                            <label class="custom-control-label" for="reactionAgreement">I have not had any adverse reactions directly caused by a vaccine before.</label>
                        
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
                                    'state':'FL'
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
                                            text = "<b>Address was successufully validated!</b><br><b>Found address:</b> "+addr+"<button type='button' class='ml-2 btn btn-outline-success btn-sm' onclick=\"syncInlineAddress('"+data.address.Address2+"', '"+data.address.Address1+"', '"+data.address.City+"', '"+data.address.Zip5+"');$(this).hide();\">Sync Address</button>";
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
                        
                            function syncInlineAddress(address1, address2, city, zip) {
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
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection