<form action="/events" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="form-group mb-5">
                <label for="title">
                    Title
                </label>
                <input id="title" name="title" class="form-control @error("title") is-invalid @enderror" type="text" value="{{ old('title') }}" placeholder="Event Title">

                @error("title")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first("title") }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-5">
                <label for="date">
                    Date
                </label>
                <input id="date" name="date" class="form-control @error("date") is-invalid @enderror" type="date" value="{{ old('date') }}">

                @error("date")
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first("date") }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-5">
                <label for="location">
                    Location
                </label>
                <select id="location" name="location" class="custom-select @error("location") is-invalid @enderror">
                    @foreach (\App\Models\Location::get() as $location)
                        <option value="{{ $location->id }}" @if (old('location') && old('location') == $location->id) selected @endif>{{ $location->name }}</option>
                    @endforeach
                </select>

                @error('location')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('location') }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="form-group mb-5">
                <label for="slider">
                    Start and End Times: <span id="slider-time"></span> - <span id="slider-time2"></span>
                </label>
                <input id="start" name="start" class="sliderValue @error("start") is-invalid @enderror" type="hidden" value="{{ old('start') ?? 8 }}">
                <input id="end" name="end" class="sliderValue @error("end") is-invalid @enderror" type="hidden" value="{{ old('end') ?? 17 }}">
                <div id="slider"></div>

                @error("start")
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first("start") }}</strong>
                    </span>
                @enderror

                @error("end")
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first("end") }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-5">
                <label for="slotLength">
                    Slot Length
                </label>
                <select id="slotLength" name="slotLength" class="custom-select @error("slotLength") is-invalid @enderror">
                    @foreach (\App\Helpers\Events\SlotMachine::$validIntervals as $interval)
                        <option value="{{ $interval }}" @if (old('slotLength') && old('slotLength') == $interval) selected @endif>{{ $interval }}</option>
                    @endforeach
                </select>

                @error('slotLength')
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('slotLength') }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-5">
                <label for="slotCapacity">
                    Slot Capacity
                </label>
                <input id="slotCapacity" name="slotCapacity" class="form-control @error("slotCapacity") is-invalid @enderror" type="number" min="0" value="{{ old('slotCapacity') }}" placeholder="Capacity per time slot">

                @error("slotCapacity")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first("slotCapacity") }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-12">
            <div class="mb-5">
                <p class="h4">
                    Lot Numbers: <span id="lot-numbers">N/a</span>

                    @error("lots")
                    <span class="text-danger font-size-sm" role="alert">
                        <strong>{{ $errors->first("lots") }}</strong>
                    </span>
                    @enderror
                </p>

                <input type="hidden" name="lots" id="lots">

                <button type="button" class="btn btn-block btn-info" data-toggle="modal" data-target="#lotModal">
                    <span class="fad fa-plus"></span> Add Lot Numbers
                </button>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-5">
            <div class="form-group mb-5">
                <strong>Partner(s) for Event</strong>
                @foreach (\App\Models\Tag::where('is_partner', true)->get() as $tag)
                <div class="form-group mb-1">
                    <div class="custom-control custom-checkbox">
                        <input value="{{ $tag->id }}" id="tag-{{ $tag->id }}" name="partners[{{ $tag->id }}]" class="custom-control-input @error("partners.".$tag->id) is-invalid @enderror" type="checkbox" @if(old('partners.'.$tag->id)) checked aria-checked="true" @endif>
                        <label class="custom-control-label" for="tag-{{ $tag->id }}">{{ $tag->description }}</label>

                        @error("partners.".$tag->id)
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first("partners.".$tag->id) }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class="col-12 col-md-6 mb-5">
            <div class="form-group mb-2">
                <div class="custom-control custom-checkbox">
                    <input id="autoNotify" name="autoNotify" class="custom-control-input @error("autoNotify") is-invalid @enderror" type="checkbox" @if(old('autoNotify')) checked aria-checked="true" @endif>
                    <label class="custom-control-label" for="autoNotify">Send automatic invitations</label>

                    @error("autoNotify")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("autoNotify") }}</strong>
                        </span>
                    @enderror
                </div>
            </div>

            @can('create_invite')
            <div class="form-group mb-5">
                <div class="custom-control custom-checkbox">
                    <input id="openAutomatically" name="openAutomatically" class="custom-control-input @error("openAutomatically") is-invalid @enderror" type="checkbox" @if(old('openAutomatically')) checked aria-checked="true" @endif>
                    <label class="custom-control-label" for="openAutomatically">Open for automatic scheduling</label>

                    @error("openAutomatically")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("openAutomatically") }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            @endcan
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <span class="h4">Settings</span>
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
                <input id="ageMin" name="ageMin" class="form-control @error("ageMin") is-invalid @enderror" type="number" min="0" value="{{ old('ageMin') ?? 65 }}" placeholder="Age minimum (leave blank if no age minimum)">

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
                <input id="ageMax" name="ageMax" class="form-control @error("ageMax") is-invalid @enderror" type="number" min="0" value="{{ old('ageMax') }}" placeholder="Age maximum (leave blank if no age maximum)">

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
        @foreach (\App\Models\Condition::get() as $condition)
            @if($condition->display_name != null)
                <div class="col-12 col-lg-6 col-md-4">
                    <div class="form-group mb-5">
                        <div class="custom-control custom-checkbox">
                            <input id="condition{{ $condition->id }}" name="condition[{{$condition->id}}]" class="custom-control-input" type="checkbox" @if(old('condition') && array_key_exists($condition->id, old('condition'))) checked aria-checked="true" @endif>
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
                    <input type="radio" id="vulnerability-low" value="0|5" name="vulnerability" @if(old('vulnerability') == '0|5') checked aria-checked="true" @endif>
                    <label for="vulnerability-low">
                        0 - 5
                    </label>
                </div>
                <div class="btn-group-item font-weight-medium font-size-sm">
                    <input type="radio" id="vulnerability-med" value="6|10" name="vulnerability" @if(old('vulnerability') == '6|10') checked aria-checked="true" @endif>
                    <label for="vulnerability-med">
                        6 - 10
                    </label>
                </div>
                <div class="btn-group-item font-weight-medium font-size-sm">
                    <input type="radio" id="vulnerability-high" value="10" name="vulnerability" @if(old('vulnerability') == '10') checked aria-checked="true" @endif>
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
        @foreach (\App\Models\Occupation::get() as $occupation)
            @if($occupation->display_name != null)
                <div class="col-12 col-lg-6 col-md-4">
                    <div class="form-group mb-5">
                        <div class="custom-control custom-checkbox">
                            <input id="occupation{{ $occupation->id }}" name="occupation[{{$occupation->id}}]" class="custom-control-input" type="checkbox" @if(old('occupation') && array_key_exists($occupation->id, old('occupation'))) checked aria-checked="true" @endif>
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
                <input class="form-control" type="text" id="zips" placeholder="Zip1,Zip2,etc." name="zips" value="{{ old('zips') }}">
            </div>
        </div>

        <!-- Geolocation Section -->
        <div class="col-12">
            <span class="h5"><u>Geolocation</u> <small>(leave blank if no geolocation restriction)</small></span>
        </div>
        <div class="col-12">
            <div class="form-group">
                <label for="autocomplete">Address search</label>
                <input class="form-control" type="text" id="autocomplete" placeholder="Enter your address" onFocus="geolocate()" name="autocomplete" value="{{ old('autocomplete') }}">
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="lat">Latitude</label>
                <input class="form-control @error("latitude") is-invalid @enderror" type="number" id="lat" name="latitude" value="{{ old('latitude') }}" step="0.000000000000001">
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
                <input class="form-control @error("longitude") is-invalid @enderror" type="number" id="lng" name="longitude" value="{{ old('longitude') }}" step="0.000000000000001">
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
                    <input class="form-control form-control-sm @error("radius") is-invalid @enderror" type="number" id="radius" min="0" placeholder="Radius (in miles)" name="radius" value="{{ old('radius') }}">

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
