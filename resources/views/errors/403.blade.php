@extends('layouts.app')

@section('title')
    Forbidden
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
                        Forbidden
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">It seems like you are trying to access something that doesn't exist.</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Most likely, you clicked a link or used a url that has expired. Use the button below to go home and try to start from there.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="row">
            <div class="col-12 text-center">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="{{ '/home' }}">
                    Take me home
                </a>
            </div>
        </div>
    </div>
</section>
@endsection
