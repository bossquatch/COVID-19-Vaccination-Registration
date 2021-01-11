@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Read QR Code
@endsection

@section('content')
<section class="main main-raised pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 text-center">
                <!-- Badge -->
                <span class="badge badge-pill badge-primary-soft mb-3">
                    <span class="h6 text-uppercase">
                        QR Code Reader
                    </span>
                </span>

                <!-- Heading -->
                <h1>
                    Read <span class="text-primary">registration codes</span> and <span class="text-primary">view data.</span>
                </h1>

                <!-- Text -->
                <p class="lead text-gray-dark mb-7 mb-md-9">
                    Verify registration just by QR Code.
                </p>
            </div>
        </div>

        <div class="col-12">
            <div class="text-center mb-6">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="/manage">
                    <span class="fad fa-times-circle mr-1"></span> Cancel
                </a>
            </div>
        </div>

        <div id="qr-reader-app" class="col-12"></div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/qr.js') }}"></script>
@endsection