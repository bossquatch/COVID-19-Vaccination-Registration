@extends('layouts.app')

@section('title')
    420 Error
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
                        420
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">What are you trying to do here?</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">No one messes with Red Leader...</p>
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