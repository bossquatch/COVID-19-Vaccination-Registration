<div class="card card-body p-4">
    <div class="row align-items-center justify-content-center">
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Date Given</h4>
            <p class="text-gray-dark mb-2">
                {{ Carbon\Carbon::createFromTimestamp($email_history->timestamp)->toDateTimeString() }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Recipient</h4>
            <p class="text-gray-dark mb-2">
                {{ $email_history->headers_to }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Subject</h4>
            <p class="text-gray-dark mb-2">
                {{ $email_history->headers_subject }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>From</h4>
            <p class="text-gray-dark mb-2">
                {{ $email_history->envelope_sender }}
            </p>
        </div>
        <div class="col-12 text-center col-md-6 col-lg-4">
            <h4>Status</h4>
            <p class="text-gray-dark mb-2">
                {{ $email_history->event }}
            </p>
        </div>
    </div>
</div>
