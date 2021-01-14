<!-- Success Modal -->
<div class="modal fade" id="successModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Success Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fad fa-check-circle fa-5x text-success"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-5">@if (\Session::has('success')) {!! \Session::get('success') !!} @endif</p>
                        <button type="button" class="btn btn-header btn-round btn-lg" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Failure Modal -->
<div class="modal fade" id="failureModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Failure Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fad fa-times-hexagon fa-5x text-danger"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-5">There are some errors in your submission:
                            @error('form')
                                @foreach ($errors->all() as $error)
                                    <br/>&nbsp;- {{ $error }}
                                @endforeach
                            @enderror
                        </p>
                        <button type="button" class="btn btn-header btn-round btn-lg" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Warning Modal -->
<div class="modal fade" id="warningModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Warning Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fad fa-exclamation-triangle fa-5x text-warning"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-5">Warning!</p>
                        <button type="button" class="btn btn-header btn-round btn-lg" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Modal -->
<div class="modal fade" id="infoModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Info Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fad fa-info-circle fa-5x text-primary"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-5">Information.</p>
                        <button type="button" class="btn btn-header btn-round btn-lg" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Loading Modal -->
<div class="modal fade" id="loadingModal" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-label="Loading Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-sm">
        <div class="modal-content">
            <div class="modal-body p-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fa fa-spinner fa-spin fa-3x"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-5">Loading...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<!-- Variable Modal -->
<div class="modal fade" id="varModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Variable Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body p-6">
                <div class="row mb-4">
                    <div class="col-12 text-center js-modal-icon"></div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-5 js-modal-text"></p>
                        <button type="button" class="btn btn-header btn-round btn-lg" data-dismiss="modal">Ok</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@error('form')
<script>
    $(document).ready(function(){
        $("#failureModal").modal();
    });
</script>
@enderror

@if (\Session::has('success'))
<script>
    $(document).ready(function(){
        $("#successModal").modal();
    });
</script>
@endif