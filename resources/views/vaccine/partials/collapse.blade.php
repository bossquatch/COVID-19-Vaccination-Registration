<div class="collapse" id="vaccineCollapse">
    <input id="registrationId" type="hidden" value="{{ $registration->id }}">
    <div class="mb-4">
        <h2 class="font-size-xl mb-3">Lot Number <small class="text-muted font-size-xs">(Choose One)</small></h2>
        <div class="custom-btn-group mb-3">
            @forelse (($registration->has_appointment ? $registration->appointment->event->lots->all() : collect([])) as $lot)
                <div class="btn-group-item font-weight-medium font-size-sm">
                    <input type="radio" id="lotNumber-{{ $lot->id }}" value="{{ $lot->id }}" name="lotNumber" @if($loop->first) checked aria-checked="true" @endif>
                    <label for="lotNumber-{{ $lot->id }}">
                        {{ $lot->number }}
                    </label>
                </div>
            @empty
                <div class="alert alert-warning col-12">
                    No available lot numbers.
                </div>
            @endforelse
        </div>
    </div>
    <div class="mb-4">
        <h2 class="font-size-xl mb-3">Injection site <small class="text-muted font-size-xs">(Choose One)</small></h2>
        <div class="custom-btn-group mb-3">
            @foreach (\App\Models\InjectionSite::get() as $site)
                <div class="btn-group-item font-weight-medium font-size-sm">
                    <input type="radio" id="injectionSite-{{ $site->id }}" value="{{ $site->id }}" name="injectionSite" @if($site->abbrev == "LD") checked aria-checked="true" @endif>
                    <label for="injectionSite-{{ $site->id }}">
                        {{ $site->abbrev }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mb-4">
        <h2 class="font-size-xl mb-3">Eligibility <small class="text-muted font-size-xs">(Choose One)</small></h2>
        <div class="custom-btn-group mb-3">
            @foreach (\App\Models\Eligibility::get() as $ele)
                <div class="btn-group-item font-weight-medium font-size-sm">
                    <input type="radio" id="eligibility-{{ $ele->id }}" value="{{ $ele->id }}" name="eligibility" @if($loop->last) checked aria-checked="true" @endif>
                    <label for="eligibility-{{ $ele->id }}">
                        {{ str_replace("COVID-19 ", "", $ele->description) }}
                    </label>
                </div>
            @endforeach
        </div>
    </div>
    <div class="mb-4">
        <h2 class="font-size-xl mb-3">Risk factors <small class="text-muted font-size-xs">(Choose All That Apply)</small></h2>
        <div class="custom-btn-group mb-3">
            @foreach (\App\Models\RiskFactor::get() as $risk)
                @if($risk->name != null)
                    <div class="btn-group-item font-weight-medium font-size-sm">
                        <input class="js-risk" type="checkbox" id="riskFactors-{{ $risk->id }}" value="{{ $risk->id }}" name="riskFactors" data-risk="{{ $risk->id }}">
                        <label for="riskFactors-{{ $risk->id }}">
                            {{ $risk->name }}
                        </label>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
    <div class="mb-4">
        <button id="vacLoadingBtn" type="button" class="btn btn-secondary btn-block" disabled aria-disabled="true" style="display: none">
            <span class="fad fa-spinner fa-spin"></span>
        </button>
        <button id="vacBtn" type="button" class="btn btn-success btn-block" onclick="submitVacForm()">Submit</button>
    </div>
    <div class="mb-4 alert alert-danger d-none" id="vaccineErrors"></div>
    <hr>
</div>
