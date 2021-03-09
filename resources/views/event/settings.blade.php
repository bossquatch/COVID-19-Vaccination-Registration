@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Event Settings
@endsection

@section('header')
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
                        Events
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">Manage Event Settings</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Manage the settings of an event.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="col-12">
            <div class="text-center mb-6">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="/events/{{ $event->id }}">
                    <span class="fad fa-arrow-left mr-1"></span> Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <!-- Card -->
                <div class="card card-border border-primary shadow-light-lg">
                    <div class="card-header">
                        <span class="h3">{{ $event->title }} - Settings</span>
                    </div>
                    
                    <div class="card-body">
                        <!-- Form -->
                        <form action="/events/{{ $event->id }}/settings" method="post">
                            @csrf
                            <div class="row">
                                <!-- Polk Only Section -->
                                <div class="col-12">
                                    <span class="h5"><u>Basic</u></span>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="ml-auto custom-control custom-switch mt-2 mb-5">
                                        <input type="checkbox" class="custom-control-input" id="polkOnly" name="polkOnly" @if(old('polkOnly') || $settings->polk_only) checked aria-checked="true" @endif>
                                        <label class="custom-control-label" for="polkOnly">Only Invite Polk Residents</label>
                                    </div>
                                </div>

                                <!-- Age Section -->
                                <div class="col-12">
                                    <span class="h5"><u>Age</u> <small>(leave blank if no age restriction)</small></span>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="ageMin">
                                            Min
                                        </label>
                                        <input id="ageMin" name="ageMin" class="form-control @error("ageMin") is-invalid @enderror" type="number" min="0" value="{{ old('ageMin') ?? $settings->age_min }}" placeholder="Age minimum (leave blank if no age minimum)">
                        
                                        @error("ageMin")
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first("ageMin") }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="form-group mb-5">
                                        <label for="ageMax">
                                            Max
                                        </label>
                                        <input id="ageMax" name="ageMax" class="form-control @error("ageMax") is-invalid @enderror" type="number" min="0" value="{{ old('ageMax') ?? $settings->age_max }}" placeholder="Age maximum (leave blank if no age maximum)">
                        
                                        @error("ageMax")
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first("ageMax") }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                        
                                <!-- Conditions Section -->
                                <div class="col-12">
                                    <span class="h5"><u>Underlying Conditions</u> <small>(leave blank if no condition restriction)</small></span>
                                </div>
                                @php
                                    $conditions = $settings->conditions()->pluck('id')->toArray();
                                @endphp
                                @foreach (\App\Models\Condition::get() as $condition)
                                    @if($condition->display_name != null)
                                        <div class="col-12 col-lg-6 col-md-4">
                                            <div class="form-group mb-5">
                                                <div class="custom-control custom-checkbox">
                                                    <input id="condition{{ $condition->id }}" name="condition[{{$condition->id}}]" class="custom-control-input" type="checkbox" @if(old('condition')) @if(array_key_exists($condition->id, old('condition'))) checked aria-checked="true" @endif @elseif(in_array($condition->id, $conditions)) checked aria-checked="true" @endif>
                                                    <label class="custom-control-label" for="condition{{ $condition->id }}">{{ $condition->display_name }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                        
                                <!-- Vulnerablity Section -->
                                <div class="col-12">
                                    <span class="h5"><u>Vulnerablity Score</u> <small>(leave blank if no vulnerability restriction)</small></span>
                                </div>
                                <div class="col-12 col-md-6">
                                    <div class="custom-btn-group my-3">
                                        <div class="btn-group-item font-weight-medium font-size-sm">
                                            <input type="radio" id="vulnerability-low" value="0|5" name="vulnerability" @if(old('vulnerability')) @if(old('vulnerability') == '0|5') checked aria-checked="true" @endif @elseif($settings->vulnerability_min == '0') checked aria-checked="true" @endif>
                                            <label for="vulnerability-low">
                                                0 - 5
                                            </label>
                                        </div>
                                        <div class="btn-group-item font-weight-medium font-size-sm">
                                            <input type="radio" id="vulnerability-med" value="6|10" name="vulnerability"  @if(old('vulnerability')) @if(old('vulnerability') == '6|10') checked aria-checked="true" @endif @elseif($settings->vulnerability_min == '6') checked aria-checked="true" @endif>
                                            <label for="vulnerability-med">
                                                6 - 10
                                            </label>
                                        </div>
                                        <div class="btn-group-item font-weight-medium font-size-sm">
                                            <input type="radio" id="vulnerability-high" value="10" name="vulnerability" @if(old('vulnerability')) @if(old('vulnerability') == '10') checked aria-checked="true" @endif @elseif($settings->vulnerability_min == '10') checked aria-checked="true" @endif>
                                            <label for="vulnerability-high">
                                                10+
                                            </label>
                                        </div>
                                    </div>
                                </div>
                        
                                <!-- Occupation Section -->
                                <div class="col-12">
                                    <span class="h5"><u>Occupational Risks</u> <small>(leave blank if no occupation restriction)</small></span>
                                </div>
                                @php
                                    $occupations = $settings->occupations()->pluck('id')->toArray();
                                @endphp
                                @foreach (\App\Models\Occupation::get() as $occupation)
                                    @if($occupation->display_name != null)
                                        <div class="col-12 col-lg-6 col-md-4">
                                            <div class="form-group mb-5">
                                                <div class="custom-control custom-checkbox">
                                                    <input id="occupation{{ $occupation->id }}" name="occupation[{{$occupation->id}}]" class="custom-control-input" type="checkbox" @if(old('occupation')) @if(array_key_exists($occupation->id, old('occupation'))) checked aria-checked="true" @endif @elseif(in_array($occupation->id, $occupations)) checked aria-checked="true" @endif>
                                                    <label class="custom-control-label" for="occupation{{ $occupation->id }}">{{ $occupation->display_name }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endforeach
                        
                                <!-- Zip Codes Section -->
                                <div class="col-12">
                                    <span class="h5"><u>Zip Codes</u> <small>(leave blank if no zip code restriction)</small></span>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="zips">Zip Codes (in a comma-seperated list)</label>
                                        <input class="form-control" type="text" id="zips" placeholder="Zip1,Zip2,etc." name="zips" value="{{ old('zips') ?? $settings->zips_string }}">
                                    </div>
                                </div>
                        
                                <!-- Geolocation Section -->
                                <div class="col-12">
                                    <span class="h5"><u>Geolocation</u> <small>(leave blank if no geolocation restriction)</small></span>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="autocomplete">Address search</label>
                                        <input class="form-control" type="text" id="autocomplete" placeholder="Enter your address" onFocus="geolocate()" name="autocomplete" value="{{ old('autocomplete') ?? $settings->search_address }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lat">Latitude</label>
                                        <input class="form-control @error("latitude") is-invalid @enderror" type="number" id="lat" name="latitude" value="{{ old('latitude') ?? $settings->latitude }}" step="0.000000000000001">
                                        @error("latitude")
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first("latitude") }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="lng">Longitude</label>
                                        <input class="form-control @error("longitude") is-invalid @enderror" type="number" id="lng" name="longitude" value="{{ old('longitude') ?? $settings->longitude }}" step="0.000000000000001">
                                        @error("longitude")
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $errors->first("longitude") }}</strong>
                                        </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row px-4">
                                        <label for="radius" class="col-form-label col-form-label-sm">Within</label>
                                        <div class="col-sm-4">
                                            <input class="form-control form-control-sm @error("radius") is-invalid @enderror" type="number" id="radius" min="0" placeholder="Radius (in miles)" name="radius" value="{{ old('radius') ?? $settings->search_radius }}">
                                        
                                            @error("radius")
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $errors->first("radius") }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <span class="col-form-label col-form-label-sm">mile radius.</span>
                                    </div>
                                </div>
                            </div>
                            <div class="row justify-content-end">
                                <div class="col-12 col-sm-5 col-md-4 col-lg-3">
                                    <button type="submit" class="btn btn-success btn-block">Submit</button>
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
let placeSearch;
let autocomplete;

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

</script>
@endsection