@extends('layouts.app')

@section('title')
    Admin Console
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
                <h2 class="title">Administration Panel</h2>

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
                <a class="btn btn-header btn-round btn-lg" href="/admin/reports">
                    <span class="fad fa-file-chart-line mr-1"></span> View PHP Reports
                </a>
            </div>
        </div>

        <div class="row mb-6">
            <div class="col-12 col-sm-6 col-md-3 ml-auto mr-auto">
                <div class="card card-body mb-5">
                    <div class="text-success mb-4 ml-auto mr-auto">
                        <span class="fad fa-user-circle fa-4x"></span>
                    </div>
                    <a href="/admin/new" class="btn btn-success font-size-sm ml-auto mr-auto">
                        <span class="fad fa-user-plus mr-1"></span> New User
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-8 mr-auto ml-auto">
                <div class="input-group mb-4">
                    <div class="input-group-prepend font-size-sm">
                        <span class="input-group-text text-primary">
                            <span class="fad fa-search"></span>
                        </span>
                    </div>
                    <input type="text" onkeyup="searchUsers()" class="form-control font-size-sm" id="userSearch" placeholder="Search Users">
                </div>
            </div>
        </div>

        <div class="row mb-6">
            @foreach ($users as $user)
            <div class="col-12 col-sm-6 col-md-3 ml-auto mr-auto js-user-card">
                <div class="card mb-5">
                    <div class="card-body text-center pb-0">
                        <div class="text-primary mb-4 ml-auto mr-auto">
                            {{--<span class="fad fa-user-circle fa-4x"></span>--}}
                            <img class="rounded-circle" src="https://www.gravatar.com/avatar/{{ md5(strtolower($user->email)) }}?d=robohash" alt="{{ $user->first_name.' '.$user->last_name }}" width="100px">
                        </div>
                        <span class="text-primary mb-2 ml-auto mr-auto js-user-name">{{ $user->first_name.' '.$user->last_name }}</span>
                        <div class="row justify-content-center">
                            <span>{{ $user->role }}</span>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="row">
                            <div class="col-6 text-left">
                                <div class="row px-4">
                                    <div class="js-button">
                                        <a href="#" class="text-secondary mr-1" title="Reset User Password" aria-title="Reset User Password" onclick="resetPassword(this, {{ $user->id }})">
                                            <span class="fad fa-undo"></span>
                                        </a>
                                    </div>
                                    <div class="js-state" style="display: none"></div>
                                </div>
                            </div>
                            <div class="col-6 text-right">
                                <a href="/admin/{{ $user->id }}" class="text-primary ml-auto" title="Edit User" aria-title="Edit User">
                                    <span class="fad fa-edit"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

<script>
    function searchUsers() {
        // Declare variables
        var input, filter, cards, username, i;
        input = document.getElementById("userSearch");
        filter = input.value.toUpperCase();
        cards = document.getElementsByClassName("js-user-card");

        // Loop through all list items, and hide those who don't match the search query
        for (i = 0; i < cards.length; i++) {
            username = cards[i].getElementsByClassName("js-user-name")[0];
            if (username.innerHTML.toUpperCase().indexOf(filter) > -1) {
                cards[i].style.display = "";
            } else {
                cards[i].style.display = "none";
            }
        }
    }

    function resetPassword(el, id) {
        var loadingIcon = '{!! view('admin.partials.reset.loading')->render() !!}';

        var button = el.parentElement;
        var state = button.nextElementSibling;

        console.log(el);
        console.log(button);
        console.log(state);

        state.innerHTML = loadingIcon;
        state.style.display = "";
        button.style.display = "none"

        var postInfo = {
            '_token' : $('meta[name=csrf-token]').attr('content'),
            'userId' : id,
        };

        $.post('/admin/reset', postInfo, function(data) {
            state.innerHTML = data.html;
            button.style.display = "";
        }, 'json');

        return false;
    }
</script>
@endsection