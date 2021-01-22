@extends('layouts.app')

@section('title')
    We'll be right back!
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
                        503
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">Our site is currently down for maintenance</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">We will be back soon</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
    </div>
</section>
@endsection
