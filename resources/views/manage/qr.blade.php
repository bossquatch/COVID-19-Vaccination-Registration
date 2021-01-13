@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Read QR Code
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
                        QR
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">Read QR Codes</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Verify registration just by QR Code.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
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