@extends('layouts.app')

@section('title')
    {{ config('app.name', 'Laravel') }} - Search
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
                        Manage
                    </span>
                </span>

                <!-- Heading -->
                <h1>
                    Review and process <span class="text-primary">online registrations.</span>
                </h1>

                <!-- Text -->
                <p class="lead text-gray-dark mb-7 mb-md-9">
                    View COVID-19 Vaccine Registrations.
                </p>
            </div>
        </div>

        <div class="col-12">
            <div class="text-center mb-6">
                <!-- Button -->
                <a class="btn btn-header btn-round btn-lg" href="/manage/register">
                    <span class="fad fa-clipboard-check mr-1"></span> Register Caller
                </a>

                <a class="btn btn-header btn-round btn-lg" href="/manage/qr">
                    <span class="fad fa-qrcode mr-1"></span> Scan QR Code
                </a>

                <a class="btn btn-header btn-round btn-lg" href="{{ route('logout') }}"
                    onclick="event.preventDefault();
                                    document.getElementById('logout-form').submit();">
                    <span class="fad fa-sign-out mr-1"></span> Sign out
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
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
                                            <th>
                                                Registration ID
                                            </th>
                                            <th>
                                                Registration Code
                                            </th>
                                            <th>
                                                Submitted At
                                            </th>
                                            <th>
                                                Status
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
        </div>
    </div>
</section>
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

    var searchInfo = {
        'val': $("#"+type).val()
    };

    $.get('/manage/'+type, searchInfo, function(data) {
        $("#registrations").html(data.result);
        $('#loadingModal').modal('hide');
    }, 'json');

    setTimeout(function () {
       	$('#loadingModal').modal('hide');
    }, 1000);
}
</script>
@endsection