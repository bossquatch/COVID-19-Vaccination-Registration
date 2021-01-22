@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Locations
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
                        Locations
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">Manage Locations</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">Manage the locations for your events.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <ul class="list-group" id="locs-list">
                    <li class="list-group-item active">
                        <h3 class="h4 d-inline align-text-top">Locations List</h3>
                        @can('create_location')
                        <button class="btn btn-success btn-sm float-right" onclick="locForm('')"><span class="fad fa-plus-circle mr-1"></span>Add</button>    
                        @endcan
                    </li>
                    @can('create_location')
                        <li class="list-group-item" id="loc-row-new" @if ($errors->isEmpty()) style="display: none;" @endif>
                            <div class="row">
                                <div class="col-12 d-flex justify-content-between">
                                    <strong>New Location</strong>
                                    <button class="btn btn-outline-secondary btn-sm" onclick="locForm('none')"><span class="fal fa-times mr-1"></span>Cancel</button>
                                </div>
                            </div>
                            @include('location.partials.form')
                        </li>    
                    @endcan
                    
                    @foreach ($locations as $location)
                        <li class="list-group-item list-group-item-light">
                            <div class="d-flex w-100 justify-content-between">
                                <h4 class="h5 mb-1">{{ $location->name }}</h5>
                                <small>{{ $location->events()->count() . ' event(s)' }}</small>
                            </div>
                            <div class="d-flex w-100 justify-content-between">
                                <div class="d-inline">
                                    <p class="mb-0 font-size-xs text-muted">{{ $location->address }}</p>
                                    <p class="my-0 font-size-xs text-muted">{{ $location->zip . ' ' . $location->city . ', ' . $location->state }}</p>
                                </div>
                                
                                @can('delete_location')
                                    <a class="text-danger" href="#" onclick="deleteModal('{{ $location->id }}')"><span class="fad fa-trash-alt"></span><span class="sr-only">Delete</span></a>
                                @endcan
                            </div>
                        </li>
                    @endforeach
                    @if($locations->hasPages())
                    <li class="list-group-item list-group-item-light d-flex justify-content-center">
                        {!! $locations->links() !!}
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
</section>

@can('delete_location')
<div class="modal fade" id="deleteModal" data-backdrop="static" tabindex="-1" role="dialog" aria-label="Location Delete Modal" aria-hidden="true">
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
                        <p class="text-gray-dark mb-0">Are you sure you wish to delete this location?</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-dismiss="modal">Cancel</button>
                <form class="form-inline" id="deleteLocationForm" action="/locations/" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete Location</button>
                </form>
            </div>        
        </div>
    </div>
</div>
@endcan

<script>
    function locForm(display) {
        document.getElementById('loc-row-new').style.display = display;
    }
</script>

@can('delete_location')
    <script>
        function deleteModal(locId) {
            document.getElementById('deleteLocationForm').action = '/locations/' + locId;
            $('#deleteModal').modal('show');
            return false;
        }
    </script>
@endcan
@endsection