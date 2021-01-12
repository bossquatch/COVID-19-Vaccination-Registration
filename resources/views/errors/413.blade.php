@extends('layouts.app')

@section('title')
    413 Error
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
                        413
                    </span>
                </span>

                <!-- Heading -->
                <h1>
                    Looks like a <span class="text-primary">file was too large.</span>
                </h1>

                <!-- Text -->
                <p class="lead text-gray-dark mb-7 mb-md-9">
                    One or more of the files that you attached is to large, please submit a smaller file(s).
                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-12 text-center">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="{{ url()->previous() }}">
                    Back to application
                </a>
            </div>
        </div>
    </div>
</section>
@endsection