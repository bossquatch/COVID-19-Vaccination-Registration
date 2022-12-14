<!-- Navigation -->
<nav class="navbar fixed-top navbar-expand-md  @if(Request::is('/')) navbar-transparent navbar-color-on-scroll @endif" @if(Request::is('/')) color-on-scroll="100" @endif>
    <div class="container-md">
        <img src="/images/FDOH-Polk-color-logo3.png" height="58" />
        <a class="navbar-brand ml-5" href="/"><span class="fal fa-home-alt mr-2"></span>Polk Health</a>

        <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="far fa-bars"></span>
        </button>

        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                {{--<li class="nav-item">
                    <a class="nav-link" href="#">Locations</a>
                </li>--}}
                {{--<li class="nav-item">
                    <a class="nav-link" href="#">Testing Sites</a>
                </li>--}}
                <li class="nav-item">
                    <a class="nav-link" href="/faqs">FAQs</a>
                </li>
                @auth
                <li class="nav-item">
                    <a class="nav-link" href="/home">Registration</a>
                </li>

                @can('keep_inventory')
                <li class="nav-item">
                    <a class="nav-link" href="/analytics">Analytics</a>
                </li>    
                @endcan

                @can('read_user')
                <li class="nav-item">
                    <a class="nav-link" href="/admin">Administration</a>
                </li>
                @endcan

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('logout') }}"
                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                            {{--<span class="fad fa-sign-out mr-1"></span> --}}Sign out
                    </a> 

                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="/login">
                        <span class="fal fa-user-alt fa-fw mr-1"></span>
                        Login
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>