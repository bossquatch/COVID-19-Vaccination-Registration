<div class="card card-body p-6 mb-4">
    <div class="row justify-content-end">
        <a class="fal fa-times text-muted" data-toggle="collapse" href="#editCollapse" role="button" aria-expanded="false" aria-controls="editCollapse" title="Close Edit Event Form"></a>
    </div>
    <span class="h3">
        Edit Event
    </span>
    <form action="/events/{{ $event->id }}" method="post">
        @csrf
        <div class="row">
            <div class="col-12">
                <div class="form-group mb-5">
                    <label for="title">
                        Title
                    </label>
                    <input id="title" name="title" class="form-control @error("title") is-invalid @enderror" type="text" value="{{ old('title') ?? $event->title }}" placeholder="Event Title">
    
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
                    <input id="date" name="date" class="form-control @error("date") is-invalid @enderror" type="date" value="{{ old('date') ?? $event->date_held }}">
    
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
                            <option value="{{ $location->id }}" @if (old('location')) @if(old('location') == $location->id) selected @endif @elseif( $event->location_id == $location->id) selected @endif>{{ $location->name }}</option>
                        @endforeach
                    </select>
    
                    @error('location')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $errors->first('location') }}</strong>
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
</div>