<div class="row justify-content-end">
    <a class="fal fa-times text-muted" data-toggle="collapse" href="#newSlotColl" role="button" aria-expanded="false" aria-controls="newSlotColl" title="Close Edit Event Form"></a>
</div>
<span class="h3">
    Add Slot
</span>
<form action="/events/{{ $event->id }}/slots" method="post">
    @csrf
    <div class="row">
        <div class="col-12">
            <div class="form-group mb-5">
                <div class="form-group mb-5">
                    <label for="startTime">
                        Start Time
                    </label>
                    <select id="startTime" name="startTime" class="custom-select @error("startTime") is-invalid @enderror">
                        @foreach ($event->startable as $date)
                            <option value="{{ $date }}" @if(old('startTime') && old('startTime') == $date) selected @endif>{{ $date->format("h:iA") }}</option>    
                        @endforeach
                    </select>
    
                    @error('startTime')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('startTime') }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <div class="form-group mb-5">
                <label for="slotLength">
                    Slot Length
                </label>
                <select id="slotLength" name="slotLength" class="custom-select @error("slotLength") is-invalid @enderror">
                    <option value="15 minutes" @if(old('slotLength') && old('slotLength') == '15 minutes') selected @endif>15 minutes</option>
                    <option value="30 minutes" @if(old('slotLength') && old('slotLength') == '30 minutes') selected @endif>30 minutes</option>
                    <option value="1 hour" @if(old('slotLength') && old('slotLength') == '1 hour') selected @endif>1 hour</option>
                    <option value="2 hours" @if(old('slotLength') && old('slotLength') == '2 hours') selected @endif>2 hours</option>
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
                <input id="slotCapacity" name="slotCapacity" class="form-control @error("slotCapacity") is-invalid @enderror" type="number" min="0" value="{{ old('slotCapacity') }}" placeholder="Capacity for time slot">

                @error("slotCapacity")
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first("slotCapacity") }}</strong>
                </span>
                @enderror
            </div>
        </div>
    </div>
    <div class="row justify-content-end">
        <div class="col-12">
            <button type="submit" class="btn btn-success btn-block">Submit</button>
        </div>
    </div>
</form>