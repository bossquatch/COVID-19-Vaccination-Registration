<form action="/locations" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="form-group mb-5">
                <label for="name">
                    Name
                </label>
                <input id="name" name="name" class="form-control @error("name") is-invalid @enderror" type="text" value="{{ old('name') }}" placeholder="Location Title">

                @error("name")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first("name") }}</strong>
                </span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-5">
                <label for="address">
                    Address
                </label>
                <input id="address" name="address" class="form-control @error("address") is-invalid @enderror" type="text" value="{{ old('address') }}" placeholder="Address" {{-- onchange="checkInlineAddress()" --}}>

                @error("address")
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first("address") }}</strong>
                    </span>
                @enderror
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-5">
                <label for="city">
                    City
                </label>
                <input id="city" name="city" class="form-control @error("city") is-invalid @enderror" type="text" value="{{ old('city') }}" placeholder="City" {{-- onchange="checkInlineAddress()" --}}>

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
                <input id="zipCode" name="zip" class="form-control @error("zip") is-invalid @enderror" type="text" value="{{ old('zip') }}" placeholder="Zip code" {{-- onchange="checkInlineAddress()" --}}>

                @error("zip")
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first("zip") }}</strong>
                    </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-12 col-sm-5 col-md-4 col-lg-3">
            <button type="submit" class="btn btn-success btn-block">Submit</button>
        </div>
    </div>
</form>