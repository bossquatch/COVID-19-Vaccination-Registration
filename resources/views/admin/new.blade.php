@extends('layouts.app')

@section('title')
    Admin Console - New User
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
                        Admin
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">New User</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Keep track of the users in the system.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="col-12">
            <div class="text-center mb-6">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="/admin">
                    <span class="fad fa-times-circle mr-1"></span> Cancel
                </a>
            </div>
        </div>

        <div class="col-12">
            <form action="/admin" method="post">
                @csrf
                @include('admin.partials.userform', [
                    'user' => $user,
                    'roles' => $roles,
                    'userRole' => $userRole,
                ])

                <div class="col-12">
                    <div class="text-center mb-6">
                        <!-- Button -->
                        <button type="submit" class="btn btn-header-success btn-header btn-round btn-lg">
                            <span class="fad fa-save mr-1"></span> Create
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>
@endsection