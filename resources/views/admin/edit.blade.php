@extends('layouts.app')

@section('title')
    Admin Console - {{ $user->first_name.' '.$user->last_name }}
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
                <h2 class="title">{{ $user->first_name.' '.$user->last_name }}</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Edit the backend user.</p>
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

                @can('delete_user')
                <button class="btn btn-header-danger btn-header btn-round btn-lg" data-toggle="modal" data-target="#deleteModal">
                    <span class="fad fa-trash-alt mr-1"></span> Delete
                </button>    
                @endcan
            </div>
        </div>

        <div class="col-12">
            <form action="/admin/{{ $user->id }}" method="post">
                @csrf
                @method('put')
                @include('admin.partials.userform', [
                    'user' => $user,
                    'roles' => $roles,
                    'userRole' => $userRole,
                ])

                <div class="col-12">
                    <div class="text-center mb-6">
                        <!-- Button -->
                        <button type="submit" class="btn btn-header-success btn-header btn-round btn-lg">
                            <span class="fad fa-save mr-1"></span> Save
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

@can('delete_user')
<div class="modal fade" id="deleteModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="User Delete Modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body pb-0 pt-6 px-6">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <span class="fad fa-exclamation-triangle fa-5x text-danger"></span>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-12 text-center">
                        <p class="text-gray-dark mb-3 font-weight-bold">Danger!</p>
                        <p class="text-gray-dark mb-0">Are you sure you wish to delete this user account?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <form class="form-inline" action="/admin/{{ $user->id }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>        
        </div>
    </div>
</div>
@endcan
@endsection