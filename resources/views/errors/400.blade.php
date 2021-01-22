@extends('layouts.app')

@section('title')
    400 Error
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
                        400
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">Looks like you're lost</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">The page you are looking for doesn't seem to exist.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="{{ url()->previous() }}">
                    Back to safety
                </a>
            </div>
        </div>
    </div>
</section>
@endsection