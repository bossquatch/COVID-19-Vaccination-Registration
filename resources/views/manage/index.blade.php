@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Search
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
                        Manage
                    </span>
                </span>

                <!-- Heading -->
                <h2 class="title">Search Online Registrations</h2>

                <!-- Text -->
                <p class="font-size-lg text-gray-dark mb-0">View COVID-19 Vaccine Registrations.</p>
            </div>
        </div>
    </div>
</div>

<section class="main pt-8 pt-md-11 pb-8 pb-md-12">
    <div class="container">
        <div class="col-12">
            <div class="text-center mb-6">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="/manage/register">
                    <span class="fad fa-clipboard-check mr-1"></span> Register Caller
                </a>

                <a class="btn btn-header btn-round btn-lg" href="/docs/consent_moderna.pdf" target="_blank" rel="noopener" download aria-download="true">
                    <span class="fad fa-file-medical mr-1"></span> Moderna Consent Form
                </a>

                @can('read_vaccine')
                <a class="btn btn-header btn-round btn-lg" href="/manage/qr">
                    <span class="fad fa-qrcode mr-1"></span> Scan QR Code
                </a>
                @endcan

                @can('read_event')
                <a class="btn btn-header btn-round btn-lg" href="/events">
                    <span class="fad fa-calendar-day mr-1"></span> Events
                </a>
                @endcan
            </div>
        </div>

        <div class="row">
            <div class="col-12 col-md-6 ml-auto">
                <div class="input-group mb-3">
                    <input type="text" class="form-control font-size-sm" id="searchName" placeholder="Search for Name" aria-label="Search for Name" aria-describedby="caseBtn">
                    <div class="input-group-append">
                        <button class="btn btn-primary font-size-sm" type="submit" id="nameBtn" onclick="search('searchName')">
                            <span class="fad fa-search mr-1"></span> Search
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 ml-auto">
                <div class="input-group mb-3">
                    <input type="text" class="form-control font-size-sm" id="searchAddr" placeholder="Search for Address" aria-label="Search for Address" aria-describedby="addrBtn">
                    <div class="input-group-append">
                        <button class="btn btn-primary font-size-sm" type="submit" id="addrBtn" onclick="search('searchAddr')">
                            <span class="fad fa-search mr-1"></span> Search
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 ml-auto">
                <div class="input-group mb-3">
                    <input type="text" class="form-control font-size-sm" id="searchRegis" placeholder="Search for Registration ID" aria-label="Search for Registration ID" aria-describedby="regisBtn">
                    <div class="input-group-append">
                        <button class="btn btn-primary font-size-sm" type="submit" id="regisBtn" onclick="search('searchRegis')">
                            <span class="fad fa-search mr-1"></span> Search
                        </button>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 ml-auto">
                <div class="input-group mb-3">
                    <input type="text" class="form-control font-size-sm" id="searchCode" placeholder="Search for Registration Code" aria-label="Search for Registration Code" aria-describedby="codeBtn">
                    <div class="input-group-append">
                        <button class="btn btn-primary font-size-sm" type="submit" id="codeBtn" onclick="search('searchCode')">
                            <span class="fad fa-search mr-1"></span> Search
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card-no-flex">
                    <div class="header border-0">
                        <!-- Title -->
                        <h2 class="h5 mb-0">
                            Registrations
                        </h2>

                        {{--<!-- Tabs -->
                        <ul id="applications-tablist" class="nav nav-tabs ml-auto" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" aria-selected="true">
                                    Showing: <b>{{ $appType }}</b>
                                </a>
                            </li>
                            <li class="nav-item text-right">
                                <div class="dropdown">
                                    <a href="#" class="nav-link dropdown-toggle no-caret dropdown-ellipsis" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        Show:
                                        <span class="fas fa-ellipsis-v"></span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right" style="">
                                        <a href="/Manage" class="dropdown-item">
                                            All
                                        </a>
                                        @php
                                            $statuses = \App\StatusType::get();
                                        @endphp
                                        @foreach ($statuses as $status)
                                        <a href="/Manage/type/{{$status->id}}" class="dropdown-item">
                                            {{ $status->status }}
                                        </a>
                                        @endforeach
                                        <a href="/Manage/mine" class="dropdown-item">
                                            Mine
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>--}}
                    </div>

                    <div id="applications-tablist-content" class="tab-content">
                        <div id="all" class="tab-pane show active">
                            <!-- Table -->
                            <div class="table-responsive">
                                <table class="table table-silk">
                                    <thead>
                                        <tr>
                                            <th>
                                                Name
                                            </th>
                                            @can('read_user')
                                            <th>
                                                Registration ID
                                            </th>    
                                            @endcan
                                            <th>
                                                Registration Code
                                            </th>
                                            <th>
                                                Submitted At
                                            </th>
                                            <th>
                                                Status
                                            </th>
                                            <th class="text-center">
                                                Email Verified
                                            </th>
                                            <th>
                                                {{-- Actions --}}
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody id="registrations"></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12 text-center" id="pagination-area"></div>
        </div>
    </div>
</section>

@can('update_registration')
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
                <form class="form-inline" id="userDeleteForm" action="/manage/user/" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete User</button>
                </form>
            </div>        
        </div>
    </div>
</div>

<script>
    function deleteUser(id) {
        document.getElementById("userDeleteForm").action = "/manage/user/" + id;
        $("#deleteModal").modal('show');
    }
</script>
@endcan

<script>
// Get the input field
var inputName = document.getElementById("searchName");
var inputAddr = document.getElementById("searchAddr");
var inputRegis = document.getElementById("searchRegis");
var inputCode = document.getElementById("searchCode");

// Execute a function when the user releases a key on the keyboard
inputName.addEventListener("keyup", event => { inputEnter(event, "nameBtn") }); 
inputAddr.addEventListener("keyup", event => { inputEnter(event, "addrBtn") });
inputRegis.addEventListener("keyup", event => { inputEnter(event, "regisBtn") }); 
inputCode.addEventListener("keyup", event => { inputEnter(event, "codeBtn") }); 

function inputEnter(event, btnid) {
    // Number 13 is the "Enter" key on the keyboard
    if (event.keyCode === 13) {
        // Cancel the default action, if needed
        event.preventDefault();
        // Trigger the button element with a click
        document.getElementById(btnid).click();
    }
}

function search(type) {
    $('#loadingModal').modal('show');

    var val = $("#"+type).val();
    var offset = '0';

    window.sessionStorage.setItem('searchVal', val);
    window.sessionStorage.setItem('searchOffset', offset);
    window.sessionStorage.setItem('searchLimit', offset);
    window.sessionStorage.setItem('searchType', type);

    var searchInfo = {
        'val': val,
        'offset': parseInt(offset)
    };

    setTimeout(function () {
       	$('#loadingModal').modal('hide');
    }, 1000);
    makeRequest(searchInfo, type);
}

function getNext() {
    $('#loadingModal').modal('show');
    
    var searchInfo = {
        'val': window.sessionStorage.getItem('searchVal'),
        'offset': parseInt(window.sessionStorage.getItem('searchOffset'))
    };

    setTimeout(function () {
       	$('#loadingModal').modal('hide');
    }, 1000);
    makeRequest(searchInfo, window.sessionStorage.getItem('searchType'));

    return false;
}

function getPrev() {
    $('#loadingModal').modal('show');
    
    var searchInfo = {
        'val': window.sessionStorage.getItem('searchVal'),
        'offset': parseInt(window.sessionStorage.getItem('searchOffset')) - (2 * parseInt(window.sessionStorage.getItem('searchLimit')))
    };

    setTimeout(function () {
       	$('#loadingModal').modal('hide');
    }, 1000);
    makeRequest(searchInfo, window.sessionStorage.getItem('searchType'));

    return false;
}

function makeRequest(searchInfo, type) {
    $.get('/manage/'+type, searchInfo, function(data) {
        // data.result, .offset, .limit, .pagination
        window.sessionStorage.setItem('searchOffset', data.offset.toString())
        window.sessionStorage.setItem('searchLimit', data.limit.toString())
        $("#registrations").html(data.result);
        $("#pagination-area").html(data.pagination);
        $('#loadingModal').modal('hide');
    }, 'json');

    setTimeout(function () {
       	$('#loadingModal').modal('hide');
    }, 1000);
}
</script>
@endsection