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
            <div class="form-group mb-5">
                <label for="lot">
                    Lot Number
                </label>
                <input id="lot" name="lot" class="lot-input form-control @error("lot") is-invalid @enderror" type="text" value="{{ old('lot') }}" placeholder="Lot Number">
                <span class="form-text font-weight-light font-size-xs text-muted">Additional lot numbers can be added later.</span>

                @error("lot")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first("lot") }}</strong>
                </span>
                @enderror
            </div>
        </div>
        @can('create_invite')
        <div class="col-12">
            <div class="form-group mb-5">
                <div class="custom-control custom-checkbox">
                    <input id="manualSchedule" name="manualSchedule" class="custom-control-input @error("manualSchedule") is-invalid @enderror" type="checkbox" @if(old('manualSchedule')) checked aria-checked="true" @endif>
                    <label class="custom-control-label" for="manualSchedule">Schedule Manually</label>

                    @error("manualSchedule")
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first("manualSchedule") }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        @endcan
    </div>
    <div class="row justify-content-end">
        <div class="col-12 col-sm-5 col-md-4 col-lg-3">
            <button type="submit" class="btn btn-success btn-block">Submit</button>
        </div>
    </div>
</form>