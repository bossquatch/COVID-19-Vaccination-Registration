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
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="text-center">
                    <!-- Button -->
                    <a class="btn btn-header btn-round btn-lg" href="/manage">
                        <span class="fad fa-times-circle mr-1"></span> Cancel
                    </a>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-7">
                <div class="card border-0 shadow my-5">
                    <div class="card-body py-7 px-5">
                        <p class="font-size-sm text-muted mb-4 text-center">Scan a QR code using the camera on your device.</p>
                        <div id="qr-reader-app"></div>                    
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-12 col-md-7">
                <!-- Card -->
                <div class="card mt-4">
                    <div class="card-body p-6">
                        <p class="font-size-sm text-muted mb-4 text-center">Sample Registrant QR Code</p>
                        <div class="row align-items-center justify-content-center">
                            {{--<div class="col-12">
                                <button class="btn btn-link float-right text-danger text-sm p-0" data-toggle="modal" data-target="#deleteModal">
                                    <small><span class="fad fa-trash-alt mr-1"></span> Delete Registration</small>
                                </button>
                            </div>--}}
                            <div class="col-12 col-lg-4 text-center mb-0">
                                {!! \SimpleSoftwareIO\QrCode\Facades\QrCode::size(150)->generate("https://www.youtube.com/embed/TKQyPfN6s88"); !!}
                            </div>
                            <div class="col-12 col-lg-8 text-center mb-0">
                                <!-- Logo -->
                                {{--<div class="text-primary mb-4">
                                    <span class="fad fa-user-circle fa-4x"></span>
                                </div>--}}

                                <!-- Title -->
                                <h2 class="mb-2">
                                    John Doe
                                </h2>

                                <div class="badge badge-outline-muted mb-2">
                                    <span class="{{ \App\Models\Status::where('name','=','Scheduled')->first()->fa_icon }} mr-1"></span> {{ \App\Models\Status::where('name','=','Scheduled')->first()->name }}
                                </div>

                                <!-- Text -->
                                <p class="text-gray-dark mb-2">
                                    Submitted at: 01-18-2021 10:26:47 AM
                                </p>

                                <p class="text-gray-dark mb-2">
                                    Code: BEN1337
                                </p>

                                <p class="text-gray-dark mb-0">
                                    Phone number ending in: 1337
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@section('scripts')
<script src="{{ asset('js/qr.js') }}"></script>
@endsection
