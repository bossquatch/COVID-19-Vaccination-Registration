@extends('layouts.app')

@section('title')
    We'll be right back!
@endsection

@section('content')
<!-- Header -->
<div class="page-header page-header-inner header-filter page-header-default"></div>

<section class="main main-raised pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-md-10 col-lg-8 text-center">
                <!-- Badge -->
                <span class="badge badge-pill badge-primary-soft mb-3">
                    <span class="h6 text-uppercase">
                        {{\Carbon\Carbon::now()->toDateTimeLocalString()}}
                    </span>
                </span>

                <!-- Heading -->
                <h1>
                    Our site is currently <span class="text-primary">down</span>  for maintenance.
                </h1>


                <!-- Text -->
                <p class="lead text-gray-dark mb-7 mb-md-9">
                    We will be back soon.
                </p>
                @can ('view_errors')
                    <p>THIS IS AN ERROR. OOOH, BIG AND SCARY!</p>
                @endcan

            </div>
        </div>
    </div>
</section>
@endsection
